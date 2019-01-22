<?php
/**
 * Created by PhpStorm.
 * User: yanse
 * Date: 09-Oct-17
 * Time: 10:57 AM
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Libs\UrgentNews;
use App\Models\Product;
use App\Models\ProductInstallment;
use App\Models\Transaction;
use App\Models\WalletStatement;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function GetChartData(){
        $user = Auth::user();
        $userId = $user->id;

        $parentArr = [];
        $colsArr = [];
        $rowsArr = [];

    }

    public function Portfolio($tab)
    {
        if(!auth()->check()){
            return redirect()->route('index');
        }

        $user = Auth::user();
        $userId = $user->id;
        $blogs = UrgentNews::GetBlogList($userId);

        if(count($blogs) > 0){
            return View('frontend.show-blog-urgents', compact('blogs'));
        }

        $productSahamHasil = Product::select('id')->wherein('category_id', [1, 3])->where('status_id', 1)->orderByDesc('created_on')->get();
        $productHutang = Product::select('id')->wherein('category_id', [2, 6])->wherein('status_id', [21,22,23])->orderByDesc('created_on')->get();

        $transactionPending = Transaction::where('user_id', $userId)->where('status_id', 3)->orderByDesc('created_on')->get();
        $transactionSahamHasil = Transaction::where('user_id', $userId)->wherein('product_id', $productSahamHasil)->orderByDesc('created_on')->get();
        $transactionHutang = Transaction::where('user_id', $userId)->where('status_id', 5)->wherein('product_id', $productHutang)->orderByDesc('created_on')->get();

        $userDompet = $user->wallet_amount;
        $userPendapatan = $user->income;
        $userInvestasi = Transaction::where('user_id', $userId)->where('status_id', 5)->sum('total_price');
        $userInvestasiFormated = number_format($userInvestasi,0, ",", ".");

        //summary portfolio
        $onGoingProductIds = Transaction::select('product_id')
            ->where('user_id', "6fa921f0-493e-11e8-9760-5f8fe286ae19")
            ->where('status_id', 5)
            ->groupBy('product_id')
            ->get();

        $collection = collect(['name', 'total', 'progress', 'return', 'status']);
        $transactionSummary = collect();
        foreach($onGoingProductIds as $onGoingProductId){
            $total = Transaction::where('product_id', $onGoingProductId->product_id)
                ->where('user_id', $userId)
                ->where('status_id', 5)
                ->sum('total_price');
            $total = number_format($total, 0, ",", ".");
            $productDB = Product::where('id', $onGoingProductId->product_id)->first();
            $productInstallmentCount = ProductInstallment::where('product_id', $onGoingProductId->product_id)
                ->where('status_id', 27)->count();

            $walletStatementDB = WalletStatement::where('description', 'like', '%'.$productDB->name.'%')
                ->where('user_id', $userId)
                ->get();
            $walletSum = $walletStatementDB->sum('amount');

            $combined = $collection->combine([
                $productDB->name, $total, $productInstallmentCount." of ".$productDB->tenor_loan,
                $walletSum, $productDB->Status->description
            ]);
            $transactionSummary = $transactionSummary->push($combined);
        }

        $isActiveDebt = ""; $isActiveEquity = "";$isActivePending = "";$isActiveSum = "";
        $isActiveTabDebt = "";$isActiveTabEquity = "";$isActiveTabPending = "";$isActiveTabSum = "";
        if($tab == "debt") {
            $isActiveDebt = "in active";
            $isActiveTabDebt = "class=active";
        }
        else if($tab == "equity") {
            $isActiveEquity = "in active";
            $isActiveTabEquity = "class=active";
        }
        else if($tab == "sum") {
            $isActiveSum = "in active";
            $isActiveTabSum = "class=active";
        }
        else if($tab == "pending") {
            $isActivePending = "in active";
            $isActiveTabPending = "class=active";
        }
//        return View ('frontend.show-portfolio',
//            compact('transactionPending','transactionSahamHasil',
//            'transactionHutang'));
        $data = [
            'transactionPending'=>$transactionPending,
            'transactionSahamHasil'=>$transactionSahamHasil,
            'transactionHutang'=>$transactionHutang,
            'transactionSummary'=>$transactionSummary,
            'user'=>$user,
            'userDompet'=>$userDompet,
            'userPendapatan'=>$userPendapatan,
            'userInvestasi'=>$userInvestasiFormated,
            'isActiveDebt'=>$isActiveDebt,
            'isActiveTabDebt'=>$isActiveTabDebt,
            'isActiveEquity'=>$isActiveEquity,
            'isActiveTabEquity'=>$isActiveTabEquity,
            'isActivePending'=>$isActivePending,
            'isActiveTabPending'=>$isActiveTabPending,
            'isActiveSum'=>$isActiveSum,
            'isActiveTabSum'=>$isActiveTabSum
        ];
        return View ('frontend.show-portfolio')->with($data);
    }


    public function PortfolioDetail($id)
    {
        return View ('frontend.show-portfolio-detail');
    }


    public function SecondaryMarkets()
    {
        $products = Product::where('is_secondary', 1)->get();
        return View ('frontend.show-secondary-markets', compact('products'));
    }
}