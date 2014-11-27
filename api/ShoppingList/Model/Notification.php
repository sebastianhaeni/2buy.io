<?php
namespace ShoppingList\Model;

use Silex\Application;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class Notification extends BaseModel
{

    private $_id;

    private $_emailRecipient;

    private $_subject;

    private $_message;

    private $_scheduled;

    /**
     *
     * @param int $id            
     * @param string $emailRecipient            
     * @param string $subject            
     * @param string $message            
     * @param string $scheduled            
     */
    public function __construct($id, $emailRecipient, $subject, $message, $scheduled)
    {
        $this->_id = $id;
        $this->setCommunityId($communityId);
        $this->setName($name);
        $this->setAddedBy($addedBy);
        $this->setInSuggestins($inSuggestions);
    }

    /**
     *
     * @param int $id            
     * @param Application $app            
     * @return NULL|\ShoppingList\Model\Notification
     */
    public static function getById($id, Application $app)
    {
        $data = $app['db']->fetchAssoc('SELECT * FROM notification WHERE idNotification = ?', array(
            $id
        ));
        
        return self::getNotification($data);
    }

    /**
     * Fetches all scheduled notifications.
     *
     * @param Application $app            
     * @return NULL|\ShoppingList\Model\Notification
     */
    public static function getScheduled(Application $app)
    {
        $data = $app['db']->fetchAll('SELECT * FROM notification WHERE scheduled > NOW()', array());
        
        $notifications = [];
        
        foreach ($data as $notification) {
            $notifications[] = self::getNotification($notification);
        }
        
        return $notifications;
    }

    /**
     *
     * @param NULL|array $data            
     * @return NULL|\ShoppingList\Model\Notification
     */
    private static function getNotification($data)
    {
        if ($data == null) {
            return null;
        }
        
        $notification = new Notification($data['idNotification'], $data['emailRecipient'], $data['subject'], $data['message'], $data['scheduled']);
        $notification->setPersisted(true);
        return $notification;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::insert()
     */
    protected function insert(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('INSERT INTO notification (emailRecipient, subject, message, scheduled) VALUES (?,?,?,?)', array(
                $this->getEmailRecipient(),
                $this->getSubject(),
                $this->getMessage(),
                $this->getScheduled()
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
            return 1 == $app['db']->executeUpdate('UPDATE notification SET
            emailRecipient = ?,
            subject = ?,
            message = ?,
            scheduled = ?
            WHERE idNotification = ?
            ', array(
                $this->getEmailRecipient(),
                $this->getSubject(),
                $this->getMessage(),
                $this->getScheduled(),
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
            return 1 == $app['db']->executeUpdate('DELETE FROM notification WHERE idNotification = ?', array(
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
        if (! filter_var($this->getEmailRecipient(), FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        if (strlen($this->getSubject()) < 1) {
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
            'emailRecipient' => $this->getEmailRecipient(),
            'subject' => $this->getSubject(),
            'message' => $this->getMessage(),
            'scheduled' => $this->getScheduled()
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

    public function getEmailRecipient()
    {
        return $this->_emailRecipient;
    }

    public function getSubject()
    {
        return $this->_subject;
    }

    public function getMessage()
    {
        return $this->_message;
    }

    public function getScheduled()
    {
        return $this->_scheduled;
    }

    public function setEmailRecipient($emailRecipient)
    {
        $this->_emailRecipient = $emailRecipient;
    }

    public function setSubject($subject)
    {
        $this->_subject = $subject;
    }

    public function setMessage($message)
    {
        $this->_message = $message;
    }

    public function setScheduled($scheduled)
    {
        $this->_scheduled = $scheduled;
    }
}