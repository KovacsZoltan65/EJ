<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Component
 * 
 * @property int $id
 * @property string $name
 *
 * @package App\Models
 */
class Component extends Model
{
    use HasFactory, SoftDeletes;
    
    //protected $table = 'components';

    protected $fillable = ['name'];
}
