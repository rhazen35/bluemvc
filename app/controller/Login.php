<?php

namespace app\controller;

use app\core\BaseController;
use app\core\Library as Lib;
use app\core\Events;

class Login extends BaseController
{
    protected $user;
    protected $user_role;
    protected $user_login;
    protected $userID;
    protected $date;

    public function __construct()
    {
        $this->user          = $this->service('UserService');
        $this->user_role     = $this->service('UserRoleService');
        $this->user_login    = $this->service('UserLoginService');
        $this->userID        = !empty( $_SESSION['login'] ) ? $_SESSION['login'] : "";
        $this->date          = date( 'Y-m-d H:i:s' );
    }

    public function index()
    {
        $this->view('home/index', []);
    }

    public function login()
    {
        $authorized = $this->authorize( $_POST );
        if( !empty( $authorized ) && $authorized !== false ){
            $this->register_login_datetime( $authorized );
            ( new Events() )->trigger( 1, true );
        } else {
            ( new Events() )->trigger( 2, true );
        }
    }

    public static function is_logged_in()
    {
        return( isset( $_SESSION['login'] ) && !empty( $_SESSION['login'] ) ? true : false );
    }

    public function validate( $data )
    {
        $email    = ( !empty( $data['email'] ) ? trim( $data['email'] ) : "" );
        $password = ( !empty( $data['password'] ) ? trim( $data['password'] ) : "" );
        return( !empty( $email ) && Lib::isValidEmail( $email ) && !empty( $password ) ? true : false );
    }

    public function authorize( $data )
    {
        $valid = $this->validate( $data );
        if( $valid ) {
            $email      = $data['email'];
            $password   = $data['password'];
            $login_data = $this->user->read( false, ['email' => $email], false, false );
            if ($this->verify($login_data, $password)) {
                foreach ($login_data as $item) {
                    $_SESSION['login'] = $item->id;
                    return ( $item->id );
                }
            } else {
                return (false);
            }
        } else {
            return (false);
        }
        return (false);
    }

    private function verify( $data, $password )
    {
        if( !empty( $data ) ):
            foreach( $data as $item ):
                if( !empty( $item->hash ) ):
                    $verify = !empty( $item->hash ) ? password_verify( $password, $item->hash ) : "";
                    return( $verify );
                else:
                    return( false );
                endif;
            endforeach;
        else:
            return( false );
        endif;
        return (false);
    }

    public function register_login_datetime( $authorized )
    {
        $data = $this->user_login->read(false, ['user_id' => $authorized], false, false);

        if( $data->isEmpty() ){
            $this->user_login->create([
                'user_id' => $authorized,
                'previous' => "",
                'current' => $this->date,
                'first' => $this->date,
                'count' => 1,
                'created_at' => $this->date
            ]);
        } else {
            foreach ($data as $login) {
                $previous = $login->current;
                $this->user_login->update(
                    ['user_id' => $authorized],
                    ['current' => $this->date, 'previous' => $previous, 'updated_at' => $this->date]
                );
            }
        }
    }

    public function logout()
    {
        unset( $_SESSION['login'] );
        ( new Events() )->trigger( 3, true );
    }

}