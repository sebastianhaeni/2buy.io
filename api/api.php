<?php
use Silex\Provider\SessionServiceProvider;
use ShoppingList\Service\Authentication;
use ShoppingList\Service\Router;
use ShoppingList\Service\Mailer;

require_once __DIR__ . '/../bootstrap.php';

$app->register(new SessionServiceProvider());
$app->register(new Authentication());
$app->register(new Silex\Provider\SwiftmailerServiceProvider(), [
    'swiftmailer.options' => $app['config']['email']
]);

$router = new Router();
$router->constructRoutes($app);

$app->run();