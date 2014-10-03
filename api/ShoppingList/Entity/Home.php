<?php
namespace ShoppingList\Entity;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class Home
{

    public function info(Request $request, Application $app)
    {
        return $app->json(array(
            'date' => date('c'),
            'author' => 'Sebastian Haeni',
            'version' => '1.0'
        ));
    }
}