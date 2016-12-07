<?php

namespace app\observer;

interface IObserver
{
    public function update(ISubject $subject_in);
}

?>