<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;


/**
 * Class BookCriteria
 * @package namespace App\Criteria;
 */
class UserCriteria implements CriteriaInterface
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
        
        $title_rel = \Request::get('user_title_rel');
        $title = \Request::get('user_title');
        
        if( $title_rel != '' && $title != '' )
        {
            $model = $model->where('name', $rels[$title_rel], '%' . $title . '%');
            
            //$model = $model->where('dolgozo_nev',
            //    ($rels[$nev_rel] == '<>' ? 'not ' : '') . 'like',
            //    '%' . $nev . '%');
            
        }
        
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