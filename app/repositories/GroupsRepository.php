<?php

namespace app\repositories;

use app\core\RepositoryController;
use app\traits\ValidateFormInput;

class GroupsRepository extends RepositoryController
{
    use ValidateFormInput;
    protected $base_model;
    protected $model;

    public function __construct()
    {
        $this->base_model = $this->model('BaseModel');
        $this->model      = $this->model('Group');
    }

    public function get_all_groups()
    {
        return( $this->model->get_all_groups() );
    }

    public function get_all_groups_paginated( $limit, $page )
    {
        return( $this->model->get_all_groups_paginated( $limit, $page ) );
    }

    public function add_group( $data )
    {
        $full_name = !empty( $data['full_name'] ) ? $data['full_name'] : "";
        /** Setup the validate array */
        $array = array(
            array('subject' => 'full_name|required|match-not-allowed'   , 'value' => $full_name)
        );
        /** Validate the user input */
        $validation = $this->validate( $array );
        /** Check if the name already exists */
        $exists = empty( $this->get_group_from_name( $full_name ) ) ? false : true;
        if ( $exists ) {
            if( $validation === true ){
                $validation = array();
            }
            $validation['full_name'] = "is in use.";
        }
        /** Check if total validation has succeeded */
        if( $validation === true ) {
            $full_name = ucfirst( $full_name );
            $params = array(
                'id'   => '',
                'name' => $full_name
            );
            $this->base_model->insert('groups', $params);
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

    public function edit_group( $data )
    {
        $group_id  = !empty( $data['group_id'] ) ? $data['group_id'] : "";
        $full_name = !empty( $data['full_name'] ) ? $data['full_name'] : "";
        if( !empty( $group_id ) ) {
            /** Setup the validate array */
            $array = array(
                array('subject' => 'full_name|required|match-not-allowed', 'value' => $full_name)
            );
            /** Validate the user input */
            $validation = $this->validate($array);
            /** Check if the name already exists */
            $groups = $this->get_group_from_id( $group_id );
            foreach( $groups as $group ){
                $group_name = $group->name;
            }
            if( $full_name !== $group_name ) {
                $exists = empty($this->get_group_from_name($full_name)) ? false : true;
                if ($exists) {
                    if ($validation === true) {
                        $validation = array();
                    }
                    $validation['full_name'] = "is in use.";
                }
            }
            /** Check if total validation has succeeded */
            if ($validation === true) {
                $full_name = ucfirst( $full_name );
                $this->base_model->edit('groups', ['id' => $group_id], ['name' => $full_name]);
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