<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 28 Aug 2017 06:57:19 +0000.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Product
 * 
 * @property string $id
 * @property int $category_id
 * @property string $name
 * @property int $user_id
 * @property int $vendor_id
 * @property float $raising
 * @property float $external_commitment
 * @property float $raised
 * @property int $equity_offered
 * @property int $days_left
 * @property int $tenor_loan
 * @property float $minimum_per_investor
 * @property string $description
 * @property string $youtube_link
 * @property string $image_path
 * @property string $prospectus_path
 * @property string $interest_rate
 * @property string $installment_per_month
 * @property string $interest_per_month
 * @property int $is_secondary
 * @property string $meta_tag_description
 * @property string $meta_tag_image
 * @property int $confirmation_1
 * @property int $confirmation_2
 * @property int $status_id
 * @property string $created_by
 * @property \Carbon\Carbon $created_on
 * @property string $modified_by
 * @property \Carbon\Carbon $modified_on
 * 
 * @property \App\Models\Status $status
 * @property \App\Models\Vendor $vendor
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $carts
 * @property \Illuminate\Database\Eloquent\Collection $transaction_details
 *
 * @package App\Models
 */
class Product extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	//protected $dateFormat = "U";

	protected $casts = [
		'raising' => 'float',
		'external_commitment' => 'float',
		'raised' => 'float',
		'equity_offered' => 'int',
		'days_left' => 'int',
		'tenor_loan' => 'int',
        'interest_rate' => 'int',
        'installment_per_month'  => 'float',
        'interest_per_month'  => 'float',
        'minimum_per_investor' => 'float',
        'is_secondary' => 'int',
		'status_id' => 'int'
	];
	protected $dates = [
		'created_on',
		'modified_on'
	];

	protected $fillable = [
	    'id',
		'name',
        'category_id',
        'user_id',
        'vendor_id',
        'raising',
        'external_commitment',
        'raised',
        'equity_offered',
        'days_left',
        'tenor_loan',
        'minimum_per_investor',
        'description',
        'youtube_link',
        'image_path',
        'prospectus_path',
        'interest_rate',
        'installment_per_month',
        'interest_per_month',
        'is_secondary',
        'meta_tag_description',
        'meta_tag_image',
        'confirmation_1',
        'confirmation_2',
		'status_id',
		'created_by',
		'created_on',
		'modified_by',
		'modified_on'
	];

	public function status()
	{
		return $this->belongsTo(\App\Models\Status::class);
	}

    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }

    public function vendor(){
        return $this->belongsTo(\App\Models\Vendor::class);
    }

	public function carts()
	{
		return $this->hasMany(\App\Models\Cart::class);
	}

	public function transaction_details()
	{
		return $this->hasMany(\App\Models\TransactionDetail::class);
	}

    public function category(){
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function product_image(){
	    return $this->hasMany(\App\Models\ProductImage::class);
    }

	public function getRaisingAttribute(){
        return number_format($this->attributes['raising'], 0, ",", ".");
    }

    public function getExternalCommitmentAttribute(){
	    if(!empty($this->attributes['external_commitment'])){
            return number_format($this->attributes['external_commitment'], 0, ",", ".");
        }
    }
    public function getRaisedAttribute(){
	    if(!empty($this->attributes['raised'])){
            return number_format($this->attributes['raised'], 0, ",", ".");
        }
    }

    public function getMinimumPerInvestorAttribute(){
        if(!empty($this->attributes['minimum_per_investor'])){
            return number_format($this->attributes['minimum_per_investor'], 0, ",", ".");
        }
    }
    public function getInstallmentPerMonthAttribute(){
        if(!empty($this->attributes['installment_per_month'])){
            return number_format($this->attributes['installment_per_month'], 0, ",", ".");
        }
    }
    public function getInterestPerMonthAttribute(){
        if(!empty($this->attributes['interest_per_month'])){
            return number_format($this->attributes['interest_per_month'], 0, ",", ".");
        }
    }
    public function getDaysLeftAttribute(){
        if(!empty($this->attributes['due_date'])){
            $dateTimeNow = Carbon::now('Asia/Jakarta');
            $daysLeft = $dateTimeNow->diffInDays(Carbon::parse($this->due_date));
            return $daysLeft;
        }
        return $this->attributes['days_left'];
    }

    public function getYoutubeLinkAttribute(){
        if(!empty($this->attributes['youtube_link'])){
            $url = $this->attributes['youtube_link'];
            if($url.contains('www.youtube.com')){
                if($url.contains('embed')){
                    $splitedUrl = explode("www.youtube.com/embed/",$url);
                    return $splitedUrl[0];

                }
                else if($url.contains('watch?')){
                    $splitedUrl = explode("www.youtube.com/watch?v=",$url);
                    return $splitedUrl[0];
                }
                else{
                    $splitedUrl = explode("www.youtube.com",$url);
                    return $splitedUrl[0];
                }
            }
            if($url.contains('youtu.be')){
                $splitedUrl = explode("youtu.be/",$url);
                return $splitedUrl[0];
            }
        }
    }
}
