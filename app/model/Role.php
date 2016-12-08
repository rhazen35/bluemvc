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
        $this->userID  = !empty( $_SESSION['login'] ) ? $_SESSION['login'] : "";
        $this->capsule = unserialize( CAPSULE );
        $this->table   = 'roles';
        parent::__construct();
    }
}