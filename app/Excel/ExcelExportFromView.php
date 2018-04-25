<?php
/**
 * Created by PhpStorm.
 * User: yanse
 * Date: 25-Apr-18
 * Time: 2:07 PM
 */

namespace App\Excel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;


class ExcelExportFromView implements FromView
{
    protected $type;

    public function __construct($type)
    {
        //
        $this->type = $type;
    }

    public function View(): View
    {

        //get all data
        if($this->type == 'mcm')
        {
            $customerListDB =
                DB::select('SELECT va_acc, upper(concat(first_name, " ", last_name)) as name  FROM investasi.users;');

            return View('excel.mcm', [
                'customerListDB' => $customerListDB
            ]);
        }
        else if($this->type == 'wallet')
        {
            $walletStatementDB =
                DB::select('SELECT CONCAT(b.first_name, \' \', b.last_name) AS name, a.bank_name, a.bank_acc_number, a.transfer_amount 
                            FROM investasi.wallet_statements as a, investasi.users as b
                            where a.user_id = b.id;');

            return View('excel.withdraw', [
                'walletStatementDB' => $walletStatementDB
            ]);
        }
    }
}