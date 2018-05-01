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
            $transaction = Transaction::find("017cb7e0-30c5-11e8-b010-2b4aab383c12");
            //Send Email,
            $userData = User::find($transaction->user_id);
            $payment = PaymentMethod::find($transaction->payment_method_id);
            $product = Product::find($transaction->product_id);

            $user = User::find("46089230-b57c-11e7-a6f4-8733a9e6ca0a");

            $data = array(
                'user' => $user
            );
            SendEmail::SendingEmail('emailVerification', $data);

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

//            $data = array(
//                'transaction' => $transaction,
//                'user'=>$userData,
//                'paymentMethod' => $payment,
//                'product' => $product
//            );
//            //Send Email for accepted fund
//            SendEmail::SendingEmail('successTransaction', $data);

            return "success";
        }
        catch (\Exception $ex){
            return "failed : ".$ex;
        }
    }
}