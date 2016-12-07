<?php
/** CORE */
namespace app\core;

use app\core\Library as Lib;
use app\controller\Login;

/** BASE CONTROLLER */
class BaseController
{
    /**
     * @param $service
     * @return mixed
     */
    protected function service( $service )
    {
        require_once( Lib::path("app/service/" . $service . ".php" ) );
        $service = "\\app\\service\\" . $service;
        return( new $service );
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
        require_once( Lib::path("app/view/common/header.phtml" ) );
        require_once( Lib::path("app/view/" . $view . ".phtml" ) );
        require_once( Lib::path("app/view/common/footer.phtml" ) );
    }
    /** View a partial
     * @param $view
     * @param $partial
     * @param array $data
     */
    protected function view_partial( $view, $partial, $data = [] ){include_once( Lib::path("app/view/" . $view . "/partials/" . $partial . ".phtml" ) );}
    /** View a message */
    protected function view_messages( $view, $data = [] ){require_once( Lib::path("app/view/messages/" . $view . ".phtml" ) );}
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

}