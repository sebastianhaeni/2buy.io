<?php
namespace ShoppingList\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use ShoppingList\Model\User;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class UserController extends BaseController
{

    public function register(Request $request, Application $app)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        
        $user = new User($name, $email, $password);
        
        $user->save();
    }
}