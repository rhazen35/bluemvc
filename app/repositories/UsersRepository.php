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

    /**
     * @return mixed
     */
    public function get_all_users()
    {
        return( $this->model->get_all_users() );
    }

    public function get_all_users_paginated( $limit, $page )
    {
        return( $this->model->get_all_users_paginated( $limit, $page ) );
    }

    public function get_user_from_id( $user_id ){
        return( $this->base_model->get( 'users', ['id' => $user_id], false, false) );
    }

    /**
     * Add a new user.
     * Pass all posted values to the validation function as an array, specifying the type and if it's required.
     * @param $data
     */
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
            array('subject' => 'full_name|required'                     , 'value' => $full_name),
            array('subject' => 'email|required|match-not-allowed'       , 'value' => $email),
            array('subject' => 'group|required'                         , 'value' => $group),
            array('subject' => 'role|required'                          , 'value' => $role),
            array('subject' => 'password|required'                      , 'value' => $password),
            array('subject' => 'password_repeat|required'               , 'value' => $password_repeat)
        );
        /** Validate the user input */
        $full_name = ucfirst($full_name);
        $validation = $this->validate( $array );
        /** Check if the name already exists */
        $exists = empty( $this->get_user_from_name( $full_name ) ) ? false : true;
        if ( $exists ) {
            if( $validation === true ){
                $validation = array();
            }
            $validation['full_name'] = "is in use.";
        }
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
            echo json_encode( true );
        } else {
            /** Respond with json object */
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode( $validation ) ;
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

    /**
     * Edit a user
     */
    public function edit_user( $data )
    {
        $user_id          = !empty( $data['user_id'] ) ? $data['user_id'] : "";
        $full_name        = !empty( $data['full_name'] ) ? $data['full_name'] : "";
        $email            = !empty( $data['email'] ) ? $data['email'] : "";
        $groups           = !empty( $data['groups'] ) ? $data['groups'] : "";
        $roles            = !empty( $data['roles'] ) ? $data['roles'] : "";

        /** Groups and roles arrays for edit and delete */
        $user_groups      = $this->get_user_groups_from_user_id( $user_id );
        $user_roles       = $this->get_user_roles_from_user_id( $user_id );
        $roles_in_use     = array();
        $groups_in_use    = array();
        $roles_to_delete  = array();
        $roles_to_add     = array();
        $groups_to_delete = array();
        $groups_to_add    = array();
        /** Roles in use and groups in use arrays */
        foreach( $user_roles as $user_role ){
            $roles_in_use[] = $user_role->role_id;
        }
        foreach( $user_groups as $user_group ){
            $groups_in_use[] = $user_group->group_id;
        }
        /** Setup the validate array */
        $array = array(
            'user_id'       => $user_id,
            array('subject' => 'full_name|required'         , 'value' => $full_name),
            array('subject' => 'email|required|match-allowed'             , 'value' => $email),
            array('subject' => 'groups|required'                          , 'value' => $groups),
            array('subject' => 'roles|required'                           , 'value' => $roles),
        );
        /** Validate the user input */
        $validation = $this->validate( $array );
        /** Check if the name already exists */
        $users = $this->get_user_from_id( $user_id );
        foreach( $users as $user ){
            $user_name = $user->name;
        }
        if( $full_name !== $user_name ) {
        $exists = empty( $this->get_user_from_name( $full_name ) ) ? false : true;
            if ( $exists ) {
                if( $validation === true ){
                    $validation = array();
                }
                $validation['full_name'] = "is in use.";
            }
        }
        /** Check if total validation has succeeded */
        if( $validation === true ) {
            /** Update the user */
            $params = array(
                'name'  => ucfirst($full_name),
                'email' => $email,
            );
            $this->base_model->edit('users', ['id' => $user_id], $params);
            /**
             * Update user roles
             * Create an array for roles to add and roles to delete
             */
            foreach( $roles as $role ){
                if( !in_array( $role, $roles_in_use ) ){
                    $roles_to_add[] = $role; /** Add */
                }
            }
            foreach( $roles_in_use as $roles_in_us ){
                if( !in_array( $roles_in_us, $roles ) ){
                    $roles_to_delete[] = $roles_in_us; /** Delete */
                }
            }
            /** Delete the roles */
            if( !empty( $roles_to_delete ) ){
                foreach( $roles_to_delete as $role_to_delete ){
                    $this->base_model->remove( 'role_user', ['user_id' => $user_id, 'role_id' => $role_to_delete] );
                }
            }
            /** Add the roles */
            if( !empty( $roles_to_add ) ){
                foreach( $roles_to_add as $role_to_add ){
                    $this->base_model->insert( 'role_user', ['user_id' => $user_id, 'role_id' => $role_to_add] );
                }
            }
            /**
             * Update user groups
             * Create an array for groups to add and groups to delete
             */
            foreach( $groups as $group ){
                if( !in_array( $group, $groups_in_use ) ){
                    $groups_to_add[] = $group; /** Add */
                }
            }
            foreach( $groups_in_use as $groups_in_us ){
                if( !in_array( $groups_in_us, $groups ) ){
                    $groups_to_delete[] = $groups_in_us; /** Delete */
                }
            }
            /** Delete groups */
            if( !empty( $groups_to_delete ) ){
                foreach( $groups_to_delete as $group_to_delete ){
                    $this->base_model->remove( 'group_user', ['user_id' => $user_id, 'group_id' => $group_to_delete] );
                }
            }
            /** Add groups */
            if( !empty( $groups_to_add ) ){
                foreach( $groups_to_add as $group_to_add ){
                    $this->base_model->insert( 'group_user', ['user_id' => $user_id, 'group_id' => $group_to_add] );
                }
            }
            /** Trigger event */
            echo json_encode( true );
        } else {
            /** Respond with json object */
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode( $validation ) ;
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
}