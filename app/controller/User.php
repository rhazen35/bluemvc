<?php

namespace app\controller;

use app\core\BaseController;
use app\traits\UsersTrait;
use app\traits\GroupsTrait;
use app\traits\RolesTrait;

class User extends BaseController implements IController
{
    use UsersTrait;
    use GroupsTrait;
    use RolesTrait;
    protected $repository;

    public function __construct()
    {
        $this->repository = $this->repository("UsersRepository");
    }

    public function index()
    {
        $this->view('user/index', []);
    }

    public function new_user()
    {
        $this->view('user/new-user', []);
    }

    public function add_user()
    {
        $this->repository->add_user( $_POST );
        return( $this->view_partial( "user", "table-user", [] ) );
    }

}