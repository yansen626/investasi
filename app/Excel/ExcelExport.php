<?php

namespace App\Excel;

use App\Models\Subscribe;
use App\Models\WalletStatement;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelExport implements FromCollection
{

    protected $type;

    public function __construct($type)
    {
        //
        $this->type = $type;
    }

    public function collection()
    {
        //get all data
        if($this->type == 'subs')
        {
            return Subscribe::all();
        }
        else if($this->type == 'wallet'){
            $walletStatementDB =
                DB::select('SELECT CONCAT(b.first_name, \' \', b.last_name) AS name, a.description, a.amount, a.fee, a.transfer_amount 
                            FROM investasi.wallet_statements as a, investasi.users as b
                            where a.user_id = b.id;');
            $walletStatementDB = collect($walletStatementDB)->map(function ($item){
                return get_object_vars($item);
            });

            return collect($walletStatementDB);

        }
    }
}
