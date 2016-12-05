<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

if( !class_exists( "LoginUser" ) ):

    class LoginUser extends Eloquent
    {
        protected $fillable = ['user_id', 'previous', 'current', 'first', 'count', 'created_at', 'updated_at'];
        public $timestamp = false;

        private function get_users_login()
        {
            $user_id = ( !empty( $_SESSION['login'] ) ? $_SESSION['login'] : "" );
            $capsule = unserialize( CAPSULE );
            $read = $capsule->table('users_login')->where('user_id', '=', $user_id)->first();
            return($read);
        }

        public function register_login()
        {
            $data = $this->get_users_login();
            return($data);
        }

        public function register_new_login()
        {
            $user_id = ( !empty( $_SESSION['login'] ) ? $_SESSION['login'] : "" );
            $date    = date( "Y-m-d H:i:s" );
            $capsule = unserialize( CAPSULE );
            $capsule->table('users_login')->insert(['user_id' => $user_id, 'previous' => "", 'current' => $date, 'first' => $date, 'count' => 1, 'created_at' => $date]);
        }

        public function update_user_login( $data )
        {
            $previous = $data->current;
            $date    = date( "Y-m-d H:i:s" );
            $user_id = ( !empty( $_SESSION['login'] ) ? $_SESSION['login'] : "" );
            $capsule = unserialize( CAPSULE );
            $capsule->table('users_login')->where('user_id', $user_id)->update(['current' => $date, 'previous' => $previous, 'updated_at' => $date]);
        }
    }

endif;
