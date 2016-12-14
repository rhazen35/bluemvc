<?php

namespace app\repositories;

use app\core\RepositoryController;
use app\traits\ValidateFormInput;

class RolesRepository extends RepositoryController
{
    use ValidateFormInput;
    protected $base_model;
    protected $model;

    public function __construct()
    {
        $this->base_model = $this->model('BaseModel');
        $this->model      = $this->model('Role');
    }

    public function get_all_roles()
    {
        return( $this->model->get_all_roles() );
    }

    public function get_all_roles_paginated( $limit, $page )
    {
        return( $this->model->get_all_roles_paginated( $limit, $page ) );
    }

    public function add_role( $data )
    {
        $full_name = !empty( $data['full_name'] ) ? $data['full_name'] : "";
        /** Setup the validate array */
        $array = array(
            array('subject' => 'full_name|required|match-not-allowed'   , 'value' => $full_name)
        );
        /** Validate the user input */
        $validation = $this->validate( $array );
        /** Check if the name already exists */
        $exists = empty( $this->get_role_from_name( $full_name ) ) ? false : true;
        if ( $exists ) {
            if( $validation === true ){
                $validation = array();
            }
            $validation['full_name'] = "is in use.";
        }
        /** Check if total validation has succeeded */
        if( $validation === true ) {
            $params = array(
                'id'   => '',
                'name' => $full_name
            );
            $this->base_model->insert('roles', $params);
            /** Trigger event */
            echo json_encode( true );
        } else {
            /** Respond with json object */
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode( $validation );
                exit;
                /** Respond with html message */
            } else {
                echo 'Form validation failed.';
                foreach( $validation as $validated ){
                    echo $validated;
                }
            }
        }
    }

    public function edit_role( $data )
    {
        $role_id   = !empty( $data['role_id'] ) ? $data['role_id'] : "";
        $full_name = !empty( $data['full_name'] ) ? $data['full_name'] : "";
        if( !empty( $role_id ) ) {
            /** Setup the validate array */
            $array = array(
                array('subject' => 'full_name|required|match-not-allowed', 'value' => $full_name)
            );
            /** Validate the user input */
            $validation = $this->validate($array);
            /** Check if the name already exists */
            $roles = $this->get_role_from_id( $role_id );
            foreach( $roles as $role ){
                $role_name = $role->name;
            }
            if( $full_name !== $role_name ) {
                $exists = empty($this->get_role_from_name($full_name)) ? false : true;
                if ($exists) {
                    if ($validation === true) {
                        $validation = array();
                    }
                    $validation['full_name'] = "is in use.";
                }
            }
            /** Check if total validation has succeeded */
            if ($validation === true) {
                $this->base_model->edit('roles', ['id' => $role_id], ['name' => $full_name]);
                /** Trigger event */
                echo json_encode(true);
            } else {
                /** Respond with json object */
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    echo json_encode($validation);
                    exit;
                    /** Respond with html message */
                } else {
                    echo 'Form validation failed.';
                    foreach ($validation as $validated) {
                        echo $validated;
                    }
                }
            }
        }
    }

}