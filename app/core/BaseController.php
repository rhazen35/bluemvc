<?php
/** CORE */
namespace app\core;

use app\core\Library as Lib;
use app\controllers\Login;

/** BASE CONTROLLER */
class BaseController
{
    /** Model
     * @param $model
     * @return mixed
     */
    protected function model( $model )
    {
        require_once( Lib::path("app/models/" . $model . ".php" ) );
        return( new $model );
    }
    /** View
     * @param $view
     * @param array $data
     */
    protected function view( $view, $data = [] )
    {
        /** Check if the user is logged, if not, send to login */
        if( !Login::is_logged_in() ):
            $view = "login/index";
        endif;
        /**
         * Setup the view
         *
         * Header, requested view, footer
         */
        require_once( Lib::path("app/views/common/header.phtml" ) );
        require_once( Lib::path("app/views/" . $view . ".phtml" ) );
        require_once( Lib::path("app/views/common/footer.phtml" ) );
    }
    /** View a partial
     * @param $view
     * @param $partial
     * @param array $data
     */
    protected function view_partial( $view, $partial, $data = [] ){include_once( Lib::path("app/views/" . $view . "/partials/" . $partial . ".phtml" ) );}
    /** View a message */
    protected function view_messages( $view, $data = [] ){require_once( Lib::path("app/views/messages/" . $view . ".phtml" ) );}
    /** Check if the user is an admon or a super user */
    protected function is_admin_or_super_user()
    {
        if( isset( $_SESSION['login'] ) ):
            $data = $_SESSION['login'];
            /**
             * Get the users type
             * @var  $userType
             */
            $userType = (int) $this->model('User')->get_user_type($data);
            if( $userType === 1 || $userType === 2 ):
                return( true );
            else:
                return( false );
            endif;
        else:
            return( false );
        endif;
    }
    /** Redirect
     * @param string $location
     */
    public function redirect( $location = '' )
    {
        header("Location: " . BASE_PATH . $location . "");
        exit();
    }
    /** Get a users email */
    public function get_user_email(){return( $this->model('User')->get_user_email() );}
    /** Get a users login */
    public function get_user_login(){return( $this->model('LoginUser')->get_users_login() );}

}