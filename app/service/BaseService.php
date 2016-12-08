<?php

namespace app\service;

use app\core\ServiceController;

class BaseService extends ServiceController implements IService
{
    protected $base_model;

    public function __construct()
    {
        $this->base_model = $this->model('BaseModel');
    }
    /**
     * Standard CRUD operations
     */
    public function create( $table, $params )
    {

    }

    public function read( $table, $where, $groups, $orders )
    {
        return( $this->base_model->get( $table, $where, $groups, $orders ) );
    }

    public function update( $table, $where, $params )
    {

    }

    public function delete( $table, $params )
    {

    }
}