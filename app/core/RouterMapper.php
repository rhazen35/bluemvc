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

            /** Admin Panel */
            array('url' => 'adminPanel/index'                   , 'controller' => 'adminPanel'         , 'action' => 'index'),

            /** Users */
            array('url' => 'user/index'                         , 'controller' => 'user'               , 'action' => 'index'),
            array('url' => 'user/new'                           , 'controller' => 'user'               , 'action' => 'new_user'),
            array('url' => 'user/add_user'                      , 'controller' => 'user'               , 'action' => 'add_user'),
            array('url' => 'user/delete'                        , 'controller' => 'user'               , 'action' => 'delete'),
            array('url' => 'user/edit'                          , 'controller' => 'user'               , 'action' => 'edit'),

            /** Home */
            array('url' => 'home/index'                         ,'controller' => 'home'                ,'action' => 'index')
        );

        return( $routes );
    }
}