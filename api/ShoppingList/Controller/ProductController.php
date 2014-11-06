<?php
namespace ShoppingList\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

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
}