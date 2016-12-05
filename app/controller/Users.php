<?php
/** CONTROLLER */
namespace app\controller;

use app\core\BaseController;
use app\core\Library as Lib;

class Users extends BaseController
{
    protected $user;

    /** Inititalize the model */
    public function __construct(){$this->user = $this->model("User");}
    /**
     * --- Router functions ---
     *
     * Index
     */
    public function index(){( $this->is_admin_or_super_user() ? $this->view('users/index', []) : $this->view('home/index', []) );}
    /** New user */
    public function new_user(){( $this->is_admin_or_super_user() ? $this->view('users/new_user', []) : $this->view('home/index', []) );}
    /**
     * --- CRUD ---
     *
     *Read all users
     */
    public function get_users()
    {
        $data = $this->model('User')->get_users();
        return( $data );
    }
    /** Read user email and check if exists */
    public function check_user_exists( $email ){return( $this->user->check_user_exists( $email ) );}
    /** Create a new user */
    public function add_user()
    {
        $email       = ( !empty( $_POST['email'] ) ? $_POST['email'] : "" );
        $type        = ( !empty( $_POST['type'] ) ? $_POST['type'] : "" );
        $type        = $this->convert_user_type_number( $type );
        $pass        = ( !empty( $_POST['password'] ) ? $_POST['password'] : "" );
        $pass_repeat = ( !empty( $_POST['pass_repeat'] ) ? $_POST['pass_repeat'] : "" );
        /** Check if the user exists */
        if( !$this->check_user_exists( $email ) ):
            /** Check if password and password repeat is set and it they match */
            if( !empty( $pass ) && !empty( $pass_repeat ) && $pass === $pass_repeat ):
                /** Check if email and type are set */
                if( Lib::noempty( $params = array($email, $this->convert_user_type_number( $type ) ) ) ):
                    $this->user->create_user( ['email' => $email, 'type' => $type, 'pass' => $pass] );
                    /** Send a registration mail and redirect */
                    $this->send_registration_mail( $email, $pass );
                    $this->redirect("users/index");
                else:
                    /** Add a message type and redirect */
                    $_SESSION['message'] = "missingFields";
                    $this->redirect("users/new");
                endif;
            else:
                /** Add a message type and redirect */
                $_SESSION['message'] = "passNoMatch";
                $this->redirect("users/new");
            endif;
        else:
            /** Add a message type and redirect */
            $_SESSION['message'] = "userExists";
            $this->redirect("users/new");
        endif;
    }
    /** Update a user */
    public function edit()
    {
        $userID = ( !empty( $_POST['userID'] ) ? $_POST['userID'] : "" );
        $email  = ( !empty( $_POST['email'] ) ? $_POST['email'] : "" );
        $type   = ( !empty( $_POST['type'] ) ? $_POST['type'] : "" );

        if( Lib::noempty( $params = array($userID, $email, $this->convert_user_type_number( $type ) ) ) ):
            $this->model('User')->update_user( $params );
        endif;

        return( $this->view_partial( "users", "users_table" ) );
    }
    /** Delete a user */
    public function delete( $data = [] )
    {
        if( !empty( $data ) ):
            $this->model('User')->delete_user( $data );
        endif;

        return( $this->view_partial( "users", "users_table" ) );
    }
    /**
     * --- User functions ---
     *
     * Send a registration mail
     */
    public function send_registration_mail( $email, $pass )
    {
        $headers  = "From: " . strip_tags("registration.hospitium@litening.org") . "\r\n";
        $headers .= "Reply-To: ". strip_tags("registration.hospitium@litening.org") . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();
        $headers .= 'MIME-Version: 1.0' . "\r\n";

        $message  = 'Uw registratie is succesvol verwerkt.' . "\r\n\r\n";
        $message .= 'U bent aangemeld als gebruiker van het Hospitium systeem.' . "\r\n\r\n";
        $message .= 'U kunt inloggen met de volgende gegevens:';
        $message .= ' Gebruikersnaam: ' . $email . "\r\n\r\n";
        $message .= ' Wachtwoord: ' . $pass . "\r\n\r\n";

        $subject = 'Registratie Hospitium Nova College';

        mail($email, $subject, $message, $headers);
    }
    /** Return a user types array */
    public function user_types_array(){return( ['admin', 'superuser', 'normal', 'guest'] );}
    /** Convert a user type number to a readable type */
    public function convert_user_type_text( $user_type )
    {
        switch( $user_type ):
            case"1":
                return( "admin" );
                break;
            case"2":
                return( "superuser" );
                break;
            case"3":
                return( "normal" );
                break;
            case"4":
                return( "guest" );
                break;
            default:
                return( "unknown" );
                break;
        endswitch;
    }
    /** Convert a user type text to a user type number */
    public function convert_user_type_number( $user_type )
    {
        switch( $user_type ):
            case"admin":
                return( 1 );
                break;
            case"superuser":
                return( 2 );
                break;
            case"normal":
                return( 3 );
                break;
            case"guest":
                return( 4 );
                break;
            default:
                return( 5 );
                break;
        endswitch;
    }

}