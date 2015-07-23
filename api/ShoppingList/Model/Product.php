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
        $this->setInSuggestions($inSuggestions);
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
     * @param int $id
     * @param Application $app
     * @return NULL|\ShoppingList\Model\Product
     */
    public static function getByCommunityId($communityId, Application $app)
    {
        $data = $app['db']->fetchAll('SELECT * FROM product WHERE idCommunity = ? ORDER BY name', array(
            $communityId
        ));

        $products = [];

        foreach ($data as $product) {
            $products[] = self::getProduct($product);
        }

        return $products;
    }

    /**
     *
     * @param int $id
     * @param Application $app
     * @param string $query
     * @return NULL|\ShoppingList\Model\Product
     */
    public static function getSuggestions($communityId, Application $app, $query)
    {
        $data = $app['db']->fetchAll('
            SELECT
                product.*
            FROM
                product
            LEFT JOIN transaction
            	ON transaction.idProduct = product.idProduct
            WHERE
                name LIKE ?
                AND product.inSuggestions = 1
            	AND product.idCommunity = ?
            GROUP BY
            	product.idProduct
            ORDER BY
                COUNT(transaction.idProduct) DESC,
            	name', array(
            '%' . $query . '%',
            $communityId
        ));

        $products = [];

        foreach ($data as $product) {
            $products[] = [
                'value' => self::getProduct($product)->getName()
            ];
        }

        return $products;
    }

    /**
     *
     * @param string $name
     * @param int $comminityId
     * @param Application $app
     * @return boolean
     */
    public static function existsNameCommunity($name, $communityId, Application $app)
    {
        return 0 <= $app['db']->executeUpdate('SELECT idProduct FROM product WHERE idCommunity = ? AND name LIKE ?', array(
            $communityId,
            $name
        ));
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

        $product = new Product($data['idProduct'], $data['idCommunity'], $data['name'], $data['addedBy'], $data['inSuggestions']);
        $product->setPersisted(true);
        return $product;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::insert()
     */
    protected function insert(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('INSERT INTO product (idCommunity, name, addedBy, inSuggestions) VALUES (?,?,?,?)', array(
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
            idCommunity = ?,
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
    public function delete(Application $app)
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

    /**
     * (non-PHPdoc)
     *
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'communityId' => $this->getCommunityId(),
            'name' => $this->getName(),
            'addedBy' => $this->getAddedBy(),
            'inSuggestions' => $this->getInSuggestions()
        ];
    }

    protected function setId($id)
    {
        $this->_id = $id;
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

    public function setInSuggestions($inSuggestions)
    {
        $this->_inSuggestions = $inSuggestions;
    }
}
