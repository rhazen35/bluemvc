<?php

namespace app\traits;

use app\repositories\BaseRepository;
use app\repositories\GroupsRepository;

trait GroupsTrait
{
    public function get_all_groups()
    {
        return ( ( new GroupsRepository() )->get_all_groups() );
    }

    /**
     * Get a group by full name
     * @param $group_name
     * @return bool
     */
    public function get_group_from_name( $group_name )
    {
        $names = ( new BaseRepository() )->read( 'groups', ['name' => $group_name], false, false );
        foreach( $names as $name ){
            return( $name );
        }
        return( false );
    }

    /**
     * Get a group by id
     * @param $group_id
     * @return mixed
     */
    public function get_group_from_id( $group_id )
    {
        return ( ( new BaseRepository() )->read( 'groups', ['id' => $group_id], false, false) );
    }
}

