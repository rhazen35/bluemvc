<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    protected $capsule;
    protected $table;
    protected $userID;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->capsule = unserialize( CAPSULE );
        $this->userID  = ( !empty( $_SESSION['login'] ) ? $_SESSION['login'] : "" );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return( $this->belongsToMany('app\model\Role') );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return( $this->belongsToMany('app\model\Group') );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function login()
    {
        return( $this->hasOne('app\model\UserLogin') );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get_all_users()
    {
        return( User::orderby('name')->get() );
    }

    public function get_all_users_paginated( $limit, $page )
    {
        $offset = ($page - 1) * $limit;
        $users = User::orderby('name')->take($limit)->offset($offset)->get();
        return($users);
    }
}