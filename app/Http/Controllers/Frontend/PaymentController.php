<?php
/**
 * Created by PhpStorm.
 * User: GMG-Developer
 * Date: 18/10/2017
 * Time: 10:30
 */

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Libs\Midtrans;
use App\Libs\TransactionUnit;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class PaymentController extends Controller
{
    public function settingData($id){
        $product = Product::find($id);
        if(!auth()->check()){
            return redirect()->route('project-detail', ['id' => $id]);
        }

        $user = Auth::user();

        return View('frontend.checkout-setting-data', compact('product', 'user'));
    }

    public function checkout($id){
        $product = Product::find($id);
        if(!auth()->check()){
            return redirect()->route('project-detail', ['id' => $id]);
        }
        if($product->status_id > 21)
            return redirect()->route('project-detail', ['id' => $id]);

        $user = Auth::user();
        $userId = $user->id;
        $userData = User::find($userId);
        $productRaising = (double)$product->getOriginal('raising');
        $productRaised = (double)$product->getOriginal('raised');
        $remaining = $productRaising - $productRaised;
        $remainingStr = number_format($remaining, 0, ",", ".");

        $notCompletedData = 1;
        if($userData->identity_number== null ||
            $userData->address_ktp== null ||
            $userData->postal_code_ktp== null ||
            $userData->address_stay== null ||
            $userData->gender== null ||
            $userData->dob== null ||
            $userData->name_ktp == null)
//            || $userData->img_ktp == null)
        {
            $notCompletedData = 0;
        }
        $data = array(
            'userData'    => $userData,
            'product'       => $product,
            'notCompletedData'    => $notCompletedData,
            'remaining'    => $remaining,
            'remainingStr'    => $remainingStr
        );
//        dd($data);
        return View('frontend.checkout')->with($data);
    }

    public function storeData(Request $request){
        $validator = Validator::make($request->all(),[
            'ktp'               => 'required',
            'citizen'           => 'required',
            'address_ktp'       => 'required',
            'city_ktp'          => 'required',
            'province_ktp'      => 'required',
            'postal_code_ktp'   => 'required',
            'dob'               => 'required',
            'gender'            => 'required',
            'address_stay'      => 'required',
            'name_ktp'          => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        //Update Data
        $productId = $request->get('product_id');
        $user = Auth::user();

        //User KTP Image
        // Get image extension
        $userData = User::find($user->id);
//        dd($request);
        $dob = Carbon::createFromFormat('d M Y', $request->get('dob'), 'Asia/Jakarta');

        $userData->identity_number = $request->get('ktp');
        $userData->citizen = $request->get('citizen');
        $userData->address_ktp = $request->get('address_ktp');
        $userData->city_ktp = $request->get('city_ktp');
        $userData->province_ktp = $request->get('province_ktp');
        $userData->postal_code_ktp = $request->get('postal_code_ktp');
        $userData->dob = $dob;
        $userData->gender = $request->get('gender');
        $userData->address_stay = $request->get('address_stay');
        $userData->name_ktp = $request->get('name_ktp');
//        dd($request);
//        if($request->file('photo_ktp') != null) {
//            //Check if Image or PDF
//            $extension = $request->file('photo_ktp')->getClientOriginalExtension();
//            $extCheck = strtolower($extension);
//
//            if($extCheck == 'png' || $extCheck == 'jpg') {
//                $img = Image::make($request->file('photo_ktp'));
//                $extStr = $img->mime();
//                $ext = explode('/', $extStr, 2);
//                if ($ext[1] == 'jpeg')
//                    $ext[1] = 'jpg';
//
//                $filename = 'ktp_' . $request->get('ktp') . '_' . $userData->first_name . '-' . $userData->last_name . '.' . $ext[1];
//
//                $img->save(public_path('storage/ktp/' . $filename), 75);
//                $userData->img_ktp = $filename;
//            }
//            else if($extCheck == 'pdf'){
//                $filename = 'ktp_' . $request->get('ktp') . '_' . $userData->first_name . '-' . $userData->last_name . '.' . $extension;
//
//                $request->file('photo_ktp')->move(public_path('storage/ktp/'), $filename);
//                $userData->img_ktp = $filename;
//            }
//        }

        $userData->save();

        $user = $userData;
        Auth::logout();
        Auth::login($user);

        Session::flash('message', 'Berhasil mengubah data KTP');

        //Back to the Payment
        return redirect()->route('checkout', ['id' => $productId]);
    }


    public function pay(Request $request, $investId){
        try{
//            dd(Input::get('checkout-invest-amount-input'). " - ". Input::get('checkout-admin-fee-input'). " - ". Input::get('checkout-payment-method-input'));

            if(!auth()->check()){
                return redirect()->route('project-detail', ['id' => $investId]);
            }

            $user = Auth::user();
            $userId = $user->id;

            $paymentMethod = Input::get('checkout-payment-method-input');

            // Get unique order id
            $orderId = 'INVEST-'. uniqid();

            $investAmount = floatval(Input::get('checkout-invest-amount-input'));
            $adminFee = floatval(Input::get('checkout-admin-fee-input'));
            $isNotComplete = Input::get('checkout-notCompletedData');

            if($isNotComplete == 0){
                $user = User::find($userId);

                $user->identity_number = Input::get('checkout-KTP');
                $user->citizen = Input::get('checkout-citizen');
                $user->address_ktp = Input::get('checkout-address');
                $user->city_ktp = Input::get('checkout-city');
                $user->province_ktp = Input::get('checkout-province');
                $user->postal_code_ktp = Input::get('checkout-zip');

                $user->save();

            }

            // Delete existing cart
            $carts = Cart::where('product_id', $investId)
                ->where('user_id', $userId)
                ->get();
            if($carts->count() > 0){
                foreach($carts as $cart){
                    $cart->delete();
                }
            }

            // Save temporary data
            $cartCreate = Cart::create([
                'product_id'            => $investId,
                'user_id'               => $userId,
                'quantity'              => 1,
                'admin_fee'             => $adminFee,
                'order_id'              => $orderId,
                'payment_method'        => $paymentMethod,
                'invest_amount'         => $investAmount,
                'total_invest_amount'   => $investAmount + $adminFee
            ]);

            if($paymentMethod != 'wallet'){
                if($paymentMethod == 'bank_transfer'){
                    error_log("CHECK!");
                    $isSuccess = TransactionUnit::createTransaction($userId, $cartCreate->id, $orderId);
                    if($isSuccess){
                        return redirect()->route('pageVA', ['orderId' => $orderId]);
                    }
                    else{
                        return View('frontend.checkout-failed', compact('investId'));
                    }
                }
                else{
                    $isSuccess = TransactionUnit::createTransaction($userId, $cartCreate->id, $orderId);
                    //set data to request
                    $transactionDataArr = Midtrans::setRequestData($userId, Input::get('checkout-payment-method-input'), $orderId, $cartCreate);
//                dd($transactionDataArr);
                    //sending to midtrans
                    $redirectUrl = Midtrans::sendRequest($transactionDataArr);
//                dd($redirectUrl);

                    return redirect($redirectUrl);
                }
            }
            //if pay with dompet
            else{
                $userDB = User::find($userId);
                $userWallet = (double) str_replace('.','', $userDB->wallet_amount);
//                dd($investAmount."|".$userWallet);
                if($investAmount <= $userWallet){
                    $isSuccess = TransactionUnit::createTransaction($userId, $cartCreate->id, $orderId);

                    //change status, date etc
                    TransactionUnit::transactionAfterVerified($orderId);

                    $paymentMethod = 'dompet';
                    return View('frontend.checkout-success', compact('paymentMethod'));
                }
                else{
                    return View('frontend.checkout-failed', compact('investId'));
                }
            }
        }
        catch(\Exception $ex){
//            dd($ex);
            return View('frontend.checkout-failed', compact('investId'));
        }
    }

    public function successCC($userId){
        try{
//            $cart = Cart::where('user_id', $userId)->first();
//            $isSuccess = TransactionUnit::createTransaction($userId, $cart->id, $cart->order_id);

            $paymentMethod = 'credit_card';
            return View('frontend.checkout-success', compact('paymentMethod'));
        }
        catch(\Exception $ex){

        }
    }

    public function pageVA($orderId){
        try{
            $paymentMethod = 'va';
            $transaction = Transaction::where('order_id', $orderId)->first();
            $user = User::find($transaction->user_id);
            return View('frontend.checkout-VA', compact('paymentMethod', 'transaction', 'user'));
        }
        catch(\Exception $ex){

        }
    }

    public function successVA(){
        try{
            $paymentMethod = 'bank_transfer';
            return View('frontend.checkout-success', compact('paymentMethod'));
        }
        catch(\Exception $ex){

        }
    }

    public function failed($investId){
        try{
            return View('frontend.checkout-failed', compact('investId'));
        }
        catch(\Exception $ex){

        }
    }

    public function test(){
        $paymentMethod = 'credit_card';
        return View('frontend.checkout-success', compact('paymentMethod'));
    }
}