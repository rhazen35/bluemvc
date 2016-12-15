<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Group extends Eloquent
{

    public function users()
    {
        return( $this->belongsToMany('app\model\User') );
    }

    public function get_all_groups()
    {
        return( Group::orderby('name')->get() );
    }

    public function get_all_groups_paginated( $limit, $page )
    {
        $offset = ($page - 1) * $limit;
        $groups = Group::orderby('name')->take($limit)->offset($offset)->get();
        return($groups);
    }
}