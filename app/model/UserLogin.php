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
        $this->table   = 'user_login';
        $this->capsule = unserialize( CAPSULE );
        parent::__construct();
    }

    public function get( $joins, $params, $groups, $orders )
    {
        $query = $this->capsule->table( $this->table );

        if( $params !== false ) {
            $query->where( $params );
        }
        $execute = $query->get();
        return ($execute);
    }

    public function insert( $params )
    {
        $this->capsule->table( $this->table )->insert( $params );
    }

    public function edit( $where, $params )
    {
        $this->capsule->table( $this->table )->where( $where )->update( $params );
    }
}
