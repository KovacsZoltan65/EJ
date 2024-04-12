<?php

namespace App\Repositories;

use App\Criteria\PostCriteria;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;

/*
 * Class BookRepositoryEloquent
 * @package namespace App\Repositories 
 */

class PostRepository extends BaseRepository implements PostRepositoryInterface {

    /**
     * Specify Model class name
     * @return class
     */
    public function model() {
        return Post::class;
    }

    public function boot() {
        $this->pushCriteria(PostCriteria::class);
    }
}
