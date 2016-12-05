<?php

namespace app\core;

class EventsMapper
{
    public static function events()
    {
        $events = array(
            /*** Event ****************** Type ********************* Message ********************* Arguments ******/
            array('event' => 1     ,'type' => 'login'             ,'message' => 'Logged in successful.'        ,'arguments' => true ),
            array('event' => 2     ,'type' => 'login'             ,'message' => 'Login Failed!'                ,'arguments' => false )
        );

        return( $events );
    }
}

?>