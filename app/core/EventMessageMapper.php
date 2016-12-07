<?php

namespace app\core;

class EventMessageMapper
{
    public static function messages()
    {
        /********* Event ********* Type ************* Message **************************************************/
        $messages = array(
            array('event' => 1    ,'type' => true   ,'message' => 'Login successful!'
            ),
            array('event' => 2    ,'type' => false  ,'message' => 'Given credentials dit not match any data, please try again or contact your PM.'
            ),
            array('event' => 3    ,'type' => true   ,'message' => 'Logged out.'
            )

        );
        return( $messages );
    }
}