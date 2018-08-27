<?php
/**
 * Created by PhpStorm.
 * User: GMG-Executive
 * Date: 04/10/2017
 * Time: 10:22
 */

namespace App\Libs;

use App\Models\AutoNumber;
use App\Models\Transaction;
use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Carbon\Carbon;

class Utilities
{
    //generate invoice number
    public static function GenerateInvoice($productName, $VANumber) {
        $start = Carbon::yesterday('Asia/Jakarta');
        $end = Carbon::tomorrow('Asia/Jakarta');
        $date = date_format($start, 'dmy');

        $transactionCount = Transaction::whereBetween('created_on', [$start->toDateString(),$end->toDateString()])->count();
        $number = str_pad($transactionCount+1, 3, '0', STR_PAD_LEFT);
        //INV070618001/QQ laundry/8879500005
        return "INV".$date.$number."/".$productName."/".$VANumber;
    }

    public static function SendSms($number, $message){
        $client = new Client([
            'base_uri' => env('URL_SMS_SERVER'),
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        //Set Json Object
        $myObj = [];
        $myObj = array_add($myObj, 'apikey', env('SMS_API_KEY'));
        $myObj = array_add($myObj, 'callbackurl', 'www.investasi.me');

        $alldata = [];
        $datapacket = [];
        $datapacket = array_add($datapacket, 'number', $number);
        $datapacket = array_add($datapacket, 'message', $message);
        $datapacket = array_add($datapacket, 'sendingdatetime', '');
        array_push($alldata, $datapacket);

        $datapacket1 = [];
        $datapacket1 = array_add($datapacket1, 'number', '111111');
        $datapacket1 = array_add($datapacket1, 'message', $message);
        $datapacket1 = array_add($datapacket1, 'sendingdatetime', '');
        array_push($alldata, $datapacket1);

        $myObj = array_add($myObj, 'datapacket', $alldata);

        $request = $client->request('POST', 'http://45.32.107.195/sms/api_sms_reguler_send_json.php', [
            'json' => $myObj
        ]);

        if($request->getStatusCode() == 200){
            $collect = json_decode($request->getBody());

            return $collect;
        }
    }


    public static function ExceptionLog($ex){
        $logContent = ['id' => 1,
            'description' => $ex];
        $today = Carbon::now('Asia/Jakarta');
        $todayFormated = Carbon::parse($today)->format('Y-m-d');

        $log = new Logger('exception');
        $log->pushHandler(new StreamHandler(storage_path('logs/'.$todayFormated.'.log')), Logger::ALERT);
        $log->info('exception', $logContent);
    }

    public static function TruncateString($oldString){
        $string = strip_tags($oldString);
        if (strlen($string) > 150) {

            // truncate string
            $stringCut = substr($string, 0, 150);

            // make sure it ends in a word so assassinate doesn't become ass...
            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
        }
        return $string;
    }

    public static function VANumber (){
        //Make Va Account Number
        //From 00001 - 99999
        $auto_number = AutoNumber::where('data', 'va_acc')->first();
        $mod = strlen($auto_number->next_no);
        $autoNumber = "";

        switch ($mod){
            case 1:
                $autoNumber = "0000" . $auto_number->next_no;
                break;
            case 2:
                $autoNumber = "000" . $auto_number->next_no;
                break;
            case 3:
                $autoNumber = "00" . $auto_number->next_no;
                break;
            case 4:
                $autoNumber = "0" . $auto_number->next_no;
                break;
            case 5:
                $autoNumber = $auto_number->next_no;
                break;
        }

        $auto_number->next_no++;
        $auto_number->save();

        return "88795".$autoNumber;
    }

    public static function VendorVANumber ($va){
        $lastnumber = substr($va, -1);
        $vendorVA = $va.$lastnumber;

        return $vendorVA;
    }

    public static function Terbilang($number){
        $angka = str_replace('.', '', $number);

        $angka = (float)$angka;
        $bilangan = array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan','Sepuluh','Sebelas');
        if ($angka < 12) {
            return $bilangan[$angka];
        } else if ($angka < 20) {
            return $bilangan[$angka - 10] . ' Belas';
        } else if ($angka < 100) {
            $hasil_bagi = (int)($angka / 10);
            $hasil_mod = $angka % 10;
            return trim(sprintf('%s Puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
        } else if ($angka < 200) {
            return sprintf('Seratus %s', self::Terbilang($angka - 100));
        } else if ($angka < 1000) {
            $hasil_bagi = (int)($angka / 100);
            $hasil_mod = $angka % 100;
            return trim(sprintf('%s Ratus %s', $bilangan[$hasil_bagi], self::Terbilang($hasil_mod)));
        } else if ($angka < 2000) {
            return trim(sprintf('Seribu %s', self::Terbilang($angka - 1000)));
        } else if ($angka < 1000000) {
            $hasil_bagi = (int)($angka / 1000);
            $hasil_mod = $angka % 1000;
            return sprintf('%s Ribu %s', self::Terbilang($hasil_bagi), self::Terbilang($hasil_mod));
        } else if ($angka < 1000000000) {
            $hasil_bagi = (int)($angka / 1000000);
            $hasil_mod = $angka % 1000000;
            return trim(sprintf('%s Juta %s', self::Terbilang($hasil_bagi), self::Terbilang($hasil_mod)));
        } else if ($angka < 1000000000000) {
            $hasil_bagi = (int)($angka / 1000000000);
            $hasil_mod = fmod($angka, 1000000000);
            return trim(sprintf('%s Milyar %s', self::Terbilang($hasil_bagi), self::Terbilang($hasil_mod)));
        } else if ($angka < 1000000000000000) {
            $hasil_bagi = $angka / 1000000000000;
            $hasil_mod = fmod($angka, 1000000000000);
            return trim(sprintf('%s Triliun %s', self::Terbilang($hasil_bagi), self::Terbilang($hasil_mod)));
        } else {
            return 'Data Salah';
        }
    }

    public static function HariIndonesia($tanggal){
        $day = date('D', strtotime($tanggal));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        return $dayList[$day];
    }

    public static function UserPercentage ($raised, $userAmount){
        $userGetTemp = number_format((($userAmount*100) / $raised),2);

        return $userGetTemp;
    }

    public static function UserGetInstallment ($paid_amount, $raised, $userAmount){
        $userGetTemp = number_format((($userAmount*100) / $raised),2);
        $userGetFinal = round(($userGetTemp * $paid_amount) / 100);

        return $userGetFinal;
    }
}