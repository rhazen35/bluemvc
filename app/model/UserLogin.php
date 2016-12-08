<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserLogin extends Eloquent
{
    protected $table;
    protected $capsule;
    public $timestamp = false;

    public function __construct()
    {
        $this->table   = 'login_user';
        $this->capsule = unserialize( CAPSULE );
        parent::__construct();
    }

    public function user()
    {
        return( $this->belongsTo('app\model\User') );
    }

}
