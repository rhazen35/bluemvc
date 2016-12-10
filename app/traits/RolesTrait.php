<?php

namespace app\traits;

use app\repositories\BaseRepository;

trait RolesTrait
{
    public function get_role_from_id( $role_id )
    {
        return( ( new BaseRepository() )->read( 'roles', ['id' => $role_id] , false, false ) );
    }

    public function get_all_roles()
    {
        return( ( new BaseRepository() )->read( 'roles', false , false, false ) );
    }
}