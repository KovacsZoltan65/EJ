<?php

namespace App\Repositories;

use App\Criteria\SubdomainCriteria;
use App\Interfaces\SubdomainRepositoryInterface;
use App\Models\Subdomain;

/**
 * Class SubdomainRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SubdomainRepository extends BaseRepository implements SubdomainRepositoryInterface {

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model() {
        return Subdomain::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot() {
        $this->pushCriteria(app(SubdomainCriteria::class));
    }
}
