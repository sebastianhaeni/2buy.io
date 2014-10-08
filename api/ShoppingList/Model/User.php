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
     * @param int $id            
     * @param Application $app            
     * @return NULL|\ShoppingList\Model\User
     */
    public static function getById($id, Application $app)
    {
        $data = $app['db']->fetchAssoc('SELECT * FROM user WHERE idUser = ?', array(
            $id
        ));
        
        return self::getUser($data);
    }

    /**
     *
     * @param string $email            
     * @param Application $app            
     * @return NULL|\ShoppingList\Model\User
     */
    public static function getByEmail($email, Application $app)
    {
        $user = $app['db']->fetchAssoc('SELECT * FROM user WHERE email = ?', array(
            $email
        ));
        
        return self::getUser($user);
    }

    /**
     *
     * @param
     *            $data
     * @return NULL|\ShoppingList\Model\User
     */
    private static function getUser($data)
    {
        if ($data == null) {
            return null;
        }
        
        return new User($data['idUser'], $data['idCommunity'], $data['name'], $data['email'], $data['password'], $data['phone'], $data['receiveUpdates'], $data['receiveSms'], $data['isAdmin']);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::update()
     */
    protected function update(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('UPDATE user SET 
            idCommunity = ?, 
            name = ?,
            email = ?,
            password = ?,
            phone = ?,
            receiveUpdates = ?,
            receiveSms = ?,
            isAdmin = ?
            WHERE idUser = ?
            ', array(
                $this->getCommunityId(),
                $this->getName(),
                $this->getEmail(),
                $this->_password,
                $this->getPhone(),
                $this->getReceiveUpdates(),
                $this->getReceiveSms(),
                $this->isAdmin(),
                $this->getId()
            ));
        } catch (\PDOException $ex) {
            return false;
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::insert()
     */
    protected function insert(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('INSERT INTO user (idCommunity, name, email, password, phone, receiveUpdates, receiveSms, isAdmin) VALUES (?,?,?,?,?,?,?,?)', array(
                $this->getCommunityId(),
                $this->getName(),
                $this->getEmail(),
                $this->_password,
                $this->getPhone(),
                $this->getReceiveUpdates(),
                $this->getReceiveSms(),
                $this->isAdmin()
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
            return 1 == $app['db']->executeUpdate('DELETE FROM user WHERE idUser = ?', array(
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
        if (! filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        return true;
    }

    /**
     *
     * @param string $password            
     * @return boolean
     */
    public function verifyPassword($password)
    {
        return password_verify($password, $this->_password);
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