<?php

namespace app\controller;

use app\core\BaseController;

class Roles extends BaseController implements IController
{
    protected $base_repo;
    protected $repository;
    public function __construct()
    {
        $this->base_repo  = $this->repository('BaseRepository');
        $this->repository = $this->repository('RolesRepository');
    }

    public function index()
    {
        $this->view('roles/index', []);
    }
}