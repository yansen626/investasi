<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 01 Apr 2018 08:23:00 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AutoNumber
 * 
 * @property int $id
 * @property string $data
 * @property int $next_no
 *
 * @package App\Models
 */
class AutoNumber extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'next_no' => 'int'
	];

	protected $fillable = [
		'data',
		'next_no'
	];
}
