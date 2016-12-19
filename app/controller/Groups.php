<?php

namespace app\controller;

use app\core\BaseController;

class Groups extends BaseController implements IController
{
    protected $base_repo;
    protected $repository;
    public function __construct()
    {
        $this->base_repo  = $this->repository('BaseRepository');
        $this->repository = $this->repository('GroupsRepository');
    }

    public function index( $data = [] )
    {
        $this->view('groups/index', $data);
    }

    /**
     * Get all system groups
     * @return mixed
     */
    public function get_all_groups()
    {
        return( $this->repository->get_all_groups() );
    }

    /** Get all groups paginated */
    public function get_all_groups_paginated( $limit, $page )
    {
        return( $this->repository->get_all_groups_paginated( $limit, $page ) );
    }

    /**
     * Get the groups table as a response after AJAX request
     */
    public function get_groups_table_result()
    {
        $page = !empty( $_POST['page'] ) ? $_POST['page'] : [];
        return( $this->view_partial('groups', 'table-groups', $page) );
    }

    /**
     * Add a new system group
     */
    public function add_group()
    {
        $this->repository->add_group( $_POST );
    }

    /**
     * Edit a system group
     */
    public function edit_group()
    {
        $this->repository->edit_group( $_POST );
    }

    /**
     * Delete a system user
     */
    public function delete()
    {
        /**
         * Check if the group has related users
         */
        $group_id = !empty( $_POST['id'] ) ? $_POST['id'] : "";
        $groups   = $this->get_all_groups();
        foreach( $groups as $group ){
            if( $group->id === (int) $group_id ){
                if( !$group->users->isEmpty() ){
                    $string = "Group is in use";
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
                    $this->base_repo->delete( 'groups', ['id' => $group_id] );
                    echo json_encode( true );
                }
            }
        }
    }
}
