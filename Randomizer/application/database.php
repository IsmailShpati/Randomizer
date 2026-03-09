<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    'driver' => 'pgsql',
    'host' =>  'localhost',
    'port' => '5432',
    'username' => 'postgres',
    'password' => '!Ismail1',
    'database' => 'cen-project',
    'charset' =>'utf8'
]);

$capsule->bootEloquent();