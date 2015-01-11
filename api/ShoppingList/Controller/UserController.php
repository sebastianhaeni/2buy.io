<?php
namespace ShoppingList\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use ShoppingList\Model\User;
use ShoppingList\Util\StatusCodes;
use ShoppingList\Model\Invite;
use ShoppingList\Model\CommunityHasUser;

/**
 * User controller.
 * 
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class UserController extends BaseController
{

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, Application $app)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        
        $user = new User(null, $name, $email, $password, null);
        $user->setPassword($password);
        
        if ($user->save($app)) {
            
            $invites = Invite::getByEmail($email, $app);
            
            foreach ($invites as $invite) {
                $communityHasUser = new CommunityHasUser($invite->getCommunityId(), $user->getId(), false, null, null, true);
                
                if (! $communityHasUser->save($app) || ! $invite->delete($app)) {
                    return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
                }
            }
            
            return $app['auth']->login($user, true, $request);
        }
        
        return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, Application $app)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $rememberMe = $request->get('remember-me') == 'on';
        
        $user = User::getByEmail($email, $app);
        
        if ($user == null) {
            return new Response('Invalid credentials', StatusCodes::HTTP_UNAUTHORIZED);
        }
        
        if ($user->verifyPassword($password)) {
            return $app['auth']->login($user, $rememberMe, $request);
        }
        
        return new Response('Invalid credentials', StatusCodes::HTTP_UNAUTHORIZED);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logout(Request $request, Application $app)
    {
        return $app['auth']->logout($request);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function isLoggedIn(Request $request, Application $app)
    {
        return $this->json(array(
            'loggedIn' => $app['auth']->isLoggedIn($request)
        ));
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changePassword(Request $request, Application $app)
    {
        $oldPassword = $request->get('oldPassword');
        $newPassword = $request->get('newPassword');
        
        $user = $app['auth']->getUser($request);
        
        if ($user != null && $user->verifyPassword($oldPassword)) {
            $user->setPassword($newPassword);
            if ($user->save($app)) {
                return new Response('Success', StatusCodes::HTTP_OK);
            }
        }
        
        return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateCurrentUser(Request $request, Application $app)
    {
        $email = $request->get('email');
        $phone = $request->get('phone');
        
        $user = $app['auth']->getUser($request);
        
        if ($user != null) {
            $user->setEmail($email);
            $user->setPhone($phone);
            if ($user->save($app)) {
                return new Response('Success', StatusCodes::HTTP_OK);
            }
        }
        
        return new Response('Error', StatusCodes::HTTP_BAD_REQUEST);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getInfo(Request $request, Application $app)
    {
        $user = $app['auth']->getUser($request)->jsonSerialize();
        
        $communityId = $request->cookies->get('community');
        if (! empty($communityId)) {
            $communityHasUser = CommunityHasUser::getById($communityId . ':' . $user['id'], $app);
            
            if ($communityHasUser != null) {
                $user['communityHasUser'] = $communityHasUser;
            }
        }
        
        return $this->json($user);
    }
}