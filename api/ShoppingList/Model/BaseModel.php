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

    public abstract function delete(Application $app);

    public abstract function getId();

    protected abstract function insert(Application $app);

    protected abstract function update(Application $app);

    public abstract function validate();

    public abstract static function getById($id, Application $app);
}