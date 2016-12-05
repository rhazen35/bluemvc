<?php

namespace app\observer;

use app\observer\ISubject;

interface IObserver {
    public function update(ISubject $subject_in);
}

?>