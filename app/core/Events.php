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

    public function trigger( $subject )
    {
        foreach ($this->events as $event) {
            if ( in_array( $subject, $event, true ) ) {
                $_SESSION['response_message'] = $event['message'];
                Lib::redirect($event['redirect']);
                break;
            }
        }
    }
}

?>