<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;

class Group extends Eloquent
{
    protected $capsule;

    public function __construct(array $attributes = [])
    {
        $this->capsule = unserialize( CAPSULE );
        parent::__construct($attributes);
    }

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
        $groups = Group::orderBy(DB::raw('LENGTH(name), name'))->take($limit)->offset($offset)->get();
        return($groups);
    }
}