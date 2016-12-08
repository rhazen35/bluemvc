<?php

namespace app\controller;

use app\core\BaseController;
use app\traits\User;

class AdminPanel extends BaseController implements IController
{
    use User;
    public function __construct()
    {

    }

    /**
     *
     */
    public function index()
    {
        $this->view('adminpanel/index', []);
    }
}