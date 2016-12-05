<?php

namespace app\core;

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
            if ( in_array( $subject, $event ) ) {
                $this->view_messages('notifications/success', $event);
            }
        }
    }
}

?>