<?php

namespace app\repositories;

use app\core\RepositoryController;

class GroupsRepository extends RepositoryController
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model('Group');
    }

    public function get_all_groups()
    {
        return( $this->model->get_all_groups() );
    }
}