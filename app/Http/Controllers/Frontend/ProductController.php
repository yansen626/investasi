<?php
/**
 * Created by PhpStorm.
 * User: yanse
 * Date: 27-Sep-17
 * Time: 2:14 PM
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Libs\SendEmail;
use App\Libs\UrgentNews;
use App\Models\Blog;
use App\Models\GuestProspectus;
use App\Models\Product;
use App\Models\ProductInstallment;
use App\Models\Vendor;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\SendProspectus;
use App\Libs\Utilities;

class ProductController extends Controller
{
    public function ProductList($tab)
    {
//        $user = Auth::user();
//        $userId = $user->id;

        if(auth()->check()){
            $user = Auth::user();
            $userId = $user->id;
            $blogs = UrgentNews::GetBlogList($userId);

            if(count($blogs) > 0){
                return View('frontend.show-blog-urgents', compact('blogs'));
            }
        }
        $products = Product::where('is_secondary', 0)->get();

        $product_debts =Product::where('category_id','=', 2)->where('is_secondary','=', 0)->where('status_id','=', 21)->get();
        $product_onprogress =Product::where('category_id','=', 2)->where('is_secondary','=', 0)->wherein('status_id',[22, 23])->get();
//        $product_equities =Product::where('category_id','=', 1)->where('is_secondary','=', 0)->where('status_id','=', 21)->get();
//        $product_sharings =Product::where('category_id','=', 3)->where('is_secondary','=', 0)->where('status_id','=', 21)->get();


        $isActiveDebt = "";$isActiveOnprogress = ""; $isActiveEquity = "";$isActiveSharing = "";
        $isActiveTabDebt = "";$isActiveTabOnprogress = ""; $isActiveTabEquity = "";$isActiveTabSharing = "";
        if($tab == "debt") {
            $isActiveDebt = "in active";
            $isActiveTabDebt = "class=active";
        }
        else if($tab == "onprogress") {
            $isActiveOnprogress = "in active";
            $isActiveTabOnprogress = "class=active";
        }
//        else if($tab == "equity") {
//            $isActiveEquity = "in active";
//            $isActiveTabEquity = "class=active";
//        }
//        else if($tab == "sharing") {
//            $isActiveSharing = "in active";
//            $isActiveTabSharing = "class=active";
//        }

//        return View ('frontend.show-products', compact('product_debts', 'product_equities', 'product_sharings'));

        $data = [
            'product_debts'=>$product_debts,
            'product_onprogress'=>$product_onprogress,
//            'product_equities'=>$product_equities,
//            'product_sharings'=>$product_sharings,
            'isActiveDebt'=>$isActiveDebt,
            'isActiveTabDebt'=>$isActiveTabDebt,
            'isActiveOnprogress'=>$isActiveOnprogress,
            'isActiveTabOnprogress'=>$isActiveTabOnprogress,
//            'isActiveEquity'=>$isActiveEquity,
//            'isActiveTabEquity'=>$isActiveTabEquity,
//            'isActiveSharing'=>$isActiveSharing,
//            'isActiveTabSharing'=>$isActiveTabSharing
        ];
        return View ('frontend.show-products')->with($data);
    }

    public function ProductDetail($id)
    {
        $product = Product::find($id);
        $vendor = null;
        $vendorDesc = null;
        $projectCount = 1;
        if(!empty($product->vendor_id)){
            $vendor = Vendor::find($product->vendor_id);
            $projectCount = Product::where('vendor_id', $product->vendor_id)->count();

            //get description vendor
            $vendorDesc = Utilities::TruncateString($vendor->description);
        }
        if(!empty($product->due_date)){
            $dateTimeNow = Carbon::now('Asia/Jakarta');
            $now = Carbon::parse(date_format($dateTimeNow, 'Y-m-d'));
            $dueDate = Carbon::parse(date_format($product->due_date, 'Y-m-d'));
            if($now < $dueDate){
                dd($now."|".$dueDate);
                $product->days_left = $dateTimeNow->diffInDays(Carbon::parse($product->due_date));
                $product->save();
            }
            else{
                $product->days_left = 0;
                $product->save();
            }
        }


        $userId = null;
        if(auth()->check()){
            $user = Auth::user();
            $userId = $user->id;
        }
        $projectNews = Blog::where('product_id', $id)->orderByDesc('created_at')->get();

        $userWishlist = Wishlist::where('user_id', $userId)->where("product_id", $id)->first();

        $isWishlist = 0;
        if($userWishlist){
            $isWishlist = 1;
        }

        $productInstallments = ProductInstallment::where("product_id", $id)->get();

//        $productDescription = DB::select(
//            "SELECT description FROM investasi.products where id='".$id."';"
//        );
//        dd($productDescription);
//
//        $arrayofDescription = str_split($product->description, 25000);
////        dd($product->description);
//        dd($arrayofDescription);

        $data = [
            'product'=>$product,
            'vendor'=>$vendor,
            'vendorDesc'=>$vendorDesc,
            'projectNews'=>$projectNews,
            'projectCount'=>$projectCount,
            'productInstallments'=>$productInstallments,
            'userId'=>$userId,
            'isWishlist'=>$isWishlist
        ];
        return View ('frontend.show-product-new')->with($data);
    }

    public function DownloadFile($filename)
    {
        $file_path = public_path('storage/project/'.$filename);
        return response()->download($file_path);
    }
    public function GetProspectus(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'    => 'required|max:100',
            'email'      => 'required|email|max:100'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else {
            $dateTimeNow = Carbon::now('Asia/Jakarta');
            $name = Input::get('name');
            $email = Input::get('email');
            $id = Input::get('id');
            try
            {
                $newGuestProspectus = GuestProspectus::create([
                    'name'       => $name,
                    'email'       => $email,
                    'date'         => $dateTimeNow->toDateTimeString(),
                ]);
                $newGuestProspectus->save();

                //send email
                $productDB = Product::find($id);
                $data = array(
                    'email' => $email,
                    'filename' => $productDB->prospectus_path
                );
                SendEmail::SendingEmail('sendProspectus', $data);

                return redirect()->route('project-detail', ['id' => $id]);
            }
            catch (\Exception $ex)
            {
                Utilities::ExceptionLog('ProductController.php > GetProspectus ========> '.$ex);
                return redirect()->route('project-detail', ['id' => $id]);
            }
        }

//        $file_path = public_path('files/'.$filename);
//        return response()->download($file_path);
    }

    public function wishlist($id){
        $userId = null;
        if(auth()->check()){
            $user = Auth::user();
            $userId = $user->id;
        }
        $dateTimeNow = Carbon::now('Asia/Jakarta');

        $userWishlist = Wishlist::where('user_id', $userId)->where("product_id", $id)->first();

        if($userWishlist){
            $deletedWishlist = Wishlist::destroy($userWishlist->id);
        }
        else{
//        create new wishlist
            $newUser = Wishlist::create([
                'product_id' =>$id,
                'user_id' => $userId,
                'date' => $dateTimeNow->toDateTimeString()
            ]);
        }

        return redirect()->route('project-detail', ['id' => $id]);
    }
}