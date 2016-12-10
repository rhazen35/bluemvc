<?php

namespace app\core;

use app\traits\UsersTrait;
use app\traits\RolesTrait;

class Privileges extends BaseController
{
    public $privileges;
    protected $userID;
    protected $base_service;
    protected $user_role;
    protected $role;
    protected $table_role;
    protected $table_user_role;

    use UsersTrait;
    use RolesTrait;

    public function __construct()
    {
        $this->userID          = ( !empty( $_SESSION['login'] ) ? $_SESSION['login'] : "" );
        $this->base_service    = $this->repository('BaseRepository');
        $this->user_role       = $this->repository('UsersRoleRepository');
        $this->role            = $this->repository('RolesRepository');
        $this->privileges      = $this->get_privileges();
        $this->table_role      = 'roles';
        $this->table_user_role = 'user_role';
    }

    private function get_privileges()
    {
        $privileges = array();
        $user_roles = $this->get_user_roles();
        foreach ($user_roles as $user_role){
            $roles = $this->get_role_from_id($user_role->role_id);
            foreach ($roles as $role) {
                $privileges[] = $role->role;
            }
        }
        return( $privileges );
    }
}
