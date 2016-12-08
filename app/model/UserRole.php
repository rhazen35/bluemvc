<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserRole extends Eloquent
{
    protected $userID;
    protected $capsule;
    protected $table;

    public function __construct()
    {
        $this->userID  = !empty( $_SESSION['login'] ) ? $_SESSION['login'] : "";
        $this->capsule = unserialize( CAPSULE );
        $this->table   = 'role_user';
        parent::__construct();
    }

    public function get_user_roles()
    {
        $data = UserRole::where('user_id', $this->userID)->get();
        return( $data );
    }
}