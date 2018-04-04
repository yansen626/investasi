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
            $transaction = Transaction::find("90ac2000-34f4-11e8-9363-af798c1f2be7");
            //Send Email,
            $userData = User::find($transaction->user_id);
            $payment = PaymentMethod::find($transaction->payment_method_id);
            $product = Product::find($transaction->product_id);

//            $data = array(
//                'transaction' => $transaction,
//                'user'=>$userData,
//                'paymentMethod' => $payment,
//                'product' => $product
//            );
//
//            SendEmail::SendingEmail('testing', $data);


//            $data7 = array(
//                'email' => $userData->email,
//                'filename' => "PT testing 5_20180331040340.pdf"
//            );
////            dd($data7);
//            SendEmail::SendingEmail('sendProspectus', $data7);

            $trx = WalletStatement::find('039d8320-30a4-11e8-9f72-a7f6da35017a');

            $data6 = array(
                'user' => $userData,
                'walletStatement' => $trx
            );
            SendEmail::SendingEmail('withdrawalAccepted', $data6);

//
//            $data8 = array(
//                'transaction' => $transaction,
//                'user'=>$userData,
//                'paymentMethod' => $payment,
//                'product' => $product
//            );
//            SendEmail::SendingEmail('successTransaction', $data8);
//
//            SendEmail::SendingEmail('collectedFund', $data8);

            return "success";
        }
        catch (\Exception $ex){
            return "failed : ".$ex;
        }
    }
}