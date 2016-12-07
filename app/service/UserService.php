<?php

namespace app\service;

use app\core\ServiceController;
use app\service\IService;

class UserService extends ServiceController implements IService
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model('User');
    }

    /**
     * Standard CRUD operations
     */

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

    /** Non-standard CRUD operations */
    public function get_users_and_groups_and_roles()
    {
        return( $this->model->get_users_and_groups_and_roles() );
    }
}