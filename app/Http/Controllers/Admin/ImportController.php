<?php
/**
 * Created by PhpStorm.
 * User: hellb
 * Date: 6/9/2018
 * Time: 7:01 PM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Libs\SendEmail;
use App\Models\Supplier;
use App\Models\User;
use App\Models\WalletStatement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades;
use Webpatser\Uuid\Uuid;

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
//            dd($data);
            foreach ($data->toArray() as $row) {
                if(!empty($row['nama'])){

                    DB::transaction(function() use ($row) {

                        $amount = $row['jumlah'];
                        $dateTimeNow = Carbon::now('Asia/Jakarta');
                        $keterangan = $row['keterangan'];
                        $virtual_akun = $row['virtual_akun'];

                        $userDB = User::where("va_acc", $virtual_akun)->first();
                        $saldo = (double) str_replace('.', '',$userDB->wallet_amount);
                        $userSaldoFinal = $saldo + (double) $amount;
    //                    dd($userSaldoFinal);

                        //add wallet statement
                        $statement = WalletStatement::create([
                            'id'            => Uuid::generate(),
                            'user_id'       => $userDB->id,
                            'description'   => $keterangan,
                            'saldo'         => $userSaldoFinal,
                            'amount'        => $amount,
                            'fee'           => 0,
                            'admin'         => 0,
                            'transfer_amount'=> 0,
                            'status_id'     => 6,
                            'date'          => $dateTimeNow->toDateTimeString(),
                            'created_on'    => $dateTimeNow->toDateTimeString()
                        ]);

                        //change user wallet amount
                        $userDB->wallet_amount = $userSaldoFinal;
                        $userDB->save();

                        //send email to user
                        $data = array(
                            'user'=>$userDB,
                            'description' => $keterangan,
                            'userGetFinal' => $amount
                        );
                        SendEmail::SendingEmail('topupSaldo', $data);
                    });
                }
            }
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