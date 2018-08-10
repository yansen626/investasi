<?php
/**
 * Created by PhpStorm.
 * User: yanse
 * Date: 03-Oct-17
 * Time: 2:23 PM
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Libs\Midtrans;
use App\Libs\SendEmail;
use App\Libs\TransactionUnit;
use App\Libs\UrgentNews;
use App\Mail\RequestWithdrawInvestor;
use App\Models\Cart;
use App\Models\TransactionWallet;
use App\Models\User;
use App\Models\Vendor;
use App\Models\WalletStatement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Webpatser\Uuid\Uuid;
use App\Libs\Utilities;
use PragmaRX\Google2FA\Google2FA;

class WalletController extends Controller
{
    public function Wallet()
    {
        if(!auth()->check()){
            return redirect()->route('index');
        }
        $user = Auth::user();
        $userId = $user->id;
        $blogs = UrgentNews::GetBlogList($userId);

        if(count($blogs) > 0){
            return View('frontend.show-blog-urgents', compact('blogs'));
        }

        $user = User::find($userId);
        $statementsWithdraw = WalletStatement::where('user_id', $userId)->orderByDesc('created_on')->get();
        $statementsTopup = TransactionWallet::where('user_id', $userId)->orderByDesc('created_at')->get();

        $fee = number_format(env('FEE'),0, ",", ".");
        $minimum = number_format(env('MINIMUM_WITHDRAWAL'),0, ",", ".");
        $feePercentage = env('FEE_PERCENTAGE') * 100;

        $data = array(
            'statementsWithdraw' => $statementsWithdraw,
            'statementsTopup' => $statementsTopup,
            'user' => $user,
            'fee' => $fee,
            'feePercentage' => $feePercentage,
            'minimum' => $minimum
        );

        return View ('frontend.show-wallet')->with($data);
    }

//    public function DepositShow()
//    {
//        if(!auth()->check()){
//            return redirect()->route('index');
//        }
//        $user = Auth::user();
//        $userId = $user->id;
//
//        $statements = WalletStatement::where('user_id', $userId)->get();
//        return View ('frontend.wallet-deposit', compact('statements'));
//    }
//
//    public function DepositConfirm(Request $request){
////        if(Input::get('amount') == '-1'){
////            return redirect()->back()->withErrors('Pilih jumlah top up!', 'default')->withInput($request->all());
////        }
//
//        if(Input::get('method') == '-1'){
//            return redirect()->back()->withErrors('Pilih metode top up!', 'default')->withInput($request->all());
//        }
//
//        if(empty(Input::get('amount')) || Input::get('amount') === '0'){
//            return redirect()->back()->withErrors('Isi jumlah top up!', 'default')->withInput($request->all());
//        }
//
////        $amount = 0;
////        if(Input::get('amount') == '0'){
////            $amount = floatval(Input::get('custom_amount'));
////        }
////        else{
////            $amount = floatval(Input::get('amount'));
////        }
//
//        $amount = (double) str_replace('.','', Input::get('amount'));
////        $amount = floatval(Input::get('amount'));
//
//        $amountStr = number_format($amount, 0, ",", ".");
//
//        // Get total top up
//        $totalAmount = $amount + 4000;
//        $totalAmountStr = number_format($totalAmount, 0, ",", ".");
//
//        $data = [
//            'amount'            => $amount,
//            'amountStr'         => $amountStr,
//            'totalAmount'       => $totalAmount,
//            'totalAmountStr'    => $totalAmountStr
//        ];
//
//        return View('frontend.wallet-deposit-confirm')->with($data);
//    }
//
//    public function DepositSubmit(Request $request){
//
//        $user = Auth::user();
//        $userId = $user->id;
//
//        $paymentMethod = Input::get('method');
//
//        // Get unique order id
//        $orderId = 'WALLET-'. uniqid();
//
////        $amount = floatval(Input::get('amount'));
//        $amount = (double) str_replace('.','', Input::get('amount'));
//
//        // Delete existing cart
//        $carts = Cart::where('user_id', $userId)
//            ->whereNull('product_id')
//            ->get();
//
//        if($carts->count() > 0){
//            foreach($carts as $cart){
//                $cart->delete();
//            }
//        }
//
//        $adminFee = 0;
//        if($paymentMethod == 'bank_transfer'){
//            $adminFee = 4000;
//        }
//
//        // Save temporary data
//        $cartCreate = Cart::create([
//            'user_id'               => $userId,
//            'quantity'              => 1,
//            'admin_fee'             => 4000,
//            'order_id'              => $orderId,
//            'payment_method'        => $paymentMethod,
//            'invest_amount'         => $amount,
//            'total_invest_amount'   => $amount + $adminFee
//        ]);
//
//        if($paymentMethod == 'bank_transfer'){
//            $isSuccess = TransactionUnit::createTransactionTopUp($userId, $cartCreate->id, $orderId);
//        }
//        //set data to request
//        $transactionDataArr = Midtrans::setRequestData($userId, $paymentMethod, $orderId, $cartCreate);
//
//        //sending to midtrans
//        $redirectUrl = Midtrans::sendRequest($transactionDataArr);
//
//
//        return redirect($redirectUrl);
//    }
//
//    public function DepositSuccess($method){
//        if($method == 'bank_transfer'){
//            return View('frontend.wallet-deposit-success', compact('method'));
//        }
//        else{
//            dd("OTHERS");
//        }
//    }
//
//    public function DepositFailed(){
//        return View('frontend.wallet-deposit-failed');
//    }

    public function WithdrawShow()
    {
        if(!auth()->check()){
            return redirect()->route('index');
        }
        $user = Auth::user();
        $userId = $user->id;
        $user = User::find($userId);

        return View ('frontend.wallet-withdraw', compact('user'));
    }

    //withdraw process
    public function WithdrawSubmit(Request $request){
        try{

            DB::transaction(function() use ($request){
                $user = Auth::user();
                $userId = $user->id;

                $validator = Validator::make($request->all(),[
                    'amount'        => 'required',
                    'acc_number'    => 'required',
                    'acc_name'      => 'required',
                    'bank'          => 'required',
                    'google'          => 'required'
                ]);

                $user = User::find($userId);
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }
                else {
                    $amount = (double) str_replace('.','', Input::get('amount'));
                    $userWallet = (double) str_replace('.','', $user->wallet_amount);

                    if($amount > $userWallet){
                        return back()->withErrors("Jumlah Penarikan harus lebih kecil dari Dana yang tersedia")->withInput();
                    }
                    $minimum = (double) env('MINIMUM_WITHDRAWAL');
                    if($amount < $minimum){
                        return back()->withErrors("Jumlah Penarikan minimal Rp ".$minimum)->withInput();
                    }

                    $secret = Input::get('google');
                    $google2fa = new Google2FA();

                    $valid = $google2fa->verifyKey($user->google2fa_secret, $secret);
//                    $valid = true;
                    if($valid){
                        $dateTimeNow = Carbon::now('Asia/Jakarta');

                        $accNumber = Input::get('acc_number');
                        $accName = Input::get('acc_name');
                        $bank = Input::get('bank');

                        //check for fee and admin
//                        $fee = (double) env('FEE');
                        $fee = 0;
                        if(Vendor::where('user_id', $userId)->exists()){
                            $fee_percentage = (double) $amount*env('FEE_PERCENTAGE');
                            $fee = $fee_percentage;
                        }
                        else if($amount > 100000000){
                            $fee2 = (double) env('FEE2');
                            $fee = $fee2;
                        }
                        $admin = (double) env('FEE_TRANSFER');

//                    $fee_percentage = (double) $amount*env('FEE_PERCENTAGE');
//                    if($fee_percentage > $fee) $fee = $fee_percentage;

                        $transfer_amount = $amount - $fee - $admin;

                        $userFinalWallet = $userWallet - $amount;

                        //if user bank account not registred
                        if(empty($user->bank_name) || empty($user->bank_acc_number) || empty($user->bank_acc_name)){
                            $user->bank_name = $bank;
                            $user->bank_acc_name = $accName;
                            $user->bank_acc_number = $accNumber;

                            $user->save();
                        }
//                        dd($userFinalWallet." | ".$amount." | ".$admin." | ".$fee." | ".$transfer_amount);
                        //status 3=pending, 6=accepted, 7=rejected
                        $newStatement = WalletStatement::create([
                            'id'                => Uuid::generate(),
                            'user_id'           => $userId,
                            'description'       => "Penarikan Dompet (".$bank." - ".$accName." - ".$accNumber.")",
                            'saldo'             => $userFinalWallet,
                            'amount'            => $amount,
                            'admin'            => $admin,
                            'fee'               => $fee,
                            'transfer_amount'   => $transfer_amount,
                            'bank_name'         => $bank,
                            'bank_acc_name'     => $accName,
                            'bank_acc_number'   => $accNumber,
                            'date'              => $dateTimeNow->toDateTimeString(),
                            'status_id'         => 3,
                            'created_on'        => $dateTimeNow->toDateTimeString()
                        ]);


                        $data = array(
                            'newStatement' => $newStatement,
                            'user' => $user,
                            'ip' => request()->ip()
                        );
                        SendEmail::SendingEmail('withdrawalRequest', $data);

                        $user->wallet_amount = $userFinalWallet;
                        $user->save();
                    }
                    else{
                        return back()->withErrors("PIN google yang Anda masukan salah")->withInput();
                    }
                }
            });

            //return ke page transaction
            return redirect()->route('my-wallet');
        }
        catch (\Exception $ex){
            Utilities::ExceptionLog('WalletWithdrawSubmit EX = '. $ex);
            return $ex;
        }
    }

    public function CancelWithdrawRequest($id){
        $wallet = WalletStatement::find($id);
        $wallet->status_id = 7;
        $wallet->updated_on = Carbon::now('Asia/Jakarta')->toDateTimeString();
        $wallet->save();

        return redirect()->route('my-wallet');
    }
}