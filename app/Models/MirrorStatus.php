<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MirrorStatus
 * 
 * @property int $id
 * @property int $mirror_subdomain_id
 * @property int|null $mirrored_subdomain_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MirrorStatus extends Model
{
	protected $table = 'mirror_statuses';

	protected $casts = [
		'mirror_subdomain_id' => 'int',
		'mirrored_subdomain_id' => 'int'
	];

	protected $fillable = [
		'mirror_subdomain_id',
		'mirrored_subdomain_id'
	];
}
