<?php

namespace app\core;

class Configuration
{
    /** Inititalize setup */
    public static function initSet()
    {
        /** Turn on error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        /** X-DEBUG */
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', 256);
        ini_set('xdebug.var_display_max_data', 1024);

        /** Set internal encoding */
        mb_internal_encoding('UTF-8');

        /** Set local */
        setlocale(LC_ALL, array('Dutch_Netherlands', 'Dutch', 'nl_NL', 'nl', 'nl_NL.ISO8859-1', 'nld_NLD'));
    }

}