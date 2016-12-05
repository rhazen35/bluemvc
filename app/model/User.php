<?php
/** --- MODEL --- */
use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    protected $fillable = ['email', 'hash'];
    protected $capsule;
    protected $userID;
    /** Inititalize the model */
    public function __construct()
    {
        parent::__construct();
        $this->capsule = unserialize( CAPSULE );
        $this->userID  = ( !empty( $_SESSION['login'] ) ? $_SESSION['login'] : "" );
    }
    /**
     * --- CRUD -=--
     *
     *Read a users type
     */
    public function get_user_type( $data = '' )
    {
        $data    = $this->capsule->table('users_type')->where('user_id', '=', $data)->select('type')->first();

        if( !empty( $data->type ) ):
            return( $data->type );
        else:
            return( false );
        endif;
    }
    /** Read all users */
    public function get_users()
    {
        $data    = $this->capsule->table('users')->get();
        return($data);
    }
    /** Read a users email */
    public function get_user_email(){return( $this->capsule->table('users')->where('id', $this->userID)->select('email')->first() );}
    /** Check if a user exists */
    public function check_user_exists( $email )
    {
        $user = $this->capsule->table('users')->where('email', $email)->select('id')->first();
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
        $userID = $this->capsule->table('users')->insertGetId($dataSet);

        $this->capsule->table('users_type')->insert(['user_id' => $userID, 'type' => $data['type']]);
    }
    /** Update a user */
    public function update_user( $params )
    {
        $this->capsule->table('users')->where('id', $params[0])->update(['email' => $params[1]]);
        $this->capsule->table('users_type')->where('user_id', $params[0])->update(['type' => $params[2]]);
    }
    /** Delete a user */
    public function delete_user( $data = [] )
    {
        $this->capsule->table('users_type')->whereIn('user_id', (array) $data)->delete();
        User::destroy($data);
    }
}