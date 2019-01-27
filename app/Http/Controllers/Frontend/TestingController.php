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
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class TestingController extends Controller
{
    public function TestingSendEmail(){
        try{
            $option = 1;
            switch($option){
                //1 for surat perjanjian manualy download
                case 1:
                    $productId = Product::whereDate('created_on', '>=', '2019-01-01 00:00:01')
                        ->orderby('created_on')
                        ->get();
//                    $productId = Product::where('category_id', 2)->where('category_id', 6)->orderby('created_on')->get();
//                    dd($productId);
                    $pdfList = collect();
                    foreach ($productId as $product){
                        $productInstallments = ProductInstallment::where('product_id',$product->id)->get();

                        $user = User::find($product->user_id);
                        $vendor = Vendor::find($product->vendor_id);

                        $noPerjanjian = Utilities::GenerateSuratPerjanjian();
                        $data = array(
                            'user'=>$user,
                            'productInstallments' => $productInstallments,
                            'product' => $product,
                            'vendor' => $vendor,
                            'noPerjanjian' => $noPerjanjian
                        );
                        $filename = "Perjanjian Pinjaman ".$product->name.".pdf";
                        $pdf = PDF::loadView('email.perjanjian-pinjaman', $data);
                        $content = $pdf->output();
                        file_put_contents('D:/Documents/'.$filename, $content);

                        $pdfList->push($pdf);
                    }

                    //dd($pdfList);
//            Mail::send('email.surat-perjanjian-pinjaman', $data, function ($message) use ($pdf2, $user, $pdfList) {
//                $message->to("yansen626@gmail.com")
//                    ->subject('Perjanjian Pinjaman di Indofund');
//
//                foreach ($pdfList as $pdf){
//                    $message->attachData($pdf->output(), "Perjanjian Pinjaman.pdf");
//                }
//            });
                    break;
                case 2:
                    break;
            }
            return "success";
        }
        catch (\Exception $ex){
            return "failed : ".$ex;
        }
    }
    public function TestingFunction(){
        try{
            $asf = Utilities::GenerateSuratPerjanjian();
//            dd($asf);
            $trxKredit = '0.00';
            $trxKredit2 = explode(".", $trxKredit);
            $amount = (double) str_replace(',', '',$trxKredit2[0]);
            $is0 = $amount == 0.0;
//            dd(!$is0);

            $asdf = TransactionUnit::InstallmentPaymentProcess('bd42c7d0-8f1b-11e8-b813-4d521d9a648a');
//            dd($asdf);
        }
        catch (\Exception $ex){
            return "failed : ".$ex;
        }
    }
}