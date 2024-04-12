<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Subdomain
 * 
 * @property int $id
 * @property string $subdomain
 * @property string $url
 * @property string $name
 * @property string $db_host
 * @property int $db_port
 * @property string $db_name
 * @property string $db_user
 * @property string $db_password
 * @property bool $notification
 * @property int $state_id
 * @property int $is_mirror
 * @property int $sso
 * @property int $access_control_system
 * @property Carbon $last_export
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Subdomain extends Model
{
    use HasFactory, 
        SoftDeletes;
    
	protected $table = 'subdomains';

	protected $casts = [
		              'db_port' => 'int',
		         'notification' => 'bool',
		             'state_id' => 'int',
		            'is_mirror' => 'bool',
		                  'sso' => 'bool',
		'access_control_system' => 'int',
		          'last_export' => 'datetime'
	];

	//protected $hidden = [
	//	'db_password'
	//];

	protected $fillable = [
		'subdomain', 'url', 'name',
		'db_host', 'db_port', 'db_name', 'db_user', 'db_password',
		'notification', 'state_id', 'is_mirror', 'sso',
		'access_control_system', 'last_export'
	];
}
