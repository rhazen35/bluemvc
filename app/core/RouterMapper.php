<?php

namespace app\core;

class RouterMapper
{
    /**
     * Set all the routes
     *
     * @return array
     */
    public static function routes()
    {
        $routes = array(
            /********** url ***************************************** controller ************************** method **********************/

            /** Login */
            array('url' => 'login/index'                        , 'controller' => 'login'              , 'action' => 'index'),
            array('url' => 'login/logout'                       , 'controller' => 'login'              , 'action' => 'logout'),
            array('url' => 'login/login'                        , 'controller' => 'login'              , 'action' => 'login'),
            array('url' => 'login/failed'                       , 'controller' => 'login'              , 'action' => 'failed'),

            /** Users */
            array('url' => 'users/index'                        , 'controller' => 'users'              , 'action' => 'index'),
            array('url' => 'users/new'                          , 'controller' => 'users'              , 'action' => 'new_user'),
            array('url' => 'users/add_user'                     , 'controller' => 'users'              , 'action' => 'add_user'),
            array('url' => 'users/delete'                       , 'controller' => 'users'              , 'action' => 'delete'),
            array('url' => 'users/edit'                         , 'controller' => 'users'              , 'action' => 'edit'),

            /** Home */
            array('url' => 'home/index'                         ,'controller' => 'home'                ,'action' => 'index')
        );

        return( $routes );
    }
}