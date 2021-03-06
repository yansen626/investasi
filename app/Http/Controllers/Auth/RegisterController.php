<?php

namespace App\Http\Controllers\Auth;

use App\Libs\SendEmail;
use App\Libs\Utilities;
use App\Models\AutoNumber;
use App\Models\Referral;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = array(
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|not_contains',
            'password' => 'required|string|min:6|confirmed',
            'username' => 'required|unique',
            'phone' => 'required|string'
        );

        $messages = array(
            'not_contains' => 'The :attribute must not contain banned words',
        );

        return Validator::make($data, $rules, $messages);
        /*return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|not_contains',
            'password' => 'required|string|min:6|confirmed',
        ]);*/
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $va_acc = Utilities::VANumber();

        return User::create([
            'id' =>Uuid::generate(),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => $data['username'],
            'va_acc'    => $va_acc,
            'email_token' => base64_encode($data['email']),
//            'status_id' => 3,
            'status_id' => 11,
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $rules = array(
            'email'                 => 'required|email|max:100|unique:users|not_contains',
            'first_name'            => 'required|max:100',
            'last_name'             => 'required|max:100',
            'phone'                 => 'required|unique:users',
            'password'              => 'required|min:6|max:20|same:password',
            'password_confirmation' => 'required|same:password',
            'username'              => 'required|unique:users'
        );

        $messages = array(
            'not_contains'  => 'Email tidak boleh memiliki karakter +',
//            'phone.max'     => 'Nomor Handphone tidak boleh lebih dari 12 karakter',
            'username.unique'   => 'Username sudah pernah terdaftar',
            'phone.unique'   => 'Nomor Handphone sudah pernah terdaftar',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        /*$validator = Validator::make($request->all(),
            [
                'email'                 => 'required|email|max:100|unique:users',
                'first_name'            => 'required|max:100',
                'last_name'             => 'required|max:100',
                'phone'                 => 'required|max:20',
                'password'              => 'required|min:6|max:20|same:password',
                'password_confirmation' => 'required|same:password'
            ]
        );*/

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        //Check Referral
        if($request->referral != null){
            $parent = User::where('username', $request->referral)->first();
            if(empty($parent)) {
                return back()->withErrors(['msg' => ['Username Referal tidak terdaftar']])->withInput();
            }
        }

        $user = $this->create($request->all());

        //Check Referral
        if($request->referral != null){
            //Add Referrals
            $parent = User::where('username', $request->referral)->first();
            $child = User::Where('username', $user->username)->first();
            Referral::create([
                'user_id_parent' => $parent->id,
                'user_id_child' => $child->id
            ]);
        }

        //Send Email
        $data = array(
            'user' => $user
        );
        SendEmail::SendingEmail('emailVerification', $data);

        $email = Input::get('email');

        return View('auth.send-email', compact('email'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function verify($token)
    {
        $user = User::where('email_token',$token)->first();
        $user->status_id = 11;
        $user->save();

        Session::put("user-data", $user);
        Session::flash('message', 'Email Anda telah diverifikasi, silahkan login dengan email dan password Anda');
        return Redirect::route('login');
//        if($user->save()){
////            return Redirect::route('verify-phone-show');
////            return View('auth.send-email', compact('email'));
////            return View('auth.email-confirm',['user'=>$user]);
//        }
    }
    public function verifyByAdmin($token)
    {
        $user = User::where('email_token',$token)->first();
        $user->status_id = 11;
        $user->save();

//        if($user->save()){
////            return Redirect::route('verify-phone-show');
////            return View('auth.send-email', compact('email'));
////            return View('auth.email-confirm',['user'=>$user]);
//        }
    }


}
