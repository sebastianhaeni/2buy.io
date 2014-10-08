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

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class Authentication implements ServiceProviderInterface
{

    const LOGGED_IN = 'logged-in';

    const USER = 'user';

    const EMAIL = 'email';

    const REMEMBER_ME = 'remember-me';

    private $_app;

    /**
     * (non-PHPdoc)
     *
     * @see \Silex\ServiceProviderInterface::register()
     */
    public function register(Application $app)
    {
        $this->_app = $app;
        $app['auth'] = $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Silex\ServiceProviderInterface::boot()
     */
    public function boot(Application $app)
    {}

    /**
     *
     * @param User $user            
     * @param boolean $rememberMe            
     * @param Request $request            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(User $user, $rememberMe, Request $request)
    {
        $this->_app['session']->set(self::LOGGED_IN, true);
        $this->_app['session']->set(self::USER, array(
            self::EMAIL => $user->getEmail()
        ));
        
        if ($rememberMe) {
            $tokenString = self::getRandomToken();
            $token = new RememberMeToken(null, $user->getId(), $tokenString, $request->getClientIp(), $request->headers->get('User-Agent'), null);
            if ($token->save($this->_app)) {
                
                $response = new Response('Success', StatusCodes::HTTP_ACCEPTED);
                $response->headers->setCookie(new Cookie(REMEMBER_ME, $tokenString, time() + (3600 * 24 * 365)));
                
                return $response;
            }
        }
        
        return new Response('Success', StatusCodes::HTTP_ACCEPTED);
    }

    /**
     *
     * @param Request $request            
     * @return boolean
     */
    public function isLoggedIn(Request $request)
    {
        if (! $this->_app['session']->has('user')) {
            
            // check remember me token
            $tokenString = $request->cookies->getAlnum(self::REMEMBER_ME);
            $token = RememberMeToken::getByToken($tokenString, $this->_app);
            
            if ($token == null) {
                return false;
            }
            
            $this->login(User::getById($token->getUserId(), $this->_app), true, $request);
            
            return true;
        }
        $user = $this->_app['session']->get(self::USER);
        if (! array_key_exists(self::EMAIL, $user)) {
            return false;
        }
        
        $email = $user['email'];
        
        if (User::getByEmail($email, $this->_app) == null) {
            return false;
        }
        
        return true;
    }

    /**
     *
     * @param Request $request            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logout(Request $request)
    {
        $tokenString = $request->cookies->getAlnum(self::REMEMBER_ME);
        $token = RememberMeToken::getByToken($id, $this->_app);
        
        $response = new Response('Success', StatusCodes::HTTP_OK);
        $response->headers->clearCookie(REMEMBER_ME);
        
        $this->_app['session']->clear();
        
        return $response;
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