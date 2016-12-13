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
    public function rules( $array )
    {
        $result = array();
        $user_id = !empty( $array['user_id'] ) ? $array['user_id'] : "";
        unset( $array['user_id'] );

        foreach( $array as $item => $value ) {
            /**
             * Trim the param and explode the subject
             * @var  $param
             */
            if ( is_array( $value['value'] ) ){
                $param = array();
                foreach( $value['value'] as $val ) {
                    $param[] = trim( $val );
                }
            } else {
                $param = trim($value['value']);
            }
            $parts = explode( '|', $value['subject'] );
            /**
             * Check if the param is required
             * @var  $required
             */
            $required = $parts[1] === "required" ? true : false;
            $match_allowed = !empty( $parts[2] ) && $parts[2] === "match-allowed" ? true : false;
            if ( empty( $param ) && $required && $parts[0] !== "password_repeat" ) {
                if( $parts[0] === "groups" || $parts[0] === "roles" ){
                    $result[$parts[0] . "[]"] = "is empty but required";
                } else {
                    $result[$parts[0]] = "is empty but required";
                }
            }
            /**
             * Full name validation
             */
            if( $parts[0] === "full_name" ) {
                if( !empty( $param ) ){
                    $users = $this->get_user_from_id( $user_id );
                    foreach( $users as $user ){
                        $user_name = $user->name;
                    }
                    $valid = Lib::hashSpecialChars( $param ) ? false : true;
                    if ( false === $valid ) {
                        $result[$parts[0]] = "has special characters";
                    } elseif( false === $match_allowed || $param !== $user_name ) {
                        $exists = empty( $this->get_user_from_name( $param ) ) ? false : true;
                        if ( $exists ) {
                            $result[$parts[0]] = "is in use.";
                        }
                    }
                }
            }
            /**
             * Email validation
             */
            if( $parts[0] === "email" ) {
                if( !empty( $param ) ){
                    $users = $this->get_user_from_id( $user_id );
                    foreach( $users as $user ){
                        $user_email = $user->email;
                    }
                    $valid    = filter_var( $param, FILTER_VALIDATE_EMAIL );
                    if( false === $valid ){
                        $result[$parts[0]] = "is not a valid email address";
                    } elseif( false === $match_allowed || $param !== $user_email ) {
                        $exists = empty( $this->get_email_by_email( $param ) ) ? false : true;
                        if ( $exists ) {
                            $result[$parts[0]] = "is in use.";
                        }
                    }
                }
            }
            /**
             * Group validation - single
             */
            if( $parts[0] === "group" ){
                if( !empty( $param ) ) {
                    $valid = Lib::hashSpecialChars( $param ) ? false : true;
                    if ( false === $valid ) {
                        $result[$parts[0]] = "has special characters.";
                    }
                }
            }
            /**
             * Group validation - multiple
             */
            if( $parts[0] === "groups" ){
                if( !empty( $param ) ) {
                    foreach( $param as $group ) {
                        $valid = Lib::hashSpecialChars( $group ) ? false : true;
                        if ( false === $valid ) {
                            $result[$parts[0] . '[]'] = "has special characters.";
                        }
                    }
                }
            }
            /**
             * Role validation - single
             */
            if( $parts[0] === "role" ){
                if( !empty( $param ) ) {
                    $valid = Lib::hashSpecialChars( $param ) ? false : true;
                    if ( false === $valid ) {
                        $result[$parts[0]] = "Role has special characters.";
                    }
                }
            }
            /**
             * Role validation - multiple
             */
            if( $parts[0] === "roles" ){
                if( !empty( $param ) ) {
                    foreach( $param as $role ) {
                        $valid = Lib::hashSpecialChars( $role ) ? false : true;
                        if ( false === $valid ) {
                            $result[$parts[0] . '[]'] = "has special characters.";
                        }
                    }
                }
            }
            /**
             * Password validation
             * @param $password -> Store for password match
             */
            if( $parts[0] === "password" ){
                if( !empty( $param ) ) {
                    $password = $param;
                    $valid = strlen($param) >= 6 ? true : false;
                    if ( false === $valid ) {
                        $result[$parts[0]] = "must contain at least 6 characters.";
                    }
                }
            }
            /**
             * Password repeat validation
             */
            if( $parts[0] === "password_repeat" ){
                if( !empty( $password ) && $password !== $param ){
                    $result[$parts[0]] = "is not a match.";
                }
                if( !empty( $password ) && empty( $param ) ){
                    $result[$parts[0]] = "is empty but required.";
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