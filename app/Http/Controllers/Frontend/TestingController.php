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
use App\Models\ProductInstallment;
use App\Models\Transaction;
use App\Models\TransactionWallet;
use App\Models\User;
use App\Models\Vendor;
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

            $user = User::find("3a7dcde0-b246-11e7-ba8d-c3ff1c82f7e4");

            $data = array(
                'user'=>User::find("3a7dcde0-b246-11e7-ba8d-c3ff1c82f7e4"),
                'productInstallment' => ProductInstallment::where('product_id', $transaction->product_id),
                'product' => Product::find($transaction->product_id)
            );
            SendEmail::SendingEmail('PerjanjianPinjaman', $data);
//            $data = array(
//                'user' => $user
//            );
//            SendEmail::SendingEmail('requestVerification', $data);
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
    public function TestingViewEmail(){
        try{
//            $angka = 50000;
//            $angkaTerbilang = Utilities::Terbilang($angka);
//            dd($angkaTerbilang);

            $transaction = Transaction::find("017cb7e0-30c5-11e8-b010-2b4aab383c12");
            //Send Email,
            $userData = User::find($transaction->user_id);
            $payment = PaymentMethod::find($transaction->payment_method_id);
            $product = Product::find($transaction->product_id);

            $productInstallments = ProductInstallment::where('product_id', $product->id)->get();
            $vendor = Vendor::find($product->vendor_id);
            $user = User::find("3a7dcde0-b246-11e7-ba8d-c3ff1c82f7e4");

            return View('email.perjanjian-layanan', compact('user', 'product', 'productInstallments', 'vendor'));

        }
        catch (\Exception $ex){
            return "failed : ".$ex;
        }
    }
}