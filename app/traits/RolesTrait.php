<?php

namespace app\traits;

use app\repositories\BaseRepository;

trait RolesTrait
{

    /**
     * Get all roles
     * @return mixed
     */
    public function get_all_roles()
    {
        return( ( new BaseRepository() )->read( 'roles', false , false, false ) );
    }

    /**
     * Get a role by full name
     * @param $role_name
     * @return bool
     */
    public function get_role_from_name( $role_name )
    {
        $names = ( new BaseRepository() )->read( 'roles', ['name' => $role_name], false, false );
        foreach( $names as $name ){
            return( $name );
        }
        return( false );
    }

    /**
     * Get a role by id
     * @param $role_id
     * @return mixed
     */
    public function get_role_from_id( $role_id )
    {
        return ( ( new BaseRepository() )->read( 'roles', ['id' => $role_id], false, false) );
    }
}