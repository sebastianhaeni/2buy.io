<?php
namespace ShoppingList\Model;

use Silex\Application;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class Invite extends BaseModel
{

    private $_id;

    private $_communityId;

    private $_email;

    /**
     *
     * @param int $id            
     * @param int $communityId            
     * @param string $email            
     */
    public function __construct($id, $communityId, $email)
    {
        $this->_id = $id;
    }

    /**
     *
     * @param int $id            
     * @param Application $app            
     * @return NULL|\ShoppingList\Model\Community
     */
    public static function getById($id, Application $app)
    {
        $data = $app['db']->fetchAssoc('SELECT * FROM invite WHERE idInvite = ?', array(
            $id
        ));
        
        return self::getInvite($data);
    }

    /**
     *
     * @param int $idCommunity            
     * @param Application $app            
     */
    public static function getByCommunityId($idCommunity, Application $app)
    {
        $data = $app['db']->fetchAll('SELECT * FROM invite WHERE idCommunity = ?', array(
            $idCommunity
        ));
        $a = array();
        
        foreach ($data as $item) {
            $a[] = self::getInvite($item);
        }
        
        return $a;
    }

    /**
     *
     * @param array $data            
     * @return NULL|\ShoppingList\Model\Invite
     */
    private static function getInvite($data)
    {
        if ($data == null) {
            return null;
        }
        
        $invite = new Invite($data['idInvite'], $data['idCommunity'], $data['email']);
        $invite->setPersisted(true);
        return $invite;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::insert()
     */
    protected function insert(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('INSERT INTO invite (idCommunity, email) VALUES (?,?)', array(
                $this->getCommunityId(),
                $this->getEmail()
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
            return 1 == $app['db']->executeUpdate('UPDATE community SET idCommunity = ?, email = ? WHERE idInvite = ?', array(
                $this->getCommunityId(),
                $this->getEmail(),
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
            return 1 == $app['db']->executeUpdate('DELETE FROM invite WHERE idInvite = ?', array(
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
        if (! filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL)) {
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
            'email' => $this->getEmail()
        ];
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getCommunityId()
    {
        return $this->_communityId;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    protected function setId($id)
    {
        $this->_id = $id;
    }

    public function setCommunityId($id)
    {
        $this->_communityId = $id;
    }

    public function setEmail($email)
    {
        $this->_email = $email;
    }
}
