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
use App\Models\ProductInstallment;
use App\Models\Transaction;
use App\Models\TransactionWallet;
use App\Models\User;
use App\Models\WalletStatement;
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
            $productDB = Product::find($cart->product_id);

            $dateTimeNow = Carbon::now('Asia/Jakarta');
            $invoice = Utilities::GenerateInvoice($productDB->name, $user->va_acc);
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
                'va_number'           => $user->va_acc,
                'invoice'           => $invoice,
                'product_id'           => $cart->product_id,
                'payment_method_id' => $paymentMethodInt,
                'order_id'          => $orderId,
                'total_payment'     => $cart->getOriginal('total_invest_amount'),
                'total_price'       => $cart->getOriginal('invest_amount'),
                'phone'             => $user->phone,
                'admin_fee'         => $cart->getOriginal('admin_fee'),
                'two_day_due_date_flag' => 0,
                'status_id'         => 3,
                'created_on'        => $dateTimeNow->toDateTimeString(),
                'created_by'        => $userId
            ]);

            $raisedDB = (double) str_replace('.','', $productDB->raised);
            $newRaise = $cart->getOriginal('invest_amount');
            $productDB->raised = $raisedDB + $newRaise;
            $productDB->save();

            // Delete cart
            $cart->delete();

            $payment = PaymentMethod::find($paymentMethodInt);
            $data = array(
                'transaction' => $trxCreate,
                'user'=>$user,
                'paymentMethod' => $payment,
                'product' => $productDB
            );
            SendEmail::SendingEmail('DetailPembayaran', $data);
            return true;
        }
        catch(\Exception $ex){
            Utilities::ExceptionLog('TransactionUnit.php > createTransaction ========> '.$ex);
            return false;
        }
    }

    public static function transactionRejected($trxid){
        try{
            DB::transaction(function() use ($trxid){
                $transaction = Transaction::find($trxid);
                if($transaction->status_id == 10){
                    return false;
                }
                $dateTimeNow = Carbon::now('Asia/Jakarta');

                $transaction->status_id = 10;
                $transaction->modified_on = $dateTimeNow->toDateTimeString();
                $transaction->save();

                //update product data
                $productDB = Product::find($transaction->product_id);
                $raisedDB = (double) str_replace('.','', $productDB->raised);
                $newRaise = (double) str_replace('.','', $transaction->total_price);
                $productDB->raised = $raisedDB - $newRaise;
                if($productDB->status_id ==  22){
                    $productDB->status_id = 21;
                }
                $productDB->save();

                Utilities::ExceptionLog("Transaction ".$transaction->invoice." Rejected on ".$dateTimeNow->toDateTimeString());

                //update user wallet
                if(strpos($transaction->order_id, "WALLET") === true){
                    $user = User::find($transaction->user_id);
                    $walletUserTemp = (double)$user->getOriginal('wallet_amount');
                    $walletUsedTemp = (double)$transaction->getOriginal('total_price');
                    $user->wallet_amount = $walletUserTemp + $walletUsedTemp;
                    $user->save();
                }

                return true;
            });
        }
        catch(\Exception $ex){
            Utilities::ExceptionLog('TransactionUnit.php > transactionRejected ========> '.$ex);
        }
        return false;
    }
    public static function transactionAfterVerified($orderid){
        try{
            $dateTimeNow = Carbon::now('Asia/Jakarta');
            DB::transaction(function() use ($orderid){
                $transaction = Transaction::where('order_id', $orderid)->first();
                if($transaction->status_id == 5){
                    Utilities::ExceptionLog("Transaction ".$orderid." status already 5");
                    return false;
                }
                $dateTimeNow = Carbon::now('Asia/Jakarta');

                $transaction->status_id = 5;
                $transaction->two_day_due_date = $dateTimeNow->addDays(2);
                $transaction->modified_on = $dateTimeNow->toDateTimeString();
                $transaction->save();
                Utilities::ExceptionLog("Transaction ".$orderid." Verified on ".$dateTimeNow->toDateTimeString());

                //update product data
                $productDB = Product::find($transaction->product_id);
                $raisedDB = (double) str_replace('.','', $productDB->raised);
                $newRaise = (double) str_replace('.','', $transaction->total_price);

                //checking if fund 100% or not and send email
                $userData = User::find($transaction->user_id);
                $payment = PaymentMethod::find($transaction->payment_method_id);
                $product = Product::find($transaction->product_id);
                $productInstallments = ProductInstallment::where('product_id',$transaction->product_id)->get();

                $data = array(
                    'transaction' => $transaction,
                    'user'=>$userData,
                    'paymentMethod' => $payment,
                    'product' => $product,
                    'productInstallment' => $productInstallments
                );

                $raisingDB = (double) str_replace('.','', $productDB->raising);
                $tempTotal = $raisedDB + $newRaise;
                if($raisedDB == $raisingDB){
                    $productDB->status_id = 22;
                    Utilities::ExceptionLog("product raising collected  ".$product->name." (".$raisedDB." from ".$raisingDB.")");
                }
                $productDB->save();

                //Send Email for accepted fund
                SendEmail::SendingEmail('successTransaction', $data);

            });
            return true;
        }
        catch(\Exception $ex){
            Utilities::ExceptionLog('TransactionUnit.php > transactionAfterVerified ========> '.$ex);
            return false;
        }
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
        return false;
    }
    public static function InstallmentPaymentProcess($id){
        try{
            $productInstallments = ProductInstallment::find($id);
            $paid_amount = (double) str_replace('.','', $productInstallments->paid_amount);
            $raised = (double) str_replace('.','', $productInstallments->product->raised);

            $transactionList = Transaction::where('product_id', $productInstallments->product_id)->where('status_id', 5)->get();
            $asdf = array();
            DB::transaction(function() use ($productInstallments, $transactionList, $paid_amount, $raised, $asdf) {
                $doneInstallmentPayment = false;
                foreach ($transactionList as $transaction){

                    $dateTimeNow = Carbon::now('Asia/Jakarta');
                    $userDB = User::find($transaction->user_id);
                    $userAmount = (double) str_replace('.','', $transaction->total_price);

                    $userGetTemp = number_format((($userAmount*100) / $raised),2);

                    $userGetFinal = round(($userGetTemp * $paid_amount) / 100);
                    $userSaldoFinal = (double) str_replace('.','', $userDB->wallet_amount);
                    $userSaldoFinal = $userSaldoFinal + $userGetFinal;
                    $desription = 'Pembayaran cicilan dan bunga ke-'.$productInstallments->month.' dari '.$productInstallments->product->name;

                    //add wallet statement
                    $statement = WalletStatement::create([
                        'id'            =>Uuid::generate(),
                        'user_id'       => $transaction->user_id,
                        'description'   => $desription,
                        'saldo'         => $userSaldoFinal,
                        'amount'        => $userGetFinal,
                        'fee'           => 0,
                        'admin'         => 0,
                        'transfer_amount'=> 0,
                        'status_id'     => 6,
                        'date'          => $dateTimeNow->toDateTimeString(),
                        'created_on'    => $dateTimeNow->toDateTimeString()
                    ]);

                    //change user wallet amount
                    $userDB->wallet_amount = $userSaldoFinal;
                    $userDB->save();

                    if($productInstallments->month == $productInstallments->Product->tenor_loan){
                        $statements = WalletStatement::where('user_id', $transaction->user_id)
                            ->where('description', 'like', '%'.$productInstallments->product->name.'%')
                            ->orderBy('created_on', 'ASC')
                            ->get();
                        //send email to user
                        $data = array(
                            'user'=>$userDB,
                            'description' => $productInstallments->product->name,
                            'statements' => $statements,
                            'userGetFinal' => $userGetFinal
                        );
                        SendEmail::SendingEmail('installmentDone', $data);
                        $doneInstallmentPayment = true;
                    }
                    else{
                        //send email to user
                        $data = array(
                            'user'=>$userDB,
                            'description' => $desription,
                            'userGetFinal' => $userGetFinal
                        );
                        SendEmail::SendingEmail('topupSaldo', $data);
                    }

                }
                //change product installment status
                $productInstallments->status_id = 27;
                $productInstallments->save();

                //change product status kalau pembayaran cicilan sudah selesai
                if($doneInstallmentPayment){
                    $productDB = Product::find($productInstallments->product_id);
                    $productDB->status_id = 24;
                    $productDB->save();
                }
            });
            return true;
        }
        catch(\Exception $ex){
            Utilities::ExceptionLog($ex);
        }
        return false;
    }
}