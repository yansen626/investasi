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
use App\Libs\TransactionUnit;
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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class TestingController extends Controller
{
    public function TestingSendEmail(){
        try{

            TransactionUnit::transactionAfterVerified("INVEST-5b512402f369a");
            $transaction = Transaction::find("017cb7e0-30c5-11e8-b010-2b4aab383c12");
            //Send Email,
            $userData = User::find($transaction->user_id);
            $payment = PaymentMethod::find($transaction->payment_method_id);
            $product = Product::find($transaction->product_id);

            $user = User::find("3a7dcde0-b246-11e7-ba8d-c3ff1c82f7e4");

//            $data = array(
//                'user'=>User::find("3a7dcde0-b246-11e7-ba8d-c3ff1c82f7e4"),
//                'productInstallment' => ProductInstallment::where('product_id', $transaction->product_id),
//                'product' => Product::find($transaction->product_id)
//            );
//            SendEmail::SendingEmail('PerjanjianPinjaman', $data);


//            $data = array(
//                'user' => User::find("3a7dcde0-b246-11e7-ba8d-c3ff1c82f7e4"),
////                'description' => "Kami telah melakukan verifikasi foto KTP beserta data anda di indofund.id."
//                'description' => "Kami telah melakukan verifikasi data anda di indofund.id namun data yang anda masukkan belum
//                    lengkap sehingga kami belum bisa melakukan verifikasi lebih lanjut, mohon kirimkan ulang foto ktp beserta data
//                    secara tepat dan sesuai"
//            );
//            SendEmail::SendingEmail('verificationKTP', $data);

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
    public function TestingFunction(){
        try{
//            $ProductIds = Product::where('vendor_id', "96b4c5d0-9ae8-11e8-bf2e-e510ffd4c4a8")->get();
//
//            foreach ($ProductIds as $ProductId){
//
//                $userData = User::find($ProductId->user_id);
//                $data = array(
//                    'user'=>$userData,
//                    'productInstallments' => ProductInstallment::where('product_id', $ProductId->id)->get(),
//                    'product' => Product::find($ProductId->id),
//                    'vendor' => Vendor::find('96b4c5d0-9ae8-11e8-bf2e-e510ffd4c4a8')
//                );
//
//                $pdf2 = PDF::loadView('email.perjanjian-pinjaman', $data);
//
//                Mail::send('email.surat-perjanjian-pinjaman', $data, function ($message) use ($pdf2, $userData) {
//                    $message->to("yansen626@gmail.com")
//                        ->subject('Perjanjian Pinjaman di Indofund');
//
//                    $message->attachData($pdf2->output(), "Perjanjian Pinjaman.pdf");
//                });
//            }

            $userGetTemp = number_format(((9000*100) / 12800000 ),2);

            $userGetFinal = round(($userGetTemp * 13582163) / 100);
            return "9000 | 13582163 | 12800000 | ".$userGetTemp." | ".$userGetFinal;
        }
        catch (\Exception $ex){
            return "failed : ".$ex;
        }
    }
}