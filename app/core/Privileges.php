<?php

namespace app\core;

use app\core\BaseController;
use app\traits\User;
use app\traits\Role;

class Privileges extends BaseController
{
    public $privileges;
    protected $userID;
    protected $base_service;
    protected $user_role;
    protected $role;
    protected $table_role;
    protected $table_user_role;

    use User;
    use Role;

    public function __construct()
    {
        $this->userID          = ( !empty( $_SESSION['login'] ) ? $_SESSION['login'] : "" );
        $this->base_service    = $this->service('BaseService');
        $this->user_role       = $this->service('UserRoleService');
        $this->role            = $this->service('RoleService');
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
