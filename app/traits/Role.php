<?php

namespace app\traits;

use app\service\BaseService;

trait Role
{
    public function get_role_from_id( $role_id )
    {
        return( ( new BaseService() )->read( 'roles', ['id' => $role_id] , false, false ) );
    }
}