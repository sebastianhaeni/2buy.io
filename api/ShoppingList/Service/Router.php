<?php
namespace ShoppingList\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;

/**
 * Builds all the routes of the API.
 * Different URLs are delegated to the respective controller.
 * There are protected routes that can only be accessed when logged in.
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
    public function constructRoutes(Application $app)
    {
        $this->constructPublicRoutes($app);
        
        if ($app['auth']->isLoggedIn()) {
            $this->constructAppRoutes($app);
        }
    }

    /**
     * Builds the routes that can be accesses all the time without being logged in.
     *
     * @param Application $app            
     */
    private function constructPublicRoutes(Application $app)
    {
        // API documentation
        $app->get('/', 'ShoppingList\\Router::redirectToDev');
        
        // Home
        $app->get('/v1/', 'ShoppingList\\Controller\\HomeController::info');
        
        // User
        $app->post('/v1/user/register', 'ShoppingList\\Controller\\UserController::register');
        $app->post('/v1/user/login', 'ShoppingList\\Controller\\UserController::login');
        $app->get('/v1/user/isLoggedIn', 'ShoppingList\\Controller\\UserController::isLoggedIn');
    }

    /**
     * Builds the routes that are only accessible inside the app (when logged in).
     *
     * @param Application $app            
     */
    private function constructAppRoutes(Application $app)
    {
        // Community
        $app->post('/v1/community', 'ShoppingList\\Controller\\CommunityController::create');
        $app->put('/v1/community/{id}', 'ShoppingList\\Controller\\CommunityController::update');
        $app->post('/v1/community/{id}/invite', 'ShoppingList\\Controller\\CommunityController::inviteUser');
        $app->delete('/v1/community/{id}', 'ShoppingList\\Controller\\CommunityController::delete');
        $app->get('/v1/community', 'ShoppingList\\Controller\\CommunityController::getAll');
        $app->get('/v1/community/{id}', 'ShoppingList\\Controller\\CommunityController::getById');
        $app->get('/v1/community/{id}/member', 'ShoppingList\\Controller\\CommunityController::getMembers');
        $app->get('/v1/community/{id}/invite', 'ShoppingList\\Controller\\CommunityController::getInvites');
        $app->put('/v1/community/{idCommunity}/member/{id}', 'ShoppingList\\Controller\\CommunityController::updateMember');
        $app->delete('/v1/community/{idCommunity}/member/{id}', 'ShoppingList\\Controller\\CommunityController::deleteMember');
        $app->delete('/v1/community/{idCommunity}/invite/{id}', 'ShoppingList\\Controller\\CommunityController::deleteInvite');
        
        // Product
        $app->get('/v1/community/{id}/product', 'ShoppingList\\Controller\\ProductController::getProducts');
        
        // Statistics
        // TODO
        
        // Transaction
        $app->get('/v1/community/{id}/transaction/', 'ShoppingList\\Controller\\TransactionController::getTransactions');
        
        // User
        $app->get('/v1/user/logout', 'ShoppingList\\Controller\\UserController::logout');
        $app->put('/v1/user/password', 'ShoppingList\\Controller\\UserController::changePassword');
        $app->put('/v1/user', 'ShoppingList\\Controller\\UserController::updateCurrentUser');
        $app->get('/v1/user', 'ShoppingList\\Controller\\UserController::getInfo');
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
