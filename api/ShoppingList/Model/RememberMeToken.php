<?php
namespace ShoppingList\Model;

use Silex\Application;
use Silex\Provider\RememberMeServiceProvider;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class RememberMeToken extends BaseModel
{

    private $_id;

    private $_userId;

    private $_token;

    private $_ip;

    private $_userAgent;

    private $_timestampCreated;

    /**
     *
     * @param int $id            
     * @param int $userId            
     * @param string $token            
     * @param string $ip            
     * @param string $userAgent            
     * @param string $timestampCreated            
     */
    public function __construct($id, $userId, $token, $ip, $userAgent, $timestampCreated)
    {
        $this->_id = $id;
        $this->setUserId($userId);
        $this->setToken($token);
        $this->setIp($ip);
        $this->setUserAgent($userAgent);
        $this->setTimestampCreate($timestampCreated);
    }

    /**
     *
     * @param int $id            
     * @param Application $app            
     */
    public static function getById($id, Application $app)
    {
        $data = $app['db']->fetchAssoc('SELECT * FROM remember_me_token WHERE idToken = ?', array(
            $id
        ));
        
        return self::getProduct($data);
    }

    /**
     *
     * @param NULL|array $data            
     * @return NULL|\ShoppingList\Model\RememberMeToken
     */
    private static function getRememberMeToken($data)
    {
        if ($data == null) {
            return null;
        }
        
        return new RememberMeToken($data['idToken'], $data['idUser'], $data['token'], $data['ip'], $data['userAgent'], $data['timestampCreated']);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::insert()
     */
    protected function insert(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('INSERT INTO remember_me_token (idUser, token, ip, userAgent) VALUES (?,?,?,?)', array(
                $this->getUserId(),
                $this->getToken(),
                $this->getIp(),
                $this->getUserAgent()
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
            return 1 == $app['db']->executeUpdate('UPDATE remember_me_token SET
            idUser = ?,
            token = ?,
            ip = ?,
            userAgent = ?
            WHERE idToken = ?
            ', array(
                $this->getUserAgent(),
                $this->getToken(),
                $this->getIp(),
                $this->getUserAgent(),
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
        if ($this->getUserId() == null) {
            return false;
        }
        if (strlen($this->getToken()) < 2) {
            return false;
        }
        if ($this->getIp() == null) {
            return false;
        }
        if ($this->getUserAgent() == null) {
            return false;
        }
        
        return true;
    }

    public function getId()
    {
        return $_id;
    }

    public function getUserId()
    {
        return $this->_userId;
    }

    public function getToken()
    {
        return $this->_token;
    }

    public function getIp()
    {
        return $this->_ip;
    }

    public function getUserAgent()
    {
        return $this->_userAgent;
    }

    public function getTimestampCreated()
    {
        return $this->_timestampCreated;
    }

    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    public function setToken($token)
    {
        $this->_token = $token;
    }

    public function setIp($ip)
    {
        $this->_ip = $ip;
    }

    public function setUserAgent($userAgent)
    {
        $this->_userAgent = $userAgent;
    }

    private function setTimestampCreated($timestampCreated)
    {
        $this->_timestampCreated = $timestampCreated;
    }
}