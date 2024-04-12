<?php

namespace App\Repositories;

use App\Criteria\BookCriteria;
use App\Interfaces\BookRepositoryInterface;
use App\Models\Book;

/*
 * Class BookRepositoryEloquent
 * @package namespace App\Repositories 
 */

class BookRepository extends BaseRepository implements BookRepositoryInterface {

    /**
     * Specify Model class name
     * @return class
     */
    public function model() {
        return Book::class;
    }

    public function boot() {
        $this->pushCriteria(BookCriteria::class);
    }
}
