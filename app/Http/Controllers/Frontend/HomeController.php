<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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

        $recentProducts = Product::where('category_id','=', 2)->where('status_id', 21)->orderByDesc('created_on')->take(3)->get();

        $recentBlogs = Blog::where('status_id', 1)
            ->orderByDesc('created_at')
            ->take(4)
            ->get();
        $highlightBlog = array();
        foreach ($recentBlogs as $blog){
            $string = Utilities::TruncateString($blog->description);

            $highlightBlog = array_add($highlightBlog,$blog->id, $string);
        }

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
        $onGoingProducts = null;

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

            $recentProductCount = Product::where('status_id', 1)->orderByDesc('created_on')->take(5)->count();
            $onGoingProducts = Product::where('status_id', 1)->count();

        }

        $data = [
            'recentProducts' => $recentProducts,
            'recentBlogs' => $recentBlogs,
            'highlightBlog' => $highlightBlog,
            'user' => $user,
            'pendingTransaction' => $pendingTransaction,
            'onGoingTransaction' => $onGoingTransaction,
            'finishTransaction' => $finishTransaction,
            'recentProductCount' => $recentProductCount,
            'onGoingProducts' => $onGoingProducts,
            'section_1' => $section1,
            'section_2' => $section2,
            'section_3' => $section3,
            'section_4_1' => $section4_1,
            'section_4_2' => $section4_2,
            'section_4_3' => $section4_3,
            'section_Popup' => $section_Popup

        ];

        return View('frontend.home-new')->with($data);
    }

    //
    public function AboutUs(){
        return View('frontend.about-us');
    }

    //
    public function TermCondition(){
        return View('frontend.term-condition');
    }

    //
    public function PrivacyPolicy(){
        return View('frontend.privacy-policy');
    }

    //
    public function ContactUs(){
        return View('frontend.contact-us');
    }

    public function Tutorial(){
        return View('frontend.show-tutorial');
    }
    public function Pengajuan(){
        return View('frontend.apply-owner');
    }

    public function Subscribe(Request $request){
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required|email|not_contains'
        ]);

        if ($validator->fails())
            return response()->json(['success' => false, 'error' => 'exception']);

        $name = $request->get('name');
        $email = $request->get('email');
        $dateTimeNow = Carbon::now('Asia/Jakarta');

        \App\Models\Subscribe::create([
            'name'      => $name,
            'email'     => $email,
            'date'      => $dateTimeNow->toDateTimeString(),
            'status_id' => 1,
        ]);

        $subscribeEmail = new Subscribe($name, $email);
        Mail::to($email)->send($subscribeEmail);

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
//            return response()->json(['success' => false, 'error' => 'exception']);
            return redirect()->route('index');

        $name = $request->get('name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $description = $request->get('description');
        $dateTimeNow = Carbon::now('Asia/Jakarta');

        $contactUsEmail = new ContactUs($name, $email, $phone, $description);
        Mail::to("contact@investasi.me")->send($contactUsEmail);

//        return response()->json(['success' => true]);
        return redirect()->route('index');
    }
}
