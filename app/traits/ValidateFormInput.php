<?php

namespace app\traits;

use app\core\Library as Lib;

trait ValidateFormInput
{
    use UsersTrait;
    public function validate( $array )
    {
        return( $this->rules( $array ) );
    }

    public function rules( $array )
    {
        $result                     = array();

        foreach( $array as $item => $value ){
            $param = trim( $value['value'] );
            $parts = explode( '|', $value['subject'] );

            /** Full name validation */
            if( $parts[0] === "full_name" ) {

                $valid = Lib::hashSpecialChars( $param ) ? false : true;
                $required = $parts[1] === "required" ? true : false;
                if( !empty( $param ) ){
                    $exists = empty( $this->get_user_from_name( $param ) ) ? false : true;
                    if( $exists ){
                        $result[$parts[0]] = "Name is in use.";
                    }
                }
                if ( false === $valid ) {
                    $result[$parts[0]] = "Invalid name";
                }
                if ( empty( $param ) && $required ) {
                    $result[$parts[0]] = "Name is empty but required";
                }
            }
            /** Email validation */
            if( $parts[0] === "email" ) {
                $valid    = filter_var( $param, FILTER_VALIDATE_EMAIL );
                $required = $parts[1] === "required" ? true : false;
                if( false === $valid ){
                    $result[$parts[0]] = "Invalid email address";
                }
                if( empty( $param ) && $required ){
                    $result[$parts[0]] = "Email is empty but required";
                }
            }
            /** Group validation - single */
            if( $parts[0] === "group" ){
                $valid    = Lib::hashSpecialChars( $param ) ? false : true;
                $required = $parts[1] === "required" ? true : false;
                if( false === $valid ){
                    $result[$parts[0]] = "Invalid group.";
                }
                if( empty( $param ) && $required ){
                    $result[$parts[0]] = "Group is empty but required.";
                }
            }
            /** Role validation - single */
            if( $parts[0] === "role" ){
                $valid    = Lib::hashSpecialChars( $param ) ? false : true;
                $required = $parts[1] === "required" ? true : false;
                if( false === $valid ){
                    $result[$parts[0]] = "Invalid role.";
                }
                if( empty( $param ) && $required ){
                    $result[$parts[0]] = "Role is empty but required.";
                }
            }
            /** Password validation*/
            if( $parts[0] === "password" ){
                $password = $param;
                $valid    = strlen( $param ) >= 6 ? true : false;
                $required = $parts[1] === "required" ? true : false;
                if( false === $valid ){
                    $result[$parts[0]] = "Password must contain at least 6 characters.";
                }
                if( empty( $param ) && $required ){
                    $result[$parts[0]] = "Password is empty but required.";
                }
            }
            /** Password repeat validation*/
            if( $parts[0] === "password_repeat" ){
                if( !empty( $password ) && $password !== $param ){
                    $result[$parts[0]] = "Passwords don't match.";
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