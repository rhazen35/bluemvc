<?php

namespace app\service;

use app\core\ServiceController;

class RoleService extends ServiceController
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model('Role');
    }


}