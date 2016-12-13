<?php

namespace app\controller;

use app\core\BaseController;
use app\traits\UsersTrait;
use app\traits\GroupsTrait;
use app\traits\RolesTrait;

class User extends BaseController implements IController
{
    use UsersTrait;
    use GroupsTrait;
    use RolesTrait;

    protected $base_repo;
    protected $repository;

    public function __construct()
    {
        $this->base_repo  = $this->repository("BaseRepository");
        $this->repository = $this->repository("UsersRepository");
    }

    public function index()
    {
        $this->view('user/index', []);
    }

    public function new_user()
    {
        $this->view('user/new-user', []);
    }

    public function add_user()
    {
        $this->repository->add_user( $_POST );
    }

    public function edit_user()
    {
        $this->repository->edit_user( $_POST );
    }

    /** Returns the user-table partial in case of a needed ajax response */
    public function get_user_table_result()
    {
        return ($this->view_partial("user", "table-user", []));
    }

    /**
     * Delete a specific user
     *
     * Tables to remove from:
     *  - role_user, group_user, login_user, users
     *
     * Returns the user-table for ajax response
     */
    public function delete()
    {
        $user_id = !empty( $_POST['id'] ) ? $_POST['id'] : "";
        if( !empty( $user_id ) ) {
            $this->base_repo->delete('role_user', ['user_id' => $user_id]);
            $this->base_repo->delete('group_user', ['user_id' => $user_id]);
            $this->base_repo->delete('login_user', ['user_id' => $user_id]);
            $this->base_repo->delete('users', ['id' => $user_id]);
        }
        return ( $this->get_user_table_result() );
    }

}