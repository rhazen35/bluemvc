<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

if( !class_exists( "Login" ) ):

    class Login extends Eloquent
    {

        public function read_where_email( $data = '' )
        {
            $capsule = unserialize( CAPSULE );
            $read = $capsule->table('users')->where('email', '=', $data['email'])->get();
            return($read);
        }
    }

endif;