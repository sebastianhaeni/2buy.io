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

    private $_name;

    private $_email;

    private $_password;

    private $_phone;

    /**
     *
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $phone
     */
    public function __construct($id, $name, $email, $password, $phone)
    {
        $this->_id = $id;
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password, false);
        $this->setPhone($phone);
    }

    public function setPassword($password, $isPlain = true)
    {
        $this->_password = $isPlain ? password_hash($password, PASSWORD_DEFAULT) : $password;
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
     * @param array $data
     * @return NULL|\ShoppingList\Model\User
     */
    private static function getUser($data)
    {
        if ($data == null) {
            return null;
        }

        $user = new User($data['idUser'], $data['name'], $data['email'], $data['password'], $data['phone']);
        $user->setPersisted(true);

        return $user;
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
        if (!filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL)) {
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

    /**
     *
     * @param Application $app
     * @return number|multitype:unknown
     */
    public function getCommunities(Application $app)
    {
        $communityHasUser = CommunityHasUser::getByUserId($this->getId(), $app);

        $communities = array();

        foreach ($communityHasUser as $a) {
            $community = Community::getById($a->getCommunityId(), $app)->jsonSerialize();
            $community['administrator'] = $a->isAdmin();
            $community['receiveNotifications'] = $a->getReceiveNotifications();
            $communities[] = $community;
        }

        usort($communities, function ($a, $b) {
            return strnatcmp($a['name'], $b['name']);
        });

        return $communities;
    }

    /**
     *
     * @param Application $app
     * @return number|multitype:unknown
     */
    public function getCurrentCommunitiyHasUser($communityId, Application $app)
    {
        try {
            return $app['db']->fetchAll('
                SELECT
                	*
                FROM
                	community_has_user

                WHERE community_has_user.idCommunity = ?
                AND community_has_user.idUser = ?', [
                $this->getId(), $communityId
            ]);
        } catch (\PDOException $ex) {
            return false;
        }
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
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone()
        ];
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
            name = ?,
            email = ?,
            password = ?,
            phone = ?
            WHERE idUser = ?
            ', array(
                $this->getName(),
                $this->getEmail(),
                $this->_password,
                $this->getPhone(),
                $this->getId()
            ));
        } catch (\PDOException $ex) {
            return false;
        }
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setEmail($email)
    {
        $this->_email = $email;
    }

    public function getPhone()
    {
        return $this->_phone;
    }

    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    public function getId()
    {
        return $this->_id;
    }

    protected function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::insert()
     */
    protected function insert(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('INSERT INTO user (name, email, password, phone) VALUES (?,?,?,?)', array(
                $this->getName(),
                $this->getEmail(),
                $this->_password,
                $this->getPhone()
            ));
        } catch (\PDOException $ex) {
            return false;
        }
    }
}