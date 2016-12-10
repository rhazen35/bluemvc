<?php

namespace app\core\interfaces;

/** Interface for the BaseController */

interface IBaseController
{
    /**
     * @param $repository
     * @return mixed
     */
    public function repository( $repository );

    /**
     * @param $view
     * @param $data
     * @return mixed
     */
    public function view($view, $data );

    /**
     * @param $view
     * @param $partial
     * @param $data
     * @return mixed
     */
    public function view_partial($view, $partial, $data );
}