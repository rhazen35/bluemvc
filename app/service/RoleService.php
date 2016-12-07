<?php

namespace app\service;

use app\core\ServiceController;
use app\service\IService;

class RoleService extends ServiceController implements IService
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model('Role');
    }

    public function create( $params )
    {

    }

    public function read( $joins, $params, $groups, $orders )
    {
        return( $this->model->get( $joins, $params, $groups, $orders ) );
    }

    public function update( $where, $params )
    {

    }

    public function delete( $params )
    {

    }

}