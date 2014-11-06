<?php
namespace ShoppingList\Controller;

use ShoppingList\Model\Community;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ShoppingList\Model\Product;
use ShoppingList\Model\Transaction;
use ShoppingList\Util\StatusCodes;
use ShoppingList\Model\BaseModel;

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
            return new Response('Error finding community', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return $app->json($community->getTransactions($app, $request->get('filter')));
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function insertTransaction(Request $request, Application $app)
    {
        $community = Community::getById($request->get('id'), $app);
        
        if ($community == null) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        $name = $request->get('name');
        $amount = $request->get('amount');
        
        $selectedProduct = null;
        
        foreach ($community->getProducts($app) as $product) {
            if ($product->getName() == $name) {
                $selectedProduct = $product;
            }
        }
        
        if ($selectedProduct == null) {
            $selectedProduct = new Product(null, $community->getId(), $name, $app['auth']->getUser()->getId(), false);
            if (! $selectedProduct->save($app)) {
                return new Response('Error saving new product', StatusCodes::HTTP_BAD_REQUEST);
            }
        }
        
        $transaction = new Transaction(null, $selectedProduct->getId(), $app['auth']->getUser()->getId(), BaseModel::getCurrentTimeStamp(), null, $amount, null, 0, null, null);
        if (! $transaction->save($app)) {
            return new Response('Error saving transaction', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }
}