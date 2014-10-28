<?php
namespace ShoppingList\Model;

use Silex\Application;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class Community extends BaseModel
{

    private $_id;

    private $_name;

    /**
     *
     * @param int $id            
     * @param string $name            
     */
    public function __construct($id, $name)
    {
        $this->_id = $id;
        $this->setName($name);
    }

    /**
     *
     * @param int $id            
     * @param Application $app            
     * @return NULL|\ShoppingList\Model\Community
     */
    public static function getById($id, Application $app)
    {
        $data = $app['db']->fetchAssoc('SELECT * FROM community WHERE idCommunity = ?', array(
            $id
        ));
        
        return self::getCommunity($data);
    }

    /**
     *
     * @param NULL|array $data            
     * @return NULL|\ShoppingList\Model\Community
     */
    private static function getCommunity($data)
    {
        if ($data == null) {
            return null;
        }
        
        $community = new Community($data['idCommunity'], $data['name']);
        $community->setPersisted(true);
        return $community;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::insert()
     */
    protected function insert(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('INSERT INTO community (name) VALUES (?)', array(
                $this->getName()
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
            return 1 == $app['db']->executeUpdate('UPDATE community SET name = ? WHERE idCommunity = ?', array(
                $this->getName(),
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
            return 1 == $app['db']->executeUpdate('DELETE FROM community WHERE idCommunity = ?', array(
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
        
        return true;
    }

    /**
     * 
     * @param Application $app
     * @return multitype:unknown
     */
    public function getMembers(Application $app)
    {
        $communityHasUser = CommunityHasUser::getByCommunityId($this->getId(), $app);
        
        $users = array();
        
        foreach ($communityHasUser as $a) {
            $user = User::getById($a->getUserId(), $app)->jsonSerialize();
            $users[] = $user;
        }
        
        return $users;
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
            'name' => $this->getName()
        ];
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getName()
    {
        return $this->_name;
    }

    protected function setId($id)
    {
        $this->_id = $id;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }
}
