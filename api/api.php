<?php
use Silex\Provider\SessionServiceProvider;
use ShoppingList\Service\Authentication;
use ShoppingList\Service\Router;
use ShoppingList\Service\Mailer;

require_once __DIR__ . '/../bootstrap.php';

$app->register(new SessionServiceProvider());
$app->register(new Authentication());

$transport = Swift_SmtpTransport::newInstance($app['config']['email']['server'], $app['config']['email']['port'], $app['config']['email']['security'])->setUsername($app['config']['email']['username'])->setPassword($app['config']['email']['password']);
$app['mailer'] = Swift_Mailer::newInstance($transport);

$router = new Router();
$router->constructRoutes($app);

$app->run();