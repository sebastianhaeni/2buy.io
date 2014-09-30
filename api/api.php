<?php
$config = __DIR__ . '/../config.php';
$autoload = __DIR__ . '/../vendor/autoload.php';

if (! stream_resolve_include_path($config)) {
    throw new Exception('Config file ' . $config . ' not found!');
}

if (! stream_resolve_include_path($autoload)) {
    throw new Exception('Composer generated file ' . $autoload . ' not found!');
}

require_once $autoload;
require_once $config;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

date_default_timezone_set('Europe/Zurich');

// init
$app = new Silex\Application();

$app['debug'] = $config['debug'];
$app['http_cache'] = $config['http_cache'];

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $config['database']
));

// home
$app->get('/v1/', function (Request $request) use($app)
{
    
    return $app->json(array(
        'date' => date('c'),
        'author' => 'Sebastian Haeni',
        'version' => '1.0'
    ));
});

$app->run();