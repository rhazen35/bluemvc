<?php
/** CORE */

/** Library consists of all global functions and can be called statically. */

namespace app\core;

class Library
{
    /**
     * @param $sPath
     * @param string $sDelimiter
     * @param string $sReplacementDelimiter
     * @return mixed
     *
     * Path function that converts a given path to an all system fit path.
     */
    public static function path($sPath, $sDelimiter = '/', $sReplacementDelimiter = DIRECTORY_SEPARATOR )
    {
        return str_replace( $sDelimiter, $sReplacementDelimiter, $sPath );
    }
    /** Get the current user is */
    public static function get_current_user_id(){return( !empty( $_SESSION['login'] ) ? $_SESSION['login'] : "" );}
    /** Redirect
     * @param string $location
     */
    public static function redirect( $location = '' )
    {
        header("Location: " . BASE_PATH . $location . "");
        exit();
    }
    /**
     * Convert microtime to readable time
     * @param $data
     * @return string
     */
    public static function microtimeFormat( $data )
    {
        $duration   = microtime( true ) - $data;
        $hours      = (int)( $duration/60/60 );
        $minutes    = (int)( $duration/60 )-$hours*60;
        $seconds    = $duration-$hours*60*60-$minutes*60;

        return( number_format( (float)$seconds, 2, '.', '' ) );
    }
    /** Convert a date time format
     * @param $data
     * @return false|string
     */
    public static function convert_datetime_format( $data )
    {
        $originalDate = $data;
        return( date( "d-m-Y H:i:s", strtotime( $originalDate ) ) );
    }
    /**
     * @param $data
     * @return false|string
     */
    public static function convert_date_format($data )
    {
        $originalDate = $data;
        return( date( "d-m-Y", strtotime( $originalDate ) ) );
    }
    /**
     * Remove a directory recursively
     * @param $dir
     */
    public static function removeDirRecursive( $dir )
    {
        if ( is_dir( $dir ) ):
            $objects = scandir( $dir );
            foreach( $objects as $object ):
                if( $object != "." && $object != ".." ):
                    if( filetype($dir."/".$object) == "dir" ):
                        Library::removeDirRecursive( $dir."/".$object );
                    else:
                        unlink( $dir."/".$object );
                    endif;
                endif;
            endforeach;
            reset( $objects );
            rmdir( $dir );
        endif;
    }
    /**
     * Create a random password
     * @return string
     */
    public static function random_password()
    {
        $alphabet    = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass        = array();
        $alphaLength = strlen( $alphabet ) - 1;

        for ($i = 0; $i < 8; $i++) {
            $n = rand( 0, $alphaLength );
            $pass[] = $alphabet[$n];
        }

        return( implode( $pass ) );
    }
    /** Check if an array is not empty
     * @param $params
     * @return bool
     */
    public static function noempty( $params )
    {
        foreach( $params as $arg )
            if(!empty($arg))
                continue;
            else
                return false;
        return true;
    }
    /** Returns selected */
    public static function selectedIf( $expression ){return $expression ? 'selected' : '';}
    /** Checks if a date isn't empty */
    public static function ifNotEmptyDate( $date ){return $date !== '0000-00-00' ? $date : '';}
    /** Checks if a string has special chars */
    public static function hashSpecialChars( $string ){return( preg_match( '/[\'^£$%&*()}{@~?><>,|=_]/', trim( $string ) ) ? true : false );}
    /** Checks if the given email is valid */
    public static function isValidEmail( $email ){return( filter_var( trim( $email ), FILTER_VALIDATE_EMAIL ) );}
    /** Checks if the string has numbers */
    public static function stringHasNumbers( $string ){return( preg_match('#[0-9]#',trim( $string ) ) ? true : false );}
    /** Checks if the string contains digits only */
    public static function containsOnlyDigits( $string )
    {
        $string = str_replace( " ", "", $string );
        return( ctype_digit( $string ) );
    }
    /** Create a random color hex code */
    public static function random_color_hex() {return sprintf('#%06X', mt_rand(0, 0xFFFFFF));}

}