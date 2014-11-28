<?php
namespace ShoppingList\Controller;

use ShoppingList\Model\Community;
use ShoppingList\Model\CommunityHasUser;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use ShoppingList\Util\StatusCodes;
use ShoppingList\Model\Invite;
use ShoppingList\Model\User;
use ShoppingList\Util\CommunityChecker;

/**
 * Provides the functions for /community.
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class CommunityController extends BaseController
{

    /**
     * Creates a new community.
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
     * Returns all communities of the current user.
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
        
        return $this->json($user->getCommunities($app));
    }

    /**
     * Returns a certain community if the current user is in it.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getById(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        return $this->json($checker->getCommunity(), $app);
    }

    /**
     * Updates a community.
     * Only an admin can change the name.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function update(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app, true);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        if (null !== $request->get('name')) {
            $checker->getCommunity()->setName($request->get('name'));
            if (! $checker->getCommunity()->save($app)) {
                return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
            }
        }
        
        if (null !== $request->get('receiveNotifications')) {
            $checker->getCommunityHasUser()->setReceiveNotifications($request->get('receiveNotifications') == 'true');
            if (! $checker->getCommunityHasUser()->save($app)) {
                return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
            }
        }
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     * Deletes a community.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function delete(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app, true);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        if ($checker->getCommunity()->delete($app)) {
            return new Response('Success', StatusCodes::HTTP_OK);
        }
        
        return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
    }

    /**
     * Invites a user to the community.
     * Only an admin can do this.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function inviteUser(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app, true);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        $email = $request->get('email');
        
        // detect if the user already is registered and add him to the community, instead of adding an invite
        $user = User::getByEmail($email, $app);
        
        if ($user == null) {
            $invite = new Invite(null, $checker->getCommunity()->getId(), $email);
            
            if ($invite->save($app)) {
                return new Response('Success', StatusCodes::HTTP_OK);
            }
            
            return new Response('Error saving invite', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        $communityHasUser = new CommunityHasUser($checker->getCommunity()->getId(), $user->getId(), false, true);
        
        if (! $communityHasUser->save($app)) {
            return new Response('Error saving community association', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     * Returns the members of a community if the current user is in it.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function getMembers(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        return $this->json($checker->getCommunity()
            ->getMembers($app));
    }

    /**
     * Returns the invitees of a community if the current user is in it.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function getInvites(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        return $this->json(Invite::getByCommunityId($checker->getCommunity()
            ->getId(), $app));
    }

    /**
     * Deletes an invite.
     * Only an admin can do this.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function deleteInvite(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app, true);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        $invite = Invite::getById($request->get('idInvite'), $app);
        
        if ($invite->delete($app)) {
            return new Response('Success', StatusCodes::HTTP_OK);
        }
        
        return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
    }

    /**
     * Deletes a member.
     * Only an admin can do this. A user cannot delete himself.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function deleteMember(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app, true);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        $member = User::getById($request->get('idMember'), $app);
        $communityHasUser = CommunityHasUser::getByUserId($request->get('idMember'), $app);
        
        if ($member == null || $communityHasUser == null || count($communityHasUser) <= 0) {
            return new Response('Member not found or is not in community', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        // Check if the user is in the community
        $validCommunity = false;
        foreach ($communityHasUser as $a) {
            if ($a->getCommunityId() == $checker->getCommunity()->getId()) {
                $validCommunity = true;
                $communityHasUser = $a;
                break;
            }
        }
        
        if (! $validCommunity) {
            return new Response('Member is not in community', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        if ($communityHasUser->delete($app)) {
            return new Response('Success', StatusCodes::HTTP_OK);
        }
        
        return new Response('Error deleting community association', StatusCodes::HTTP_BAD_REQUEST);
    }

    /**
     * Updates a member of a community.
     * Only an admin can do this. An admin cannot remove his own admin status.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function updateMember(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app, true);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        $member = User::getById($request->get('idMember'), $app);
        $communityHasUser = CommunityHasUser::getByUserId($request->get('idMember'), $app);
        
        if ($member == null || $communityHasUser == null || count($communityHasUser) <= 0) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        // Check if the user is in the community
        $validCommunity = false;
        foreach ($communityHasUser as $a) {
            if ($a->getCommunityId() == $checker->getCommunity()->getId()) {
                $validCommunity = true;
                $communityHasUser = $a;
                break;
            }
        }
        
        if (! $validCommunity) {
            return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        $communityHasUser->setAdmin($request->get('admin') == 'true');
        
        if ($communityHasUser->save($app)) {
            return new Response('Success', StatusCodes::HTTP_OK);
        }
        
        return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
    }
}
