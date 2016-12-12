<?php

namespace app\traits;

/**
 * Validation trait that validated all form input.
 */

use app\core\Library as Lib;

trait ValidateFormInput
{
    use UsersTrait;

    /**
     * Validate passes the array to the rules to check if it matches any rule.
     * @param $array
     * @return array|bool
     */
    public function validate( $array )
    {
        return( $this->rules( $array ) );
    }

    /**
     * Rules check for valid input and input requirements.
     * @param $array
     * @return array|bool
     */
    public function rules($array )
    {
        $result = array();

        foreach( $array as $item => $value ){
            $param = trim( $value['value'] );
            $parts = explode( '|', $value['subject'] );

            /**
             * Full name validation
             */
            if( $parts[0] === "full_name" ) {
                $valid = Lib::hashSpecialChars( $param ) ? false : true;
                $required = $parts[1] === "required" ? true : false;
                if( !empty( $param ) ){
                    $exists = empty( $this->get_user_from_name( $param ) ) ? false : true;
                    if( $exists ){
                        $result[$parts[0]] = " is in use.";
                    }
                }
                if ( false === $valid ) {
                    $result[$parts[0]] = " has special characters";
                }
                if ( empty( $param ) && $required ) {
                    $result[$parts[0]] = " is empty but required";
                }
            }
            /**
             * Email validation
             */
            if( $parts[0] === "email" ) {
                $valid    = filter_var( $param, FILTER_VALIDATE_EMAIL );
                $required = $parts[1] === "required" ? true : false;
                if( !empty( $param ) ){
                    $exists = empty( $this->get_email_by_email( $param ) ) ? false : true;
                    if( $exists ){
                        $result[$parts[0]] = " is in use.";
                    }
                }
                if( false === $valid ){
                    $result[$parts[0]] = "is not a valid email address";
                }
                if( empty( $param ) && $required ){
                    $result[$parts[0]] = " is empty but required";
                }
            }
            /**
             * Group validation - single
             */
            if( $parts[0] === "group" ){
                $valid    = Lib::hashSpecialChars( $param ) ? false : true;
                $required = $parts[1] === "required" ? true : false;
                if( false === $valid ){
                    $result[$parts[0]] = " has special characters.";
                }
                if( empty( $param ) && $required ){
                    $result[$parts[0]] = " is empty but required.";
                }
            }
            /**
             * Role validation - single
             */
            if( $parts[0] === "role" ){
                $valid    = Lib::hashSpecialChars( $param ) ? false : true;
                $required = $parts[1] === "required" ? true : false;
                if( false === $valid ){
                    $result[$parts[0]] = " has special characters.";
                }
                if( empty( $param ) && $required ){
                    $result[$parts[0]] = " is empty but required.";
                }
            }
            /**
             * Password validation
             */
            if( $parts[0] === "password" ){
                $password = $param; // Set the pass for pass repeat
                $valid    = strlen( $param ) >= 6 ? true : false;
                $required = $parts[1] === "required" ? true : false;
                if( false === $valid ){
                    $result[$parts[0]] = " must contain at least 6 characters.";
                }
                if( empty( $param ) && $required ){
                    $result[$parts[0]] = " is empty but required.";
                }
            }
            /**
             * Password repeat validation
             */
            if( $parts[0] === "password_repeat" ){
                if( !empty( $password ) && $password !== $param ){
                    $result[$parts[0]] = " don't match.";
                }
                if( !empty( $password ) && empty( $param ) ){
                    $result[$parts[0]] = "Please re-type the password.";
                }
            }
        }

        /** Return true if no errors have been found - this let's ajax know where good. */
        if( empty( $result ) ){
            $result = true;
        }

        return( $result );
    }
}