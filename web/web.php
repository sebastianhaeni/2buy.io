<?php
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

require_once __DIR__ . '/../bootstrap.php';

// valid pages
$app['validPages'] = [
    'public' => [
        'home',
        'developers',
        'getstarted',
        'signup',
        'signin',
        'terms',
        'privacy',
        'contact'
    ],
    'app' => [
        'shoppinglist',
        'communities'
    ],
    'shoppinglist' => [
        'history',
        'products',
        'statistics'
    ]
];

$app->get('/', function () use($app)
{
    $subRequest = Request::create('/home', 'GET');
    return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
});

$app->get('/{page}', function (Application $app, $page) use($app)
{
    $templateName = 'notfound';
    
    if ($page == 'app') {
        $templateName = 'app/communities/main';
    } elseif (in_array($page, $app['validPages']['public'])) {
        $templateName = 'public/' . $page;
    }
    
    $template = $app['twig']->loadTemplate($templateName . '.html');
    return $template->render(array(
        'config' => $app['config'],
        'page' => $templateName
    ));
});

$app->get('/app/{page}', function (Application $app, $page) use($app)
{
    $templateName = 'notfound.html';
    
    if (in_array($page, $app['validPages']['app'])) {
        $templateName = 'app/' . $page . '/main.html';
    }
    
    $template = $app['twig']->loadTemplate($templateName);
    return $template->render(array(
        'config' => $app['config'],
        'page' => $templateName
    ));
});

$app->get('/app/shoppinglist/{page}', function (Application $app, $page) use($app)
{
    $templateName = 'notfound.html';
    
    if (in_array($page, $app['validPages']['shoppinglist'])) {
        $templateName = 'app/shoppinglist/' . $page . '.html';
    }
    
    $template = $app['twig']->loadTemplate($templateName);
    return $template->render(array(
        'config' => $app['config'],
        'page' => $templateName
    ));
});

$app->run();
