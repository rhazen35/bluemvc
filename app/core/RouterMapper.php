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
            array('url' => 'login/index'                             , 'controller' => 'login'              , 'action' => 'index'),
            array('url' => 'login/logout'                            , 'controller' => 'login'              , 'action' => 'logout'),
            array('url' => 'login/authorize'                         , 'controller' => 'login'              , 'action' => 'authorize'),
            array('url' => 'login/failed'                            , 'controller' => 'login'              , 'action' => 'failed'),

            /** Home */
            array('url' => 'home/index'                              ,'controller' => 'home'                ,'action' => 'index')
        );

        return( $routes );
    }
}