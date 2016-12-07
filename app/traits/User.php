<?php

namespace app\traits;

use app\service\UserService;

trait User
{
    public function get_users_and_groups_and_roles()
    {
        return( ( new UserService() )->get_users_and_groups_and_roles() );
    }
}