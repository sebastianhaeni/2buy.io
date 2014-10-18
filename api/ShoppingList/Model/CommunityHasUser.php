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
    {}

    /**
     *
     * @param int $id            
     * @param Application $app            
     * @return NULL|\ShoppingList\Model\Community
     */
    public static function getById($idCommunity, Application $app)
    {
        $data = $app['db']->fetchAssoc('SELECT * FROM community_has_user WHERE CONCAT(idCommunity, \':\', idUser) = ?', array(
            $id
        ));
        
        return self::getCommunity($data);
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
        
        return new CommunityHasUser($data['idCommunity'], $data['idUser'], $data['admin'], $data['receiveNotifications']);
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
    protected function delete(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('DELETE FROM community WHERE CONCAT(idCommunity, \':\', idUser) = ?', array(
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
        if ($this->isAdmin() == null) {
            return false;
        }
        
        if ($this->getReceiveNotifications() == null) {
            return false;
        }
        
        return true;
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

    public function setAdmin($value)
    {
        $this->_admin = $value;
    }

    public function setReceiveNotifications($value)
    {
        $this->_receiveNotifications = $value;
    }
}
