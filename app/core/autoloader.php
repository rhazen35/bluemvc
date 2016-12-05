<?php
/** CORE */

/** Autoload namespaces, class names and class file names must contain uppercase first letter.*/

use app\core\Library as Lib;

/** Spl autoload register function */
spl_autoload_register(
/**
 * @param $class
 * @return bool
 */
    function( $class )
    {
        $path = APPLICATION_PATH . Lib::path( $class . '.php', '\\' );
        if( is_file( $path ) ):
            require_once( $path );
            return( true );
        endif;
        return( false );
    },
    false
);