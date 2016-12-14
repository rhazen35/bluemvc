<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Role extends Eloquent
{
    protected $userID;
    protected $capsule;
    protected $table;

    public function __construct()
    {
        parent::__construct();
    }

    public function users()
    {
        return( $this->belongsToMany( 'app\model\User' ) );
    }

    public function get_all_roles()
    {
        return( Role::orderby('name')->get() );
    }

    public function get_all_roles_paginated( $limit, $page )
    {
        $offset = ($page - 1) * $limit;
        $roles = Role::orderby('name')->take($limit)->offset($offset)->get();
        return($roles);
    }
}