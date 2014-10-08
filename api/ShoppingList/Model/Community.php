<?php
namespace ShoppingList\Model;

use Silex\Application;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class Community extends BaseModel
{

    private $_id;

    private $_name;

    private $_admin;

    /**
     *
     * @param int $id            
     * @param string $name            
     * @param int $admin            
     */
    public function __construct($id, $name, $admin)
    {
        $this->_id = $id;
        $this->setName($name);
        $this->setAdmin($admin);
    }

    /**
     *
     * @param int $id            
     * @param Application $app            
     * @return NULL|\ShoppingList\Model\Community
     */
    public static function getById($id, Application $app)
    {
        $data = $app['db']->fetchAssoc('SELECT * FROM community WHERE idCommunity= ?', array(
            $id
        ));
        
        return self::getCommunity($data);
    }

    /**
     *
     * @param NULL|array $data            
     * @return NULL|\ShoppingList\Model\Community
     */
    private static function getCommunity($data)
    {
        if ($data == null) {
            return null;
        }
        
        return new Community($data['idCommunity'], $data['name'], $data['admin']);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::insert()
     */
    protected function insert(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('INSERT INTO community (name, admin) VALUES (?,?)', array(
                $this->getName(),
                $this->getAdmin()
            ));
        } catch (\PDOException $ex) {
            return false;
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::update()
     */
    protected function update(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('UPDATE community SET name = ?, admin = ? WHERE idCommunity = ?', array(
                $this->getName(),
                $this->getAdmin(),
                $this->getId()
            ));
        } catch (\PDOException $ex) {
            return false;
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::delete()
     */
    protected function delete(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('DELETE FROM community WHERE idCommunity = ?', array(
                $this->getId()
            ));
        } catch (\PDOException $ex) {
            return false;
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::validate()
     */
    public function validate()
    {
        if (strlen($this->getName()) < 2) {
            return false;
        }
        
        if ($this->getAdmin() == null) {
            return false;
        }
        
        return true;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getAdmin()
    {
        return $this->_admin;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function setAdmin($admin)
    {
        $this->_admin = $admin;
    }
}