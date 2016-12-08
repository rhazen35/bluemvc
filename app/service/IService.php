<?php

namespace app\service;

interface IService
{
    public function create( $table, $params );
    public function read( $table, $where, $groups, $orders );
    public function update( $table, $where, $params );
    public function delete( $table, $params );
}