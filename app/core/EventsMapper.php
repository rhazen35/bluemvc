<?php

namespace app\core;

class EventsMapper
{
    public static function events()
    {
        /******** Event ****************** Type ****************** Response **************************** Arguments ***************** Redirect ********/
        $events = array(
             array('event' => 1     ,'type' => 'login'       ,'response' => 'success'            ,'arguments' => true       , 'redirect' => 'home/index')
            ,array('event' => 2     ,'type' => 'login'       ,'response' => 'failed'             ,'arguments' => false      , 'redirect' => 'login/index')
            ,array('event' => 3     ,'type' => 'logout'      ,'response' => 'success'            ,'arguments' => true       , 'redirect' => 'home/index')

            ,array('event' => 100   ,'type' => 'user'        ,'response' => 'success'            ,'arguments' => true       , 'redirect' => false)
        );
        return( $events );
    }
}
?>