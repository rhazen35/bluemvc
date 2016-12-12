<?php

namespace app\repositories;

/**
 * Base repository is responsible for all basic queries.
 * - Simple CRUD operations must be provided with a table.
 *
 * Additional params per CRUD-item:
 * - C = $params, R = $where, $groups and $orders, U = $where, $params, D = $where
 */
use app\core\RepositoryController;

class BaseRepository extends RepositoryController implements IRepository
{
    protected $base_model;

    public function __construct()
    {
        $this->base_model = $this->model('BaseModel');
    }

    public function create( $table, $params )
    {

    }

    public function read( $table, $where, $groups, $orders )
    {
        return( $this->base_model->get( $table, $where, $groups, $orders ) );
    }

    public function update( $table, $where, $params )
    {

    }

    public function delete( $table, $where )
    {
        $this->base_model->remove( $table, $where );
    }
}