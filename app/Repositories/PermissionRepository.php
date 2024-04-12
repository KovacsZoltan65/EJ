<?php

namespace App\Repositories;

use App\Criteria\PermissionCriteria;
use App\Models\Permission;

class PermissionRepository extends BaseRepository implements \App\Interfaces\PermissionRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return class
     */
    public function model()
    {
        return Permission::class;
    }
    
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria( PermissionCriteria::class );
    }
}