<?php
namespace ShoppingList\Controller;

use ShoppingList\Model\Community;
use ShoppingList\Model\CommunityHasUser;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use ShoppingList\Util\StatusCodes;
use ShoppingList\Model\Invite;

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
        $user = $app['auth']->getUser($request);
        
        if ($user == null) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return $app->json($user->getCommunities($app));
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

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function update(Request $request, Application $app)
    {
        $community = Community::getById($request->get('id'), $app);
        if ($community == null) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        $communityHasUser = CommunityHasUser::getById($community->getId() . ':' . $app['auth']->getUser($request)->getId(), $app);
        
        if ($communityHasUser == null) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        if ($communityHasUser->isAdmin() && null !== $request->get('name')) {
            $community->setName($request->get('name'));
            if (! $community->save($app)) {
                return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
            }
        }
        
        if (null !== $request->get('receiveNotifications')) {
            $communityHasUser->setReceiveNotifications($request->get('receiveNotifications') == 'true');
            if (! $communityHasUser->save($app)) {
                return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
            }
        }
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function delete(Request $request, Application $app)
    {
        $community = Community::getById($request->get('id'), $app);
        
        if ($community == null) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        $communityHasUser = CommunityHasUser::getById($community->getId() . ':' . $app['auth']->getUser($request)->getId(), $app);
        
        if ($communityHasUser == null) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        if (! $communityHasUser->isAdmin()) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        if ($community->delete($app)) {
            return new Response('Success', StatusCodes::HTTP_OK);
        }
        
        return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function inviteUser(Request $request, Application $app)
    {
        $community = Community::getById($request->get('id'), $app);
        $email = $request->get('email');
        
        if ($community == null) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        $communityHasUser = CommunityHasUser::getById($community->getId() . ':' . $app['auth']->getUser($request)->getId(), $app);
        
        if ($communityHasUser == null) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        if (! $communityHasUser->isAdmin()) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        $invite = new Invite(null, $community->getId(), $email);
        
        if ($invite->save($app)) {
            return new Response('Success', StatusCodes::HTTP_OK);
        }
        
        return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function getMembers(Request $request, Application $app)
    {
        $community = Community::getById($request->get('id'), $app);
        
        if ($community == null) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return $app->json($community->getMembers($app));
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function getInvites(Request $request, Application $app)
    {
        $community = Community::getById($request->get('id'), $app);
        
        if ($community == null) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return $app->json(Invite::getByCommunityId($community->getId(), $app));
    }
}
