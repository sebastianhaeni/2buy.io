<?php
global $config;
$config = array();

$config['product_name'] = 'SebaList';
$config['debug']        = true;
$config['http_cache']   = false;
$config['site_url']     = 'http://localhost/';

$config['database'] = [
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'dbname'   => 'shoppinglist',
    'user'     => 'root',
    'password' => '',
    'charset'  => 'utf8'
];

$config['email'] = [
    'server'	 => 'localhost',
    'port' 		 => 465,
    'security'   => 'ssl',
    'username'   => 'TODO',
    'password'   => 'TODO'
];

$config['i18n'] = [
    'languages' => [
        'de',
        'en'
    ]
];
