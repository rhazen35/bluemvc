<?php

namespace app\controller;

use app\core\BaseController;


class Home extends BaseController implements IController
{
    public function index( $data = [] )
    {
        $this->view('home/index', $data);
    }

}