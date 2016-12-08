<?php

namespace app\core;

/** Displays an event message */

class EventMessage
{
    protected $event;
    protected $messages;

    public function __construct()
    {
        $this->event = !empty( $_SESSION['event'] ) ? $_SESSION['event'] : "";
        $this->messages = EventMessageMapper::messages();
    }

    /**
     * @return string
     */
    public function display()
    {
        if( !empty( $this->event ) ):
            unset( $_SESSION['event'] );
            foreach( $this->messages as $message  ):
                if( in_array( $this->event, $message, true ) ):
                    $class     = $message['type'] === true ? 'event-success' : 'event-failed';
                    $message   = $message['message'];
                    $response  = '<div class="' . $class . '">';
                    $response .= $message;
                    $response .= '</div>';
                    return($response);
                endif;
            endforeach;
        endif;
    }
}