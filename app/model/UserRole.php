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
        $this->table   = 'user_role';
        parent::__construct();
    }

    public function get( $joins, $params, $groups, $orders  )
    {
        $query = $this->capsule->table( $this->table );

        if( $params !== false ) {
            $query->where( $params );
        }
        $execute = $query->get();
        return ($execute);
    }
}