<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Seed
 * 
 * @property int $id
 * @property string $seed
 * @property int $batch
 *
 * @package App\Models
 */
class Seed extends Model
{
    use HasFactory;
    
	protected $table = 'seeds';
	public $timestamps = false;

	protected $casts = [
		'batch' => 'int'
	];

	protected $fillable = [
		'seed',
		'batch'
	];
}
