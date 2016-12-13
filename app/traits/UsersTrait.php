<?php

namespace app\traits;

use app\repositories\BaseRepository;
use app\repositories\UsersRepository;
use app\repositories\UsersRoleRepository;

trait UsersTrait
{
    /**
     * Get all users.
     * @return mixed
     */
    public function get_all_users()
    {
        return( ( new UsersRepository() )->get_all_users() );
    }

    /**
     * Get a user by id
     * @param $user_id
     * @return mixed
     */
    public function get_user_from_id($user_id )
    {
        return ( ( new BaseRepository() )->read( 'users', ['id' => $user_id], false, false) );
    }

    /**
     * Get a user by full name
     * @param $user_name
     * @return bool
     */
    public function get_user_from_name($user_name )
    {
        $names = ( new BaseRepository() )->read( 'users', ['name' => $user_name], false, false );
        foreach( $names as $name ){
            return( $name );
        }
        return( false );
    }

    /**
     * Get the email matching the given email
     * @param $email
     * @return bool
     */
    public function get_email_by_email($email )
    {
        $emails = ( new BaseRepository() )->read( 'users', ['email' => $email], false, false );
        foreach( $emails as $email ){
            return( $email );
        }
        return( false );
    }

    /**
     * Get a user his/her roles
     * @return mixed
     */
    public function get_user_roles()
    {
        return( ( new UsersRoleRepository() )->get_user_roles() );
    }

    /**
     *  Get a user his/her groups
     * @param $user
     * @return array
     */
    public function get_user_groups_from_user( $user )
    {
        $groups = array();
        foreach( $user->groups as $group ){
            $groups[]   = $group->name;
        }
        return( $groups );
    }

    /**
     * Get a user his/her groups by id
     * @param $user_id
     * @return mixed
     */
    public function get_user_groups_from_user_id($user_id )
    {
        return( ( new BaseRepository() )->read( 'group_user', ['user_id' => $user_id], false, false  ) );
    }

    /**
     * Get a user his/her roles by user
     * @param $user
     * @return array
     */
    public function get_user_roles_from_user( $user )
    {
        $roles = array();
        foreach( $user->roles as $role ){
            $roles[] = $role->name;
        }
        return( $roles );
    }

    /**
     * Get a user his/her groups by id
     * @param $user_id
     * @return mixed
     */
    public function get_user_roles_from_user_id($user_id )
    {
        return( ( new BaseRepository() )->read( 'role_user', ['user_id' => $user_id], false, false  ) );
    }
}