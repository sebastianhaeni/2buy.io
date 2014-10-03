<?php
use ShoppingList\Router;

require_once __DIR__ . '/../bootstrap.php';

$router = new Router();
$router->constructRoutes($app);

$app->run();