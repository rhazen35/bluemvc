<?php

namespace app\traits;

use app\service\UserService;
use app\service\UserRoleService;

trait User
{
    public function get_all_users()
    {
        return( ( new UserService() )->get_all_users() );
    }

    public function get_user_roles()
    {
        return( ( new UserRoleService() )->get_user_roles() );
    }
}