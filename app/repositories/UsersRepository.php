<?php

namespace app\repositories;

use app\core\RepositoryController;
use app\traits\ValidateFormInput;
use app\core\Events;

class UsersRepository extends RepositoryController
{
    use ValidateFormInput;
    protected $base_model;
    protected $model;

    public function __construct()
    {
        $this->base_model = $this->model('BaseModel');
        $this->model      = $this->model('User');
    }

    public function get_all_users()
    {
        return( $this->model->get_all_users() );
    }

    public function add_user( $data )
    {
        $full_name       = !empty( $data['full_name'] ) ? $data['full_name'] : "";
        $email           = !empty( $data['email'] ) ? $data['email'] : "";
        $group           = !empty( $data['group'] ) ? $data['group'] : "";
        $role            = !empty( $data['role'] ) ? $data['role'] : "";
        $password        = !empty( $data['password'] ) ? $data['password'] : "";
        $password_repeat = !empty( $data['password_repeat'] ) ? $data['password_repeat'] : "";
        /** Setup the validate array */
        $array = array(
            array('subject' => 'full_name|required'         , 'value' => $full_name),
            array('subject' => 'email|required'             , 'value' => $email),
            array('subject' => 'group|required'             , 'value' => $group),
            array('subject' => 'role|required'              , 'value' => $role),
            array('subject' => 'password|required'          , 'value' => $password),
            array('subject' => 'password_repeat|required'   , 'value' => $password_repeat)
        );
        /** Validate the user input */
        $validation = $this->validate( $array );
        /** Check if total validation has succeeded */
        if( $validation === true ) {
            /** Create a new user */
            $params = array(
                'id' => '',
                'name' => $full_name,
                'email' => $email,
                'hash' => $password
            );
            $user_id = $this->base_model->insert('users', $params);
            /** Create a new user role */
            $params_role = array(
                'user_id' => $user_id,
                'role_id' => $role
            );
            $this->base_model->insert('role_user', $params_role);
            /** Create a new user group */
            $params_group = array(
                'user_id' => $user_id,
                'group_id' => $group
            );
            $this->base_model->insert('group_user', $params_group);
            /** Trigger event */
            (new Events())->trigger(21, true);
            echo json_encode( true );
        } else {
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode( $validation ) ;
                exit;
            }
        }
    }
}