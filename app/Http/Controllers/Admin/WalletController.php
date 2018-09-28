<?php
/**
 * Created by PhpStorm.
 * User: GMG-Developer
 * Date: 30/08/2017
 * Time: 15:31
 */

namespace App\Http\Controllers\Admin;


use App\Excel\ExcelExport;
use App\Excel\ExcelExportFromView;
use App\Http\Controllers\Controller;
use App\Libs\SendEmail;
use App\Mail\AcceptPenarikan;
use App\Models\Transaction;
use App\Models\TransferConfirmation;
use App\Models\User;
use App\Models\WalletStatement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Maatwebsite\Excel\Facades;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user_admins');
    }

    public function index(){
        $statements = WalletStatement::all()->sortByDesc('created_on');

        return View('admin.show-wallets', compact('statements'));
    }

    public function detail($id){
        $transaction = Transaction::find($id);

        return View('admin.show-transaction-details', compact('transaction'));
    }

    public function newRequest(){
        $statements = WalletStatement::where('status_id', 3)->orderByDesc('date')->get();

        return View('admin.show-wallet-requests', compact('statements'));
    }

    public function acceptOrder($id){
        DB::transaction(function() use ($id){
            $trx = WalletStatement::find($id);

            $trx->status_id = 6;
            $trx->date = Carbon::now('Asia/Jakarta');
            $trx->save();

            Session::flash('message', 'Penarikan Dana Accepted!');

            //Send Email
            $userData = User::find($trx->user_id);
            $data = array(
                'user' => $userData,
                'walletStatement' => $trx
            );
            SendEmail::SendingEmail('withdrawalAccepted', $data);

            Session::flash('message', 'Penarikan Dana Accepted!');
        });

        return redirect::route('dompet-request');
    }

    public function rejectOrder($id){
        DB::transaction(function() use ($id){
            $trx = WalletStatement::find($id);


            $trx->status_id = 7;
            $trx->date = Carbon::now('Asia/Jakarta');
            $trx->save();

            $user = User::find($trx->user_id);
            $userWallet = (double) str_replace('.','', $user->wallet_amount);
            $amount = (double) str_replace('.','', $trx->amount);
            $userWalletFinal = $userWallet + $amount;
            $user->wallet_amount = $userWalletFinal;
            $user->save();

            //Send Email
            $data = array(
                'user' => $user,
                'walletStatement' => $trx
            );
            SendEmail::SendingEmail('withdrawalRejected', $data);

            Session::flash('message', 'Penarikan Dana Rejected!');
        });

        return redirect::route('dompet-request');
    }


    public function MultipleProcessOrder(Request $request){
        $checkboxs = $request["submitCheckbox"];
        $action = $request["action"];
        if($action == "accept"){
            foreach ($checkboxs as $checkboxID){
                if(!empty($checkboxID)){
                    DB::transaction(function() use ($checkboxID){
                        $trx = WalletStatement::find($checkboxID);

                        $trx->status_id = 6;
                        $trx->date = Carbon::now('Asia/Jakarta');
                        $trx->save();

                        //Send Email
                        $userData = User::find($trx->user_id);
                        $data = array(
                            'user' => $userData,
                            'walletStatement' => $trx
                        );
                        SendEmail::SendingEmail('withdrawalAccepted', $data);

                        Session::flash('message', 'Penarikan Dana Accepted!');
                    });
                }
            }
        }
        else{
            foreach ($checkboxs as $checkboxID){
                if(!empty($checkboxID)){
                    DB::transaction(function() use ($checkboxID){
                        $trx = WalletStatement::find($checkboxID);

                        $trx->status_id = 7;
                        $trx->date = Carbon::now('Asia/Jakarta');
                        $trx->save();

                        $user = User::find($trx->user_id);
                        $userWallet = (double) str_replace('.','', $user->wallet_amount);
                        $amount = (double) str_replace('.','', $trx->amount);
                        $userWalletFinal = $userWallet + $amount;
                        $user->wallet_amount = $userWalletFinal;
                        $user->save();

                        Session::flash('message', 'Penarikan Dana Rejected!');
                    });
                }
            }
        }

        return redirect::route('dompet-request');
    }

    public function payment(){
        //$transfers = TransferConfirmation::where('status_id', 4)->get();
        $transactions = Transaction::where('status_id', 3)
            ->orWhere('status_id', 4)
            ->orderByDesc('created_on')->get();

        return View('admin.show-payments', compact('transactions'));
    }

    public function confirmPayment($id){
        $trans = TransferConfirmation::find($id);

        $trans->status_id = 5;
        $trans->save();

        $trx = Transaction::find($trans->trx_id);
        $trx->status_id = 5;
        $trx->save();

        return redirect::route('payment-list');
    }

    public function cancelPayment($id){
        $trx = Transaction::find($id);
        $trx->status_id = 10;
        $trx->finish_date = Carbon::now('Asia/Jakarta')->toDateTimeString();
        $trx->save();

        return redirect::route('payment-list');
    }

    public function deliveryRequest(){
        $transactions = Transaction::where('status_id', 6)->get();

        return View('admin.show-delivery-requests', compact('transactions'));
    }

    public function confirmDelivery(Request $request){
        $trx = Transaction::find(Input::get('delivery-trx-id'));

        $trx->tracking_code = Input::get('tracking-code');
        $trx->status_id = 9;
        $trx->save();

        return redirect::route('delivery-list');
    }

    public function downloadExcel(){
        try {
            $newFileName = "List Penarikan Dana_".Carbon::now('Asia/Jakarta')->format('Ymdhms');
            $walletStatementDB =
                WalletStatement::where('description', 'LIKE', '%Penarikan Dompet%')->where('status_id', 3)->get();
//                DB::select('SELECT CONCAT(b.first_name, \' \', b.last_name) AS name, a.bank_name, a.bank_acc_number, a.transfer_amount
//                            FROM investasi.wallet_statements as a, investasi.users as b
//                            where a.user_id = b.id;');
//                DB::select('SELECT CONCAT(b.first_name, \' \', b.last_name) AS name, a.bank_name, a.bank_acc_number, a.transfer_amount
//                            FROM socmedse_indofund.wallet_statements as a, socmedse_indofund.users as b
//                            where a.user_id = b.id;');

            return Facades\Excel::create($newFileName, function($excel) use ($walletStatementDB) {
                $excel->sheet('New sheet', function($sheet) use ($walletStatementDB) {
                    $sheet->loadView('excel.withdraw', array('walletStatementDB' => $walletStatementDB));
                });
            })->export('xlsx');
//            return Facades\Excel::download(new ExcelExportFromView('wallet'), $newFileName.'.xlsx');
        }
        catch (Exception $ex){
            //Utilities::ExceptionLog($ex);
            return response($ex, 500)
                ->header('Content-Type', 'text/plain');
        }
    }

    public function track($id){
        $trx = Transaction::find($id);

        $client = new Client([
            'base_uri' => 'https://pro.rajaongkir.com/api/waybill',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'key' => env('RAJAONGKIR_API_KEY')
            ],
        ]);

        $request = $client->request('POST', 'https://pro.rajaongkir.com/api/waybill', [
            'form_params' => [
                'waybill' => $trx->tracking_code,
                'courier' => $trx->courier_code,
            ]
        ]);

        if($request->getStatusCode() == 200){
            $collect = json_decode($request->getBody());

            $returnHtml = View('admin.partials._show-tracks',['collect' => $collect])->render();

            return response()->json( array('success' => true, 'html' => $returnHtml) );
        }
    }
}