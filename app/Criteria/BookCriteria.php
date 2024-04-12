<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;


/**
 * Class BookCriteria
 * @package namespace App\Criteria;
 */
class BookCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        /*
        $rels = [
            0 => '=',
            1 => '<>',
            2 => '<',
            3 => '>',
            4 => '>=',
            5 => '<=',
            6 => 'like',
            7 => 'not like',
        ];

        $title_rel = \Request::get('book_title_rel');
        $title = \Request::get('book_title');

        $munkahely_id = \Request::get('munkahely_id');
        $munkahely_id_rel = \Request::get('munkahely_id_rel');

        if( $title_rel != '' && $title != '' )
        {
            $model = $model->where('title', $rels[$title_rel], '%' . $title . '%');
            
            //$model = $model->where('dolgozo_nev',
            //    ($rels[$nev_rel] == '<>' ? 'not ' : '') . 'like',
            //    '%' . $nev . '%');
            
        }

        //if( $munkahely_id_rel != '' && $munkahely_id != '' )
        //{
        //    $model = $model->where('munkahely_id', $rels[$munkahely_id_rel], $munkahely_id);
        //}

        $orderBy = \Request::get('orderBy');
        $sortedBy = \Request::get('sortedBy');

        if( $orderBy != '' )
        {
            $model = $model->orderBy($orderBy, $sortedBy);
        }
        */
        return $model;
    }
}
