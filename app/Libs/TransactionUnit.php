<?php
/**
 * Created by PhpStorm.
 * User: GMG-Developer
 * Date: 18/10/2017
 * Time: 14:48
 */

namespace App\Libs;


use App\Mail\InvoicePembelian;
use App\Mail\PerjanjianLayanan;
use App\Mail\PerjanjianPinjaman;
use App\Models\Cart;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionWallet;
use App\Models\User;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TransactionUnit
{
    public static function createTransaction($userId, $cartId, $orderId){
        try{

            $cart = Cart::find($cartId);
            $user = User::find($userId);

            $dateTimeNow = Carbon::now('Asia/Jakarta');
            $invoice = Utilities::GenerateInvoice();
            $paymentMethodInt = 1;
            if($cart->payment_method == 'credit_card'){
                $paymentMethodInt = 2;
            }
            else if($cart->payment_method == 'wallet'){
                $walletTemp = (double)$user->getOriginal('wallet_amount');
                $user->wallet_amount = $walletTemp - (double)$cart->getOriginal('invest_amount');
                $user->save();

                $paymentMethodInt = 3;
            }

            $trxCreate = Transaction::create([
                'id'                => Uuid::generate(),
                'user_id'           => $userId,
                'invoice'           => $invoice,
                'product_id'           => $cart->product_id,
                'payment_method_id' => $paymentMethodInt,
                'order_id'          => $orderId,
                'total_payment'     => $cart->getOriginal('total_invest_amount'),
                'total_price'       => $cart->getOriginal('invest_amount'),
                'phone'             => $user->phone,
                'admin_fee'         => $cart->getOriginal('admin_fee'),
                'status_id'         => 3,
                'created_on'        => $dateTimeNow->toDateTimeString(),
                'created_by'        => $userId
            ]);

            // Delete cart
            $cart->delete();

            return true;
        }
        catch(\Exception $ex){
            Utilities::ExceptionLog($ex);
            return false;
        }
    }

    public static function transactionAfterVerified($orderid){

        DB::transaction(function() use ($orderid){
            $transaction = Transaction::where('order_id', $orderid)->first();
            $dateTimeNow = Carbon::now('Asia/Jakarta');

            $transaction->status_id = 5;
            $transaction->two_day_due_date = $dateTimeNow->addDays(2);
            $transaction->modified_on = $dateTimeNow->toDateTimeString();
            $transaction->save();

            //update product data
            $productDB = Product::find($transaction->product_id);
            $raisedDB = (double) str_replace('.','', $productDB->raised);
            $newRaise = (double) str_replace('.','', $transaction->total_price);
            $productDB->raised = $raisedDB + $newRaise;

            //checking if fund 100% or not
            $raisingDB = (double) str_replace('.','', $productDB->raising);
            if(($raisedDB + $newRaise) >= $raisingDB){
                $productDB->status_id = 22;
            }
            $productDB->save();

            //Send Email,
            $userData = User::find($transaction->user_id);
            $payment = PaymentMethod::find($transaction->payment_method_id);
            $product = Product::find($transaction->product);

            $invoiceEmail = new InvoicePembelian($payment, $transaction, $product, $userData);
            Mail::to($userData->email)->send($invoiceEmail);


            $perjanjianLayananEmail = new PerjanjianLayanan($payment, $transaction, $product, $userData);
            Mail::to($userData->email)->send($perjanjianLayananEmail);

            $perjanjianPinjamanEmail = new PerjanjianPinjaman($payment, $transaction, $product, $userData);
            Mail::to($userData->email)->send($perjanjianPinjamanEmail);

            return true;
        });
    }

    public static function createTransactionTopUp($userId, $cartId, $orderId){
        try{
            $cart = Cart::find($cartId);

            $user = User::find($userId);

            $dateTimeNow = Carbon::now('Asia/Jakarta');

            $paymentMethodInt = 1;
            if($cart->payment_method == 'credit_card'){
                $paymentMethodInt = 2;
            }

            $trxCreate = TransactionWallet::create([
                'user_id'           => $userId,
                'payment_method_id' => $paymentMethodInt,
                'order_id'          => $orderId,
                'total_payment'     => $cart->getOriginal('total_invest_amount'),
                'amount'            => $cart->getOriginal('invest_amount'),
                'phone'             => $user->phone,
                'admin_fee'         => $cart->getOriginal('admin_fee'),
                'status_id'         => 16,
                'created_at'        => $dateTimeNow->toDateTimeString(),
                'created_by'        => $userId
            ]);

            // Delete cart
            $cart->delete();



            return true;
        }
        catch(\Exception $ex){
            Utilities::ExceptionLog($ex);
        }
    }
}