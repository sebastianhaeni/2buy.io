<?php
use Silex\Provider\SessionServiceProvider;
use ShoppingList\Service\Authentication;
use ShoppingList\Service\Router;

require_once __DIR__ . '/../bootstrap.php';

$app->register(new SessionServiceProvider());
$app->register(new Authentication());

$router = new Router();
$router->constructRoutes($app);

$app->run();