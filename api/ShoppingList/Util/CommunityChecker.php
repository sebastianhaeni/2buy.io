<?php
namespace ShoppingList\Util;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use ShoppingList\Model\Community;
use ShoppingList\Model\CommunityHasUser;
use ShoppingList\Util\StatusCodes;

/**
 * Checks if the current user is logged in and in the community with the id of the 'id' request value.
 * Can optionally check for admin flag.
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class CommunityChecker
{

    private $_request;

    private $_app;

    private $_hasToBeAdmin = false;

    private $_response = null;

    private $_isGood = false;

    private $_community = null;

    private $_communityHasUser = null;

    /**
     * Initialize checker.
     *
     * @param Request $request            
     * @param Application $app            
     * @param boolean $hasToBeAdmin            
     */
    public function __construct(Request $request, Application $app, $hasToBeAdmin = false)
    {
        $this->_request = $request;
        $this->_app = $app;
        $this->_hasToBeAdmin = $hasToBeAdmin;
        
        $this->checkCommunity();
    }

    /**
     * Returns true if the community exists, the user is in the community and if
     * <code>$hasToBeAdmin</code> has been set to <code>true</code>, if the user is an admin of the community.
     *
     * @return boolean
     */
    public function isGood()
    {
        return $this->_isGood;
    }

    /**
     * Returns the error response when there's something not good.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Returns the fetched community.
     *
     * @return NULL|\ShoppingList\Model\Community
     */
    public function getCommunity()
    {
        return $this->_community;
    }

    /**
     * Returns the fetched community->user association.
     *
     * @return NULL|\ShoppingList\Model\CommunityHasUser
     */
    public function getCommunityHasUser()
    {
        return $this->_communityHasUser;
    }

    /**
     * Does the actual checking and setting of class variables.
     */
    private function checkCommunity()
    {
        $this->_community = Community::getById($this->_request->get('id'), $this->_app);
        
        if ($this->_community == null) {
            $this->_response = new Response('Error finding community', StatusCodes::HTTP_BAD_REQUEST);
            $this->_isGood = false;
            return;
        }
        
        $this->_communityHasUser = CommunityHasUser::getById($this->_community->getId() . ':' . $this->_app['auth']->getUser($this->_request)->getId(), $this->_app);
        
        if ($this->_communityHasUser == null) {
            $this->_response = new Response('Error, user is not in community', StatusCodes::HTTP_UNAUTHORIZED);
            $this->_isGood = false;
            return;
        }
        
        if ($this->_hasToBeAdmin && ! $this->_communityHasUser->isAdmin()) {
            $this->_response = new Response('Error, user is not admin', StatusCodes::HTTP_UNAUTHORIZED);
            $this->_isGood = false;
            return;
        }
        
        $this->_isGood = true;
    }
}
