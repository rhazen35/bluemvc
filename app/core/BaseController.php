<?php
namespace app\core;

use app\core\Library as Lib;
use app\controller\Login;
use app\core\interfaces\IBaseController;

class BaseController implements IBaseController
{
    /**
     * @param $repository
     * @return mixed
     */
    public function repository( $repository )
    {
        require_once( Lib::path("app/repositories/" . $repository . ".php" ) );
        $repository = "\\app\\repositories\\" . $repository;
        return( new $repository );
    }

    /** View
     * @param $view
     * @param array $data
     * @return void
     */
    public function view( $view, $data = [] )
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
     * @return void
     */
    public function view_partial( $view, $partial, $data = [] )
    {
        include( Lib::path("app/view/" . $view . "/partials/" . $partial . ".phtml" ) );
    }


}