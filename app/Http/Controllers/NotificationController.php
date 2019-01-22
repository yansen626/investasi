<?php
/**
 * Created by PhpStorm.
 * User: GMG-Developer
 * Date: 18/10/2017
 * Time: 13:52
 */

namespace App\Http\Controllers;


use App\Libs\SendEmail;
use App\Libs\TransactionUnit;
use App\Libs\Utilities;
use App\Mail\InvoicePembelian;
use App\Mail\PerjanjianLayanan;
use App\Mail\PerjanjianPinjaman;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductInstallment;
use App\Models\Transaction;
use App\Models\TransactionWallet;
use App\Models\User;
use App\Models\Vendor;
use App\Models\WalletStatement;
use Carbon\Carbon;
use Dompdf\Exception;
use Faker\Provider\DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Webpatser\Uuid\Uuid;

class NotificationController extends Controller
{
    public function notificationMCM(){
        try
        {
            $json_result = file_get_contents('php://input');
            $json = json_decode($json_result);

            Utilities::ExceptionLog($json);

            $jsonTransactions =  $json->Transactions;
            foreach ($jsonTransactions as $jsonTransaction){
                $trxDesc = $jsonTransaction->description;

//                Utilities::ExceptionLog($trxDesc);
//                $trxDescPart = str_replace("\r", '',$trxDesc);
//                $trxDescPart1 = str_replace("\nPRMA", '',$trxDescPart);
//                $trxDescPart2 = str_replace("\nATMB", '',$trxDescPart1);
//                $trxDescPart3 = str_replace("\nMCM", '',$trxDescPart2);
//                $trxDescPart4 = explode(" ", $trxDescPart3);
//                $vaNumber = $trxDescPart4[0];


                $trxKredit = $jsonTransaction->kredit;
                $trxKredit2 = explode(".", $trxKredit);
                $amount = (double) str_replace(',', '',$trxKredit2[0]);

                $vaProceed = false;
                //process transaction checking
                $vaNumber = substr($trxDesc, 20, 10);
                $transactionDB = Transaction::where('va_number', $vaNumber)
                    ->where('status_id', 3)
                    ->where('payment_method_id', 1)
                    ->where('total_payment', $amount)
                    ->first();

                $vaVendorNumber = substr($trxDesc, 20, 11);
                $installmentDB = ProductInstallment::where('paid_amount', $amount)
                    ->where('status_id', 1)
                    ->where('vendor_va', $vaVendorNumber)
                    ->first();

                Utilities::ExceptionLog($vaNumber."/".$vaVendorNumber." | ".$amount);

                if(!empty($transactionDB)){
                    $orderid = $transactionDB->order_id;

                    $isSuccess = TransactionUnit::transactionAfterVerified($orderid);
                    if($isSuccess){
                        Utilities::ExceptionLog("Change transaction status success");
                    }
                    else{
                        Utilities::ExceptionLog("Change transactionDB status failed");
                    }
                    $vaProceed = true;
                }
                else if(!empty($installmentDB)){
                    //process installment payment checking
                    DB::transaction(function() use ($installmentDB){
                        if(!empty($installmentDB)){
                            //change status for installment payment DB
                            $installmentDB->status_id = 26;
                            $installmentDB->save();

                            //send email notif to admin

                        }
                        //distribute payment installment
                        $isSuccess = TransactionUnit::InstallmentPaymentProcess($installmentDB->id);
                        if($isSuccess){
                            Utilities::ExceptionLog("Change installment payment status success");
                        }
                        else{
                            Utilities::ExceptionLog("Change installment payment status failed");
                        }

                        Utilities::ExceptionLog("Change installment payment status success");
                    });
                    $vaProceed = true;
                }
                //dana tanpa ada transaksi yang cocok
                else{
                        $vendorDB = Vendor::where('vendor_va', $vaVendorNumber)->first();
                        if(!empty($vendorDB)){
                            $userDB = User::find($vendorDB->user_id);
                        }
                        else{
                            $userDB = User::where('va_acc', $vaNumber)->first();
                        }
                        if(!empty($userDB) && $amount != 0.0){

                            $keterangan = "Dana dari virtual account ".$vaNumber;
                            DB::transaction(function() use ($vaVendorNumber, $vaNumber, $amount, $userDB, $keterangan){
                                $dateTimeNow = Carbon::now('Asia/Jakarta');
                                $saldo = (double) str_replace('.', '',$userDB->wallet_amount);
                                $userSaldoFinal = $saldo + $amount;
                                $keterangan = "Dana dari virtual account ".$vaNumber;
                                //add wallet statement
                                $statement = WalletStatement::create([
                                    'id'            => Uuid::generate(),
                                    'user_id'       => $userDB->id,
                                    'description'   => $keterangan,
                                    'saldo'         => $userSaldoFinal,
                                    'amount'        => $amount,
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

                                Utilities::ExceptionLog("Dana tak ada transaksinya sukses di pindahkan ke akun pemilik");
                            });

                            try{
                                //send email to user
                                $data = array(
                                    'user'=>$userDB,
                                    'description' => $keterangan,
                                    'userGetFinal' => $amount
                                );
                                SendEmail::SendingEmail('topupSaldo', $data);
                            }
                            catch (\Exception $ex){
                                Utilities::ExceptionLog("(dana tanpa ada transaksi yang cocok) send email error =  ".$ex);
                            }

                        }
                        else{
                            Utilities::ExceptionLog("Dana tak ada transaksinya TIDAK ADA akun pemilik ".
                                $vaVendorNumber." / ".$vaNumber." Sejumlah ".$amount);
                        }
                    $vaProceed = true;

                }
                if(!$vaProceed){
                    Utilities::ExceptionLog("Va number = ".$vaNumber." or ".$vaVendorNumber." is not Processed");
                }
            }
        }
        catch (\Exception $ex){
            Utilities::ExceptionLog("Change transaction status failed error =  ".$ex);
            //return $ex;
        }
    }

    //reminding borrower payment installment
    public function limitTransferCheck(){
        try{
            $temp = Carbon::now('Asia/Jakarta');
            $now = Carbon::parse(date_format($temp,'Y-m-d'));

            //checking H-30
            $dateH30 = $now->addDays(30);
            $productInstalments = ProductInstallment::where('due_date', $dateH30)->get();

            if(!empty($productInstalments)){
                foreach($productInstalments as $productInstalment){
                    $productDB = Product::find($productInstalment->product_id);
                    $borrower = User::find($productDB->user_id);

                    $data = array(
                        'user'=>$borrower,
                        'productInstallment' => $productInstalment,
                        'product' => $productDB
                    );
                    SendEmail::SendingEmail('reminderInstallment', $data);
                }
            }

            //checking H-7
            $dateH7 = $now->addDays(7);
            $productInstalments2 = ProductInstallment::where('due_date', $dateH7)->get();

            if(!empty($productInstalments2)){
                foreach($productInstalments2 as $productInstalment){
                    $productDB = Product::find($productInstalment->product_id);
                    $borrower = User::find($productDB->user_id);

                    $data = array(
                        'user'=>$borrower,
                        'productInstallment' => $productInstalment,
                        'product' => $productDB
                    );
                    SendEmail::SendingEmail('reminderInstallment', $data);
                }
            }

            //checking H-2
            $dateH2 = $now->addDays(1);
            $productInstalments3 = ProductInstallment::where('due_date', $dateH2)->get();
            if(!empty($productInstalments3)){
                foreach($productInstalments3 as $productInstalment){
                    $productDB = Product::find($productInstalment->product_id);
                    $borrower = User::find($productDB->user_id);

                    $data = array(
                        'user'=>$borrower,
                        'productInstallment' => $productInstalment,
                        'product' => $productDB
                    );
                    SendEmail::SendingEmail('reminderInstallment', $data);
                }
            }

            return "Sukses";
        }
        catch (Exception $ex){
            Utilities::ExceptionLog("Send Email to notify installment failed ".$ex);
            //return $ex;
        }
    }

    //checking project date
    public function limitProjectCheck(){
        //DB : product
        //Awal 21 jadinya 26
        try{
            $products = Product::where('status_id', 21)->get();
            $temp = Carbon::now('Asia/Jakarta');
            $now = Carbon::parse(date_format($temp,'Y-m-d'));
            foreach($products as $product){
                //return $product->due_date;
                $tmp = Carbon::parse($product->due_date);
                $projectDate = Carbon::parse(date_format($tmp, 'Y-m-d'));
                $interval = $now->diff($projectDate, true);

                //Change Status
                if($projectDate <= $now){
                    $temporary = Product::where('id', $product->id)->first();
                    $temporary->status_id = 25;
                    $temporary->save();
                }
            }

            return "Sukses";
        }
        catch (Exception $ex){
            Utilities::ExceptionLog("Change project limit failed ".$ex);
            //return $ex;
        }
    }

    //checking payment from lender
    public function limitPaymentCheck(){
        //DB : transaction
        try{
            $transactions = Transaction::where('status_id', 3)->where('payment_method_id', 1)->get();
            $temp = Carbon::now('Asia/Jakarta');
            $now = Carbon::parse(date_format($temp,'j-F-Y H:i:s'));
//            dd($transactions);
            foreach($transactions as $transaction){
                $trxDate = Carbon::parse(date_format($transaction->created_on, 'j-F-Y H:i:s'));
                $interval = $now->diffInHours($trxDate);
                $intervalMinute = $now->diffInMinutes($trxDate);
//                dd($now." | ".$trxDate." | ".$interval);

                //reminder email
                if($intervalMinute >= 293 && $intervalMinute <= 302){

                    $data = array(
                        'transaction' => $transaction,
                        'user'=>User::find($transaction->user_id),
                        'paymentMethod' => $transaction->payment_method_id,
                        'product' => Product::where('product_id',$transaction->product_id)->first()
                    );
                    SendEmail::SendingEmail('DetailPembayaran', $data);
                    //send email to user
//                    $data = array(
//                        'user'=>$userDB,
//                        'description' => $keterangan,
//                        'userGetFinal' => $amount
//                    );
//                    SendEmail::SendingEmail('topupSaldo', $data);
                }

                //Change Status if more than 6 hours
                if($interval >= 6){
                    Utilities::ExceptionLog("Transaction ".$transaction->invoice." Reject Start");
                    TransactionUnit::transactionRejected($transaction->id);
                }
            }
            return "Sukses";
        }
        catch (Exception $ex){
            Utilities::ExceptionLog("Change payment due date failed ".$ex);
            //return $ex;
        }
    }

    public function CheckInstallmentPayment($vaNumber, $amount)
    {

    }
}