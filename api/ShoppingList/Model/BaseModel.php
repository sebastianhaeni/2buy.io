<?php
namespace ShoppingList\Model;

use Silex\Application;
use ShoppingList\Exception\NotImplementedException;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
abstract class BaseModel
{

    /**
     *
     * @param Application $app            
     * @return boolean
     */
    public function save(Application $app)
    {
        if (! $this->validate()) {
            return false;
        }
        if (! is_null($this->getId())) {
            return $this->update($app);
        }
        return $this->insert($app);
    }

    public function getId()
    {
        throw new NotImplementedException();
    }

    protected function insert(Application $app)
    {
        throw new NotImplementedException();
    }

    protected function update(Application $app)
    {
        throw new NotImplementedException();
    }

    public function validate()
    {
        throw new NotImplementedException();
    }

    public static function getById($id)
    {
        throw new NotImplementedException();
    }
}