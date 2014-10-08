<?php
use ShoppingList\Router;
use ShoppingList\Authentication;
use Silex\Provider\SessionServiceProvider;

require_once __DIR__ . '/../bootstrap.php';

$app->register(new SessionServiceProvider());
$app['auth'] = new Authentication();

$router = new Router();
$router->constructRoutes($app);

$app->run();