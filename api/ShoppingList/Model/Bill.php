<?php
namespace ShoppingList\Model;

use Silex\Application;

/**
 *
 * @author David Wiedmer <dave@sidefyn.ch>
 */
class Bill extends BaseModel
{


    private $_id;

    private $_price;

    private $_picturePath;

    private $_communityId;

    private $_community;

    private $_createdBy;

    private $_createdDate;

    private $_accepted;

    private $_closedBy;

    private $_closedDate;

    private $_creater;

    private $_closer;

    /**
     *
     * @param int $id
     * @param double $price
     * @param string $picturePath
     * @param int $communityId
     * @param int $createdBy
     * @param string $createdDate
     * @param boolean $accepted
     * @param int $closedBy
     * @param string $closedDate
     */
    public function __construct($id, $price, $picturePath, $communityId, $createdBy, $createdDate, $accepted, $closedBy, $closedDate)
    {
        $this->_id = $id;
        $this->setPrice($price);
        $this->setPicturePath($picturePath);
        $this->setCommunityId($communityId);
        $this->setCreatedBy($createdBy);
        $this->setCreatedDate($createdDate);
        $this->setAccepted($accepted);
        $this->setClosedBy($closedBy);
        $this->setClosedDate($closedDate);
    }

    /**
     *
     * @param int $id
     * @param Application $app
     * @return NULL|\ShoppingList\Model\Bill
     */
    public static function getById($id, Application $app)
    {
        $data = $app['db']->fetchAssoc('SELECT * FROM bill WHERE idBill = ?', array(
            $id
        ));

        return self::getBill($data);
    }

    /**
     *
     * @param NULL|array $data
     * @return NULL|\ShoppingList\Model\Transaction
     */
    private static function getBill($data, Application $app = null)
    {
        if ($data == null) {
            return null;
        }

        $bill = new Bill($data['idBill'], $data['price'], $data['picturePath'], $data['idCommunity'], $data['createdBy'], $data['createdDate'], $data['accepted'], $data['closedBy'], $data['closedDate']);

        if ($app != null) {
            $bill->setCommunity(Community::getById($bill->getCommunityId(), $app));
            $bill->setCreater(User::getById($bill->getCreatedBy(), $app));
            $bill->setCloser(User::getById($bill->getClosedBy(), $app));
        }

        $bill->setPersisted(true);
        return $bill;
    }

    public function getCommunityId()
    {
        return $this->_communityId;
    }

    public function setCommunityId($communityId)
    {
        $this->_communityId = $communityId;
    }

    public function getCreatedBy()
    {
        return $this->_createdBy;
    }

    public function setCreatedBy($createdBy)
    {
        $this->_createdBy = $createdBy;
    }

    public function getClosedBy()
    {
        return $this->_closedBy;
    }

    public function setClosedBy($closedBy)
    {
        $this->_closedBy = $closedBy;
    }

    /**
     *
     * @param int $communityId
     * @param Application $app
     * @return NULL|\ShoppingList\Model\Bill
     */
    public static function getActiveBills($communityId, Application $app)
    {
        return self::getBills($communityId, $app, 'closedDate IS NULL');
    }

    /**
     *
     * @param int $communityId
     * @param Application $app
     * @param string $filter
     *            sanitized where clause
     * @return NULL|\ShoppingList\Model\Bill
     */
    private static function getBills($communityId, Application $app, $filter)
    {
        $params = [
            $communityId
        ];

        $data = $app['db']->fetchAll('
            SELECT * FROM bill
            WHERE bill.idCommunity = ? AND ' . $filter, $params);

        $bills = [];
        foreach ($data as $bill) {
            $bills[] = self::getBill($bill, $app);
        }

        return $bills;
    }

    /**
     *
     * @param int $communityId
     * @param Application $app
     * @return NULL|\ShoppingList\Model\Bill
     */
    public static function getHistory($communityId, Application $app)
    {
        return self::getBills($communityId, $app, 'closedDate IS NOT NULL');
    }

    /**
     *
     * @param int $communityId
     * @param Application $app
     * @return boolean
     */
    public static function clearHistory($communityId, Application $app)
    {
        try {
            $app['db']->executeUpdate('DELETE FROM bill WHERE idCommunity = ? AND closedDate IS NOT NULL', array(
                $communityId
            ));
            return true;
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
            return 1 == $app['db']->executeUpdate('DELETE FROM bill WHERE idBill = ?', array(
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
        if ($this->getPicturePath() == null) {
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
            'price' => $this->getPrice(),
            'picturePath' => $this->getPicturePath(),
            'communityId' => $this->getCommunityId(),
            'createdBy' => $this->getCreatedBy(),
            'createdDate' => $this->getCreatedDate(),
            'creater' => $this->getCreater(),
            'accepted' => $this->getAccepted(),
            'closedBy' => $this->getClosedBy(),
            'closedDate' => $this->getClosedDate(),
            'closer' => $this->getCloser()

        ];
    }

    public function getCreater()
    {
        return $this->_creater;
    }

    public function setCreater($creater)
    {
        $this->_creater = $creater;
    }

    public function getCloser()
    {
        return $this->_closer;
    }

    public function setCloser($closer)
    {
        $this->_closer = $closer;
    }

    public function getCommunity()
    {
        return $this->_community;
    }

    public function setCommunity($community)
    {
        $this->_community = $community;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::insert()
     */
    protected function insert(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('INSERT INTO bill (price, picturePath, idCommunity, createdBy, createdDate, accepted, closedBy, closedDate) VALUES (?,?,?,?,?,?,?,?)', [
                $this->getPrice(),
                $this->getPicturePath(),
                $this->getCommunityId(),
                $this->getCreatedBy(),
                $this->getCreatedDate(),
                $this->getAccepted(),
                $this->getClosedBy(),
                $this->getClosedDate()
            ]);
        } catch (\PDOException $ex) {
            return false;
        }
    }

    public function getPrice()
    {
        return $this->_price;
    }

    public function setPrice($price)
    {
        $this->_price = $price;
    }

    public function getPicturePath()
    {
        return $this->_picturePath;
    }

    public function setPicturePath($picturePath)
    {
        $this->_picturePath = $picturePath;
    }

    public function getCreatedDate()
    {
        return $this->_createdDate;
    }

    public function setCreatedDate($createdDate)
    {
        $this->_createdDate = $createdDate;
    }

    public function getAccepted()
    {
        return $this->_accepted;
    }

    public function setAccepted($accepted)
    {
        $this->_accepted = $accepted;
    }

    public function getClosedDate()
    {
        return $this->_closedDate;
    }

    public function setClosedDate($closedDate)
    {
        $this->_closedDate = $closedDate;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::update()
     */
    protected function update(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('UPDATE bill SET
                price = ?, picturePath = ?, idCommunity = ?, createdBy = ?, createdDate = ?, accepted = ?, closedBy = ?, closedDate = ?
                WHERE idBill = ?', array(
                $this->getPrice(),
                $this->getPicturePath(),
                $this->getCommunityId(),
                $this->getCreatedBy(),
                $this->getCreatedDate(),
                $this->getAccepted(),
                $this->getClosedBy(),
                $this->getClosedDate(),
                $this->getId()
            ));
        } catch (\PDOException $ex) {
            return false;
        }
    }

    public function getId()
    {
        return $this->_id;
    }

    protected function setId($id)
    {
        $this->_id = $id;
    }
}
