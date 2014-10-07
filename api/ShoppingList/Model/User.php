<?php
namespace ShoppingList\Model;

use Silex\Application;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class User extends BaseModel
{

    private $_id;

    private $_communityId;

    private $_name;

    private $_email;

    private $_password;

    private $_phone;

    private $_receiveUpdates;

    private $_receiveSms;

    private $_isAdmin;

    /**
     */
    public function __construct()
    {}

    /**
     *
     * @param int $id            
     * @param int $communityId            
     * @param string $name            
     * @param string $email            
     * @param string $password            
     * @param string $phone            
     * @param boolean $receiveUpdates            
     * @param boolean $receiveSms            
     * @param boolean $isAdmin            
     */
    public function __construct($id, $communityId, $name, $email, $password, $phone, $receiveUpdates, $receiveSms, $isAdmin)
    {
        $this->_id = $id;
        $this->setCommunityId($communityId);
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password, false);
        $this->setPhone($phone);
        $this->setReceiveUpdates($receiveUpdates);
        $this->setReceiveSms($receiveSms);
        $this->setIsAdmin($isAdmin);
    }

    /**
     *
     * @param int $communityId            
     * @param string $name            
     * @param string $email            
     * @param string $password            
     * @param string $phone            
     * @param boolean $receiveUpdates            
     * @param boolean $receiveSms            
     * @param boolean $isAdmin            
     */
    public function __construct($communityId, $name, $email, $password, $phone, $receiveUpdates, $receiveSms, $isAdmin)
    {
        $this->setCommunityId($communityId);
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password, false);
        $this->setPhone($phone);
        $this->setReceiveUpdates($receiveUpdates);
        $this->setReceiveSms($receiveSms);
        $this->setIsAdmin($isAdmin);
    }

    public static function getById($id, Application $app)
    {
        $user = $app['db']->fetchAssoc('SELECT * FROM user WHERE idUser = ?', array(
            $id
        ));
        if ($user == null) {
            return null;
        }
        return new User($user['id'], $user['idCommunity'], $user['name'], $user['email'], $user['password'], $user['phone'], $user['receiveUpdates'], $user['receiveSms'], $user['idAdmin']);
    }

    public function save(Application $app)
    {
        if (isset($this->_id)) {
            return $this->update($app);
        }
        return $this->insert($app);
    }

    private function update(Application $app)
    {
        return 1 == $app['db']->executeUpdate('UPDATE user SET 
            idCommunity = ?, 
            name = ?,
            email = ?,
            password = ?,
            phone = ?,
            receiveUpdates = ?,
            receiveSms = ?
            isAdmin = ?
            WHERE idUser = ?
            ', array(
            $this->_communityId,
            $this->_name,
            $this->_email,
            $this->_password,
            $this->_phone,
            $this->_receiveUpdates,
            $this->_receiveSms,
            $this->_isAdmin,
            $this->_id
        ));
    }

    private function insert(Application $app)
    {
        return 1 == $app['db']->executeQuery('INSERT INTO user (idCommunity, name, email, password, phone, receiveUpdates, receiveSms, isAdmin) VALUES (?,?,?,?,?,?,?,?)', array(
            $this->_communityId,
            $this->_name,
            $this->_email,
            $this->_password,
            $this->_phone,
            $this->_receiveUpdates,
            $this->_receiveSms,
            $this->_isAdmin,
            $this->_id
        ));
    }

    public function setCommunityId($id)
    {
        $this->_communityId = $id;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function setEmail($email)
    {
        $this->_email = $email;
    }

    public function setPassword($password, $isPlain = true)
    {
        $this->_password = $isPlain ? password_hash($password, PASSWORD_DEFAULT) : $password;
    }

    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    public function setReceiveUpdates($receiveUpdates)
    {
        $this->_receiveUpdates = $receiveUpdates;
    }

    public function setReceiveSms($receiveSms)
    {
        $this->_receiveSms = $receiveSms;
    }

    public function setIsAdmin($isAdmin)
    {
        $this->_isAdmin = $isAdmin;
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

    public function getEmail()
    {
        return $this->_email;
    }

    public function getPhone()
    {
        return $this->_phone;
    }

    public function getReceiveUpdates()
    {
        return $this->_receiveUpdates;
    }

    public function getReceiveSms()
    {
        return $this->_receiveSms;
    }

    public function isAdmin()
    {
        return $this->_isAdmin;
    }
}