<?php

namespace app\service;

interface IService
{
    public function create( $params );
    public function read( $joins, $params, $groups, $orders );
    public function update( $where, $params );
    public function delete( $params );
}