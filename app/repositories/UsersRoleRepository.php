<?php

namespace app\repositories;

use app\core\RepositoryController;

class UsersRoleRepository extends RepositoryController
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