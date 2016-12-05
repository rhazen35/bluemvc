<?php

namespace app\observer;

use app\observer\IObserver;

interface ISubject {
    public function attach(IObserver $observer_in);
    public function detach(IObserver $observer_in);
    public function notify();
}

?>