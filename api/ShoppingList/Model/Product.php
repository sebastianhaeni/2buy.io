<?php
namespace ShoppingList\Model;

use Silex\Application;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class Product extends BaseModel
{

    private $_id;

    private $_communityId;

    private $_name;

    private $_addedBy;

    private $_inSuggestions;

    /**
     *
     * @param int $id            
     * @param int $communityId            
     * @param string $name            
     * @param int $addedBy            
     * @param boolean $inSuggestions            
     */
    public function __construct($id, $communityId, $name, $addedBy, $inSuggestions)
    {
        $this->_id = $id;
        $this->setCommunityId($communityId);
        $this->setName($name);
        $this->setAddedBy($addedBy);
        $this->setInSuggestins($inSuggestions);
    }

    /**
     *
     * @param int $id            
     * @param Application $app            
     * @return NULL|\ShoppingList\Model\Product
     */
    public static function getById($id, Application $app)
    {
        $data = $app['db']->fetchAssoc('SELECT * FROM product WHERE idProduct = ?', array(
            $id
        ));
        
        return self::getProduct($data);
    }

    /**
     *
     * @param NULL|array $data            
     * @return NULL|\ShoppingList\Model\Product
     */
    private static function getProduct($data)
    {
        if ($data == null) {
            return null;
        }
        
        return new Product($data['idProduct'], $data['idCommunity'], $data['name'], $data['addedBy'], $data['inSuggestions']);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::insert()
     */
    protected function insert(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('INSERT INTO product (communityId, name, addedBy, inSuggestions) VALUES (?,?,?,?)', array(
                $this->getCommunityId(),
                $this->getName(),
                $this->getAddedBy(),
                $this->getInSuggestions()
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
            return 1 == $app['db']->executeUpdate('UPDATE product SET
            communityId = ?,
            name = ?,
            addedBy = ?,
            inSuggestions = ?
            WHERE idProduct = ?
            ', array(
                $this->getCommunityId(),
                $this->getName(),
                $this->getAddedBy(),
                $this->getInSuggestions(),
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
            return 1 == $app['db']->executeUpdate('DELETE FROM product WHERE idProduct = ?', array(
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
        if ($this->getCommunityId() == null) {
            return false;
        }
        if (strlen($this->getName()) < 2) {
            return false;
        }
        
        return true;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getCommunityId()
    {
        return $this->_communityId;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getAddedBy()
    {
        return $this->_addedBy;
    }

    public function getInSuggestions()
    {
        return $this->_inSuggestions;
    }

    public function setCommunityId($communityId)
    {
        $this->_communityId = $communityId;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function setAddedBy($addedBy)
    {
        $this->_addedBy = $addedBy;
    }

    public function setInSuggestins($inSuggestions)
    {
        $this->_inSuggestions = $inSuggestions;
    }
}