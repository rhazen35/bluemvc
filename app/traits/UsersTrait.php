<?php

namespace app\traits;

use app\repositories\UsersRepository;
use app\repositories\UsersRoleRepository;

trait UsersTrait
{
    public function get_all_users()
    {
        return( ( new UsersRepository() )->get_all_users() );
    }

    public function get_user_roles()
    {
        return( ( new UsersRoleRepository() )->get_user_roles() );
    }
}