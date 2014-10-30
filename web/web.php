<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../bootstrap.php';

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

$supportedLangs = [
    'de',
    'en'
];

$request = Request::createFromGlobals();

$lang = $request->cookies->getAlpha('lang');
if (empty($lang) || ! in_array($lang, $supportedLangs)) {
    $lang = $request->getPreferredLanguage($supportedLangs);
}

// Set language
putenv('LC_ALL=' . $lang . '.UTF-8');
setlocale(LC_ALL, $lang . '.UTF-8');

// Specify the location of the translation tables
bindtextdomain('SebaList', __DIR__ . '/locale');
bind_textdomain_codeset('SebaList', 'UTF-8');

// Choose domain
textdomain('SebaList');

// Testing i18n, does not work as of 30.10.14
// echo _("Coming soon");
// die();

// load template
$template = $app['twig']->loadTemplate($templateName . '.html');

// render and send template
(new Response($template->render(array(
    'config' => $app['config'],
    'page' => $templateName
))))->send();
