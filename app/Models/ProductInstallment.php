<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 06 Apr 2018 09:24:41 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProductInstallment
 * 
 * @property string $id
 * @property string $product_id
 * @property int $month
 * @property float $amount
 * @property float $interest_amount
 * @property float $paid_amount
 * @property int $status_id
 * @property string $created_by
 * @property \Carbon\Carbon $created_on
 * @property string $modified_by
 * @property \Carbon\Carbon $modified_on
 * 
 * @property \App\Models\Product $product
 *
 * @package App\Models
 */
class ProductInstallment extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'month' => 'int',
		'amount' => 'float',
		'interest_amount' => 'float',
		'paid_amount' => 'float',
		'status' => 'int'
	];

	protected $dates = [
		'created_on',
		'modified_on'
	];

	protected $fillable = [
		'id',
		'product_id',
		'month',
		'amount',
		'interest_amount',
		'paid_amount',
		'status_id',
		'created_by',
		'created_on',
		'modified_by',
		'modified_on'
	];

	public function product()
	{
		return $this->belongsTo(\App\Models\Product::class);
	}

	public function status()
	{
		return $this->belongsTo(\App\Models\Status::class, 'status_id');
	}
    public function getInterestAmountAttribute(){
        if(!empty($this->attributes['interest_amount'])){
            return number_format($this->attributes['interest_amount'], 0, ",", ".");
        }
    }
    public function getAmountAttribute(){
        if(!empty($this->attributes['amount'])){
            return number_format($this->attributes['amount'], 0, ",", ".");
        }
    }
    public function getPaidAmountAttribute(){
        if(!empty($this->attributes['paid_amount'])){
            return number_format($this->attributes['paid_amount'], 0, ",", ".");
        }
    }
}
