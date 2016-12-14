<?php

namespace app\controller;

use app\core\BaseController;

class Roles extends BaseController implements IController
{
    protected $base_repo;
    protected $repository;
    public function __construct()
    {
        $this->base_repo  = $this->repository('BaseRepository');
        $this->repository = $this->repository('RolesRepository');
    }

    public function index()
    {
        $this->view('roles/index', []);
    }

    public function get_all_roles()
    {
        return( $this->repository->get_all_roles() );
    }

    public function get_roles_table_result()
    {
        return( $this->view_partial('roles', 'table-roles', []) );
    }

    public function add_role()
    {
        $this->repository->add_role( $_POST );
    }

    /**
     * Edit a system group
     */
    public function edit_role()
    {
        $this->repository->edit_role( $_POST );
    }

    /**
     * Delete a system user
     */
    public function delete()
    {
        /**
         * Check if the group has related users
         */
        $role_id  = !empty( $_POST['id'] ) ? $_POST['id'] : "";
        $roles    = $this->get_all_roles();
        foreach( $roles as $role ){
            if( $role->id === (int) $role_id ){
                if( !$role->users->isEmpty() ){
                    $string = "Role is in use";
                    /** Respond with json object */
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        echo json_encode($string);
                        exit;
                        /** Respond with html message */
                    } else {
                        echo 'Form validation failed.';
                        echo '<br>' . $string;
                    }
                } else {
                    $this->base_repo->delete( 'roles', ['id' => $role_id] );
                    echo json_encode( true );
                }
            }
        }
    }
}