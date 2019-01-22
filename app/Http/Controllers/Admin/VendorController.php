<?php
/**
 * Created by PhpStorm.
 * User: yanse
 * Date: 22-Sep-17
 * Time: 4:03 PM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Libs\SendEmail;
use App\Libs\Utilities;
use App\Models\ProductInstallment;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user_admins');
    }


    public function index(){
        $vendors = Vendor::orderBy('created_at', 'Desc')->get();

        return View('admin.show-vendors', compact('vendors'));
    }

    public function GetDetailVendor($id)
    {
        $vendor = Vendor::find($id);
        $user = User::find($vendor->user_id);
        $product = Product::where('vendor_id', $vendor->id)->first();
        $productInstallments = ProductInstallment::where('product_id', $product->id)->get();


        return View('admin.show-vendor-detail', compact('vendor', 'user', 'product', 'productInstallments'));
    }

    public function edit($id){
        $vendorDB = Vendor::find($id);
        $userDB = User::find($vendorDB->user_id);

        $data = [
            'vendorDB'    => $vendorDB,
            'userDB'    => $userDB
        ];

        return View('admin.edit-vendor')->with($data);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[

            'email'                 => 'required|email|max:100',
            'phone'                 => 'required|max:20',
            'name'            => 'required|max:100',
            'dob'            => 'required|max:100',
            'address_ktp'            => 'required|max:100',
            'identity_number'            => 'required',
            'marital_status'            => 'required|max:100',
            'education'            => 'required|max:100',
            'username'              => 'required',
//            'fb_acc'              => 'required',
//            'ig_acc'              => 'required',
//            'twitter_acc'              => 'required',

//            'vendor_image'          => 'required',
            'name_vendor'           => 'required',
            'brand'           => 'required',
            'establish_since'           => 'required',
            'ownership'           => 'required',
            'description_vendor'    => 'required',
            'address'    => 'required',
            'postal_code'    => 'required',
            'city'    => 'required',
            'province'    => 'required',
            'phone_office'    => 'required',
            'monthly_income'    => 'required',
            'monthly_profit'    => 'required',

            'bank'                  => 'required',
            'no_rek'                => 'required',
            'acc_bank'              => 'required'
        ],
            [
                'email.email'   => 'Format Email Anda salah',
                'email.required'   => 'Email harus diisi',
                'name.required'   => 'Nama harus diisi',
                'phone.required'   => 'Nomor handphone harus diisi',
                'password.required'   => 'Password harus diisi',
                'password_confirmation.required'   => 'Konfirmasi Password harus diisi',
                'password_confirmation.same'   => 'Konfirmasi Password harus sama dengan Password',
                'username.required'   => 'Username harus diisi',
                'dob.required'   => 'Tanggal Lahir harus diisi',
                'address_ktp.required'   => 'Alamat Rumah harus diisi',
                'identity_number.required'   => 'Nomor KTP harus diisi',
                'marital_status.required'   => 'Status Pernikahan harus diisi',
                'education.required'   => 'Pendidikan Terakhir harus diisi',
//                'fb_acc.required'   => 'Akun Facebook harus diisi',
//                'ig_acc.required'   => 'Akun Instagram harus diisi',
//                'twitter_acc.required'   => 'Akun Twitter harus diisi',

                'vendor_image.required'   => 'Gambar Perusahaan harus diisi',
                'name_vendor.required'   => 'Nama Perusahaan harus diisi',
                'description_vendor.required'   => 'Deskripsi Perusahaan harus diisi',
                'brand.required'   => 'Merek/Nama Dagang harus diisi',
                'establish_since.required'   => 'Lama Usaha Berdiri harus diisi',
                'ownership.required'   => 'Kepemilikan Saham harus diisi',
                'address.required'    => 'Alamat Perusahaan harus diisi',
                'postal_code.required'    => 'Kode Pos Perusahaan harus diisi',
                'city.required'    => 'Kota Perusahaan harus diisi',
                'province.required'    => 'Provinsi Perusahaan harus diisi',
                'phone_office.required'    => 'Nomor Telepon Perusahaan harus diisi',
                'monthly_income.required'    => 'Penjualan per Bulan Perusahaan harus diisi',
                'monthly_profit.required'    => 'Keuntungan  per Bulan Perusahaan harus diisi',

                'bank.required'   => 'Bank harus diisi',
                'no_rek.required'   => 'Nomor Rekening harus diisi',
                'acc_bank.required'   => 'Akun Bank harus diisi',

            ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request['category'] == "-1") {
            return back()->withErrors("Kategori harus dipilih")->withInput();
        }
        try{

            DB::transaction(function() use ($request){
                $vendorDB = Vendor::find($request['vendor_id']);
                $userDB = User::find($vendorDB->user_id);

//            dd($request);
                $dateTimeNow = Carbon::now('Asia/Jakarta');

//        edit user
                $userDB->first_name = $request['name'];
                $userDB->email = $request['email'];
                $userDB->phone = $request['phone'];
                $userDB->name_ktp = $request['name'];
                $userDB->identity_number = $request['identity_number'];
                $userDB->address_ktp = $request['address_ktp'];
                $userDB->marital_status = $request['marital_status'];
                $userDB->education = $request['education'];
                $userDB->fb_acc = $request['fb_acc'];
                $userDB->ig_acc = $request['ig_acc'];
                $userDB->twitter_acc = $request['twitter_acc'];
                $userDB->username = $request['username'];
                $userDB->updated_at = $dateTimeNow->toDateTimeString();
                $userDB->save();

//        edit vendor
                $vendorDB->name = $request['name_vendor'];
                $vendorDB->description = $request['description_vendor'];
                $vendorDB->bank_name = $request['bank'];
                $vendorDB->bank_acc_name = $request['acc_bank'];
                $vendorDB->bank_acc_number = $request['no_rek'];
                $vendorDB->brand = $request['brand'];
                $vendorDB->vendor_type = $request['vendor_type'];
                $vendorDB->business_type = $request['business_type'];
                $vendorDB->establish_since = $request['establish_since'];
                $vendorDB->ownership = $request['ownership'];
                $vendorDB->address = $request['address'];
                $vendorDB->postal_code = $request['postal_code'];
                $vendorDB->city = $request['city'];
                $vendorDB->province = $request['province'];
                $vendorDB->phone_office = $request['phone_office'];
                $vendorDB->monthly_income = $request['monthly_income'];
                $vendorDB->monthly_profit = $request['monthly_profit'];
                $vendorDB->fb_acc = $request['vendor_fb'];
                $vendorDB->ig_acc = $request['vendor_ig'];
                $vendorDB->twitter_acc = $request['vendor_tw'];
                $vendorDB->youtube_acc = $request['vendor_yt'];
                $vendorDB->youtube_acc = $request['vendor_yt'];
                $vendorDB->updated_at = $dateTimeNow->toDateTimeString();
                $vendorDB->save();


//                dd($request->file('vendor_image'));
                // Get image extension
                if(!empty($request->file('vendor_image'))){

                    $img = Image::make($request->file('vendor_image'));

                    $filename = $vendorDB->profile_picture;

                    $img->save(public_path('storage/owner_picture/'. $filename), 45);
                    $vendorDB->profile_picture = $filename;
                    $vendorDB->save();
                }

            });
        }
        catch (\Exception $ex){
//            dd($ex);
            Utilities::ExceptionLog('VendorController.php > update ========> '.$ex);
        }

        Session::flash('message', 'Admin Berhasil Mengubah Data Borrower!');

        return Redirect::route('vendor-list');
    }

    public function RequestList(){
        $vendors = Vendor::Where('status_id', 3)->orderBy('created_at', 'Desc')->get();

        return View('admin.show-vendor-requests', compact('vendors'));
    }


    public function AcceptRequest($id){
        DB::transaction(function() use ($id){
            $dateTimeNow = Carbon::now('Asia/Jakarta');

            $vendor = Vendor::find($id);
            $vendor->status_id = 1;
            $vendor->save();

            $product = Product::where('vendor_id', $id)->first();
            $product->status_id = 21;
            $product->due_date = $dateTimeNow->addDays($product->days_left);
            $product->save();


            //send email to borrower
//            $data = array(
//                'user'=>User::find($product->user_id),
//                'productInstallment' => ProductInstallment::where('product_id', $product->id)->get(),
//                'product' => $product,
//                'vendor' => $vendor
//            );
//            SendEmail::SendingEmail('PerjanjianPinjaman', $data);

            Session::flash('message', 'Vendor and Project Accepted!');
        });
        return Redirect::route('product-request');
    }

    public function RejectRequest($id){
        DB::transaction(function() use ($id){
            $vendor = Vendor::find($id);
            $vendor->status_id = 7;
            $vendor->save();


            $product = Product::where('vendor_id', $id)->first();
            $product->status_id = 7;
            $product->save();

            Session::flash('message', 'Vendor and Project Rejected!');
        });
        return Redirect::route('product-request');
    }

    public function RequestUpdate(){
        $categories = Category::all();

        return View('admin.create-update-product', compact('categories'));
    }
    public function RequestOwner(){
        $categories = Category::all();

        return View('admin.create-vendor-register', compact('categories'));
    }
    public function RequestOwnerSubmit(Request $request){

        $validator = Validator::make($request->all(),[
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
            'business_class'           => 'required|max:2',

            'email'                 => 'required|email|max:100|unique:users',
            'phone'                 => 'required|max:20|unique:users',
            'name'            => 'required|max:100',
            'dob'            => 'required|max:100',
            'address_ktp'            => 'required|max:100',
            'identity_number'            => 'required',
            'marital_status'            => 'required|max:100',
            'education'            => 'required|max:100',
            'password'              => 'required|min:6|max:20|same:password',
            'password_confirmation' => 'required|same:password',
            'username'              => 'required|unique:users',
//            'fb_acc'              => 'required',
//            'ig_acc'              => 'required',
//            'twitter_acc'              => 'required',

            'vendor_image'          => 'required',
            'name_vendor'           => 'required',
            'brand'           => 'required',
            'establish_since'           => 'required',
            'ownership'           => 'required',
            'description_vendor'    => 'required',
            'address'    => 'required',
            'postal_code'    => 'required',
            'city'    => 'required',
            'province'    => 'required',
            'phone_office'    => 'required',
            'monthly_income'    => 'required',
            'monthly_profit'    => 'required',

            'bank'                  => 'required',
            'no_rek'                => 'required',
            'acc_bank'              => 'required'
        ],
            [
                'email.email'   => 'Format Email Anda salah',
                'email.required'   => 'Email harus diisi',
                'email.unique'   => 'Email sudah pernah terdaftar',
                'name.required'   => 'Nama harus diisi',
                'phone.required'   => 'Nomor handphone harus diisi',
                'phone.unique'   => 'Nomor handphone sudah pernah terdaftar',
                'password.required'   => 'Password harus diisi',
                'password_confirmation.required'   => 'Konfirmasi Password harus diisi',
                'password_confirmation.same'   => 'Konfirmasi Password harus sama dengan Password',
                'username.required'   => 'Username harus diisi',
                'username.unique'   => 'Username sudah pernah terdaftar',
                'dob.required'   => 'Tanggal Lahir harus diisi',
                'address_ktp.required'   => 'Alamat Rumah harus diisi',
                'identity_number.required'   => 'Nomor KTP harus diisi',
                'marital_status.required'   => 'Status Pernikahan harus diisi',
                'education.required'   => 'Pendidikan Terakhir harus diisi',
//                'fb_acc.required'   => 'Akun Facebook harus diisi',
//                'ig_acc.required'   => 'Akun Instagram harus diisi',
//                'twitter_acc.required'   => 'Akun Twitter harus diisi',

                'project_image.required'   => 'Gambar Proyek harus diisi',
                'project_name.required'   => 'Nama Proyek harus diisi',
                'project_tagline.required'   => 'Tagline Proyek harus diisi',
                'category.required'   => 'Kategori harus diisi',
                'raising.required'   => 'Total Pendanaan harus diisi',
                'days_left.required'   => 'Durasi Pengumpulan Dana harus diisi',
                'tenor_loan.required'   => 'Durasi Pinjaman harus diisi',
                'description.required'   => 'Deskripsi Proyek harus diisi',
                'interest_rate.required'   => 'Suku Bunga Proyek harus diisi',
//                'installment_per_month.required'   => 'Cicilan / Bulan harus diisi',
//                'interest_per_month.required'   => 'Bunga / Bulan harus diisi',
                'prospectus.required'   => 'Product Disclosure Statement Proyek harus diisi',
                'business_class.required'   => 'Kelas harus diisi',
                'business_class.max'   => 'Kelas Maksimal 2 huruf',

                'vendor_image.required'   => 'Gambar Perusahaan harus diisi',
                'name_vendor.required'   => 'Nama Perusahaan harus diisi',
                'description_vendor.required'   => 'Deskripsi Perusahaan harus diisi',
                'brand.required'   => 'Merek/Nama Dagang harus diisi',
                'establish_since.required'   => 'Lama Usaha Berdiri harus diisi',
                'ownership.required'   => 'Kepemilikan Saham harus diisi',
                'address.required'    => 'Alamat Perusahaan harus diisi',
                'postal_code.required'    => 'Kode Pos Perusahaan harus diisi',
                'city.required'    => 'Kota Perusahaan harus diisi',
                'province.required'    => 'Provinsi Perusahaan harus diisi',
                'phone_office.required'    => 'Nomor Telepon Perusahaan harus diisi',
                'monthly_income.required'    => 'Penjualan per Bulan Perusahaan harus diisi',
                'monthly_profit.required'    => 'Keuntungan  per Bulan Perusahaan harus diisi',

                'bank.required'   => 'Bank harus diisi',
                'no_rek.required'   => 'Nomor Rekening harus diisi',
                'acc_bank.required'   => 'Akun Bank harus diisi',

            ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request['category'] == "-1") {
            return back()->withErrors("Kategori harus dipilih")->withInput();
        }

        $interestPerMonths = "";
        $installmentPerMonths = "";
        $interestPerMonths = $request['interest_per_month'];
        $installmentPerMonths = $request['installment_per_month'];
        $isNullMemberInterest = in_array(null, $interestPerMonths, true);
        $isNullMemberInstallment = in_array(null, $installmentPerMonths, true);
        if($isNullMemberInterest || $isNullMemberInstallment)
            return back()->withErrors("Cicilan&Bunga / bulan harus diisi semua")->withInput();

        try{
            $userID = Uuid::generate();
            $vendorID = Uuid::generate();
            $productID = Uuid::generate();

            DB::transaction(function() use ($request, $interestPerMonths, $installmentPerMonths, $userID, $vendorID, $productID){
//            dd($request);
                $dateTimeNow = Carbon::now('Asia/Jakarta');

//        create new user
                $va_acc = Utilities::VANumber();
                $newUser = User::create([
                    'id' =>$userID,
                    'first_name' => $request['name'],
                    'last_name' => "",
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                    'identity_number' => $request['identity_number'],
                    'name_ktp' => $request['name'],
                    'address_ktp' => $request['address_ktp'],
//                    'dob' => $request['dob'],
                    'marital_status' => $request['marital_status'],
                    'education' => $request['education'],

                    'fb_acc' => $request['fb_acc'],
                    'ig_acc' => $request['ig_acc'],
                    'twitter_acc' => $request['twitter_acc'],
                    'username' => $request['username'],
                    'va_acc' => $va_acc,
                    'email_token' => base64_encode($request['email']),
                    'status_id' => 11,
                    'password' => bcrypt($request['password']),
                    'created_at'        => $dateTimeNow->toDateTimeString()
                ]);

//        create new vendor
                $vendor_va_acc = Utilities::VendorVANumber($va_acc);
                $newVendor = Vendor::create([
                    'id' =>$vendorID,
                    'user_id' => $userID,
                    'vendor_va' => $vendor_va_acc,
                    'name' => $request['name_vendor'],
                    'description' => $request['description_vendor'],
                    'bank_name' => $request['bank'],
                    'bank_acc_name' => $request['acc_bank'],
                    'bank_acc_number' => $request['no_rek'],
                    'brand'   => $request['brand'],
                    'vendor_type'   => $request['vendor_type'],
                    'business_type'   => $request['business_type'],
                    'establish_since'   => $request['establish_since'],
                    'ownership'   => $request['ownership'],
                    'address'    => $request['address'],
                    'postal_code'    => $request['postal_code'],
                    'city'    => $request['city'],
                    'province'    => $request['province'],
                    'phone_office'    => $request['phone_office'],
                    'monthly_income'    => $request['monthly_income'],
                    'monthly_profit'    => $request['monthly_profit'],
                    'fb_acc'    => $request['vendor_fb'],
                    'ig_acc'    => $request['vendor_ig'],
                    'twitter_acc'    => $request['vendor_tw'],
                    'youtube_acc'    => $request['vendor_yt'],
                    'status_id' => 3,
                    'created_at'        => $dateTimeNow->toDateTimeString()
                ]);

                // Get image extension
                $img = Image::make($request->file('vendor_image'));
                $extStr = $img->mime();
                $ext = explode('/', $extStr, 2);

                $filename = $request['name_vendor'].'_'.Carbon::now('Asia/Jakarta')->format('Ymdhms'). '_0.'. $ext[1];

                $img->save(public_path('storage/owner_picture/'. $filename), 45);
                $newVendor->profile_picture = $filename;
                $newVendor->save();

//        create new product
                $newProduct = Product::create([
                    'id' => $productID,
                    'category_id' => $request['category'],
                    'name' => $request['project_name'],
                    'user_id' => $userID,
                    'vendor_id' => $vendorID,
                    'raising' => $request['raising'],
                    'days_left' => $request['days_left'],
                    'tagline' => $request['project_tagline'],
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
                $category = $request['category'];
                if($category != 6){
                    $start = 1;
                }
                else{
                    $start = 0;
                }

                $i = 0;
                for($j=$start;$j<=$request['tenor_loan'];$j++){
                    $totalPayment = $installmentPerMonths[$i] + $interestPerMonths[$i];
                    $ProductInstallment = ProductInstallment::create([
                        'id'            =>Uuid::generate(),
                        'product_id'    => $productID,
                        'month'         => $j,
                        'amount'        => $installmentPerMonths[$i],
                        'interest_amount'        => $interestPerMonths[$i],
                        'paid_amount'        => $totalPayment,
                        'vendor_va'        => $vendor_va_acc,
                        'status_id'     => 1,
                        'created_on'    => $dateTimeNow->toDateTimeString()
                    ]);
                    $i++;
                }
            });
        }
        catch (\Exception $ex){
//            dd($ex);
            Utilities::ExceptionLog('VendorController.php > RequestOwnerSubmit ========> '.$ex);
        }


        return Redirect::route('vendor-list');
    }
}