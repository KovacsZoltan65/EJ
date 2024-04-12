<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as OriginalRole;

class Role extends OriginalRole
{
    use HasFactory;

    protected $fillable = [
        'name', 'guard_name', 'created_at', 'updated_at',
    ];
}
