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
            //PRMG002
            $product = Product::find('34f54170-d04f-11e8-882f-15662530057c');
            //PRMG003
//            $product = Product::find('de31cfc0-d75a-11e8-89b3-f3cf371d0b47');

            $productInstallments = ProductInstallment::where('product_id',$product->id)->get();

            $data = array(
                'user'=>User::find($product->user_id),
                'productInstallment' => $productInstallments,
                'product' => $product,
                'vendor' => Vendor::find($product->vendor_id)
            );
            dd($data);
            SendEmail::SendingEmail('PerjanjianPinjaman', $data);
            return "success";
        }
        catch (\Exception $ex){
            return "failed : ".$ex;
        }
    }
    public function TestingFunction(){
        try{
            $asf = Utilities::GenerateSuratPerjanjian();
            dd($asf);
            $trxKredit = '0.00';
            $trxKredit2 = explode(".", $trxKredit);
            $amount = (double) str_replace(',', '',$trxKredit2[0]);
            $is0 = $amount == 0.0;
            dd(!$is0);

            $asdf = TransactionUnit::InstallmentPaymentProcess('bd42c7d0-8f1b-11e8-b813-4d521d9a648a');
            dd($asdf);
        }
        catch (\Exception $ex){
            return "failed : ".$ex;
        }
    }
}