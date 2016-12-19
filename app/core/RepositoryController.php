<?php

namespace app\core;

use app\core\Library as Lib;

class RepositoryController extends BaseController
{
    /** Model
     * @param $model
     * @return mixed
     */
    public function model( $model )
    {
        require_once( Lib::path("app/model/" . $model . ".php" ) );
        $model = "\\app\\model\\" . $model;
        return( new $model );
    }

    public function view_partial( $view, $partial, $data = [] )
    {
        include( Lib::path("app/view/" . $view . "/partials/" . $partial . ".phtml" ) );
    }
}