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
    public function notification(){
        try
        {
            $json_result = file_get_contents('php://input');
            $json = json_decode($json_result);

            Utilities::ExceptionLog($json);

//            $notif = $vt->status($json->order_id);

            $vaNumber = $json->transaction->ref;

            sleep(15);

            DB::transaction(function() use ($vaNumber, $json){

//                Utilities::ExceptionLog($orderid);

                $dateTimeNow = Carbon::now('Asia/Jakarta');

            }, 5);
        }
        catch (\Exception $ex){
            Utilities::ExceptionLog($ex);
        }
    }

    public function limitTransferCheck(){
        //Berhasil jadi 10 awal 3
        try{
            $transactions = Transaction::where('status_id', 3)->get();
            $temp = Carbon::now();
            $now = Carbon::parse(date_format($temp,'Y-m-d'));
            foreach($transactions as $transaction){
                $trxDate = Carbon::parse(date_format($transaction->created_on, 'Y-m-d'));
                $interval = $now->diff($trxDate, true);

                //Change Status
                if($interval->days > 2){
                    $temporary = Transaction::where('id', $transaction->id)->first();
                    $temporary->status_id = 10;
                    $temporary->save();
                }
            }

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
            $temp = Carbon::now();
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
            return $ex;
        }
    }
}