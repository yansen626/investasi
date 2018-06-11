<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Libs\SendEmail;
use App\Libs\UrgentNews;
use App\Libs\Utilities;
use App\Mail\ContactUs;
use App\Mail\InvoicePembelian;
use App\Mail\Subscribe;
use App\Models\Blog;
use App\Models\BlogReadUser;
use App\Models\BlogUrgent;
use App\Models\Content;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class HomeController extends Controller
{
    //
    public function Home(){
        $blogCount = 4;
        $recentProducts = Product::where('category_id','=', 2)->where('status_id', 21)->orderByDesc('created_on')->take(3)->get();

        $randomBlogs = Blog::where('status_id', 1)
            ->orderByDesc('created_at')
            ->take($blogCount)
            ->get();

        // get content from DB
        $section1 = Content::where('section', 'home_1')->first();
        $section2 = Content::where('section', 'home_2')->first();
        $section3 = Content::where('section', 'home_3')->first();
        $section4_1 = Content::where('section', 'home_4_title')->first();
        $section4_2 = Content::where('section', 'home_4_row_1')->first();
        $section4_3 = Content::where('section', 'home_4_row_2')->first();
        $section_Popup = Content::where('section', 'home_popup')->first();

        $user = null;
        $pendingTransaction = null;
        $onGoingTransaction = null;
        $finishTransaction = null;
        $recentProductCount = null;
        $myProductCount = null;
        $onGoingProducts = null;
        $onGoingProductCount = null;
        $isBorrower = false;
        $recentBlogs = $randomBlogs;

        if(auth()->check()){
            $user = Auth::user();
            $userId = $user->id;
            $blogs = UrgentNews::GetBlogList($userId);

//            $user = User::find($userId);
//            $pendingTransaction = Transaction::where('user_id', $userId)->where('status_id', 3)->count();
//            $onGoingTransaction = Transaction::where('user_id', $userId)->where('status_id', 5)->count();
//            $finishTransaction = Transaction::where('user_id', $userId)->where('status_id', 9)->count();

            if(count($blogs) > 0){
//                if($pendingTransaction > 0 || $onGoingTransaction > 0 || $finishTransaction > 0){
//                    return View('frontend.show-blog-urgents', compact('blogs'));
//                }
                return View('frontend.show-blog-urgents', compact('blogs', 'section_Popup'));
            }

//            $isBorrower = Vendor::where("user_id", $userId)->exists();
//            if($isBorrower){
//                $vendor = Vendor::select('id')->where("user_id", $userId)->first();
//                $myProductCount = Product::where('status_id', 21)
//                    ->where('vendor_id', $vendor->id)
//                    ->where('category_id', 2)
//                    ->orderByDesc('created_on')
//                    ->count();
//            }

            $recentProductCount = Product::where('status_id', 21)->where('category_id', 2)->orderByDesc('created_on')->count();
            $onGoingProducts = Transaction::where('user_id', $userId)->orderByDesc('created_on')->take(3)->get();
            $onGoingProductCount = Transaction::where('user_id', $userId)->orderByDesc('created_on')->count();

            //lender blog base on funded project
            $onGoingProductIds = Transaction::select('product_id')->where('user_id', $userId)->get();
            $onGoingProductIdArray = $onGoingProductIds->toArray();

            $recentBlogProducts = Blog::where('status_id', 1)
                ->whereIn('product_id', $onGoingProductIdArray)
                ->orderByDesc('created_at')
                ->take($blogCount)
                ->get();

            $randomBlogs = Blog::where('status_id', 1)
                ->where('product_id', null)
                ->orderByDesc('created_at')
                ->take($blogCount+$blogCount)
                ->get();

            if($recentBlogProducts->count() < $blogCount){
                $recentBlogs = $recentBlogProducts;
                $count =0;
                for($i=$recentBlogProducts->count(); $i<$randomBlogs->count(); $i++){
                    if($recentBlogs->count() >= 4) break;
                    $recentBlogs->add($randomBlogs[$count]);
                    $count++;
                }
            }
        }

        $highlightBlog = array();
        foreach ($recentBlogs as $blog){
            $string = Utilities::TruncateString($blog->description);

            $highlightBlog = array_add($highlightBlog,$blog->id, $string);
        }

        $data = [
            'recentProducts' => $recentProducts,
            'recentBlogs' => $recentBlogs,
            'highlightBlog' => $highlightBlog,
            'user' => $user,
//            'isBorrower' => $isBorrower,
//            'myProductCount' => $myProductCount,
            'pendingTransaction' => $pendingTransaction,
            'onGoingTransaction' => $onGoingTransaction,
            'finishTransaction' => $finishTransaction,
            'recentProductCount' => $recentProductCount,
            'onGoingProducts' => $onGoingProducts,
            'onGoingProductCount' => $onGoingProductCount,
            'section_1' => $section1,
            'section_2' => $section2,
            'section_3' => $section3,
            'section_4_1' => $section4_1,
            'section_4_2' => $section4_2,
            'section_4_3' => $section4_3,
            'section_Popup' => $section_Popup
        ];

        return View('frontend.homes.home-new')->with($data);
    }

    //
    public function AboutUs(){
        return View('frontend.homes.about-us');
    }

    //
    public function TermCondition(){
        return View('frontend.homes.term-condition');
    }

    //
    public function PrivacyPolicy(){
        return View('frontend.homes.privacy-policy');
    }

    //
    public function JobVacancy(){
        return View('frontend.homes.job-vacancy');
    }

    //
    public function ContactUs(){
        return View('frontend.homes.contact-us');
    }

    public function Tutorial(){
        return View('frontend.homes.show-tutorial');
    }
    public function Pengajuan(){
        return View('frontend.homes.apply-owner');
    }
    public function PerjanjianLayanan(){

        if(auth()->check()) {
            $user = Auth::user();

            return View('email.perjanjian-layanan', compact('user'));
        }
        else{
            return redirect()->route('index');
        }
    }

    public function Subscribe(Request $request){
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required|email|not_contains',
            'phone' => 'required'
        ]);

        if ($validator->fails())
            return response()->json(['success' => false, 'error' => 'exception']);

        $name = $request->get('name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $dateTimeNow = Carbon::now('Asia/Jakarta');

        \App\Models\Subscribe::create([
            'name'      => $name,
            'email'     => $email,
            'phone'     => $phone,
            'date'      => $dateTimeNow->toDateTimeString(),
            'status_id' => 1,
        ]);

        $data = array(
            'email' => $email,
            'name' => $name
        );
        SendEmail::SendingEmail('subscribe', $data);

        return response()->json(['success' => true]);
    }

    public function ContactUsSumbit(Request $request){
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required|email|not_contains',
            'phone' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails())
//            return response()->json(['success' => false]);
            return response()->json(['success' => false, 'error' => 'Harap mengisi semua data']);
//            return redirect()->route('index');

        $name = $request->get('name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $description = $request->get('description');
        $dateTimeNow = Carbon::now('Asia/Jakarta');
//        Utilities::ExceptionLog($name." ".$email." ".$phone." ".$description);

        $data = array(
            'email' => $email,
            'name' => $name,
            'phone' => $phone,
            'description' => $description
        );
        SendEmail::SendingEmail('contactUs', $data);

        return response()->json(['success' => true]);
//        return redirect()->route('index');
    }

    public function RequestVerification($email){

        $userDB = User::where('email', $email)->first();
        $data = array(
            'user' => $userDB
        );
        SendEmail::SendingEmail('requestVerification', $data);

        return Redirect::route('login');
    }
}
