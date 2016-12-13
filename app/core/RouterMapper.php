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
            array('url' => 'user/edit_user'                     , 'controller' => 'user'               , 'action' => 'edit_user'),
            array('url' => 'user/get_user_table_result'         , 'controller' => 'user'               , 'action' => 'get_user_table_result'),

            /** Groups */
            array('url' => 'groups/index'                       , 'controller' => 'groups'             , 'action' => 'index'),
            array('url' => 'groups/add_group'                   , 'controller' => 'groups'             , 'action' => 'add_group'),
            array('url' => 'groups/get_groups_table_result'     , 'controller' => 'groups'             , 'action' => 'get_groups_table_result'),
            array('url' => 'groups/edit_group'                  , 'controller' => 'groups'             , 'action' => 'edit_group'),
            array('url' => 'groups/delete'                      , 'controller' => 'groups'             , 'action' => 'delete'),

            /** Roles */
            array('url' => 'roles/index'                        , 'controller' => 'roles'              , 'action' => 'index'),
            array('url' => 'roles/add_role'                     , 'controller' => 'roles'              , 'action' => 'add_role'),
            array('url' => 'roles/get_roles_table_result'       , 'controller' => 'roles'              , 'action' => 'get_roles_table_result'),
            array('url' => 'roles/edit_role'                    , 'controller' => 'roles'              , 'action' => 'edit_role'),
            array('url' => 'roles/delete'                       , 'controller' => 'roles'              , 'action' => 'delete'),

            /** Home */
            array('url' => 'home/index'                         ,'controller' => 'home'                ,'action' => 'index')
        );

        return( $routes );
    }
}