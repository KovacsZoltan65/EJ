<?php

namespace App\Repositories;

use App\Criteria\RoleCriteria;
use App\Interfaces\RoleRepositoryInterface;
use App\Models\Role;

/**
 * Class RoleRepository.
 *
 * @package namespace App\Repositories;
 */
class RoleRepository extends BaseRepository implements RoleRepositoryInterface {

    /**
     * Specify Model class name
     *
     * @return object
     */
    public function model() {
        return Role::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot() {
        $this->pushCriteria(RoleCriteria::class);
    }
}
