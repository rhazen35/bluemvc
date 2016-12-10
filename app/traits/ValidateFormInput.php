<?php

namespace app\traits;

trait ValidateFormInput
{
    public function validate( $array )
    {
        return( $this->rules( $array ) );
    }

    public function rules( $array )
    {
        $result                     = array();
        $result['total_validation'] = true;

        foreach( $array as $item => $value ){

            /** Email validation */
            $parts = explode( '|', $value['subject'] );
            switch( $parts[0] ){
                case"email":
                    $empty_but_required = false;
                    $valid              = filter_var( trim( $value['value'] ), FILTER_VALIDATE_EMAIL );
                    $required           = $parts[1] === "required" ? true : false;

                    if( empty( $value['value'] ) && $required ){
                        $empty_but_required         = true;
                        $result['total_validation'] = false;
                    }

                    if( false === $valid ){
                        $result['total_validation'] = false;
                    }

                    $result[$parts[0]]['valid']              = $valid;
                    $result[$parts[0]]['empty_but_required'] = $empty_but_required;
                    break;
            }
        }

        return( $result );
    }
}