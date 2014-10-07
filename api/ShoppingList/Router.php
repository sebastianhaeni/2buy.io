<?php
namespace ShoppingList;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class Router
{

    /**
     * Set up routes of the API.
     *
     * @param \Silex\Application $app            
     */
    public function constructRoutes(\Silex\Application $app)
    {
        $app->get('/', 'ShoppingList\\Router::redirectToDev');
        
        // Home
        $app->get('/v1/', 'ShoppingList\\Controller\\HomeController::info');
        
        // Product
        // TODO
        
        // Statistics
        // TODO
        
        // Transaction
        // TODO
        
        // User
        $app->post('/v1/register', 'ShoppingList\\Controller\\UserController::register');
    }

    /**
     * Redirect requests to the api without any params to the API documentation paeg.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToDev(Request $request, Application $app)
    {
        return $app->redirect($app['config']['site_url'] . 'developers');
    }
}