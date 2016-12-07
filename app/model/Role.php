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
        $this->table   = 'role';
        parent::__construct();
    }

    public function get( $params )
    {
        $query = $this->capsule->table( $this->table );

        if( $params !== false ) {
            $query->where( $params );
        }
        $execute = $query->get();
        return ($execute);

    }
}