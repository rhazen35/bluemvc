<?php

namespace app\model;

interface IBaseModel
{
    /**
     * @param $table
     * @param $params
     * @return mixed
     */
    public function insert( $table, $params );

    /**
     * @param $table
     * @param $where
     * @param $groups
     * @param $orders
     * @return mixed
     */
    public function get( $table, $where, $groups, $orders );

    /**
     * @param $table
     * @param $where
     * @param $params
     * @return mixed
     */
    public function edit( $table, $where, $params );

    /**
     * @param $table
     * @param $where
     * @return mixed
     */
    public function remove( $table, $where );
}