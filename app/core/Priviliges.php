<?php

namespace app\core;

use app\core\BaseController;

class Priviliges extends BaseController
{
    protected $userID;
    public $privilige;
    protected $users;

    public function __construct()
    {
        $this->userID    = ( !empty( $_SESSION['login'] ) ? $_SESSION['login'] : "" );
        $this->users     = $this->model('User');
        $this->privilige = $this->get_privilige();
    }

    private function get_privilige()
    {
        return( $this->users->get_user_type( $this->userID ) );
    }

    public static function convert_user_type_text( $user_type )
    {
        switch( $user_type ):
            case"1":
                return( "admin" );
                break;
            case"2":
                return( "superuser" );
                break;
            case"3":
                return( "normal" );
                break;
            case"4":
                return( "guest" );
                break;
            default:
                return( "unknown" );
                break;
        endswitch;
    }
    /** Convert a user type text to a user type number */
    public static function convert_user_type_number( $user_type )
    {
        switch( $user_type ):
            case"admin":
                return( 1 );
                break;
            case"superuser":
                return( 2 );
                break;
            case"normal":
                return( 3 );
                break;
            case"guest":
                return( 4 );
                break;
            default:
                return( 5 );
                break;
        endswitch;
    }
}
