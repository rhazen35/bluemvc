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

    public function index()
    {
        $this->view('groups/index', []);
    }

    public function get_all_groups()
    {
        return( $this->repository->get_all_groups() );
    }

    public function add_group()
    {
        $this->repository->add_group( $_POST );
    }

    public function get_groups_table_result()
    {
        return( $this->view_partial('groups', 'table-groups', []) );
    }

    public function delete()
    {
        $group_id = !empty( $_POST['id'] ) ? $_POST['id'] : "";
        if( !empty( $group_id ) ) {
            $this->base_repo->delete( 'groups', ['id' => $group_id] );
        }
        return ( $this->get_groups_table_result() );
    }

    public function edit_group()
    {
      $this->repository->edit_group( $_POST );
    }
}
