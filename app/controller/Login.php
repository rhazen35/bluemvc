<?php

namespace app\controller;

use app\core\BaseController;
use app\core\Library as Lib;
use app\observer\ISubject;
use app\observer\IObserver;
use app\observer\login\AuthorizeObserver;
use app\observer\login\RegisterLoginObserver;

class Login extends BaseController implements ISubject
{
    private $observers = array();
    protected $login;
    protected $login_user;

    public function __construct()
    {
        $this->login = $this->model('Login');
        $this->login_user = $this->model('LoginUser');
    }

    public function index()
    {
        $this->view('home/index', []);
    }

    function attach(IObserver $observer_in)
    {
        $this->observers[] = $observer_in;
    }

    function detach(IObserver $observer_in)
    {
        foreach ($this->observers as $okey => $oval) {
            if ($oval == $observer_in) {
                unset($this->observers[$okey]);
            }
        }
    }

    function notify()
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
        $a = new AuthorizeObserver();
        $r = new RegisterLoginObserver();

        $this->attach($a);
        $events = $this->notify();
        foreach( $events as $event ) {
            if( $event['event'] === 'login_authorization' && $event['response'] === true ) {
                $this->detach( $a );
                $this->attach($r);
                $events = $this->notify();
                $this->detach( $r );
                foreach ($events as $eventi) {
                    if( $eventi['event'] === 'register_user_login' && $eventi['response'] === true ) {
                        Lib::redirect('home/index');
                    }
                    else{
                        Lib::redirect('login/failed');
                    }
                }
                break;
            }
            else{
                Lib::redirect('login/failed');
            }
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