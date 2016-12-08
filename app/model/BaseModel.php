<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class BaseModel extends Eloquent implements IBaseModel
{
    protected $capsule;

    public function __construct()
    {
        $this->capsule = unserialize( CAPSULE );
        parent::__construct();
    }

    public function insert( $table, $where )
    {

    }

    public function get( $table, $params, $groups, $orders )
    {
        $query = $this->capsule->table( $table );

        if( $params !== false ) {
            $query->where( $params );
        }
        $execute = $query->get();
        return ($execute);
    }

    public function edit( $table, $where, $params )
    {

    }

    public function remove( $table, $where )
    {

    }
}