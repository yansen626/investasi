<?php
/**
 * Created by PhpStorm.
 * User: GMG-Developer
 * Date: 18/10/2017
 * Time: 13:52
 */

namespace App\Http\Controllers;


use App\Libs\TransactionUnit;
use App\Libs\Utilities;
use App\Mail\InvoicePembelian;
use App\Mail\PerjanjianLayanan;
use App\Mail\PerjanjianPinjaman;
use App\Models\PaymentMethod;
use App\Models\Product;
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
                $trxDescPart = str_replace("\nPRMA", '',$trxDesc);
                $trxDescPart1 = str_replace("\nATMB", '',$trxDescPart);
                $trxDescPart2 = explode(" ", $trxDescPart1);
                $vaNumber = $trxDescPart2[0];


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
            }
        }
        catch (\Exception $ex){
            Utilities::ExceptionLog("Change transaction status failed ".$ex);
            return $ex;
        }
    }

    public function limitTransferCheck(){
        //Berhasil jadi 10 awal 3
        try{
//            $transactions = Transaction::where('status_id', 3)->get();
//            $temp = Carbon::now('Asia/Jakarta');
//            $now = Carbon::parse(date_format($temp,'j-F-Y'));
//            foreach($transactions as $transaction){
//                $trxDate = Carbon::parse(date_format($transaction->created_on, 'j-F-Y'));
//                $interval = $now->diff($trxDate, true);
//
//                //Change Status
//                if($interval->days > 2){
//                    $temporary = Transaction::where('id', $transaction->id)->first();
//                    $temporary->status_id = 10;
//                    $temporary->save();
//                }
//            }
            return "Sukses";
        }
        catch (Exception $ex){
            return $ex;
        }
    }

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
}