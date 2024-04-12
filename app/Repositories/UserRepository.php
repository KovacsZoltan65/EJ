<?php

namespace App\Repositories;

use App\Criteria\UserCriteria;
use App\Models\User;

/**
 * Class UserRepositoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRepository extends BaseRepository implements \App\Interfaces\UserRepositoryInterface {

    /**
     * Specify Model class name
     *
     * @return object
     */
    public function model() {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot() {
        $this->pushCriteria(UserCriteria::class);
    }
}
