<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VersionInformationEmailAddress
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $subdomain
 * @property int $external_admin
 * @property int $internal_admin
 * @property int $papik
 * @property int $valid_counter
 * @property int $send_email
 * @property int $active
 *
 * @package App\Models
 */
class VersionInformationEmailAddress extends Model
{
    use HasFactory;
    
	protected $table = 'version_information_email_addresses';
	public $timestamps = false;

	protected $casts = [
		'external_admin' => 'int',
		'internal_admin' => 'int',
		'papik' => 'int',
		'valid_counter' => 'int',
		'send_email' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'name',
		'email',
		'subdomain',
		'external_admin',
		'internal_admin',
		'papik',
		'valid_counter',
		'send_email',
		'active'
	];
}
