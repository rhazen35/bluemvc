<?php

namespace app\model;
/** --- MODEL --- */
use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    protected $capsule;
    protected $table;
    protected $userID;
    /** Inititalize the model */
    public function __construct()
    {
        parent::__construct();
        $this->capsule = unserialize( CAPSULE );
        $this->table   = 'user';
        $this->userID  = ( !empty( $_SESSION['login'] ) ? $_SESSION['login'] : "" );
    }

    public function get( $joins, $params, $groups, $orders )
    {
        $query = $this->capsule->table( $this->table );

        if( $params !== false ) {
            $query->where( $params );
        }
        $execute = $query->get();
        return ($execute);
    }

    /**
     * --- CRUD -=--
     *

     */

    public function get_users_and_groups_and_roles()
    {
        $data = $this->capsule->table( $this->table )->select('id', 'email')->get();
        return( $data );
    }

    /** Check if a user exists */
    public function check_user_exists( $email )
    {
        $user = $this->capsule->table('user')->where('email', $email)->select('id')->first();
        if( !empty( $user ) ):
            return( true );
        else:
            return( false );
        endif;
    }
    /** Create a new user */
    public function create_user( $data = [] )
    {
        $hash    = password_hash( $data['pass'], PASSWORD_BCRYPT );
        $dataSet = array('email' => $data['email'], 'hash' => $hash);
        $userID = $this->capsule->table('user')->insertGetId($dataSet);

        $this->capsule->table('users_type')->insert(['user_id' => $userID, 'type' => $data['type']]);
    }
    /** Update a user */
    public function update_user( $params )
    {
        $this->capsule->table('user')->where('id', $params[0])->update(['email' => $params[1]]);
        $this->capsule->table('users_type')->where('user_id', $params[0])->update(['type' => $params[2]]);
    }
    /** Delete a user */
    public function delete_user( $data = [] )
    {
        $this->capsule->table('users_type')->whereIn('user_id', (array) $data)->delete();
        User::destroy($data);
    }
}