<?php

namespace app\controller;

use app\core\BaseController;
use app\core\Library as Lib;

class User extends BaseController implements IController
{
    protected $service;

    public function __construct()
    {
        $this->service = $this->service("UserService");
    }

    public function index()
    {
        $this->view('users/index', []);
    }

    public function new_user()
    {
        $this->view('users/new_user', []);
    }

}