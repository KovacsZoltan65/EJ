<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HqSetting
 * 
 * @property int $id
 * @property string $key
 * @property string $value
 *
 * @package App\Models
 */
class HqSetting extends Model
{
	protected $table = 'hq_settings';
	public $timestamps = false;

	protected $fillable = [
		'key',
		'value'
	];
}
