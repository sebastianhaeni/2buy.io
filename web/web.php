<?php
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

require_once __DIR__ . '/../bootstrap.php';

// valid pages
$app ['validPages'] = [ 
    'home',
    'developers',
    'getstarted',
    'app',
    'signup',
    'signin',
    'communities'
];

$app->get('/', function () use($app)
{
    $subRequest = Request::create('/home', 'GET');
    return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
});

$app->get('/{page}', function (Application $app, $page) use($app)
{
    $templateName = in_array($page, $app ['validPages']) ? $page : 'notfound';
    $template = $app ['twig']->loadTemplate($templateName . '.html');
    return $template->render(array (
        'config' => $app ['config'],
        'page' => $templateName 
    ));
});

$app->run();