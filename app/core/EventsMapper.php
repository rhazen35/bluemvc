<?php

namespace app\core;

class EventsMapper
{
    public static function events()
    {
        /** Event ************** Type ********************** Message ************************************* Arguments *************** Redirect ********/
        $events = array(
            array('event' => 1     ,'type' => 'login'       ,'message' => 'Logged in successful.'        ,'arguments' => true       , 'home/index' ),
            array('event' => 2     ,'type' => 'login'       ,'message' => 'Login Failed!'                ,'arguments' => false )    , 'login/index'
        );

        return( $events );
    }
}

?>