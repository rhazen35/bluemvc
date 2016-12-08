<?php

namespace app\service;

use app\core\ServiceController;

class UserRoleService extends ServiceController
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model('UserRole');
    }

    public function get_user_roles()
    {
        return( $this->model->get_user_roles() );
    }

}