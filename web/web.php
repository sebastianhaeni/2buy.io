<?php
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

require_once __DIR__ . '/../bootstrap.php';

$app->get('/', function () use($app)
{
    $subRequest = Request::create('/home', 'GET');
    return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
});

$app->get('/{page}', function (Application $app, $page) use($app)
{
    $templateName = 'notfound';
    switch ($page) {
        case 'home':
            $templateName = 'home';
            break;
        case 'developers':
            $templateName = 'developers';
            break;
        case 'getstarted':
            $templateName = 'getstarted';
            break;
        case 'app':
            $templateName = 'app';
            break;
    }
    $template = $app['twig']->loadTemplate($templateName . '.html');
    return $template->render(array(
        'config' => $app['config'],
        'page' => $templateName
    ));
});

$app->run();