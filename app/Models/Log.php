<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Log
 * 
 * @property int $id
 * @property int $user_id
 * @property int $subdomain_id
 * @property int $level
 * @property string $what
 * @property string $with
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Log extends Model
{
    use HasFactory;
    
	protected $table = 'logs';

	protected $casts = [
		'user_id' => 'int',
		'subdomain_id' => 'int',
		'level' => 'int'
	];

	protected $fillable = [
		'user_id',
		'subdomain_id',
		'level',
		'what',
		'with'
	];
}
