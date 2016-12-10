<?php

namespace app\core;

class EventMessageMapper
{
    public static function messages()
    {
        /********* Event ********* Type ************* Message **************************************************/
        $messages = array(
            /**
             * System events 1-100
             */
            array('event' => 1    ,'type' => true   ,'message' => 'Login successful!'
            ),
            array('event' => 2    ,'type' => false  ,'message' => 'Given credentials dit not match any data, please try again or contact your PM.'
            ),
            array('event' => 3    ,'type' => true   ,'message' => 'Logged out.'
            ),
            /**
             * User events 100-200
             */
            array('event' => 100    ,'type' => true   ,'message' => 'New user added.')
        );
        return( $messages );
    }
}