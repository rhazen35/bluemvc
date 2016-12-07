<?php

namespace app\core;

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

    public function trigger( $subject, $display )
    {
        foreach ($this->events as $event) {
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