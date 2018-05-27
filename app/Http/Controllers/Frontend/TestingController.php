<?php
/**
 * Created by PhpStorm.
 * User: GMG-Developer
 * Date: 18/10/2017
 * Time: 13:52
 */

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Libs\SendEmail;
use App\Libs\Utilities;
use App\Libs\Veritrans;
use App\Mail\InvoicePembelian;
use App\Mail\PerjanjianLayanan;
use App\Mail\PerjanjianPinjaman;
use App\Models\Option;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionWallet;
use App\Models\User;
use App\Models\WalletStatement;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TestingController extends Controller
{
    public function TestingSendEmail(){
        try{
            $string ="UBP60148879501FFFFFF8879500071\r\nMCM CA/SA UBP PYM CR";
            $vaNumber = substr($string, 20, 10);
            $string2 ="UBP60228879501FFFFFF8879500036\r\nATMB trf Credt CF545003 /2100435496/ATB-0000000000009";
            $vaNumber2 = substr($string2, 20, 10);
            $string3 ="UBP60148879501FFFFFF8879500011";
            $vaNumber3 = substr($string3, 20, 10);
            $string4 ="UBP60118879501FFFFFF8879500010\r\n100000 ";
            $vaNumber4 = substr($string4, 20, 10);
            $string5 ="UBP66668879501FFFFFF8879500072PRMA CR Transfer 1020007258285 6019002682358967";
            $vaNumber5 = substr($string5, 20, 10);
            dd($vaNumber." | ". $vaNumber2." | ". $vaNumber3." | ". $vaNumber4." | ". $vaNumber5);

            $transaction = Transaction::find("017cb7e0-30c5-11e8-b010-2b4aab383c12");
            //Send Email,
            $userData = User::find($transaction->user_id);
            $payment = PaymentMethod::find($transaction->payment_method_id);
            $product = Product::find($transaction->product_id);

            $user = User::find("3a7dcde0-b246-11e7-ba8d-c3ff1c82f7e4");

            $data = array(
                'user' => $user
            );
            SendEmail::SendingEmail('requestVerification', $data);
//            SendEmail::SendingEmail('emailVerification', $data);

//            $data = array(
//                'transaction' => $transaction,
//                'user'=>$userData,
//                'paymentMethod' => $payment,
//                'product' => $product
//            );
//
//            SendEmail::SendingEmail('testing', $data);

//            $data = array(
//                'email' => $userData->email,
//                'filename' => $product->prospectus_path
//            );
//            SendEmail::SendingEmail('sendProspectus', $data);

            $data = array(
                'transaction' => $transaction,
                'user'=>$userData,
                'paymentMethod' => $payment,
                'product' => $product
            );
            //Send Email for accepted fund
            SendEmail::SendingEmail('successTransaction', $data);

            return "success";
        }
        catch (\Exception $ex){
            return "failed : ".$ex;
        }
    }
}