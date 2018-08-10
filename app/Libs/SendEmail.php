<?php
/**
 * Created by PhpStorm.
 * User: GMG-Executive
 * Date: 04/10/2017
 * Time: 10:22
 */

namespace App\Libs;

use App\Mail\AcceptPenarikan;
use App\Mail\ContactUs;
use App\Mail\DetailPembayaran;
use App\Mail\EmailVerification;
use App\Mail\InvoicePembelian;
use App\Mail\PerjanjianLayanan;
use App\Mail\PerjanjianPinjaman;
use App\Mail\ReminderInstallment;
use App\Mail\RequestVerification;
use App\Mail\RequestWithdrawInvestor;
use App\Mail\SendProspectus;
use App\Mail\Subscribe;
use App\Mail\TopUpSaldo;
use App\Mail\VerificationKTP;
use App\Models\Vendor;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;

class SendEmail
{
    //generate invoice number
    public static function SendingEmail($option, $data) {
        try{
            $objData = (object) $data;
            switch ($option) {
                case 'emailVerification' :
                    $user = $objData->user;
                    $emailVerify = new EmailVerification($user);
                    Mail::to($user->email)
                        ->bcc("ryanfilbert@gdrive.id")
                        ->bcc("indofund.id@gmail.com")
                        ->send($emailVerify);
//                    Mail::to("ryanfilbert@gdrive.id")->send($emailVerify);
//                    Mail::to("indofund.id@gmail.com")->send($emailVerify);
                    break;

                case 'requestVerification' :
                    $user = $objData->user;

                    $requestVerification = new RequestVerification($user);
//                    Mail::to($user->email)->send($requestVerification);
                    Mail::to("ryanfilbert@gdrive.id")->send($requestVerification);
                    Mail::to("vina.marintan@gmail.com")->send($requestVerification);
                    Mail::to("indofund.id@gmail.com")->send($requestVerification);
//                    Mail::to("contact@mail.indofund.id")->send($requestVerification);
                    break;

                case 'verificationKTP' :
                    $user = $objData->user;
                    $description = $objData->description;

                    $subscribeEmail = new VerificationKTP($user, $description);
                    Mail::to($user->email)->send($subscribeEmail);
                    break;

                case 'contactUs' :
                    $name = $objData->name;
                    $email = $objData->email;
                    $phone = $objData->phone;
                    $description = $objData->description;
                    Utilities::ExceptionLog($name." ".$email." ".$phone." ".$description);

                    $contactUsEmail = new ContactUs($name, $email, $phone, $description);
                    Mail::to("ryanfilbert@gdrive.id")->send($contactUsEmail);
                    Mail::to("vina.marintan@gmail.com")->send($contactUsEmail);
                    Mail::to("indofund.id@gmail.com")->send($contactUsEmail);
//                    Mail::to("contact@mail.indofund.id")->send($contactUsEmail);
                    break;


                case 'subscribe' :
                    $email = $objData->email;
                    $name = $objData->name;

                    $subscribeEmail = new Subscribe($name, $email);
                    Mail::to($email)->send($subscribeEmail);
                    break;

                case 'withdrawalRequest' :
                    $newStatement = $objData->newStatement;
                    $user = $objData->user;
                    $ip = $objData->ip;

                    Mail::to($user->email)
                        ->bcc("ryanfilbert@gdrive.id")
                        ->bcc("indofund.id@gmail.com")
                        ->send(new RequestWithdrawInvestor($newStatement, $user, $ip));
                    break;

                case 'withdrawalAccepted' :
                    $walletStatement = $objData->walletStatement;
                    $userData = $objData->user;

                    $acceptWithdrawalEmail = new AcceptPenarikan($walletStatement, $userData, 1);
                    Mail::to($userData->email)
                        ->bcc("ryanfilbert@gdrive.id")
                        ->bcc("indofund.id@gmail.com")
                        ->send($acceptWithdrawalEmail);
                    break;


                case 'withdrawalRejected' :
                    $walletStatement = $objData->walletStatement;
                    $userData = $objData->user;

                    $acceptWithdrawalEmail = new AcceptPenarikan($walletStatement, $userData, 0);
                    Mail::to($userData->email)
                        ->bcc("ryanfilbert@gdrive.id")
                        ->bcc("indofund.id@gmail.com")
                        ->send($acceptWithdrawalEmail);
                    break;

                case 'OrderAccepted' :
//                    $walletStatement = $objData->walletStatement;
//                    $userData = $objData->user;
//
//                    $acceptWithdrawalEmail = new AcceptPenarikan($walletStatement, $userData);
//                    Mail::to($userData->email)->send($acceptWithdrawalEmail);
                    break;

                case 'sendProspectus' :

                    $email = $objData->email;
                    $fileName = $objData->filename;

                    //change valid file name
                    $file_path = $fileName;

                    $sendProspectus = new SendProspectus($file_path);
                    Mail::to($email)->send($sendProspectus);
                    break;

                //send document "perjanjian Pinjaman" to borrower
                case 'PerjanjianPinjaman' :
                    $userData = $objData->user;
                    $data = array(
                        'user'=>$objData->user,
                        'productInstallments' => $objData->productInstallment,
                        'product' => $objData->product,
                        'vendor' => $objData->vendor
                    );
                    $pdf2 = PDF::loadView('email.perjanjian-pinjaman', $data);
                    Mail::send('email.surat-perjanjian-pinjaman', $data, function ($message) use ($pdf2, $userData) {
                        $message->to($userData->email)->subject('Perjanjian Pinjaman di Indofund');

                        $message->attachData($pdf2->output(), "Perjanjian Pinjaman.pdf");
                    });
                    break;

                case 'DetailPembayaran' :

                    $transaction = $objData->transaction;
                    $userData = $objData->user;
                    $payment = $objData->paymentMethod;
                    $product = $objData->product;

                    $vendor = Vendor::where('user_id', $userData->id)->first();
                    $data = array(
                        'transaction' => $objData->transaction,
                        'user'=>$objData->user,
                        'paymentMethod' => $objData->paymentMethod,
                        'product' => $objData->product,
                        'vendor' => $vendor
                    );

                    $detailPembayaran = new DetailPembayaran($payment, $transaction, $product, $userData);
                    Mail::to($userData->email)
                        ->bcc("ryanfilbert@gdrive.id")
                        ->bcc("indofund.id@gmail.com")
                        ->send($detailPembayaran);
//                    Mail::to("ryanfilbert@gdrive.id")->send($detailPembayaran);
//                    Mail::to("indofund.id@gmail.com")->send($detailPembayaran);

                    break;

                case 'successTransaction' :

                    $transaction = $objData->transaction;
                    $userData = $objData->user;
                    $payment = $objData->paymentMethod;
                    $product = $objData->product;

                    $vendor = Vendor::where('user_id', $userData->id)->first();
                    $data = array(
                        'transaction' => $objData->transaction,
                        'user'=>$objData->user,
                        'paymentMethod' => $objData->paymentMethod,
                        'product' => $objData->product,
                        'vendor' => $vendor,
                        'productInstallments' => $objData->productInstallment,
                    );

                    // payment confirmed send email
                    $invoiceEmail = new InvoicePembelian($payment, $transaction, $product, $userData);
                    Mail::to($userData->email)->send($invoiceEmail);
                    Mail::to("ryanfilbert@gdrive.id")->send($invoiceEmail);
                    Mail::to("indofund.id@gmail.com")->send($invoiceEmail);

                    //send document "perjanjian layanan" to user
                    $pdf = PDF::loadView('email.perjanjian-layanan', $data);
                    Mail::send('email.surat-perjanjian-layanan', $data, function ($message) use ($pdf, $userData) {
                        $message->to($userData->email)->subject('Perjanjian Layanan Pinjam Meminjam di Indofund');

                        $message->attachData($pdf->output(), "Perjanjian Layanan.pdf");
                    });
                    break;

                    // dana telah diterima status = 5
                case 'acceptedTransaction' :

                    break;
                case 'collectedFund' :

                    break;

                // notif email for topup saldo
                case 'topupSaldo' :
                    $userDB = $objData->user;
                    $desription = $objData->description;
                    $userGetFinal = $objData->userGetFinal;

                    $topupEmail = new TopUpSaldo($userDB, $desription, $userGetFinal);
//                    dd($topupEmail);
                    Mail::to($userDB->email)->send($topupEmail);
                    break;

                //proyek berjalan
                case 'acceptCollectedFund' :
                    $project = $objData->project;
                    $vendorData = $objData->vendorData;
                    $data = array(
                        'vendor'    => $vendorData,
                        'project'   => $project
                    );

                    Mail::send('email.proyek-berjalan', $data, function ($message) use ($project, $vendorData) {
                        $message->to($vendorData->email)->subject('Dana project telah terkumpul di Indofund');
                    });

                    break;
                // proyek tidak berjalan
                case 'acceptFailedFund' :
                    $project = $objData->project;
                    $vendorData = $objData->vendorData;
                    $percentage = $objData->percentage;
                    $data = array(
                        'vendor'        => $vendorData,
                        'project'       => $project,
                        'percentage'    => $percentage
                    );

                    Mail::send('email.proyek-tidak-berjalan', $data, function ($message) use ($project, $vendorData) {
                        $message->to($vendorData->email)->subject('Dana project gagal terkumpul di Indofund');
                    });

                    break;
                // pembayaran pinjaman proyek di indofund.id
                case 'installmentPayment' :
                    break;

                //tagihan pinjaman proyek
                case 'reminderInstallment' :
                    $userData = $objData->user;
                    $product = $objData->product;
                    $productInstallment = $objData->productInstallment;

                    $reminderInstallment = new ReminderInstallment($userData, $product, $productInstallment);
                    Mail::to($userData->email)
                        ->bcc("ryanfilbert@gdrive.id")
                        ->bcc("indofund.id@gmail.com")
                        ->send($reminderInstallment);
//                    Mail::to("ryanfilbert@gdrive.id")->send($reminderInstallment);
//                    Mail::to("indofund.id@gmail.com")->send($reminderInstallment);
                    break;
                case 'testing' :

                    $userData = $objData->userData;
                    $vendor = Vendor::where('user_id', $userData->id)->first();
                    $data = array(
                        'transaction' => $objData->transaction,
                        'user'=>$objData->userData,
                        'paymentMethod' => $objData->payment,
                        'product' => $objData->product,
                        'vendor' => $vendor
                    );

//                dd($data);
                    $pdf = PDF::loadView('email.perjanjian-layanan', $data);
                    $pdf2 = PDF::loadView('email.perjanjian-pinjaman', $data);
                    Mail::send('email.surat-perjanjian-layanan', $data, function ($message) use ($pdf, $pdf2, $userData) {
                        $message->to($userData->email)->subject('test surat perjanjian');

                        $message->attachData($pdf->output(), "Perjanjian Layanan.pdf");
                        $message->attachData($pdf2->output(), "Perjanjian Pinjaman.pdf");
                    });
                    break;
            }
        }
        catch (\Exception $ex){
            dd($ex);
            Utilities::ExceptionLog('SendEmail.php > SendingEmail ('.$option.') ========> '.$ex);
        }
    }
}