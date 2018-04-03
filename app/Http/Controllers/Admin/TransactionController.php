<?php
/**
 * Created by PhpStorm.
 * User: GMG-Developer
 * Date: 30/08/2017
 * Time: 15:31
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Libs\TransactionUnit;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransferConfirmation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user_admins');
    }

    public function index(){
        $transactions = Transaction::all()->sortByDesc('created_on');

        return View('admin.show-transactions', compact('transactions'));
    }

    public function detail($id){
        $transaction = Transaction::find($id);

        return View('admin.show-transaction-details', compact('transaction'));
    }

    public function VAtoRDN(){
        //get 2 days transfer
        $startDate = Carbon::now('Asia/Jakarta')->startOfDay();
        $finishDate = Carbon::now('Asia/Jakarta')->addDays(1)->endOfDay();
//        dd($startDate." | ".$finishDate);
        $twoDayTransfer = Transaction::where('payment_method_id', 1)
            ->where('status_id', 5)
            ->where('two_day_due_date_flag', 0)
            ->whereBetween('two_day_due_date', [$startDate, $finishDate])
            ->orderByDesc('created_on')
            ->get();

        return View('admin.show-VA-RDN', compact('twoDayTransfer'));
    }

    public function acceptVAtoRDN($id){

        $trx = Transaction::find($id);

        //change two_day_due_date_flag
        $trx->two_day_due_date_flag = 1;
        $trx->save();

        Session::flash('message', 'Transfer dari VA ke RDN telah Diterima!');

        return redirect::route('VA-RDN-list');
    }

    public function newOrder(){
        $transactions = Transaction::where('status_id', 3)->orderByDesc('created_on')->get();

        return View('admin.show-new-orders', compact('transactions'));
    }

    public function acceptOrder($id){

        $trx = Transaction::find($id);

        //change status, date etc
        TransactionUnit::transactionAfterVerified($trx->order_id);
        Session::flash('message', 'Transaksi telah diterima!');

        return redirect::route('new-order-list');
    }

    public function rejectOrder(Request $request){

        $trx = Transaction::find(Input::get('reject-trx-id'));

        $trx->status_id = 10;
        if(!empty(Input::get('reject-reason'))){
            $trx->reject_note = Input::get('reject-reason');
        }
        $trx->save();
        Session::flash('message', 'Transaksi telah ditolak!');

        return redirect::route('new-order-list');
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