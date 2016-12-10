<?php

namespace app\core;

use app\core\Library as Lib;

class RepositoryController
{
    /** Model
     * @param $model
     * @return mixed
     */
    protected function model( $model )
    {
        require_once( Lib::path("app/model/" . $model . ".php" ) );
        $model = "\\app\\model\\" . $model;
        return( new $model );
    }
}