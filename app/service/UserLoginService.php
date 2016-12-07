<?php

namespace app\service;

use app\core\ServiceController;
use app\service\IService;

class UserLoginService extends ServiceController implements IService
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model('UserLogin');
    }

    public function create( $params )
    {
        return( $this->model->insert( $params ) );
    }

    public function read( $joins, $params, $groups, $orders )
    {
        return( $this->model->get( $joins, $params, $groups, $orders ) );
    }

    public function update( $where, $params )
    {
        return( $this->model->edit( $where, $params ) );
    }

    public function delete( $params )
    {

    }
}