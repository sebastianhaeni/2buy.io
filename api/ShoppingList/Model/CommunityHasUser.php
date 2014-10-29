<?php
namespace ShoppingList\Model;

use Silex\Application;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class CommunityHasUser extends BaseModel
{

    private $_communityId;

    private $_userId;

    private $_admin;

    private $_receiveNotifications;

    /**
     *
     * @param int $communityId            
     * @param int $userId            
     * @param boolean $admin            
     * @param boolean $receiveNotifications            
     */
    public function __construct($communityId, $userId, $admin, $receiveNotifications)
    {
        $this->_communityId = $communityId;
        $this->_userId = $userId;
        $this->setAdmin($admin);
        $this->setReceiveNotifications($receiveNotifications);
    }

    /**
     *
     * @param int $id            
     * @param Application $app            
     * @return NULL|\ShoppingList\Model\CommunityHasUser
     */
    public static function getById($id, Application $app)
    {
        $data = $app['db']->fetchAssoc('SELECT * FROM community_has_user WHERE CONCAT(idCommunity, \':\', idUser) = ?', array(
            $id
        ));
        
        return self::getCommunityHasUser($data);
    }

    /**
     *
     * @param int $idUser            
     * @param Application $app            
     */
    public static function getByUserId($idUser, Application $app)
    {
        $data = $app['db']->fetchAll('SELECT * FROM community_has_user WHERE idUser = ?', array(
            $idUser
        ));
        $a = array();
        
        foreach ($data as $item) {
            $a[] = self::getCommunityHasUser($item);
        }
        
        return $a;
    }

    /**
     *
     * @param int $idCommunity            
     * @param Application $app            
     */
    public static function getByCommunityId($idCommunity, Application $app)
    {
        $data = $app['db']->fetchAll('SELECT * FROM community_has_user WHERE idCommunity = ?', array(
            $idCommunity
        ));
        $a = array();
        
        foreach ($data as $item) {
            $a[] = self::getCommunityHasUser($item);
        }
        
        return $a;
    }

    /**
     *
     * @param array $data            
     * @return NULL|\ShoppingList\Model\CommunityHasUser
     */
    private static function getCommunityHasUser($data)
    {
        if ($data == null) {
            return null;
        }
        
        $communityHasUser = new CommunityHasUser($data['idCommunity'], $data['idUser'], $data['admin'], $data['receiveNotifications']);
        $communityHasUser->setPersisted(true);
        return $communityHasUser;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::insert()
     */
    protected function insert(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('INSERT INTO community_has_user (idCommunity, idUser, admin, receiveNotifications) VALUES (?,?,?,?)', array(
                $this->getCommunityId(),
                $this->getUserId(),
                $this->isAdmin(),
                $this->getReceiveNotifications()
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
            return 1 == $app['db']->executeUpdate('UPDATE community_has_user SET admin = ?, receiveNotifications = ? WHERE CONCAT(idCommunity, \':\', idUser) = ?', array(
                $this->isAdmin(),
                $this->getReceiveNotifications(),
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
            return 1 == $app['db']->executeUpdate('DELETE FROM community_has_user WHERE CONCAT(idCommunity, \':\', idUser) = ?', array(
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
            'communityId' => $this->getCommunityId(),
            'userId' => $this->getUserId(),
            'admin' => $this->isAdmin(),
            'receiveNotifications' => $this->getReceiveNotifications()
        ];
    }

    public function getId()
    {
        return $this->_communityId . ':' . $this->_userId;
    }

    public function getCommunityId()
    {
        return $this->_communityId;
    }

    public function getUserId()
    {
        return $this->_userId;
    }

    public function isAdmin()
    {
        return $this->_admin;
    }

    public function getReceiveNotifications()
    {
        return $this->_receiveNotifications;
    }

    protected function setId($id)
    {
        // Intentionally left empty
    }

    public function setAdmin($value)
    {
        $this->_admin = $value;
    }

    public function setReceiveNotifications($value)
    {
        $this->_receiveNotifications = $value;
    }
}
