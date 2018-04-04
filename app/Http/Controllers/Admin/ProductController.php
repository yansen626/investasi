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
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
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
                $userDB = User::find($product->user_id);
                $userWalletDB = (double) str_replace('.','', $userDB->wallet_amount);
                $collectedFund = (double) str_replace('.','', $product->raised);
                $userDB->wallet_amount = $userWalletDB + $collectedFund;
                $userDB->save();


                //send email notfication to project owner, fund collected
                $data = array(
                    'vendorData'    => $userDB,
                    'project'       => $product
                );
                SendEmail::SendingEmail('acceptCollectedFund', $data);

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
                    $percentage = $product->raised / $product->raising * 100;
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

    public function ProductInvestorList($id){
        $productDB = Product::find($id);
        $transactionDB = Transaction::where('product_id', $id)->get();

        return View('admin.show-product-investors', compact('transactionDB', 'productDB'));
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
            'installment_per_month'           => 'required',
            'interest_per_month'           => 'required',
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
                'installment_per_month.required'   => 'Cicilan / Bulan harus diisi',
                'interest_per_month.required'   => 'Bunga / Bulan harus diisi',
                'prospectus.required'   => 'Product Disclosure Statement Proyek harus diisi',

            ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::transaction(function() use ($request){
//            dd($request);
            $vendorDB = Vendor::find($request['vendor_id']);
            $vendorID = $vendorDB->id;
            $userID = $vendorDB->user_id;
            $dateTimeNow = Carbon::now('Asia/Jakarta');

//        create new product
            $newProduct = Product::create([
                'id' =>Uuid::generate(),
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
                'installment_per_month' => $request['installment_per_month'],
                'interest_per_month' => $request['interest_per_month'],
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

            // save pdf
            $filenamePDF = $request['project_name'].'_'.Carbon::now('Asia/Jakarta')->format('Ymdhms').'.pdf';
            $destinationPath = public_path('storage/project/');

            $request->file('prospectus')->move($destinationPath, $filenamePDF);
            $newProduct->prospectus_path = $filenamePDF;
            $newProduct->save();

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

            Session::flash('message', 'Project Rejected!');
        });
        return Redirect::route('product-request');
    }

    public function edit($id){
        $product = Product::findorFail($id);

        $imgFeatured = $product->product_image()->where('featured', 1)->first()->path;
        $imgPhotos = $product->product_image()->where('featured', 0)->get();
        $categories = Category::all();

        $data = [
            'product'       => $product,
            'imgFeatured'   => $imgFeatured,
            'imgPhotos'     => $imgPhotos,
            'categories'    => $categories
        ];

        return view('admin.edit-product')->with($data);
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'category'              => 'required|option_not_default',
            'name'                  => 'required',
            'price'                 => 'required',
            'weight'                => 'required',
            'qty'                   => 'required'
        ],[
            'option_not_default'    => 'Select a category'
        ]);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        else{
            $product = Product::find($id);
            $product->name = Input::get('name');
            $product->category_id = Input::get('category');

            $status = Input::get('status');
            $product->status_id = $status === '1' ? 1 : 2;

            $price = $request->input('price');
            $priceDouble = (double) str_replace('.','', $price);
            $weight = (double) str_replace('.','', Input::get('weight'));

            $product->price = $priceDouble;
            $product->weight = $weight;
            $product->quantity = Input::get('qty');

            if(Input::get('options') == 'percent'){
                $discountPercent = (double) Input::get('discount-percent');
                $product->discount = $discountPercent;

                $discountAmount = $priceDouble / 100 * $discountPercent;
                $product->price_discounted = $priceDouble - $discountAmount;

                // Set other null
                $product->discount_flat = null;
            }
            else if(Input::get('options') == 'flat'){
                $discountFlat = (double) str_replace('.','', Input::get('discount-flat'));
                $product->discount_flat = $discountFlat;

                $product->price_discounted = $priceDouble - $discountFlat;

                // Set other null
                $product->discount_flat = null;
            }
            else if(Input::get('options' == 'none')){
                // Set all null
                $product->discount = null;
                $product->discount_flat = null;
                $product->price_discounted = $priceDouble;
            }

            if(!empty(Input::get('description'))){
                $product->description = Input::get('description');
            }else{
                $product->description = null;
            }

            $product->save();

            // Image handling
            $savedId = $product->id;

            if(!empty(Input::get('img_featured_changed') && Input::get('img_featured_changed') === 'new')){
                // Change old value of featured image
                $currentImgFeatured = $product->product_image()->where('featured',1)->first();
                $currentImgFeatured->featured = 0;
                $currentImgFeatured->save();

                $img = Image::make($request->file('product-featured'));

                // Get image extension
                $extStr = $img->mime();
                $ext = explode('/', $extStr, 2);

                $filename = $savedId.'_'. Carbon::now('Asia/Jakarta')->format('Ymdhms'). '_0.'. $ext[1];

                $img->save(public_path('storage\product' . '\\'. $filename));

                $productImgFeatured = ProductImage::create([
                    'product_id'    => $savedId,
                    'path'          => $filename,
                    'featured'      => 1
                ]);

                $productImgFeatured->save();
            }

            error_log("Deleted: ". Input::get('deleted_img_id'));

            // Delete product images
            if(!empty(Input::get('deleted_img_id'))){
                $deletedIdTmp = Input::get('deleted_img_id');

                if(strpos($deletedIdTmp,',')){
                    $deletedIdList = explode(',', $deletedIdTmp);
                    foreach($deletedIdList as $deletedId){
                        $productImage = ProductImage::find($deletedId);

                        $deletedPath = storage_path('app/public/product/'. $productImage->path);
                        if(file_exists($deletedPath)) unlink($deletedPath);

                        $productImage->delete();
                    }
                }
                else{
                    $productImage = ProductImage::find($deletedIdTmp);
                    $productImage->delete();
                }
            }

            // Change featured value of existing product images
            if(!empty(Input::get('img_featured_changed') && Input::get('img_featured_changed') != 'new')){
                // Change old value of featured image
                $currentImgFeatured = $product->product_image()->where('featured',1)->first();
                $currentImgFeatured->featured = 0;
                $currentImgFeatured->save();

                $image = ProductImage::find(Input::get('img_featured_changed'));
                $image->featured = 1;
                $image->save();
            }

            if(!empty($request->file('product-photos'))){
                $idx = 1;
                foreach($request->file('product-photos') as $img){
                    error_log('index: '. $idx);
                    $photo = Image::make($img);

                    // Get image extension
                    $extStr = $photo->mime();
                    $ext = explode('/', $extStr, 2);

                    $filename = $savedId.'_'. Carbon::now('Asia/Jakarta')->format('Ymdhms'). '_'. $idx. '.'. $ext[1];


                    $photo->save(public_path('storage\product'. '\\'. $filename));

                    $productPhoto = ProductImage::create([
                        'product_id'    => $savedId,
                        'path'          => $filename,
                        'featured'      => 0
                    ]);

                    $productPhoto->save();
                    $idx++;
                }
            }

            return redirect::route('product-list');
        }
    }
}