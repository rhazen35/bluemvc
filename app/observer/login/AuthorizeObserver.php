<?php

namespace app\observer\login;

use app\core\BaseController;
use app\observer\IObserver;
use app\observer\ISubject;
use app\core\Library as Lib;

class AuthorizeObserver extends BaseController implements IObserver
{
    protected $login;

    public function __construct()
    {
        $this->login = $this->model('Login');
    }
    public function update(ISubject $subject)
    {
        $email    = ( !empty( $_POST['email'] ) ? trim( $_POST['email'] ) : "" );
        $password = ( !empty( $_POST['password'] ) ? trim( $_POST['password'] ) : "" );

        if( !empty( $email ) && !empty( $password ) ):
            $data = $this->login->read_where_email(['email' => $email]);
            if( $this->verify( $data, $password ) ):
                foreach( $data as $item ):
                    $_SESSION['login'] = $item->id;
                endforeach;
                return( true );
            else:
                return( false );
            endif;
        else:
            return( false );
        endif;
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
    }
}