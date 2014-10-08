<?php
namespace ShoppingList;

use ShoppingList\Model\User;
use Silex\Application;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class Authentication
{

    private $_app;

    public function __construct(Application $app)
    {
        $this->_app = $app;
    }

    public function login(User $user)
    {
        $this->_app['session']->set('logged-in', true);
        $this->_app['session']->set('user', array(
            'email' => $user->getEmail()
        ));
    }

    public function logout()
    {
        $this->_app['session']->clear();
    }
}