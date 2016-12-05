<?php

namespace app\observer\login;

use app\core\BaseController;
use app\observer\IObserver;
use app\observer\ISubject;

class RegisterLoginObserver extends BaseController implements IObserver
{
    protected $login_user;

    public function __construct()
    {
        $this->login_user = $this->model('LoginUser');
    }

    public function update( ISubject $subject )
    {
        $data = $this->login_user->register_login();

        if( empty( $data ) ):
            $this->login_user->register_new_login();
        else:
            $this->login_user->update_user_login( $data );
        endif;

        return( true );
    }
}