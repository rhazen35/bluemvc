<?php

namespace app\service;

use app\core\ServiceController;

class UserLoginService extends ServiceController
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model('UserLogin');
    }

}