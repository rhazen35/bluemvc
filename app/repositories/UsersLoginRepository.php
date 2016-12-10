<?php

namespace app\repositories;

use app\core\RepositoryController;

class UsersLoginRepository extends RepositoryController
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model('UserLogin');
    }

}