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
        
        return $this->json($checker->getCommunity()
            ->getProducts($app));
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response|\Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getProduct(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app, true);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        $product = Product::getById($request->get('idProduct'), $app);
        
        if ($product == null) {
            return new Response('Product not found', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        if ($product->getCommunityId() != $checker->getCommunity()->getId()) {
            return new Response('Product not in community', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return $this->json($product);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response|\Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createProduct(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app, true);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        // TODO check if the name is not already in use
        $product = new Product(null, $checker->getCommunity()->getId(), $request->get('name'), $app['auth']->getUser()->getId(), 0);
        
        if (! $product->save($app)) {
            return new Response('Could not save', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response|\Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateProduct(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app, true);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        $product = Product::getById($request->get('idProduct'), $app);
        
        if ($product == null) {
            return new Response('Product not found', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        if ($product->getCommunityId() != $checker->getCommunity()->getId()) {
            return new Response('Product not in community', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        if ($request->get('name') != null) {
            $product->setName($request->get('name'));
        }
        
        if ($request->get('inSuggestions') != null) {
            $product->setInSuggestions($request->get('inSuggestions') == '1');
        }
        
        // TODO check if the name is not already in use
        
        if (! $product->save($app)) {
            return new Response('Could not save', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response|\Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteProduct(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app, true);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        $product = Product::getById($request->get('idProduct'), $app);
        
        if ($product == null) {
            return new Response('Product not found', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        if ($product->getCommunityId() != $checker->getCommunity()->getId()) {
            return new Response('Product not in community', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        if (! $product->delete($app)) {
            return new Response('Could not delete', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return new Response('Success', StatusCodes::HTTP_OK);
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
        
        return $this->json(Product::getSuggestions($checker->getCommunity()
            ->getId(), $app, $request->get('query')));
    }
}
