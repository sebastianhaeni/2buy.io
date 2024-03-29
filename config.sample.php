<?php
global $config;
$config = array();

$config['product_name'] = '2buy.io';
$config['debug']        = true;
$config['http_cache']   = false;
$config['site_url']     = 'http://localhost/';

$config['database'] = [
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'dbname'   => '2buy',
    'user'     => 'root',
    'password' => '',
    'charset'  => 'utf8'
];

$config['email'] = [
    'server'   => 'localhost',
    'port'     => 465,
    'security' => 'ssl',
    'username' => '',
    'password' => ''
];

$config['i18n'] = [
    'languages' => [
        'en_US',
        'de_CH'
    ]
];
