<?php
namespace ShoppingList\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use ShoppingList\Model\User;
use ShoppingList\Util\StatusCodes;

/**
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
        
        $user = new User(null, null, $name, $email, $password, null, false, false, false);
        
        if ($user->save($app)) {
            return new Response('Success', StatusCodes::HTTP_CREATED);
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
        
        $user = User::getByEmail($email, $app);
        
        if ($user == null) {
            return new Response('Invalid credentials', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        if ($user->verifyPassword($password)) {
            $app['auth']->login($user);
            return new Response('Success', StatusCodes::HTTP_OK);
        }
        
        return new Response('Invalid credentials', StatusCodes::HTTP_BAD_REQUEST);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logout(Request $request, Application $app)
    {
        $app['auth']->logout();
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function isLoggedIn(Request $request, Application $app)
    {
        if ($app['auth']->isLoggedIn()) {
            return new Response('Logged in', StatusCodes::HTTP_ACCEPTED);
        }
        
        return new Response('Not authenticated', StatusCodes::HTTP_UNAUTHORIZED);
    }
}