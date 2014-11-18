<?php
namespace ShoppingList\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use ShoppingList\Model\Community;
use ShoppingList\Model\Product;
use Symfony\Component\HttpFoundation\Response;
use ShoppingList\Util\StatusCodes;
use ShoppingList\Util\CommunityChecker;

/**
 * Provides functions for /community/{id}/product.
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class ProductController extends BaseController
{

    /**
     * Gets all products of a community if the current user is in it.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function getProducts(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        return $app->json($checker->getCommunity()
            ->getProducts($app));
    }

    /**
     * Gets product suggestions of a community if the user is in it.
     * Suggestions are sorted by product usage and name.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function getSuggestions(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        return $app->json(Product::getSuggestions($checker->getCommunity()
            ->getId(), $app, $request->get('query')));
    }
}
