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
use Carbon\Carbon;
use Dompdf\Exception;
use Faker\Provider\DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

                Utilities::ExceptionLog($trxDesc);
//                $trxDescPart = str_replace("\r", '',$trxDesc);
//                $trxDescPart1 = str_replace("\nPRMA", '',$trxDescPart);
//                $trxDescPart2 = str_replace("\nATMB", '',$trxDescPart1);
//                $trxDescPart3 = str_replace("\nMCM", '',$trxDescPart2);
//                $trxDescPart4 = explode(" ", $trxDescPart3);
//                $vaNumber = $trxDescPart4[0];
                $vaNumber = substr($trxDesc, 20, 10);


                $trxKredit = $jsonTransaction->kredit;
                $trxKredit2 = explode(".", $trxKredit);
                $amount = (double) str_replace(',', '',$trxKredit2[0]);

                //Utilities::ExceptionLog($vaNumber." | ".$amount);
                DB::transaction(function() use ($vaNumber, $amount, $json){

                    $dateTimeNow = Carbon::now('Asia/Jakarta');

                    $transactionDB = Transaction::where('va_number', $vaNumber)
                        ->where('status_id', 3)
                        ->where('payment_method_id', 1)
                        ->where('total_payment', $amount)
                        ->first();
                    if(!empty($transactionDB)){
                        $orderid = $transactionDB->order_id;

                        TransactionUnit::transactionAfterVerified($orderid);
                        Utilities::ExceptionLog("Change transaction status success");
                    }
                }, 5);
//                $isInstallment = ProductInstallment::where('paid_amount', $amount)
//                    ->where('vendor_va', $vaNumber)
//                    ->exist();
//                if($isInstallment){
//                    DB::transaction(function() use ($vaNumber, $amount, $json){
//
//                        $dateTimeNow = Carbon::now('Asia/Jakarta');
//
//                        $installmentDB = ProductInstallment::where('paid_amount', $amount)
//                            ->where('vendor_va', $vaNumber)
//                            ->first();
//                        if(!empty($installmentDB)){
//                            //change status for installment payment DB
////                            $installmentDB->status_id =
//                        }
//                    }, 5);
//                }
//                else{
//                }
            }
        }
        catch (\Exception $ex){
            Utilities::ExceptionLog("Change transaction status failed ".$ex);
            return $ex;
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
            return $ex;
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
                    $temporary->status_id = 26;
                    $temporary->save();
                }
            }

            return "Sukses";
        }
        catch (Exception $ex){
            Utilities::ExceptionLog("Change project limit failed ".$ex);
            return $ex;
        }
    }

    //checking payment from lender
    public function limitPaymentCheck(){
        //DB : transaction
        try{
            $transactions = Transaction::where('status_id', 3)->get();
            $temp = Carbon::now('Asia/Jakarta');
            $now = Carbon::parse(date_format($temp,'j-F-Y H:i:s'));
//            dd($transactions);
            foreach($transactions as $transaction){
                $trxDate = Carbon::parse(date_format($transaction->created_on, 'j-F-Y H:i:s'));
                $interval = $now->diffInHours($trxDate);
//                dd($now." | ".$trxDate." | ".$interval);

                //Change Status if more than 6 hours
                if($interval >= 6){
                    TransactionUnit::transactionRejected($transaction->id);
                }
            }
            return "Sukses";
        }
        catch (Exception $ex){
            Utilities::ExceptionLog("Change payment due date failed ".$ex);
            return $ex;
        }
    }

    public function CheckInstallmentPayment($vaNumber, $amount)
    {

    }
}