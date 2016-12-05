<?php

session_start();

use app\core\Library as Lib;
use app\core\Configuration;
use app\core\Router;

/** Require all base classes */
require_once( 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php' );
require_once( 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'database.php' );
require_once( 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Library.php' );
require_once( 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'BaseController.php' );
require_once( 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Router.php' );

/** Define the application path */
define( 'APPLICATION_PATH', realpath( Lib::path(__DIR__) ) . DIRECTORY_SEPARATOR );

/** Require the autoloader and the glossary */
require_once( APPLICATION_PATH . Lib::path( 'app/core/autoloader.php' ) );
require_once( APPLICATION_PATH . Lib::path( 'app/core/glossary.php' ) );

/** Initialize the configuration and start the application */
( new Configuration() )->initSet();

/** Globalize capsule (Laravel / Eloquent) and set the route */
define( "CAPSULE", serialize( $GLOBALS['capsule'] ) );
( new Router() )->set_route();