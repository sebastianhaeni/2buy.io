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

    private $_price;

    private $_billId;

    private $_product;

    private $_reporter;

    private $_editor;

    private $_buyer;

    private $_canceller;

    private $_bill;

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
     * @param double $price
     * @param int $billId
     */
    public function __construct($id, $productId, $reportedBy, $reportedDate, $editedBy, $amount, $boughtBy, $cancelled, $cancelledBy, $closeDate, $price, $billId)
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
        $this->setPrice($price);
        $this->setBillId($billId);
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
    private static function getTransaction($data, Application $app = null)
    {
        if ($data == null) {
            return null;
        }

        $transaction = new Transaction($data['idTransaction'], $data['idProduct'], $data['reportedBy'], $data['reportedDate'], $data['editedBy'], $data['amount'], $data['boughtBy'], $data['cancelled'], $data['cancelledBy'], $data['closeDate'], $data['price'], $data['idBill']);

        if ($app != null) {
            $transaction->setProduct(Product::getById($transaction->getProductId(), $app));
            $transaction->setReporter(User::getById($transaction->getReportedBy(), $app));
            $transaction->setEditor(User::getById($transaction->getEditedBy(), $app));
            $transaction->setBuyer(User::getById($transaction->getBoughtBy(), $app));
            $transaction->setCanceller(User::getById($transaction->getCancelledBy(), $app));
            $transaction->setBill(Bill::getById($transaction->getBillId(), $app));
        }

        $transaction->setPersisted(true);
        return $transaction;
    }

    public function getProductId()
    {
        return $this->_productId;
    }

    public function setProductId($productId)
    {
        $this->_productId = $productId;
    }

    public function getReportedBy()
    {
        return $this->_reportedBy;
    }

    public function setReportedBy($reportedBy)
    {
        $this->_reportedBy = $reportedBy;
    }

    public function getEditedBy()
    {
        return $this->_editedBy;
    }

    public function setEditedBy($editedBy)
    {
        $this->_editedBy = $editedBy;
    }

    public function getBoughtBy()
    {
        return $this->_boughtBy;
    }

    public function setBoughtBy($boughtBy)
    {
        $this->_boughtBy = $boughtBy;
    }

    public function getCancelledBy()
    {
        return $this->_cancelledBy;
    }

    public function setCancelledBy($cancelledBy)
    {
        $this->_cancelledBy = $cancelledBy;
    }

    public function getBillId()
    {
        return $this->_billId;
    }

    public function setBillId($billId)
    {
        $this->_billId = $billId;
    }

    /**
     *
     * @param int $communityId
     * @param Application $app
     * @param int $productId
     * @return NULL|\ShoppingList\Model\Transaction
     */
    public static function getActiveTransactions($communityId, Application $app, $productId = null)
    {
        return self::getTransactions($communityId, $app, 'closeDate IS NULL', $productId);
    }

    /**
     *
     * @param int $communityId
     * @param Application $app
     * @param string $filter
     *            sanitized where clause
     * @param int $productId
     * @return NULL|\ShoppingList\Model\Transaction
     */
    private static function getTransactions($communityId, Application $app, $filter, $productId = null)
    {
        $params = [
            $communityId
        ];

        if ($productId != null) {
            $params[] = $productId;
        }

        $data = $app['db']->fetchAll('
            SELECT * FROM transaction
            INNER JOIN product ON transaction.idProduct = product.idProduct
            WHERE product.idCommunity = ? AND ' . ($productId != null ? 'product.idProduct = ? AND ' : '') . $filter, $params);

        $transactions = [];
        foreach ($data as $transaction) {
            $transactions[] = self::getTransaction($transaction, $app);
        }

        return $transactions;
    }

    /**
     *
     * @param int $communityId
     * @param Application $app
     * @return NULL|\ShoppingList\Model\Transaction
     */
    public static function getHistory($communityId, Application $app)
    {
        return self::getTransactions($communityId, $app, 'closeDate IS NOT NULL');
    }

    /**
     *
     * @param int $communityId
     * @param Application $app
     * @return boolean
     */
    public static function clearHistory($communityId, Application $app)
    {
        try {
            $app['db']->executeUpdate('DELETE transaction.* FROM transaction INNER JOIN product ON transaction.idProduct = product.idProduct WHERE product.idCommunity = ? AND closeDate IS NOT NULL', array(
                $communityId
            ));
            return true;
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

    /**
     * (non-PHPdoc)
     *
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'productId' => $this->getProductId(),
            'product' => $this->getProduct(),
            'reportedBy' => $this->getReportedBy(),
            'reportedDate' => $this->getReportedDate(),
            'reporter' => $this->getReporter(),
            'editedBy' => $this->getEditedBy(),
            'editor' => $this->getEditor(),
            'amount' => $this->getAmount(),
            'boughtBy' => $this->getBoughtBy(),
            'buyer' => $this->getBuyer(),
            'cancelled' => $this->getCancelled(),
            'cancelledBy' => $this->getCancelledBy(),
            'canceller' => $this->getCanceller(),
            'closeDate' => $this->getCloseDate(),
            'price' => $this->getPrice(),
            'billId' => $this->getBillId(),
            'bill' => $this->getBill()
        ];
    }

    public function getProduct()
    {
        return $this->_product;
    }

    public function setProduct($value)
    {
        $this->_product = $value;
    }

    public function getReporter()
    {
        return $this->_reporter;
    }

    public function setReporter($value)
    {
        $this->_reporter = $value;
    }

    public function getEditor()
    {
        return $this->_editor;
    }

    public function setEditor($value)
    {
        $this->_editor = $value;
    }

    public function getBuyer()
    {
        return $this->_buyer;
    }

    public function setBuyer($value)
    {
        $this->_buyer = $value;
    }

    public function getCanceller()
    {
        return $this->_canceller;
    }

    public function setCanceller($value)
    {
        $this->_canceller = $value;
    }

    public function getBill()
    {
        return $this->_bill;
    }

    public function setBill($bill)
    {
        $this->_bill = $bill;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::insert()
     */
    protected function insert(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('INSERT INTO transaction (idProduct, reportedBy, reportedDate, editedBy, amount, boughtBy, cancelled, cancelledBy, closeDate, price, idBill) VALUES (?,?,?,?,?,?,?,?,?,?,?)', [
                $this->getProductId(),
                $this->getReportedBy(),
                $this->getReportedDate(),
                $this->getEditedBy(),
                $this->getAmount(),
                $this->getBoughtBy(),
                $this->getCancelled(),
                $this->getCancelledBy(),
                $this->getCloseDate(),
                $this->getPrice(),
                $this->getBillId()
            ]);
        } catch (\PDOException $ex) {
            return false;
        }
    }

    public function getReportedDate()
    {
        return $this->_reportedDate;
    }

    public function setReportedDate($reportedDate)
    {
        $this->_reportedDate = $reportedDate;
    }

    public function getAmount()
    {
        return $this->_amount;
    }

    public function setAmount($amount)
    {
        $this->_amount = $amount;
    }

    public function getCancelled()
    {
        return $this->_cancelled;
    }

    public function setCancelled($cancelled)
    {
        $this->_cancelled = $cancelled;
    }

    public function getCloseDate()
    {
        return $this->_closeDate;
    }

    public function setCloseDate($closeDate)
    {
        $this->_closeDate = $closeDate;
    }

    public function getPrice()
    {
        return $this->_price;
    }

    public function setPrice($price)
    {
        $this->_price = $price;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \ShoppingList\Model\BaseModel::update()
     */
    protected function update(Application $app)
    {
        try {
            return 1 == $app['db']->executeUpdate('UPDATE transaction SET
                idProduct = ?, reportedBy = ?, reportedDate = ?, editedBy = ?, amount = ?, boughtBy = ?, cancelled = ?, cancelledBy = ?, closeDate = ?, price = ?, idBill = ?
                WHERE idTransaction = ?', array(
                $this->getProductId(),
                $this->getReportedBy(),
                $this->getReportedDate(),
                $this->getEditedBy(),
                $this->getAmount(),
                $this->getBoughtBy(),
                $this->getCancelled(),
                $this->getCancelledBy(),
                $this->getCloseDate(),
                $this->getPrice(),
                $this->getBillId(),
                $this->getId()
            ));
        } catch (\PDOException $ex) {
            return false;
        }
    }

    public function getId()
    {
        return $this->_id;
    }

    protected function setId($id)
    {
        $this->_id = $id;
    }
}
