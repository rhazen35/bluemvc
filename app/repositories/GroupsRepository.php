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

    public function add_group( $data )
    {
        $group_name = !empty( $_POST['full_name'] ) ? $_POST['full_name'] : "";
        /** Setup the validate array */
        $array = array(
            array('subject' => 'full_name|required|match-not-allowed'   , 'value' => $group_name)
        );
        /** Validate the user input */
        $validation = $this->validate( $array );
        /** Check if total validation has succeeded */
        if( $validation === true ) {
            $params = array(
                'id'   => '',
                'name' => $group_name
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
            /** Check if total validation has succeeded */
            if ($validation === true) {
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