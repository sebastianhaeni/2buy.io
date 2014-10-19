<?php
namespace ShoppingList\Controller;

use ShoppingList\Model\Community;
use ShoppingList\Model\CommunityHasUser;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class CommunityController extends BaseController
{

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function create(Request $request, Application $app)
    {
        $name = $request->get('name');
        
        $community = new Community(null, $name);
        if (! $community->save($app)) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        $communityHasUser = new CommunityHasUser($community->getId(), $app['auth']->getUser($request)->getId(), true, true);
        if (! $communityHasUser->save($app)) {
            $community->delete($app);
            
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAll(Request $request, Application $app)
    {
        return $app->json($app['auth']->getUser($request)
            ->getCommunities($app));
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getById(Request $request, Application $app)
    {
        return $app->json(Community::getById($request->get('id'), $app));
    }
}