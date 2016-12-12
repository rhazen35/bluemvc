<?php

namespace app\traits;

use app\repositories\BaseRepository;
use app\repositories\UsersRepository;
use app\repositories\UsersRoleRepository;

trait UsersTrait
{
    public function get_all_users()
    {
        return( ( new UsersRepository() )->get_all_users() );
    }

    public function get_user_from_name( $user_name )
    {
        $names = ( new BaseRepository() )->read( 'users', ['name' => $user_name], false, false );
        foreach( $names as $name ){
            return( $name );
        }
        return( false );
    }

    public function get_email_by_email( $email )
    {
        $emails = ( new BaseRepository() )->read( 'users', ['email' => $email], false, false );
        foreach( $emails as $email ){
            return( $email );
        }
        return( false );
    }

    public function get_user_roles()
    {
        return( ( new UsersRoleRepository() )->get_user_roles() );
    }

    public function get_user_groups_from_user( $user )
    {
        $groups = array();
        foreach( $user->groups as $group ){
            $groups[]   = $group->name;
        }
        return( $groups );
    }

    public function get_user_roles_from_user( $user )
    {
        $roles = array();
        foreach( $user->roles as $role ){
            $roles[] = $role->name;
        }
        return( $roles );
    }
}