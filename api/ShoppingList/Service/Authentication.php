<?php
namespace ShoppingList\Service;

use ShoppingList\Model\User;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class Authentication implements ServiceProviderInterface
{

    private $_app;

    /**
     *
     * @param Application $app            
     */
    public function register(Application $app)
    {
        $this->_app = $app;
        $app['auth'] = $this;
    }

    /**
     *
     * @param Application $app            
     */
    public function boot(Application $app)
    {}

    /**
     *
     * @param User $user            
     */
    public function login(User $user)
    {
        $this->_app['session']->set('logged-in', true);
        $this->_app['session']->set('user', array(
            'email' => $user->getEmail()
        ));
    }

    /**
     * 
     * @return boolean
     */
    public function isLoggedIn()
    {
        if (! $this->_app['session']->has('user')) {
            return false;
        }
        $user = $this->_app['session']->get('user');
        if (! array_key_exists('email', $user)) {
            return false;
        }
        
        $email = $user['email'];
        
        if (User::getByEmail($email, $this->_app) != null) {
            return true;
        }
    }

    /**
     */
    public function logout()
    {
        $this->_app['session']->clear();
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