<?php

namespace app\observer\login;

use app\observer\IObserver;
use app\observer\ISubject;

class LoginObserver implements IObserver
{
    public function __construct() {

    }
    public function update(ISubject $subject) {
        echo 'Ik ben een login observer en ik update';
    }
}

?>