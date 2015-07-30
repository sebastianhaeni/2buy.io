<?php
$config = __DIR__ . '/../config/api.yml';
$autoload = __DIR__ . '/../vendor/autoload.php';

// Check if config file is present. If not throw an error.
if (! stream_resolve_include_path($config)) {
    throw new Exception('Config file ' . $config . ' not found! Create it from config/sample/api.yml.');
}

// Check if depenedencies are installed. If not throw an error.
if (! stream_resolve_include_path($autoload)) {
    throw new Exception('Composer generated file ' . $autoload . ' not found! Execute <code>composer install</code>.');
}

require_once $autoload;

use Symfony\Component\Yaml\Parser;
$yaml = new Parser();
$config = $yaml->parse(file_get_contents($config))['api'];

// Providing password_hash() and password_verify() in PHP <= 5.4
require_once __DIR__ . '/../vendor/Antnee/phpPasswordHashingLib/passwordLib.php';

date_default_timezone_set('Europe/Zurich');

// Allowing js apps from a different domain to access the api
header('Access-Control-Allow-Origin: *');

// init
$app = new Silex\Application();

$app['debug'] = $config['debug'];
$app['http_cache'] = $config['httpCache'];
$app['config'] = $config;

$app->register(new Propel\Silex\PropelServiceProvider(), [
    'propel.config-file' => __DIR__ . '/../generated-conf/config.php'
]);
