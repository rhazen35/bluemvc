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

}