<?php
namespace ShoppingList\Model;

use Silex\Application;
use ShoppingList\Exception\NotImplementedException;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
abstract class BaseModel implements \JsonSerializable
{

    private $_isPersisted = false;

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
        if ($this->isPersisted()) {
            return $this->update($app);
        }
        $result = $this->insert($app);
        $this->setId($app['db']->lastInsertId());
        
        return $result;
    }

    public function isPersisted()
    {
        return $this->_isPersisted;
    }

    protected function setPersisted($value)
    {
        $this->_isPersisted = $value;
    }

    /**
     * Returns the current timestamp that can be inserted into the database.
     *
     * @return string
     */
    public static function getCurrentTimeStamp()
    {
        return date('Y-m-d H:i:s');
    }

    public abstract function delete(Application $app);

    public abstract function getId();

    protected abstract function setId($id);

    protected abstract function insert(Application $app);

    protected abstract function update(Application $app);

    public abstract function validate();

    public static function getById($id, Application $app)
    {
        return new NotImplementedException();
    }
}
