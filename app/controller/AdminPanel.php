<?php

namespace app\controller;

use app\core\BaseController;

class AdminPanel extends BaseController implements IController
{

    public function __construct()
    {

    }

    public function index()
    {
        $this->view('adminpanel/index', []);
    }
}