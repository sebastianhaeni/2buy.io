<?php
namespace ShoppingList\Model;

use Silex\Application;
/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
abstract class BaseModel
{

    public function save(Application $app);
    public static function getById($id);
}