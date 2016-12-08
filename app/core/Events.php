<?php

namespace app\core;

/** Handles all events */

use app\core\Library as Lib;

class Events extends BaseController
{

    protected $events;
    protected $event;
    protected $type;
    protected $args;

    public function __construct()
    {
        $this->events = EventsMapper::events();
    }

    /**
     * Trigger an event, the event will be passed trough a session when display is true, redirect afterwards.
     * @param $subject
     * @param $display
     */
    public function trigger( $subject, $display )
    {
        foreach ( $this->events as $event ) {
            if ( in_array( $subject, $event, true ) ) {
                if( true === $display ) {
                    $_SESSION['event'] = $subject;
                }
                Lib::redirect($event['redirect']);
            }
        }
    }
}

?>