<?php
global $config;
$config = array();

$config['debug']      = true;
$config['http_cache'] = false;
$config['site_url']   = 'http://localhost/';

$config['database']   = array(
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'dbname'   => 'shoppinglist',
    'user'     => 'root',
    'password' => '',
    'charset'  => 'utf8'
);

$config['email'] = array(
    'server'	 => 'localhost',
    'port' 		 => 465,
    'security'   => 'ssl',
    'username'   => 'TODO',
    'password'   => 'TODO'
);
