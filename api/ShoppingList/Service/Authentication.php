<?php
namespace ShoppingList\Service;

use ShoppingList\Model\User;
use Silex\Application;
use Silex\ServiceProviderInterface;
use ShoppingList\Model\RememberMeToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use ShoppingList\Util\StatusCodes;
use ShoppingList\Model\ShoppingList\Model;
use ShoppingList\Util\SuccessResponse;

/**
 * Handles the authentication in this app.
 * This class can log users in or out. Handle the remember me tokens and can determine if a user is logged in.
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class Authentication implements ServiceProviderInterface
{

    const LOGGED_IN = 'logged-in';

    const USER = 'user';

    const USER_ID = 'user_id';

    const REMEMBER_ME = 'remember-me';

    private $_app;

    private $_user;

    /**
     * (non-PHPdoc).
     *
     * @see \Silex\ServiceProviderInterface::register()
     */
    public function register(Application $app)
    {
        $this->_app = $app;
        $app['auth'] = $this;
    }

    /**
     * (non-PHPdoc).
     *
     * @see \Silex\ServiceProviderInterface::boot()
     */
    public function boot(Application $app)
    {
        // no op
    }

    /**
     * Logs the user in.
     * If a remember me token is desired, it will be created and set as a cookie.
     *
     * @param User $user            
     * @param bool $rememberMe            
     * @param Request $request            
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(User $user, Request $request)
    {
        $this->_app['session']->set(self::LOGGED_IN, true);
        $this->_app['session']->set(self::USER, array(
            self::USER_ID => $user->getIdUser()
        ));
        
        $tokenString = self::getRandomToken();
        
        $token = new RememberMeToken();
        $token->setIdUser($user->getIdUser());
        $token->setToken($tokenString);
        $token->setIP($request->getClientIp());
        $token->setUserAgent($request->headers->get('User-Agent'));
        $token->save();
        
        $response = new SuccessResponse();
        $response->headers->setCookie(new Cookie(self::REMEMBER_ME, $tokenString, time() + (3600 * 24 * 365)));

        return $response;
    }

    /**
     * Checks if the user is logged in.
     * If the user has no running server session but a valid remember me cookie, the session will be created as well.
     *
     * @param Request $request            
     *
     * @return bool
     */
    public function isLoggedIn(Request $request = null)
    {
        if ($this->_user != null) {
            return true;
        }
        
        if (! $this->_app['session']->has('user')) {
            if ($request == null) {
                return false;
            }
            
            // check remember me token
            $tokenString = $request->cookies->get(self::REMEMBER_ME);
            $token = RememberMeToken::getByToken($tokenString, $this->_app);
            if ($token == null) {
                return false;
            }
            
            $this->login(User::getById($token->getUserId(), $this->_app), true, $request);
            
            return true;
        }
        
        $user = $this->_app['session']->get(self::USER);
        if (! array_key_exists(self::USER_ID, $user)) {
            return false;
        }
        
        $userId = $user[self::USER_ID];
        
        $user = User::getById($userId, $this->_app);
        if ($user == null) {
            return false;
        }
        
        $this->_user = $user;
        
        return true;
    }

    /**
     * Logs the user out.
     * Destroys the session and removes the remembe me cookie.
     *
     * @param Request $request            
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logout(Request $request)
    {
        $tokenString = $request->cookies->getAlnum(self::REMEMBER_ME);
        $token = RememberMeToken::getByToken($tokenString, $this->_app);
        
        $response = new Response('Success', StatusCodes::HTTP_OK);
        $response->headers->clearCookie(self::REMEMBER_ME);
        
        $this->_app['session']->clear();
        
        return $response;
    }

    /**
     * Returns the current logged in user object.
     * If the user is not logged in, <code>null</code> will be returned.
     *
     * @param Request $request            
     *
     * @return NULL|\ShoppingList\Model\User
     */
    public function getUser(Request $request = null)
    {
        if (! $this->isLoggedIn($request)) {
            return;
        }
        
        return $this->_user;
    }

    /**
     * Creates a random token.
     *
     * @return string
     */
    public static function getRandomToken()
    {
        return md5(uniqid(microtime(), true));
    }
}
