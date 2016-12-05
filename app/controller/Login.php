<?php

namespace app\controller;

use app\core\BaseController;
use app\core\Library as Lib;
use app\observer\ISubject;
use app\observer\IObserver;
use app\observer\login\RegisterLoginObserver;
use app\core\Events;

class Login extends BaseController implements ISubject
{
    protected $login;
    protected $login_user;
    private $observers = array();

    public function __construct()
    {
        $this->login = $this->model('Login');
        $this->login_user = $this->model('LoginUser');
    }

    public function index()
    {
        $this->view('home/index', []);
    }

    public function attach( IObserver $observer_in )
    {
        $this->observers[] = $observer_in;
    }

    public function detach( IObserver $observer_in )
    {
        foreach ($this->observers as $okey => $oval) {
            if ($oval == $observer_in) {
                unset($this->observers[$okey]);
            }
        }
    }

    public function notify()
    {
        foreach ($this->observers as $obs) {
           $obs->update($this);
        }
    }

    public function login()
    {
        $authorized = $this->authorize( $_POST );
        if( $authorized ){
            $this->register_login_datetime();
            ( new Events() )->trigger( 1 );
        } else {
            ( new Events() )->trigger( 2 );
        }
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
            $login_data = $this->login->read_where_email(['email' => $email]);
            if ($this->verify($login_data, $password)) {
                foreach ($login_data as $item) {
                    $_SESSION['login'] = $item->id;
                    return (true);
                }
            } else {
                return (false);
            }
        } else {
            return (false);
        }
        return (false);
    }

    public function register_login_datetime()
    {
        $regi = new RegisterLoginObserver();
        $this->attach( $regi );
        $this->notify();
        $this->detach( $regi );
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

    public static function is_logged_in()
    {
        return( isset( $_SESSION['login'] ) && !empty( $_SESSION['login'] ) ? true : false );
    }

    public function failed()
    {
        $this->index();
        $this->view_messages('login/failed', []);
    }

    public function logout()
    {
        unset( $_SESSION['login'] );
        Lib::redirect("home/index");
    }

}