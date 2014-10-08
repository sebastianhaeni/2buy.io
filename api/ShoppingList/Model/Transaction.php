<?php
namespace ShoppingList\Model;

use Silex\Application;

/**
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class Transaction extends BaseModel
{

    private $_id;

    private $_productId;

    private $_reportedBy;

    private $_reportedDate;

    private $_editedBy;

    private $_amount;

    private $_boughtBy;

    private $_cancelled;

    private $_cancelledBy;

    private $_closeDate;

    /**
     *
     * @param int $id            
     * @param int $productId            
     * @param int $reportedBy            
     * @param string $reportedDate            
     * @param int $editedBy            
     * @param int $amount            
     * @param int $boughtBy            
     * @param boolean $cancelled            
     * @param int $cancelledBy            
     * @param string $closeDate            
     */
    public function __construct($id, $productId, $reportedBy, $reportedDate, $editedBy, $amount, $boughtBy, $cancelled, $cancelledBy, $closeDate)
    {
        $this->_id = $id;
        $this->setProductId($productId);
        $this->setReportedBy($reportedBy);
        $this->setReportedDate($reportedDate);
        $this->setEditedBy($editedBy);
        $this->setAmount($amount);
        $this->setBoughtBy($boughtBy);
        $this->setCancelled($cancelled);
        $this->setCancelledBy($cancelledBy);
        $this->setCloseDate($closeDate);
    }

    /**
     *
     * @param int $id            
     * @param Application $app            
     * @return NULL|\ShoppingList\Model\Transaction
     */
    public static function getById($id, Application $app)
    {
        $data = $app['db']->fetchAssoc('SELECT * FROM transaction WHERE idTransaction = ?', array(
            $id
        ));
        
        return self::getTransaction($data);
    }

    /**
     *
     * @param NULL|array $data            
     * @return NULL|\ShoppingList\Model\Transaction
     */
    private static function getTransaction($data)
    {
        if ($data == null) {
            return null;
        }
        
        return new Transaction($data['idTransaction'], $data['idProduct'], $data['reportedBy'], $data['reportedDate'], $data['editedBy'], $data['amount'], $data['boughtBy'], $data['cancelled'], $data['cancelledBy'], $data['closeDate']);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::insert()
     */
    protected function insert(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('INSERT INTO remember_me_token (idProduct, reportedBy, reportedDate, editedBy, amount, boughtBy, cancelled, cancelledBy, closeDate) VALUES (?,?,?,?,?,?,?,?,?)', array(
                $this->getProductId(),
                $this->getReportedBy(),
                $this->getReportedDate(),
                $this->getEditedBy(),
                $this->getAmount(),
                $this->getBoughtBy(),
                $this->getCancelled(),
                $this->getCancelledBy(),
                $this->getCloseDate()
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
                idProduct = ?, reportedBy = ?, reportedDate = ?, editedBy = ?, amount = ?, boughtBy = ?, cancelled = ?, cancelledBy = ?, closeDate = ? 
                WHERE idToken= ?', array(
                $this->getProductId(),
                $this->getReportedBy(),
                $this->getReportedDate(),
                $this->getEditedBy(),
                $this->getAmount(),
                $this->getBoughtBy(),
                $this->getCancelled(),
                $this->getCancelledBy(),
                $this->getCloseDate(),
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
            return 1 == $app['db']->executeUpdate('DELETE FROM transaction WHERE idTransaction = ?', array(
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
        if ($this->getProductId() == null) {
            return false;
        }
        
        if ($this->getAmount() < 1) {
            return false;
        }
        
        return true;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getProductId()
    {
        return $this->_productId;
    }

    public function getReportedBy()
    {
        return $this->_reportedBy;
    }

    public function getReportedDate()
    {
        return $this->_reportedDate;
    }

    public function getEditedBy()
    {
        return $this->_editedBy;
    }

    public function getAmount()
    {
        return $this->_amount;
    }

    public function getBoughtBy()
    {
        return $this->_boughtBy;
    }

    public function getCancelled()
    {
        return $this->_cancelled;
    }

    public function getCancelledBy()
    {
        return $this->_cancelledBy;
    }

    public function getCloseDate()
    {
        return $this->_closeDate;
    }

    public function setProductId($productId)
    {
        $this->_productId = $productId;
    }

    public function setReportedBy($reportedBy)
    {
        $this->_reportedBy = $reportedBy;
    }

    public function setReportedDate($reportedDate)
    {
        $this->_reportedDate = $reportedDate;
    }

    public function setEditedBy($editedBy)
    {
        $this->_editedBy = $editedBy;
    }

    public function setAmount($amount)
    {
        $this->_amount = $amount;
    }

    public function setBoughtBy($boughtBy)
    {
        $this->_boughtBy = $boughtBy;
    }

    public function setCancelled($cancelled)
    {
        $this->_cancelled = $cancelled;
    }

    public function setCancelledBy($cancelledBy)
    {
        $this->_cancelledBy = $cancelledBy;
    }

    public function setCloseDate($closeDate)
    {
        $this->_closeDate = $closeDate;
    }
}