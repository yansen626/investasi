<?php
/**
 * Created by PhpStorm.
 * User: GMG-Developer
 * Date: 30/08/2017
 * Time: 10:53
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WalletStatement;
use App\Notifications\NewOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user_admins');
    }


    public function index(){

        //finish transaction
        $trxTotal = Transaction::where('status_id', 9)->get()->count();

        //new customer not verified
        $startDate = Carbon::now('Asia/Jakarta')->subDay(30);
        $finishDate = Carbon::now('Asia/Jakarta');
        $newCustomerTotal = User::where('status_id', 3)
            ->whereBetween('created_at', [$startDate, $finishDate])
            ->get()->count();

        //wallet withdraw
        $walletWithdraw = WalletStatement::where('status_id',3)->get()->count();

        //new transaction
        $newOrderTotal = Transaction::where('status_id', 3)->get()->count();

        $onGoingPaymentTotal = Transaction::where('status_id', 3)
            ->orWhere('status_id',4)
            ->get()->count();
        $onGoingPaymentBankTotal = Transaction::where('payment_method_id', 1)
            ->where('status_id', 3)->orWhere('status_id', 4)
            ->get()->count();

        $raisingDone = Product::where('status_id', 22)->get()->count();

        //get 2 days transfer
        $startDate = Carbon::now('Asia/Jakarta')->subDay();
        $finishDate = Carbon::now('Asia/Jakarta')->addDay();
        $twoDayTransfer = Transaction::where('payment_method_id', 1)
            ->where('status_id', 5)
            ->whereBetween('two_day_due_date', [$startDate, $finishDate])
            ->get()->count();

        $data =[
            'trxTotal'              => $trxTotal,
            'newCustomerTotal'         => $newCustomerTotal,
            'newOrderTotal'         => $newOrderTotal,
            'walletWithdraw'         => $walletWithdraw,
            'onGoingPaymentTotal'   => $onGoingPaymentTotal,
            'raisingDone'   => $raisingDone,
            'onGoingPaymentBankTotal'   => $onGoingPaymentBankTotal,
            'twoDayTransfer'   => $twoDayTransfer
        ];

        return View('admin.dashboard')->with($data);
    }
}