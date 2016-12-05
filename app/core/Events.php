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

    public function trigger()
    {
        foreach( $this->events as $event )
        {

        }
    }

}

?>