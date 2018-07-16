<?php
/**
 * Created by PhpStorm.
 * User: hellb
 * Date: 6/9/2018
 * Time: 7:01 PM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades;

class ImportController extends Controller
{
    public function uploadExcel(){
        return view('admin.imports.upload-excel');
    }

    public function importExcel(Request $request){
        $dateTimeNow = Carbon::now('Asia/Jakarta');
        $user = Auth::user();

        try{
            $data = Facades\Excel::load(Input::file('file'), function($reader) {})->get();
            dd($data);
            foreach ($data[0]->toArray() as $row) {
                if(!empty($row['nama'])){

                    $email =  $row['email'];
                    if(strpos($email, ',')){
                        $emailArr = explode(',', $email);
                        $email1 = trim($emailArr[0]);
                        $email2 = trim($emailArr[1]);
                    }
                    else{
                        $email1 = $email;
                        $email2 = null;
                    }

                    $phone =  $row['telp'];
                    if(strpos($phone, ',')){
                        $phoneArr = explode(',', $phone);
                        $phone1 = trim($phoneArr[0]);
                        $phone2 = trim($phoneArr[1]);
                    }
                    else{
                        $phone1 = $phone;
                        $phone2 = null;
                    }

                    Supplier::create([
                        'name'                  => $row['nama'],
                        'email1'                => $email1 ?? null,
                        'email2'                => $email2 ?? null,
                        'phone1'                => $phone1 ?? null,
                        'phone2'                => $phone2 ?? null,
                        'contact_person'        => $row['cp'] ?? null,
                        'address'               => $row['alamat'] ?? null,
                        'bank_name'             => 'BANK',
                        'bank_account_number'   => '123456',
                        'bank_account_name'     => 'PEMILIK REKENING',
                        'created_by'            => $user->id,
                        'created_at'            => $dateTimeNow->toDateTimeString(),
                        'updated_by'            => $user->id,
                        'updated_at'            => $dateTimeNow->toDateTimeString(),
                    ]);
                }
            }

//            Excel::load(Input::file('file'), function ($reader) use($user, $dateTimeNow) {
//                foreach ($reader->toArray() as $key => $value) {
//                    if($row['nama'] != null){
//
//                        Supplier::create([
//                            'name'                  => $row['nama'],
//                            'email'                 => $row['email'],
//                            'phone'                 => $row['telp'],
//                            'contact_person'        => $row['cp'],
//                            'address'               => $row['alamat'],
//                            'city'                  => $row['lokasi'],
//                            'bank_name'             => 'BANK',
//                            'bank_account_number'   => '123456',
//                            'bank_account_name'     => 'PEMILIK REKENING',
//                            'created_by'            => $user->id,
//                            'created_at'            => $dateTimeNow->toDateTimeString(),
//                            'updated_by'            => $user->id,
//                            'updated_at'            => $dateTimeNow->toDateTimeString(),
//                        ]);
//                    }
//                }
//            });

            Session::flash('message', 'Berhasil Import data vendor!');
             return redirect(route('admin.import.suppliers.upload'));
        }
        catch (\Exception $exception){
            return $exception;
        }
    }

    public function importUser(Request $request){
        $dateTimeNow = Carbon::now('Asia/Jakarta');
        $user = Auth::user();

        try{
            Excel::load(Input::file('file'), function ($reader) use($user, $dateTimeNow) {
                foreach ($reader->toArray() as $row) {
                    if($row['nama'] != null){

                    }
                }
            });

            Session::flash('message', 'Berhasil Import data vendor!');

            return redirect(route('admin.import.suppliers.upload'));
        }
        catch (\Exception $exception){
            return $exception;
        }
    }
}