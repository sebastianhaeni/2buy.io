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
        $app->get('/', 'ShoppingList\\Service\\Router::redirectToDev');
        
        // Home
        $app->get('/v1/', 'ShoppingList\\Controller\\HomeController::info');

        // Notification
        $app->get('/v1/notification/update', 'ShoppingList\\Controller\\NotificationController::update');
        
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
        $app->post  ('/v1/community',                        'ShoppingList\\Controller\\CommunityController::create');
        $app->put   ('/v1/community/{id}',                   'ShoppingList\\Controller\\CommunityController::update');
        $app->post  ('/v1/community/{id}/invite',            'ShoppingList\\Controller\\CommunityController::inviteUser');
        $app->delete('/v1/community/{id}',                   'ShoppingList\\Controller\\CommunityController::delete');
        $app->get   ('/v1/community',                        'ShoppingList\\Controller\\CommunityController::getAll');
        $app->get   ('/v1/community/{id}',                   'ShoppingList\\Controller\\CommunityController::getById');
        $app->get   ('/v1/community/{id}/member',            'ShoppingList\\Controller\\CommunityController::getMembers');
        $app->get   ('/v1/community/{id}/invite',            'ShoppingList\\Controller\\CommunityController::getInvites');
        $app->put   ('/v1/community/{id}/member/{idMember}', 'ShoppingList\\Controller\\CommunityController::updateMember');
        $app->delete('/v1/community/{id}/member/{idMember}', 'ShoppingList\\Controller\\CommunityController::deleteMember');
        $app->delete('/v1/community/{id}/invite/{idInvite}', 'ShoppingList\\Controller\\CommunityController::deleteInvite');
        $app->put   ('/v1/community/{id}/ownpreferences',    'ShoppingList\\Controller\\CommunityController::editOwnPreferences');
        $app->get   ('/v1/community/{id}/ownpreferences',    'ShoppingList\\Controller\\CommunityController::getOwnPreferences');

        // Product
        $app->get   ('/v1/community/{id}/product',             'ShoppingList\\Controller\\ProductController::getProducts');
        $app->post  ('/v1/community/{id}/product',            'ShoppingList\\Controller\\ProductController::createProduct');
        $app->get   ('/v1/community/{id}/product/suggestions', 'ShoppingList\\Controller\\ProductController::getSuggestions');
        $app->get   ('/v1/community/{id}/product/{idProduct}', 'ShoppingList\\Controller\\ProductController::getProduct');
        $app->put   ('/v1/community/{id}/product/{idProduct}', 'ShoppingList\\Controller\\ProductController::updateProduct');
        $app->delete('/v1/community/{id}/product/{idProduct}', 'ShoppingList\\Controller\\ProductController::deleteProduct');
        
        // Statistics
        $app->get('/v1/community/{id}/stats/purchases', 'ShoppingList\\Controller\\StatisticsController::getPurchaseData');
        $app->get('/v1/community/{id}/stats/orders',    'ShoppingList\\Controller\\StatisticsController::getOrderData');
        $app->get('/v1/community/{id}/stats/paid',    'ShoppingList\\Controller\\StatisticsController::getPaidData');
        $app->get('/v1/community/{id}/stats/declined',    'ShoppingList\\Controller\\StatisticsController::getDeclinedData');

        // Transaction
        $app->get   ('/v1/community/{id}/transaction/active',                 'ShoppingList\\Controller\\TransactionController::getActiveTransactions');
        $app->get   ('/v1/community/{id}/transaction/history',                'ShoppingList\\Controller\\TransactionController::getHistory');
        $app->delete('/v1/community/{id}/transaction/history/clear',          'ShoppingList\\Controller\\TransactionController::clearHistory');
        $app->post  ('/v1/community/{id}/transaction',                        'ShoppingList\\Controller\\TransactionController::insertTransaction');
        $app->put   ('/v1/community/{id}/transaction/{idTransaction}',        'ShoppingList\\Controller\\TransactionController::update');
        $app->put   ('/v1/community/{id}/transaction/buy/{idTransaction}',    'ShoppingList\\Controller\\TransactionController::buy');
        $app->put   ('/v1/community/{id}/transaction/cancel/{idTransaction}', 'ShoppingList\\Controller\\TransactionController::cancel');
        $app->put   ('/v1/community/{id}/transaction/undo/{idTransaction}',   'ShoppingList\\Controller\\TransactionController::undo');

        // Bill
        $app->get   ('/v1/community/{id}/bill/active',                  'ShoppingList\\Controller\\BillController::getActiveBills');
        $app->get   ('/v1/community/{id}/bill/history',                 'ShoppingList\\Controller\\BillController::getHistory');
        $app->delete('/v1/community/{id}/bill/history/clear',           'ShoppingList\\Controller\\BillController::clearHistory');
        $app->post  ('/v1/community/{id}/bill',                         'ShoppingList\\Controller\\BillController::insertBill');
        $app->put   ('/v1/community/{id}/bill/accept/{idBill}',         'ShoppingList\\Controller\\BillController::accept');
        $app->put   ('/v1/community/{id}/bill/decline/{idBill}',        'ShoppingList\\Controller\\BillController::decline');
        $app->put   ('/v1/community/{id}/bill/undo/{idBill}',           'ShoppingList\\Controller\\BillController::undo');
        
        // User
        $app->get('/v1/user/logout',   'ShoppingList\\Controller\\UserController::logout');
        $app->put('/v1/user/password', 'ShoppingList\\Controller\\UserController::changePassword');
        $app->put('/v1/user',          'ShoppingList\\Controller\\UserController::updateCurrentUser');
        $app->get('/v1/user',          'ShoppingList\\Controller\\UserController::getInfo');
        
        // Barcode
        $app->get('/v1/barcode/{barcode}', 'ShoppingList\\Controller\\BarcodeController::get');
    }

    /**
     * Redirect requests to the api without any params to the API documentation page.
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
