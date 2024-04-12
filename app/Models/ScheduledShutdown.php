<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ScheduledShutdown
 * 
 * @property int $id
 * @property int $subdomain_id
 * @property Carbon|null $datetime
 * @property int $duration
 * @property int $user_id
 * @property string $notes
 * @property int $executed
 *
 * @package App\Models
 */
class ScheduledShutdown extends Model
{
	protected $table = 'scheduled_shutdowns';
	public $timestamps = false;

	protected $casts = [
		'subdomain_id' => 'int',
		'datetime' => 'datetime',
		'duration' => 'int',
		'user_id' => 'int',
		'executed' => 'int'
	];

	protected $fillable = [
		'subdomain_id',
		'datetime',
		'duration',
		'user_id',
		'notes',
		'executed'
	];
}
