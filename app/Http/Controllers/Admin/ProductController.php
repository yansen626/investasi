<?php
/**
 * Created by PhpStorm.
 * User: GMG-Developer
 * Date: 30/08/2017
 * Time: 12:01
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Libs\SendEmail;
use App\Libs\TransactionUnit;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductInstallment;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vendor;
use App\Models\WalletStatement;
use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Webpatser\Uuid\Uuid;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user_admins');
    }

    public function index(){
        $products = Product::all()->sortByDesc('created_on');

        return View('admin.show-products', compact('products'));
    }

    public function RequestBlogProduct($productId){
        $categories = Category::all();
        $product = Product::find($productId);

        return View('admin.create-blog', compact('categories', 'product'));
    }

    public function ProductRequest(){
        $products = Product::Where('status_id', 3)->get()->sortByDesc('created_on');

        return View('admin.show-product-requests', compact('products'));
    }

    public function ProductCollectedFund(){
        $adminType = Auth::guard('user_admins')->user()->user_type;
        $products = Product::Where('status_id', 22)->get()->sortByDesc('created_on');

        return View('admin.show-product-collected-funds', compact('products', 'adminType'));
    }

    /*
     * process for 100% collected fund
     */
    public function AcceptCollectedFund($id){

        $product = Product::find($id);

        $adminType = Auth::guard('user_admins')->user()->user_type;
        //admin confirmation
        if($product->confirmation_1 == 0 && $adminType == 2){
            $product->confirmation_1 = 1;
            $product->save();

            Session::flash('message', 'Admin Berhasil konfirmasi!');
        }
        // moderator / supperadmin confirmation
        else if($product->confirmation_1 == 1 && $product->confirmation_2 == 0 && $adminType == 1){

            DB::transaction(function() use ($product){

                $product->confirmation_2 = 1;
                $product->status_id = 23;
                $product->save();

                //send fund to project owner
//                $userDB = User::find($product->user_id);
//                $userWalletDB = (double) str_replace('.','', $userDB->wallet_amount);
//                $collectedFund = (double) str_replace('.','', $product->raised);
//                $userDB->wallet_amount = $userWalletDB + $collectedFund;
//                $userDB->save();

                //update project installment due date
                $productInstallments = ProductInstallment::where('product_id',$product->id)->get();

                foreach ($productInstallments as $productInstallment){
                    $dateTimeNow = Carbon::now('Asia/Jakarta');
                    $productMonth = $productInstallment->month;
                    $intervalDay = $productMonth * 30;
                    $productInstallment->due_date = $dateTimeNow->addDays($intervalDay);
                    $productInstallment->save();
                }

                //send email notfication to project owner, fund collected
//                $data = array(
//                    'vendorData'    => $userDB,
//                    'project'       => $product
//                );
//                SendEmail::SendingEmail('acceptCollectedFund', $data);

                Session::flash('message', 'Superadmin Berhasil konfirmasi!');
            });
        }
        else{
            Session::flash('message', 'Gagal dalam melakukan tindakan!');
        }

        return Redirect::route('product-collected-fund');
    }

    public function ProductFailedFund(){
        $adminType = Auth::guard('user_admins')->user()->user_type;
        $products = Product::Where('status_id', 26)->get()->sortByDesc('created_on');

        return View('admin.show-product-failed-funds', compact('products', 'adminType'));
    }

    public function AcceptFailedFund($id){

        $product = Product::find($id);

        $adminType = Auth::guard('user_admins')->user()->user_type;
        //admin confirmation
        if($product->confirmation_1 == 0 && $adminType == 2){
            $product->confirmation_1 = 1;
            $product->save();

            Session::flash('message', 'Admin Berhasil konfirmasi!');
        }
        // moderator / supperadmin confirmation
        else if($product->confirmation_1 == 1 && $product->confirmation_2 == 0 && $adminType == 1){

            DB::transaction(function() use ($product){
                $product->confirmation_2 = 1;
                $product->status_id = 25;
                $product->save();

                $transactionDB = Transaction::where('product_id', $product->id)->get();

                foreach ($transactionDB as $trx){
                    //send fund to original lender
                    $userDB = User::find($trx->user_id);
                    $userWalletDB = (double) str_replace('.','', $userDB->wallet_amount);
                    $collectedFund = (double) str_replace('.','', $trx->total_price);
                    $userDB->wallet_amount = $userWalletDB + $collectedFund;
                    $userDB->save();

                    //send email notfication to every lender if project failed
                    //Calculate Percentage
                    $productRaised = (double) str_replace('.','', $product->raised);
                    $productRaising = (double) str_replace('.','', $product->raising);
                    $percentage = $productRaised / $productRaising * 100;
                    $data = array(
                        'vendorData'    => $userDB,
                        'project'       => $product,
                        'percentage'    => $percentage
                    );
                    SendEmail::SendingEmail('acceptFailedFund', $data);
                }

                Session::flash('message', 'Superadmin Berhasil konfirmasi!');
            });
        }
        else{
            Session::flash('message', 'Gagal dalam melakukan tindakan!');
        }

        return Redirect::route('product-failed-fund');
    }

    /*
     * function to get lender list of a project
     * */
    public function ProductInvestorList($id){
        $productDB = Product::find($id);
        $transactionDB = Transaction::where('product_id', $id)->get();

        return View('admin.show-product-investors', compact('transactionDB', 'productDB'));
    }

    public function ProductInstallmentDetail($id){
        $productDB = Product::find($id);
        $productInstallments = ProductInstallment::where('product_id', $id)->get();
        $transactionDB = Transaction::where('product_id', $id)->where('status_id', 5)->get();

        return View('admin.product.show-product-installment', compact('transactionDB', 'productDB', 'productInstallments'));
    }

    public function ProductInstallmentPayment($id){
        try{
            $productInstallments = ProductInstallment::find($id);
            $isSuccess = TransactionUnit::InstallmentPaymentProcess($id);

//            $paid_amount = (double) str_replace('.','', $productInstallments->paid_amount);
//            $raised = (double) str_replace('.','', $productInstallments->product->raised);
//
//            $transactionList = Transaction::where('product_id', $productInstallments->product_id)->where('status_id', 5)->get();
//            $asdf = array();
//            DB::transaction(function() use ($productInstallments, $transactionList, $paid_amount, $raised, $asdf) {
//
//                foreach ($transactionList as $transaction){
//
//                    $dateTimeNow = Carbon::now('Asia/Jakarta');
//                    $userDB = User::find($transaction->user_id);
//                    $userAmount = (double) str_replace('.','', $transaction->total_price);
//
//                    $userGetTemp = number_format((($userAmount*100) / $raised),2);
//
//                    $userGetFinal = round(($userGetTemp * $paid_amount) / 100);
//                    $userSaldoFinal = (double) str_replace('.','', $userDB->wallet_amount);
//                    $userSaldoFinal = $userSaldoFinal + $userGetFinal;
//                    $desription = 'Pembayaran cicilan dan bunga ke-'.$productInstallments->month.' dari '.$productInstallments->product->name;
//
//                    //add wallet statement
//                    $statement = WalletStatement::create([
//                        'id'            =>Uuid::generate(),
//                        'user_id'       => $transaction->user_id,
//                        'description'   => $desription,
//                        'saldo'         => $userSaldoFinal,
//                        'amount'        => $userGetFinal,
//                        'fee'           => 0,
//                        'admin'         => 0,
//                        'transfer_amount'=> 0,
//                        'status_id'     => 6,
//                        'date'          => $dateTimeNow->toDateTimeString(),
//                        'created_on'    => $dateTimeNow->toDateTimeString()
//                    ]);
//
//                    //change user wallet amount
//                    $userDB->wallet_amount = $userSaldoFinal;
//                    $userDB->save();
//
//                    //send email to user
//                    $data = array(
//                        'user'=>$userDB,
//                        'description' => $desription,
//                        'userGetFinal' => $userGetFinal
//                    );
//                    SendEmail::SendingEmail('topupSaldo', $data);
//
//                }
//                //change product installment status
//                $productInstallments->status_id = 27;
//                $productInstallments->save();
//            });

            if($isSuccess){
                Session::flash('message', 'Pembayaran cicilan dan bunga Berhasil!');
            }
            else{
                Session::flash('message', 'Terjadi kesalahan pada proses!');
            }

            return Redirect::route('product-installment', ['id' => $productInstallments->product_id]);
        }
        catch (Exception $ex){
            Session::flash('message', 'Terjadi kesalahan pada proses!');

            return Redirect::route('product-installment', ['id' => $productInstallments->product_id]);
        }
    }

    public function create($id){
        $vendorDB = Vendor::find($id);
        $categories = Category::all();

        return View('admin.create-product', compact('categories', 'vendorDB'));
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'vendor_id'         => 'required',
            'project_image'         => 'required',
            'project_name'          => 'required',
            'project_tagline'       => 'required',
            'category'              => 'required',
            'raising'               => 'required',
            'days_left'             => 'required',
            'tenor_loan'            => 'required',
            'description'           => 'required',
            'interest_rate'           => 'required',
//            'installment_per_month'           => 'required',
//            'interest_per_month'           => 'required',
            'prospectus'           => 'required',
        ],
            [
                'project_image.required'   => 'Gambar Proyek harus diisi',
                'project_name.required'   => 'Nama Proyek harus diisi',
                'project_tagline.required'   => 'Tagline Proyek harus diisi',
                'category.required'   => 'Ketegori harus diisi',
                'raising.required'   => 'Total Pendanaan harus diisi',
                'days_left.required'   => 'Durasi Pengumpulan Dana harus diisi',
                'tenor_loan.required'   => 'Durasi Pinjaman harus diisi',
                'description.required'   => 'Deskripsi Proyek harus diisi',
                'interest_rate.required'   => 'Suku Bunga Proyek harus diisi',
//                'installment_per_month.required'   => 'Cicilan / Bulan harus diisi',
//                'interest_per_month.required'   => 'Bunga / Bulan harus diisi',
                'prospectus.required'   => 'Product Disclosure Statement Proyek harus diisi',

            ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $vendorDB = Vendor::find($request['vendor_id']);
        $vendorID = $vendorDB->id;
        $userID = $vendorDB->user_id;
        $vendor_va_acc = $vendorDB->vendor_va;
        $productID = Uuid::generate();

        DB::transaction(function() use ($request, $vendorDB, $vendorID, $userID, $vendor_va_acc, $productID){
            $interestPerMonths = "";
            $installmentPerMonths = "";
            $interestPerMonths = $request['interest_per_month'];
            $installmentPerMonths = $request['installment_per_month'];
            $isNullMemberInterest = in_array(null, $interestPerMonths, true);
            $isNullMemberInstallment = in_array(null, $installmentPerMonths, true);

            if($isNullMemberInterest || $isNullMemberInstallment){
                return back()->withErrors("Cicilan&Bunga / bulan harus diisi semua")->withInput();
            }

//            dd($request);
            $dateTimeNow = Carbon::now('Asia/Jakarta');

//        create new product
            $newProduct = Product::create([
                'id' => $productID,
                'category_id' => $request['category'],
                'name' => $request['project_name'],
                'user_id' => $userID,
                'vendor_id' => $vendorID,
                'tagline' => $request['project_tagline'],
                'raising' => $request['raising'],
                'days_left' => $request['days_left'],
                'description' => $request['description'],
                'interest_rate' => $request['interest_rate'],
                'business_class' => $request['business_class'],
                'prospectus_path' => $request['prospectus'],
//                'installment_per_month' => $request['installment_per_month'],
//                'interest_per_month' => $request['interest_per_month'],
                'tenor_loan' => $request['tenor_loan'],
                'is_secondary' => 0,
                'status_id' => 3,
                'created_on'        => $dateTimeNow->toDateTimeString()
            ]);

            //get youtube code
            $url = $request['youtube'];
            if(strpos($url, 'https://www.youtube.com') !== false){
                if(strpos($url, 'embed') !== false){
                    $splitedUrl = explode("https://www.youtube.com/embed/",$url);
                    $newProduct->youtube_link = $splitedUrl[1];

                }
                else if(strpos($url, 'watch?') !== false){
                    $splitedUrl = explode("https://www.youtube.com/watch?v=",$url);
                    $newProduct->youtube_link = $splitedUrl[1];
                }
                else{
                    $splitedUrl = explode("https://www.youtube.com",$url);
                    $newProduct->youtube_link = $splitedUrl[1];
                }
            }
            if(strpos($url, 'youtu.be') !== false){
                $splitedUrl = explode("https://youtu.be/",$url);
                $newProduct->youtube_link = $splitedUrl[1];
            }

            // Get image extension
            $img = Image::make($request->file('project_image'));
            $extStr = $img->mime();
            $ext = explode('/', $extStr, 2);

            $filename = $request['project_name'].'_'.Carbon::now('Asia/Jakarta')->format('Ymdhms'). '.'. $ext[1];

            $img->save(public_path('storage/project/'. $filename), 75);
            $newProduct->image_path = $filename;
            $newProduct->save();

            // save pdf
//            $filenamePDF = $request['project_name'].'_'.Carbon::now('Asia/Jakarta')->format('Ymdhms').'.pdf';
//            $destinationPath = public_path('storage/project/');
//
//            $request->file('prospectus')->move($destinationPath, $filenamePDF);
//            $newProduct->prospectus_path = $filenamePDF;
//            $newProduct->save();

//        create product ciclan & bunga
            for($i=0;$i<$request['tenor_loan'];$i++){
                $totalPayment = $installmentPerMonths[$i] + $interestPerMonths[$i];
                $newProduct = ProductInstallment::create([
                    'id'            =>Uuid::generate(),
                    'product_id'    => $productID,
                    'month'         => $i + 1,
                    'amount'        => $installmentPerMonths[$i],
                    'interest_amount'        => $interestPerMonths[$i],
                    'paid_amount'        => $totalPayment,
                    'vendor_va'        => $vendor_va_acc,
                    'status_id'     => 1,
                    'created_on'    => $dateTimeNow->toDateTimeString()
                ]);
            }

        });

        return Redirect::route('vendor-list');
    }

    public function AcceptRequest($id){
        DB::transaction(function() use ($id){
            $dateTimeNow = Carbon::now('Asia/Jakarta');

            $product = Product::find($id);
            $product->status_id = 21;
            $product->due_date = $dateTimeNow->addDays($product->days_left);
            $product->save();

            Session::flash('message', 'Project Accepted!');
        });
        return Redirect::route('product-request');
    }

    public function RejectRequest($id){
        DB::transaction(function() use ($id){

            $product = Product::find($id);
            $product->status_id = 7;
            $product->save();

            //send email to borrower
            $data = array(
                'user'=>User::find($product->user_id),
                'productInstallment' => ProductInstallment::where('product_id', $id)->get(),
                'product' => $product,
                'vendor' => Vendor::find($product->vendor_id)
            );
            SendEmail::SendingEmail('PerjanjianPinjaman', $data);

            Session::flash('message', 'Project Rejected!');
        });
        return Redirect::route('product-request');
    }

    public function edit($id){
        $productDB = Product::find($id);
        $productInstallmentDB = ProductInstallment::where('product_id', $id)->get();
        $productVendorDB = Vendor::find($productDB->vendor_id);

        $categories = Category::all();

        $data = [
            'productDB'          => $productDB,
            'productInstallmentDB'          => $productInstallmentDB,
            'vendorDB'          => $productVendorDB,
            'categories'    => $categories
        ];

        return View('admin.edit-product')->with($data);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'vendor_id'         => 'required',
            'project_name'          => 'required',
            'project_tagline'       => 'required',
            'category'              => 'required',
            'raising'               => 'required',
            'days_left'             => 'required',
            'description'           => 'required',
            'interest_rate'           => 'required',
            'prospectus'           => 'required',
        ],
            [
                'project_name.required'   => 'Nama Proyek harus diisi',
                'project_tagline.required'   => 'Tagline Proyek harus diisi',
                'category.required'   => 'Ketegori harus diisi',
                'raising.required'   => 'Total Pendanaan harus diisi',
                'days_left.required'   => 'Durasi Pengumpulan Dana harus diisi',
                'description.required'   => 'Deskripsi Proyek harus diisi',
                'interest_rate.required'   => 'Suku Bunga Proyek harus diisi',
                'prospectus.required'   => 'Product Disclosure Statement Proyek harus diisi',

            ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $vendorDB = Vendor::find($request['vendor_id']);
        $vendorID = $vendorDB->id;
        $userID = $vendorDB->user_id;
        $vendor_va_acc = $vendorDB->vendor_va;


        DB::transaction(function() use ($request, $vendorDB, $vendorID, $userID, $vendor_va_acc){
            $interestPerMonths = "";
            $installmentPerMonths = "";

            $productDB = Product::find($request['product_id']);
            $interestPerMonths = $request['interest_per_month'];
            $installmentPerMonths = $request['installment_per_month'];
            $isNullMemberInterest = in_array(null, $interestPerMonths, true);
            $isNullMemberInstallment = in_array(null, $installmentPerMonths, true);

            if($isNullMemberInterest && $isNullMemberInstallment){
                return back()->withErrors("Cicilan&Bunga / bulan harus diisi semua")->withInput();
            }

//            dd($request);
            $dateTimeNow = Carbon::now('Asia/Jakarta');
            $productDB->category_id = $request['category'];
            $productDB->name = $request['project_name'];
            $productDB->tagline = $request['project_tagline'];
            $productDB->days_left = $request['days_left'];
            $productDB->description = $request['description'];
            $productDB->interest_rate = $request['interest_rate'];
            $productDB->business_class = $request['business_class'];
            $productDB->prospectus_path = $request['prospectus'];
            $productDB->modified_on = $dateTimeNow->toDateTimeString();

            if($request->filled('youtube')){
                //get youtube code
                $url = $request['youtube'];
                if(strpos($url, 'https://www.youtube.com') !== false){
                    if(strpos($url, 'embed') !== false){
                        $splitedUrl = explode("https://www.youtube.com/embed/",$url);
                        $productDB->youtube_link = $splitedUrl[1];

                    }
                    else if(strpos($url, 'watch?') !== false){
                        $splitedUrl = explode("https://www.youtube.com/watch?v=",$url);
                        $productDB->youtube_link = $splitedUrl[1];
                    }
                    else{
                        $splitedUrl = explode("https://www.youtube.com",$url);
                        $productDB->youtube_link = $splitedUrl[1];
                    }
                }
                if(strpos($url, 'youtu.be') !== false){
                    $splitedUrl = explode("https://youtu.be/",$url);
                    $productDB->youtube_link = $splitedUrl[1];
                }
            }

            // Get image extension
            if(!empty($request->file('project_image'))){

                $img = Image::make($request->file('project_image'));
                $extStr = $img->mime();
                $ext = explode('/', $extStr, 2);

                $filename = $productDB->image_path;

                $img->save(public_path('storage/project/'. $filename), 75);
                $productDB->image_path = $filename;
            }
            $productDB->save();

//        edit product ciclan & bunga
            $productInstallmentDB = ProductInstallment::where('product_id', $productDB->id)->orderby('month')->get();
            $i = 0;
            foreach ($productInstallmentDB as $productInstallment)
            {
                $totalPayment = $installmentPerMonths[$i] + $interestPerMonths[$i];
                $productInstallment->amount = $installmentPerMonths[$i];
                $productInstallment->interest_amount = $interestPerMonths[$i];
                $productInstallment->paid_amount = $totalPayment;
                $productInstallment->save();

                $i++;
            }

        });

        Session::flash('message', 'Admin Berhasil Mengubah Data Project!');
        return Redirect::route('product-list');
    }
}