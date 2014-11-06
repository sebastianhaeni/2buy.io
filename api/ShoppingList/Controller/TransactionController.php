<?php
namespace ShoppingList\Controller;

use ShoppingList\Model\Community;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class TransactionController extends BaseController
{

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function getTransactions(Request $request, Application $app)
    {
        $community = Community::getById($request->get('id'), $app);
        
        if ($community == null) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return $app->json($community->getTransactions($app, $request->get('filter')));
    }
}