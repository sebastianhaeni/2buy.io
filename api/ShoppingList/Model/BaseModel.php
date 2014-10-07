<?php
namespace ShoppingList\Model;

use Silex\Application;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
abstract class BaseModel
{

    public function save(Application $app)
    {
        throw new \Exception('Not implemented');
    }

    public function validate()
    {
        throw new \Exception('Not implemented');
    }

    public static function getById($id)
    {
        throw new \Exception('Not implemented');
    }
}