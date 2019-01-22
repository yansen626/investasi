<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 31 Mar 2018 05:45:56 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Option
 * 
 * @property int $id
 * @property int $va_last_number
 * @property int $perjanjian_year
 * @property int $perjanjian_number
 *
 * @package App\Models
 */
class Option extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'va_last_number' => 'int',
		'perjanjian_year' => 'int',
		'perjanjian_number' => 'int'
	];

	protected $fillable = [
		'va_last_number',
		'perjanjian_year',
		'perjanjian_number'
	];
}
