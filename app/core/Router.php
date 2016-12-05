<?php
/** CORE */

/** Router extracts the url and determines the path to go to */

namespace app\core;

use app\core\Library as Lib;
use app\core\BaseController;

class Router extends BaseController
{
    protected $url;
    protected $routes;
    protected $default_controller = "Home";
    protected $default_method     = "index";
    protected $controller         = "Home";
    protected $method             = 'index';
    protected $params             = [];

    /**
     * Router constructor.
     *
     * Set the url and get the routes from the mapper
     */
    public function __construct()
    {
        /**
         * Parse the url
         * @var $url
         */
        $this->url    = $this->parse_url( isset( $_GET['url'] ) ? $_GET['url'] : "" );
        $this->routes = RouterMapper::routes();
    }
    /**
     * Parse the url
     * @param $url
     * @return array|bool
     */
    private function parse_url( $url )
    {
        if( !empty( $url ) ):
            $parsed_url = explode('/', filter_var( rtrim( $url, '/' ), FILTER_SANITIZE_URL ) );
            return( $parsed_url );
        endif;

        return( false );
    }
    /** Set the route, extracted from the url */
    public function set_route()
    {
        $url         = $this->url;
        $route       = !empty( $url[0] ) && !empty( $url[1] ) ? $url[0] . '/' . $url[1] : 'home/index';
        $route_exist = false;
        /**
         * Walk trough the routes array and find the correct route
         * @var  $route_item
         */
        foreach( $this->routes as $route_item ):
            if( in_array( $route, $route_item ) ):
                $this->controller = $route_item['controller']; /** Set the controller */
                $this->method     = $route_item['action']; /** Set the method/action */
                $route_exist      = true; /** Set route exists to true */
                break;
            endif;
        endforeach;
        /** Check if the route exists, if not send 404 */
        if( !$route_exist ):
            $this->view('common/404', []);
        endif;
        /** Check if the controller exists, if not send 404 */
        $controllerPath = realpath( APPLICATION_PATH . Lib::path('app/controller/' . ucfirst( $this->controller ) . '.php' ) );
        if( file_exists( $controllerPath ) ):
            require_once($controllerPath);
            unset($url[0]);
            /** Capitalize first letter of controller and set controller namespace */
            $cp_controller    = ucfirst( $this->controller );
            $ns_controller    = "\\app\\controller\\".$cp_controller;
            $this->controller = ( new $ns_controller );
            /** Check if the method exists, if not send 404 */
            if( method_exists( $this->controller, $this->method ) ):
                unset( $url[1] );
            else:
                $this->view('common/404', []);
            endif;
            /** Set the params */
            $this->params = $url ? array_values( $url ) : [];
            /** Call the method with parameters */
            call_user_func_array( [ $this->controller, $this->method ], $this->params );
        else:
            $this->view('common/404', []);
        endif;
    }
}