<?php
namespace ShoppingList\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use ShoppingList\Model\Community;
use ShoppingList\Model\Product;
use Symfony\Component\HttpFoundation\Response;
use ShoppingList\Util\StatusCodes;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class ProductController extends BaseController
{

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function getProducts(Request $request, Application $app)
    {
        $community = Community::getById($request->get('id'), $app);
        
        if ($community == null) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return $app->json($community->getProducts($app));
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function getSuggestions(Request $request, Application $app)
    {
        $community = Community::getById($request->get('id'), $app);
        
        if ($community == null) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return $app->json(Product::getSuggestions($community->getId(), $app, $request->get('query')));
    }
}