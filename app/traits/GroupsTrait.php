<?php

namespace app\traits;

use app\repositories\GroupsRepository;

trait GroupsTrait
{
    public function get_all_groups()
    {
        return ( ( new GroupsRepository() )->get_all_groups() );
    }
}

