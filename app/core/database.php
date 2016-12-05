<?php
/** CORE */

/** Use Laravel's database manager Eloquent */
use Illuminate\Database\Capsule\Manager as Capsule;

/** @var $capsule */
$capsule = new Capsule();

/** Add a connection to the database */
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'username'  => 'ruben35',
    'password'  => 'Ruben1986Hazenbosch35',
    'database'  => 'hospitium',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => ''
]);

/** Set capsule as a global */
$capsule->setAsGlobal();

/** Boot Eloquent */
$capsule->bootEloquent();