<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 29 Jan 2018 02:03:52 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Subscribe
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property \Carbon\Carbon $date
 *
 * @package App\Models
 */
class Subscribe extends Eloquent
{
	public $timestamps = false;

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'name',
		'email',
		'phone',
		'date',
        'status_id'
	];
}
