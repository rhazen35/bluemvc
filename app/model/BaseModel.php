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

    public function insert( $table, $params )
    {
        $return_id = $this->capsule->table( $table )->insertGetId( $params );
        return( $return_id );
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
        $this->capsule->table($table)->where($where)->update($params);
    }

    public function remove( $table, $where )
    {
        $this->capsule->table($table)->where($where)->delete();
    }
}