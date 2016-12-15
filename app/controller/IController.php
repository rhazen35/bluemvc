<?php

namespace app\controller;

/**
 * Standard interface for controllers, except the BaseController.
 */

interface IController
{
    /**
     * @return mixed
     */
    public function index( $data = [] );
}