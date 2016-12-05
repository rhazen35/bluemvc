<?php

namespace app\core;

class EventsMapper
{
    public static function events()
    {
        $events = array(
            /************** Event ********************************* Type ************************* Arguments ******/
            array('login_authorization'                 , 'login'                                  , true )
        );

        return( $events );
    }
}

?>