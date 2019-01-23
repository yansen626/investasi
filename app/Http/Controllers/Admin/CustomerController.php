<?php
/**
 * Created by PhpStorm.
 * User: GMG-Developer
 * Date: 28/08/2017
 * Time: 14:11
 */

namespace App\Http\Controllers\Admin;

use App\Excel\ExcelExport;
use App\Excel\ExcelExportFromView;
use App\Http\Controllers\Controller;
use App\Libs\SendEmail;
use App\Libs\Utilities;
use App\Models\Product;
use App\Models\ProductInstallment;
use App\Models\Referral;
use App\Models\Subscribe;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WalletStatement;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Dompdf\Exception;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades;
use Webpatser\Uuid\Uuid;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user_admins');
    }

    public function index()
    {
        $users = User::orderByDesc('created_at')->get();
        $adminType = Auth::guard('user_admins')->user()->user_type;

        return View('admin.show-customers', compact('users', 'adminType'));
        //return view('admin.show_users')->with('users', $users);
    }
    public function show($id)
    {
        $user = User::find($id);
        $statements = WalletStatement::where('user_id', $id)->orderBy('date', 'Desc')->get();
        $transactions = Transaction::where('user_id', $id)->orderBy('created_on', 'Desc')->get();

        return View('admin.lenders.show-customer', compact('user', 'statements', 'transactions'));
        //return view('admin.show_users')->with('users', $users);
    }
    public function DownloadPdfKtp($filename)
    {
        $file_path = public_path('storage/ktp/'.$filename);
        return response()->download($file_path);
    }

    public function customerAddDana($id){
        $user = User::find($id);

        return View('admin.lenders.create-add-dana', compact('user'));
    }

    public function submitCustomerAddDana(Request $request){
        try{
            DB::transaction(function() use ($request){
                $dateTimeNow = Carbon::now('Asia/Jakarta');

                $userDB = User::find($request->input('user_id'));
                $userWalletDB = (double) str_replace('.','', $userDB->wallet_amount);

                $amount = $request->input('amount');
                $newWallet = $userWalletDB + $amount;
                $userDB->wallet_amount = $newWallet;
                $userDB->save();

                $desription = 'Pembayaran '.$request->input('description');

                $statement = WalletStatement::create([
                    'id'            => Uuid::generate(),
                    'user_id'       => $request->input('user_id'),
                    'description'   => $desription,
                    'saldo'         => $newWallet,
                    'amount'        => $amount,
                    'fee'           => 0,
                    'admin'         => 0,
                    'transfer_amount'=> 0,
                    'status_id'     => 6,
                    'date'          => $dateTimeNow->toDateTimeString(),
                    'created_on'    => $dateTimeNow->toDateTimeString()
                ]);

                Session::flash('message', 'Penambahan Dana Berhasil!');
            });
        }
        catch(\Exception $ex){
            Utilities::ExceptionLog('CustomerController.php > submitCustomerAddDana ========> '.$ex);
        }
        return Redirect::route('customer-list');
    }

    public function customerKtp($id){
        $user = User::find($id);

        return View('admin.show-customer-ktp', compact('user'));
    }

    public function AcceptKTPData($id){
        DB::transaction(function() use ($id){
            $dateTimeNow = Carbon::now('Asia/Jakarta');

            $user = User::find($id);
            $user->ktp_verified = 1;
            $user->save();

            //send email to notify user
            $data = array(
                'user' => $user,
                'description' => "Kami telah melakukan verifikasi data anda di indofund.id namun data yang anda masukkan belum 
                    lengkap sehingga kami belum bisa melakukan verifikasi lebih lanjut, mohon kirimkan ulang foto ktp beserta data 
                    secara tepat dan sesuai"
            );
            SendEmail::SendingEmail('verificationKTP', $data);

            Session::flash('message', 'Data KTP User Accepted!');
        });
        return Redirect::route('customer-list');

    }
    public function RejectKTPData($id){
        DB::transaction(function() use ($id){

            $user = User::find($id);
            $user->ktp_verified = 0;
//
//            $user->identity_number = null;
//            $user->citizen = null;
//            $user->address_ktp = null;
//            $user->city_ktp = null;
//            $user->province_ktp = null;
//            $user->postal_code_ktp = null;
//            $user->name_ktp = null;
//            $user->img_ktp = null;
            $user->save();

            //send email to notify user
            $data = array(
                'user' => $user,
                'description' => "Kami telah melakukan verifikasi foto KTP beserta data anda di indofund.id."
            );
            SendEmail::SendingEmail('verificationKTP', $data);

            Session::flash('message', 'Data KTP User Rejected!');
        });
        return Redirect::route('customer-list');
    }

    public function subscribe()
    {
        $subscribes = Subscribe::all();

        return View('admin.show-subscribes', compact('subscribes'));
        //return view('admin.show_users')->with('users', $users);
    }

    public function referral()
    {
        $referrals = Referral::all();

        return View('admin.lenders.show-referrals', compact('referrals'));
        //return view('admin.show_users')->with('users', $users);
    }


    public function downloadExcel(){
        try {
            $newFileName = "List transaction_".Carbon::now('Asia/Jakarta')->format('Ymdhms');

            $datetimeNow = Carbon::now('Asia/Jakarta');
            $datetimeStart = Carbon::create('2018', 8, 1, 0,0,0,'Asia/Jakarta');

            $subscribeListDB = Transaction::where('status_id', 5)
                ->whereBetween('due_date', [$datetimeStart, $datetimeNow])
                ->get();

            return Facades\Excel::create($newFileName, function($excel) use ($subscribeListDB) {
                $excel->sheet('New sheet', function($sheet) use ($subscribeListDB) {
                    $sheet->loadView('excel.transaction', array('subscribeListDB' => $subscribeListDB));
                });
            })->export('xlsx');
//            $newFileName = "List productInstallment_".Carbon::now('Asia/Jakarta')->format('Ymdhms');
//
//            $datetimeNow = Carbon::now('Asia/Jakarta');
//            $datetimeStart = Carbon::create('2018', 8, 1, 0,0,0,'Asia/Jakarta');
//            $subscribeListDB = ProductInstallment::whereBetween($datetimeStart, $datetimeNow)->get();
//
//            return Facades\Excel::create($newFileName, function($excel) use ($subscribeListDB) {
//                $excel->sheet('New sheet', function($sheet) use ($subscribeListDB) {
//                    $sheet->loadView('excel.transaction', array('subscribeListDB' => $subscribeListDB));
//                });
//            })->export('xlsx');
//            $subscribeListDB = Product::all();
//
//            return Facades\Excel::create($newFileName, function($excel) use ($subscribeListDB) {
//                $excel->sheet('New sheet', function($sheet) use ($subscribeListDB) {
//                    $sheet->loadView('excel.transaction', array('subscribeListDB' => $subscribeListDB));
//                });
//            })->export('xlsx');

//            $newFileName = "List Subscribe_".Carbon::now('Asia/Jakarta')->format('Ymdhms');
//
//            $subscribeListDB = Subscribe::all();
//
//            return Facades\Excel::create($newFileName, function($excel) use ($subscribeListDB) {
//                $excel->sheet('New sheet', function($sheet) use ($subscribeListDB) {
//                    $sheet->loadView('excel.subscribe', array('subscribeListDB' => $subscribeListDB));
//                });
//            })->export('xlsx');
        }
        catch (Exception $ex){
            //Utilities::ExceptionLog($ex);
            return response($ex, 500)
                ->header('Content-Type', 'text/plain');
        }
    }

    public function downloadMCMData(){
        try {
//            $customerListDB =
//                DB::select('SELECT va_acc, upper(concat(first_name, " ", last_name)) as name  FROM investasi.users;');
//                DB::select('SELECT va_acc, upper(concat(first_name, " ", last_name)) as name  FROM socmedse_indofund.users;');

            $customerList = User::all();
            return Facades\Excel::create('88795', function($excel) use ($customerList) {
                $excel->sheet('New sheet', function($sheet) use ($customerList) {
                    $sheet->loadView('excel.mcm', array('customerListDB' => $customerList));
                });
            })->export('xlsx');
//            return Facades\Excel::download(new ExcelExportFromView('mcm'), '88795.xlsx');
        }
        catch (Exception $ex){
            //Utilities::ExceptionLog($ex);
            return response($ex, 500)
                ->header('Content-Type', 'text/plain');
        }

//        try {
//            $users = User::all();
//            $newFileName = "88795";
//            $filePath = '/88795.xls';
//
//            $path = public_path('document/');
//            Facades\Excel::load($path . $filePath, function($reader) use($users)
//            {
//                $reader->sheet('44_tagihan_2_periode_20171', function($sheet) use($users)
//                {
//                    $idx = 2;
//                    foreach ($users as $user) {
//                        //Set Name
//                        $name = strtoupper($user->first_name . " " . $user->last_name);
//                        $date = Carbon::parse($user->created_at)->format('j F Y');
//
//                        //Set The field Data
//                        $sheet->getCell('A'.$idx)->setValueExplicit($user->va_acc);
//                        $sheet->getCell('D'.$idx)->setValueExplicit("IDR");
//                        $sheet->getCell('E'.$idx)->setValueExplicit($name);
//                        $sheet->getCell('AD'.$idx)->setValueExplicit($date);
//                        $sheet->getCell('AE'.$idx)->setValueExplicit("20220831");
//                        $sheet->getCell('AF'.$idx)->setValueExplicit("01\TOTAL\TOTAL\\10");
//                        $sheet->getCell('AG'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AH'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AI'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AJ'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AK'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AL'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AM'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AN'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AO'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AP'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AQ'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AR'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AS'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AT'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AU'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AV'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AW'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AX'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AY'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('AZ'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('BA'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('BB'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('BC'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('BD'.$idx)->setValueExplicit("\\\\");
//                        $sheet->getCell('BE'.$idx)->setValueExplicit("~");
//
//                        $idx++;
//                    }
//                });
//            })
//            ->setFilename($newFileName)
//            ->export('xlsx');
//        }
//        catch (Exception $ex){
//
//        }
    }
}