<?php

namespace app\service;

use app\core\ServiceController;

class UserService extends ServiceController
{
    protected $model;

    public function __construct()
    {
        $this->model      = $this->model('User');
    }

    /** Non-standard CRUD operations */
    public function get_all_users()
    {
        return( $this->model->get_all_users() );
    }
}