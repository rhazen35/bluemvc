<?php

namespace app\controller;

use app\core\BaseController;
use app\core\Library as Lib;


class Users extends BaseController
{
    protected $user;

    public function index()
    {
        ( $this->is_admin_or_super_user() ? $this->view('users/index', []) : $this->view('home/index', []) );
    }

    public function new_user()
    {
        ( $this->is_admin_or_super_user() ? $this->view('users/new_user', []) : $this->view('home/index', []) );
    }

    public function get_users()
    {
        $data = $this->model('User')->get_users();
        return( $data );
    }

    public function add_user()
    {
        $email  = ( !empty( $_POST['email'] ) ? $_POST['email'] : "" );
        $type   = ( !empty( $_POST['type'] ) ? $_POST['type'] : "" );
        $type   = $this->convert_user_type_number( $type );
        $pass   = ( !empty( $_POST['password'] ) ? $_POST['password'] : "" );

        if( Lib::noempty( $params = array($email, $this->convert_user_type_number( $type ), $pass ) ) ):
            $this->model('User')->create_user( ['email' => $email, 'type' => $type, 'pass' => $pass] );
            Lib::redirect("users/index");
        endif;

    }

    public function edit()
    {
        $userID = ( !empty( $_POST['userID'] ) ? $_POST['userID'] : "" );
        $email  = ( !empty( $_POST['email'] ) ? $_POST['email'] : "" );
        $type   = ( !empty( $_POST['type'] ) ? $_POST['type'] : "" );

        if( Lib::noempty( $params = array($userID, $email, $this->convert_user_type_number( $type ) ) ) ):
            $this->model('User')->update_user( $params );
        endif;

        return( $this->view_partial( "users", "users_table" ) );
    }

    public function delete( $data = [] )
    {
        if( !empty( $data ) ):
            $this->model('User')->delete_user( $data );
        endif;

        return( $this->view_partial( "users", "users_table" ) );
    }

    public function user_types_array()
    {
        return( ['admin', 'superuser', 'normal', 'guest'] );
    }

    public function convert_user_type_text( $user_type )
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

    public function convert_user_type_number( $user_type )
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