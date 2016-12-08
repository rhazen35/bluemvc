<?php

namespace app\core\interfaces;

interface IBaseController
{
    /**
     * @param $service
     * @return mixed
     */
    public function service($service );

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