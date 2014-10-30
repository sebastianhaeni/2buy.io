<?php
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../bootstrap.php';
require_ONCE __DIR__ . '/locale/locale.php';

// load route definitions
$routes = json_decode(file_get_contents(__DIR__ . '/routes.json'), true);

// default template
$templateName = 'notfound';

// requested template
$route = $_SERVER['REQUEST_URI'];

// check if the route and template exist
if (array_key_exists($route, $routes) && file_exists(__DIR__ . '/templates/' . $routes[$route] . '.html')) {
    $templateName = $routes[$route];
}

// load template
$template = $app['twig']->loadTemplate($templateName . '.html');

// render and send template
(new Response($template->render(array(
    'config' => $app['config'],
    'page' => $templateName,
    'selectedLang' => $config['i18n']['selectedLang']
))))->send();
