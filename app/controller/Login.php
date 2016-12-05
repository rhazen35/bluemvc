<?php

namespace app\controller;

use app\core\BaseController;
use app\core\Library as Lib;
use app\observer\ISubject;
use app\observer\IObserver;
use app\observer\login\AuthorizeObserver;
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

    public function attach(IObserver $observer_in)
    {
        $this->observers[] = $observer_in;
    }

    public function detach(IObserver $observer_in)
    {
        foreach ($this->observers as $okey => $oval) {
            if ($oval == $observer_in) {
                unset($this->observers[$okey]);
            }
        }
    }

    public function notify()
    {
        $events = array();
        foreach ($this->observers as $obs) {
            $event = $obs->update($this);
            if (!empty($event) && $event !== null) {
                $events[] = $event;
            }
        }
        return ($events);
    }

    public function authorize()
    {
        $auth = new AuthorizeObserver();
        $regi = new RegisterLoginObserver();

        $this->attach( $auth );
        $response = $this->notify();
        $this->detach( $auth );

        if( $response )
        {
            $this->attach( $regi );
            $response = $this->notify();
            $this->detach( $regi );

            if( $response ):
                ( new Events() )->trigger( 1 );
            else:
                ( new Events() )->trigger( 2 );
            endif;
        }
        else
        {
            ( new Events() )->trigger( 2 );
        }
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