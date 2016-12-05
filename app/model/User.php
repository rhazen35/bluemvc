<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

if( !class_exists( "User" ) ):

    class User extends Eloquent
    {
        protected $fillable = [
            'email',
            'hash'
        ];


        //--------------------------------------------------------------------------------------------------------------
        // Relations
        //--------------------------------------------------------------------------------------------------------------

        public function projects()
        {
            return $this->hasMany(Project::class);
        }


        public function get_user_type( $data = [] )
        {
            $capsule = unserialize( CAPSULE );
            $data    = $capsule->table('users_type')->where('user_id', '=', $data['user_id'])->get();

            if( !empty( $data ) ):
                foreach( $data as $item ):
                    if( !empty( $item->type ) ):
                        return( $item->type );
                    else:
                        return( false );
                    endif;
                endforeach;
            else:
                return( false );
            endif;

            return( false );
        }

        public function get_users()
        {
            $capsule = unserialize( CAPSULE );
            $data    = $capsule->table('users')->get();
            return($data);
        }

        public function create_user( $data = [] )
        {
            $capsule = unserialize( CAPSULE );
            $hash    = password_hash( $data['pass'], PASSWORD_BCRYPT );
            $dataSet = array('email' => $data['email'], 'hash' => $hash);
            $user    = User::create($dataSet);
            $userID  = $user->id;

            $capsule->table('users_type')->insert(['user_id' => $userID, 'type' => $data['type']]);
        }

        public function update_user( $params )
        {
            $capsule = unserialize( CAPSULE );
            $capsule->table('users')->where('id', $params[0])->update(['email' => $params[1]]);
            $capsule->table('users_type')->where('user_id', $params[0])->update(['type' => $params[2]]);
        }

        public function delete_user( $data = [] )
        {
            $capsule = unserialize( CAPSULE );
            $capsule->table('users_type')->whereIn('user_id', (array) $data)->delete();
            User::destroy($data);
        }
    }

endif;