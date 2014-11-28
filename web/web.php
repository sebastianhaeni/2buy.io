<?php
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/locale/locale.php';

$routeDefinitions = __DIR__ . '/routes.json';
$templatePath = __DIR__ . '/templates/';
$templateExt = '.html';

// load route definitions
$routes = json_decode(file_get_contents($routeDefinitions), true);

// default template
$templateName = 'notfound';

// requested template
$route = $_SERVER['REQUEST_URI'];

// check if the route and template exist
if (array_key_exists($route, $routes) && file_exists($templatePath . $routes[$route] . $templateExt)) {
    $templateName = $routes[$route];
}

// load template
$template = $app['twig']->loadTemplate($templateName . $templateExt);

// render and send template
(new Response($template->render(array(
    'config' => $app['config'],
    'page' => $templateName,
    'selectedLang' => $app['selectedLang'],
    'htmlLang' => substr($app['selectedLang'], 0, strpos($app['selectedLang'], '_'))
))))->send();
