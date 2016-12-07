<?php

namespace app\core;

use app\core\BaseController;

class Privileges extends BaseController
{
    protected $userID;
    public $privileges;
    protected $service;
    protected $role;

    public function __construct()
    {
        $this->userID     = ( !empty( $_SESSION['login'] ) ? $_SESSION['login'] : "" );
        $this->service    = $this->service('UserRoleService');
        $this->role       = $this->service('RoleService');
        $this->privileges = $this->get_privileges();
    }

    private function get_privileges()
    {
        $privileges = array();
        $data = $this->service->read(
            false,
            $params = array( 'user_id' => $this->userID ),
            false,
            false
        );
        foreach( $data as $privilege ){
            $role         = $this->get_role_from_id( $privilege->role_id );
            $privileges[] = $role;
        }
        return( $privileges );
    }

    private function get_role_from_id( $role_id )
    {
        $data  = '';
        $roles = $this->role->read(
            false,
            $params = array( 'role_id' => $role_id ),
            false,
            false
        );
        foreach( $roles as $role ){
            $data = $role->role;
        }
        return( $data );
    }
}
