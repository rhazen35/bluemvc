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

    public function index()
    {
        $this->view('adminpanel/index', []);
    }

    public function get_all_user_info()
    {
        return( $this->get_users_and_groups_and_roles() );
    }
}