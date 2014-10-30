<?php
$config = __DIR__ . '/config.php';
$autoload = __DIR__ . '/vendor/autoload.php';

// Check if config file is present. If not throw an error.
if (! stream_resolve_include_path($config)) {
    throw new Exception('Config file ' . $config . ' not found! Create it from config.sample.php.');
}

// Check if depenedencies are installed. If not throw an error.
if (! stream_resolve_include_path($autoload)) {
    throw new Exception('Composer generated file ' . $autoload . ' not found! Execute <code>composer install</code>.');
}

require_once $autoload;
require_once $config;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ShoppingList\Router;

date_default_timezone_set('Europe/Zurich');

// init
$app = new Silex\Application();

$app['debug'] = $config['debug'];
$app['http_cache'] = $config['http_cache'];
$app['config'] = $config;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $config['database']
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/web/templates'
));
$app['twig']->addExtension(new Twig_Extensions_Extension_I18n());