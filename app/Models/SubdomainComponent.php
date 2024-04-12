<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SubdomainComponent
 * 
 * @property int $id
 * @property int $subdomain_id
 * @property int $component_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SubdomainComponent extends Model
{
	protected $table = 'subdomain_components';

	protected $casts = [
		'subdomain_id' => 'int',
		'component_id' => 'int'
	];

	protected $fillable = [
		'subdomain_id',
		'component_id'
	];
}
