<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 31 Oct 2017 03:59:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class WalletStatement
 * 
 * @property string $id
 * @property string $user_id
 * @property string $description
 * @property float $saldo
 * @property float $amount
 * @property float $fee
 * @property float $admin
 * @property float $transfer_amount
 * @property string $bank_name
 * @property string $bank_acc_name
 * @property string $bank_acc_number
 * @property \Carbon\Carbon $date
 * @property int $status_id
 * @property \Carbon\Carbon $created_on
 * @property string $created_by
 * @property \Carbon\Carbon $updated_on
 * @property string $updated_by
 * 
 * @property \App\Models\Status $status
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class WalletStatement extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'amount' => 'float',
		'fee' => 'float',
		'admin' => 'float',
		'transfer_amount' => 'float',
		'saldo' => 'float',
		'status_id' => 'int'
	];

	protected $dates = [
		'date',
		'created_on',
		'updated_on'
	];

	protected $fillable = [
	    'id',
		'user_id',
		'description',
        'saldo',
		'amount',
		'fee',
		'admin',
		'transfer_amount',
		'bank_name',
		'bank_acc_name',
		'bank_acc_number',
		'date',
		'status_id',
		'created_on',
		'created_by',
		'updated_on',
		'updated_by'
	];

	public function status()
	{
		return $this->belongsTo(\App\Models\Status::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function getUserNameAttribute()
	{
        $firstName = User::find($this->attributes['user_id']);
        $lastName = User::find($this->attributes['user_id']);
		return $firstName->first_name." ".$lastName->last_name;
	}

    public function getAmountAttribute(){
        return number_format($this->attributes['amount'],0, ",", ".");
    }

    public function getSaldoAttribute(){
        return number_format($this->attributes['saldo'],0, ",", ".");
    }

    public function getFeeAttribute(){
        return number_format($this->attributes['fee'],0, ",", ".");
    }

    public function getAdminAttribute(){
        return number_format($this->attributes['admin'],0, ",", ".");
    }

    public function getTransferAmountAttribute(){
        return number_format($this->attributes['transfer_amount'],0, ",", ".");
    }
}
