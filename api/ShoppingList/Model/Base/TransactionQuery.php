<?php

namespace ShoppingList\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use ShoppingList\Model\Transaction as ChildTransaction;
use ShoppingList\Model\TransactionQuery as ChildTransactionQuery;
use ShoppingList\Model\Map\TransactionTableMap;

/**
 * Base class that represents a query for the 'transaction' table.
 *
 * 
 *
 * @method     ChildTransactionQuery orderByIdTransaction($order = Criteria::ASC) Order by the idTransaction column
 * @method     ChildTransactionQuery orderByIdProduct($order = Criteria::ASC) Order by the idProduct column
 * @method     ChildTransactionQuery orderByReportedBy($order = Criteria::ASC) Order by the reportedBy column
 * @method     ChildTransactionQuery orderByReportedDate($order = Criteria::ASC) Order by the reportedDate column
 * @method     ChildTransactionQuery orderByEditedBy($order = Criteria::ASC) Order by the editedBy column
 * @method     ChildTransactionQuery orderByAmount($order = Criteria::ASC) Order by the amount column
 * @method     ChildTransactionQuery orderByBoughtBy($order = Criteria::ASC) Order by the boughtBy column
 * @method     ChildTransactionQuery orderByCancelled($order = Criteria::ASC) Order by the cancelled column
 * @method     ChildTransactionQuery orderByCancelledBy($order = Criteria::ASC) Order by the cancelledBy column
 * @method     ChildTransactionQuery orderByCloseDate($order = Criteria::ASC) Order by the closeDate column
 *
 * @method     ChildTransactionQuery groupByIdTransaction() Group by the idTransaction column
 * @method     ChildTransactionQuery groupByIdProduct() Group by the idProduct column
 * @method     ChildTransactionQuery groupByReportedBy() Group by the reportedBy column
 * @method     ChildTransactionQuery groupByReportedDate() Group by the reportedDate column
 * @method     ChildTransactionQuery groupByEditedBy() Group by the editedBy column
 * @method     ChildTransactionQuery groupByAmount() Group by the amount column
 * @method     ChildTransactionQuery groupByBoughtBy() Group by the boughtBy column
 * @method     ChildTransactionQuery groupByCancelled() Group by the cancelled column
 * @method     ChildTransactionQuery groupByCancelledBy() Group by the cancelledBy column
 * @method     ChildTransactionQuery groupByCloseDate() Group by the closeDate column
 *
 * @method     ChildTransactionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTransactionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTransactionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTransactionQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildTransactionQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildTransactionQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildTransactionQuery leftJoinUserRelatedByReportedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByReportedBy relation
 * @method     ChildTransactionQuery rightJoinUserRelatedByReportedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByReportedBy relation
 * @method     ChildTransactionQuery innerJoinUserRelatedByReportedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByReportedBy relation
 *
 * @method     ChildTransactionQuery leftJoinUserRelatedByEditedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByEditedBy relation
 * @method     ChildTransactionQuery rightJoinUserRelatedByEditedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByEditedBy relation
 * @method     ChildTransactionQuery innerJoinUserRelatedByEditedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByEditedBy relation
 *
 * @method     ChildTransactionQuery leftJoinUserRelatedByBoughtBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByBoughtBy relation
 * @method     ChildTransactionQuery rightJoinUserRelatedByBoughtBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByBoughtBy relation
 * @method     ChildTransactionQuery innerJoinUserRelatedByBoughtBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByBoughtBy relation
 *
 * @method     ChildTransactionQuery leftJoinUserRelatedByCancelledBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByCancelledBy relation
 * @method     ChildTransactionQuery rightJoinUserRelatedByCancelledBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByCancelledBy relation
 * @method     ChildTransactionQuery innerJoinUserRelatedByCancelledBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByCancelledBy relation
 *
 * @method     \ShoppingList\Model\ProductQuery|\ShoppingList\Model\UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTransaction findOne(ConnectionInterface $con = null) Return the first ChildTransaction matching the query
 * @method     ChildTransaction findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTransaction matching the query, or a new ChildTransaction object populated from the query conditions when no match is found
 *
 * @method     ChildTransaction findOneByIdTransaction(int $idTransaction) Return the first ChildTransaction filtered by the idTransaction column
 * @method     ChildTransaction findOneByIdProduct(int $idProduct) Return the first ChildTransaction filtered by the idProduct column
 * @method     ChildTransaction findOneByReportedBy(int $reportedBy) Return the first ChildTransaction filtered by the reportedBy column
 * @method     ChildTransaction findOneByReportedDate(string $reportedDate) Return the first ChildTransaction filtered by the reportedDate column
 * @method     ChildTransaction findOneByEditedBy(int $editedBy) Return the first ChildTransaction filtered by the editedBy column
 * @method     ChildTransaction findOneByAmount(int $amount) Return the first ChildTransaction filtered by the amount column
 * @method     ChildTransaction findOneByBoughtBy(int $boughtBy) Return the first ChildTransaction filtered by the boughtBy column
 * @method     ChildTransaction findOneByCancelled(boolean $cancelled) Return the first ChildTransaction filtered by the cancelled column
 * @method     ChildTransaction findOneByCancelledBy(int $cancelledBy) Return the first ChildTransaction filtered by the cancelledBy column
 * @method     ChildTransaction findOneByCloseDate(string $closeDate) Return the first ChildTransaction filtered by the closeDate column *

 * @method     ChildTransaction requirePk($key, ConnectionInterface $con = null) Return the ChildTransaction by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOne(ConnectionInterface $con = null) Return the first ChildTransaction matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTransaction requireOneByIdTransaction(int $idTransaction) Return the first ChildTransaction filtered by the idTransaction column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOneByIdProduct(int $idProduct) Return the first ChildTransaction filtered by the idProduct column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOneByReportedBy(int $reportedBy) Return the first ChildTransaction filtered by the reportedBy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOneByReportedDate(string $reportedDate) Return the first ChildTransaction filtered by the reportedDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOneByEditedBy(int $editedBy) Return the first ChildTransaction filtered by the editedBy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOneByAmount(int $amount) Return the first ChildTransaction filtered by the amount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOneByBoughtBy(int $boughtBy) Return the first ChildTransaction filtered by the boughtBy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOneByCancelled(boolean $cancelled) Return the first ChildTransaction filtered by the cancelled column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOneByCancelledBy(int $cancelledBy) Return the first ChildTransaction filtered by the cancelledBy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOneByCloseDate(string $closeDate) Return the first ChildTransaction filtered by the closeDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTransaction[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTransaction objects based on current ModelCriteria
 * @method     ChildTransaction[]|ObjectCollection findByIdTransaction(int $idTransaction) Return ChildTransaction objects filtered by the idTransaction column
 * @method     ChildTransaction[]|ObjectCollection findByIdProduct(int $idProduct) Return ChildTransaction objects filtered by the idProduct column
 * @method     ChildTransaction[]|ObjectCollection findByReportedBy(int $reportedBy) Return ChildTransaction objects filtered by the reportedBy column
 * @method     ChildTransaction[]|ObjectCollection findByReportedDate(string $reportedDate) Return ChildTransaction objects filtered by the reportedDate column
 * @method     ChildTransaction[]|ObjectCollection findByEditedBy(int $editedBy) Return ChildTransaction objects filtered by the editedBy column
 * @method     ChildTransaction[]|ObjectCollection findByAmount(int $amount) Return ChildTransaction objects filtered by the amount column
 * @method     ChildTransaction[]|ObjectCollection findByBoughtBy(int $boughtBy) Return ChildTransaction objects filtered by the boughtBy column
 * @method     ChildTransaction[]|ObjectCollection findByCancelled(boolean $cancelled) Return ChildTransaction objects filtered by the cancelled column
 * @method     ChildTransaction[]|ObjectCollection findByCancelledBy(int $cancelledBy) Return ChildTransaction objects filtered by the cancelledBy column
 * @method     ChildTransaction[]|ObjectCollection findByCloseDate(string $closeDate) Return ChildTransaction objects filtered by the closeDate column
 * @method     ChildTransaction[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TransactionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ShoppingList\Model\Base\TransactionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ShoppingList\\Model\\Transaction', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTransactionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTransactionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTransactionQuery) {
            return $criteria;
        }
        $query = new ChildTransactionQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildTransaction|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TransactionTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TransactionTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTransaction A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idTransaction, idProduct, reportedBy, reportedDate, editedBy, amount, boughtBy, cancelled, cancelledBy, closeDate FROM transaction WHERE idTransaction = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildTransaction $obj */
            $obj = new ChildTransaction();
            $obj->hydrate($row);
            TransactionTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildTransaction|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TransactionTableMap::COL_IDTRANSACTION, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TransactionTableMap::COL_IDTRANSACTION, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the idTransaction column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTransaction(1234); // WHERE idTransaction = 1234
     * $query->filterByIdTransaction(array(12, 34)); // WHERE idTransaction IN (12, 34)
     * $query->filterByIdTransaction(array('min' => 12)); // WHERE idTransaction > 12
     * </code>
     *
     * @param     mixed $idTransaction The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByIdTransaction($idTransaction = null, $comparison = null)
    {
        if (is_array($idTransaction)) {
            $useMinMax = false;
            if (isset($idTransaction['min'])) {
                $this->addUsingAlias(TransactionTableMap::COL_IDTRANSACTION, $idTransaction['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTransaction['max'])) {
                $this->addUsingAlias(TransactionTableMap::COL_IDTRANSACTION, $idTransaction['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionTableMap::COL_IDTRANSACTION, $idTransaction, $comparison);
    }

    /**
     * Filter the query on the idProduct column
     *
     * Example usage:
     * <code>
     * $query->filterByIdProduct(1234); // WHERE idProduct = 1234
     * $query->filterByIdProduct(array(12, 34)); // WHERE idProduct IN (12, 34)
     * $query->filterByIdProduct(array('min' => 12)); // WHERE idProduct > 12
     * </code>
     *
     * @see       filterByProduct()
     *
     * @param     mixed $idProduct The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByIdProduct($idProduct = null, $comparison = null)
    {
        if (is_array($idProduct)) {
            $useMinMax = false;
            if (isset($idProduct['min'])) {
                $this->addUsingAlias(TransactionTableMap::COL_IDPRODUCT, $idProduct['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idProduct['max'])) {
                $this->addUsingAlias(TransactionTableMap::COL_IDPRODUCT, $idProduct['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionTableMap::COL_IDPRODUCT, $idProduct, $comparison);
    }

    /**
     * Filter the query on the reportedBy column
     *
     * Example usage:
     * <code>
     * $query->filterByReportedBy(1234); // WHERE reportedBy = 1234
     * $query->filterByReportedBy(array(12, 34)); // WHERE reportedBy IN (12, 34)
     * $query->filterByReportedBy(array('min' => 12)); // WHERE reportedBy > 12
     * </code>
     *
     * @see       filterByUserRelatedByReportedBy()
     *
     * @param     mixed $reportedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByReportedBy($reportedBy = null, $comparison = null)
    {
        if (is_array($reportedBy)) {
            $useMinMax = false;
            if (isset($reportedBy['min'])) {
                $this->addUsingAlias(TransactionTableMap::COL_REPORTEDBY, $reportedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($reportedBy['max'])) {
                $this->addUsingAlias(TransactionTableMap::COL_REPORTEDBY, $reportedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionTableMap::COL_REPORTEDBY, $reportedBy, $comparison);
    }

    /**
     * Filter the query on the reportedDate column
     *
     * Example usage:
     * <code>
     * $query->filterByReportedDate('2011-03-14'); // WHERE reportedDate = '2011-03-14'
     * $query->filterByReportedDate('now'); // WHERE reportedDate = '2011-03-14'
     * $query->filterByReportedDate(array('max' => 'yesterday')); // WHERE reportedDate > '2011-03-13'
     * </code>
     *
     * @param     mixed $reportedDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByReportedDate($reportedDate = null, $comparison = null)
    {
        if (is_array($reportedDate)) {
            $useMinMax = false;
            if (isset($reportedDate['min'])) {
                $this->addUsingAlias(TransactionTableMap::COL_REPORTEDDATE, $reportedDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($reportedDate['max'])) {
                $this->addUsingAlias(TransactionTableMap::COL_REPORTEDDATE, $reportedDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionTableMap::COL_REPORTEDDATE, $reportedDate, $comparison);
    }

    /**
     * Filter the query on the editedBy column
     *
     * Example usage:
     * <code>
     * $query->filterByEditedBy(1234); // WHERE editedBy = 1234
     * $query->filterByEditedBy(array(12, 34)); // WHERE editedBy IN (12, 34)
     * $query->filterByEditedBy(array('min' => 12)); // WHERE editedBy > 12
     * </code>
     *
     * @see       filterByUserRelatedByEditedBy()
     *
     * @param     mixed $editedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByEditedBy($editedBy = null, $comparison = null)
    {
        if (is_array($editedBy)) {
            $useMinMax = false;
            if (isset($editedBy['min'])) {
                $this->addUsingAlias(TransactionTableMap::COL_EDITEDBY, $editedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($editedBy['max'])) {
                $this->addUsingAlias(TransactionTableMap::COL_EDITEDBY, $editedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionTableMap::COL_EDITEDBY, $editedBy, $comparison);
    }

    /**
     * Filter the query on the amount column
     *
     * Example usage:
     * <code>
     * $query->filterByAmount(1234); // WHERE amount = 1234
     * $query->filterByAmount(array(12, 34)); // WHERE amount IN (12, 34)
     * $query->filterByAmount(array('min' => 12)); // WHERE amount > 12
     * </code>
     *
     * @param     mixed $amount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByAmount($amount = null, $comparison = null)
    {
        if (is_array($amount)) {
            $useMinMax = false;
            if (isset($amount['min'])) {
                $this->addUsingAlias(TransactionTableMap::COL_AMOUNT, $amount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amount['max'])) {
                $this->addUsingAlias(TransactionTableMap::COL_AMOUNT, $amount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionTableMap::COL_AMOUNT, $amount, $comparison);
    }

    /**
     * Filter the query on the boughtBy column
     *
     * Example usage:
     * <code>
     * $query->filterByBoughtBy(1234); // WHERE boughtBy = 1234
     * $query->filterByBoughtBy(array(12, 34)); // WHERE boughtBy IN (12, 34)
     * $query->filterByBoughtBy(array('min' => 12)); // WHERE boughtBy > 12
     * </code>
     *
     * @see       filterByUserRelatedByBoughtBy()
     *
     * @param     mixed $boughtBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByBoughtBy($boughtBy = null, $comparison = null)
    {
        if (is_array($boughtBy)) {
            $useMinMax = false;
            if (isset($boughtBy['min'])) {
                $this->addUsingAlias(TransactionTableMap::COL_BOUGHTBY, $boughtBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($boughtBy['max'])) {
                $this->addUsingAlias(TransactionTableMap::COL_BOUGHTBY, $boughtBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionTableMap::COL_BOUGHTBY, $boughtBy, $comparison);
    }

    /**
     * Filter the query on the cancelled column
     *
     * Example usage:
     * <code>
     * $query->filterByCancelled(true); // WHERE cancelled = true
     * $query->filterByCancelled('yes'); // WHERE cancelled = true
     * </code>
     *
     * @param     boolean|string $cancelled The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByCancelled($cancelled = null, $comparison = null)
    {
        if (is_string($cancelled)) {
            $cancelled = in_array(strtolower($cancelled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(TransactionTableMap::COL_CANCELLED, $cancelled, $comparison);
    }

    /**
     * Filter the query on the cancelledBy column
     *
     * Example usage:
     * <code>
     * $query->filterByCancelledBy(1234); // WHERE cancelledBy = 1234
     * $query->filterByCancelledBy(array(12, 34)); // WHERE cancelledBy IN (12, 34)
     * $query->filterByCancelledBy(array('min' => 12)); // WHERE cancelledBy > 12
     * </code>
     *
     * @see       filterByUserRelatedByCancelledBy()
     *
     * @param     mixed $cancelledBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByCancelledBy($cancelledBy = null, $comparison = null)
    {
        if (is_array($cancelledBy)) {
            $useMinMax = false;
            if (isset($cancelledBy['min'])) {
                $this->addUsingAlias(TransactionTableMap::COL_CANCELLEDBY, $cancelledBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cancelledBy['max'])) {
                $this->addUsingAlias(TransactionTableMap::COL_CANCELLEDBY, $cancelledBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionTableMap::COL_CANCELLEDBY, $cancelledBy, $comparison);
    }

    /**
     * Filter the query on the closeDate column
     *
     * Example usage:
     * <code>
     * $query->filterByCloseDate('2011-03-14'); // WHERE closeDate = '2011-03-14'
     * $query->filterByCloseDate('now'); // WHERE closeDate = '2011-03-14'
     * $query->filterByCloseDate(array('max' => 'yesterday')); // WHERE closeDate > '2011-03-13'
     * </code>
     *
     * @param     mixed $closeDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByCloseDate($closeDate = null, $comparison = null)
    {
        if (is_array($closeDate)) {
            $useMinMax = false;
            if (isset($closeDate['min'])) {
                $this->addUsingAlias(TransactionTableMap::COL_CLOSEDATE, $closeDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($closeDate['max'])) {
                $this->addUsingAlias(TransactionTableMap::COL_CLOSEDATE, $closeDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionTableMap::COL_CLOSEDATE, $closeDate, $comparison);
    }

    /**
     * Filter the query by a related \ShoppingList\Model\Product object
     *
     * @param \ShoppingList\Model\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \ShoppingList\Model\Product) {
            return $this
                ->addUsingAlias(TransactionTableMap::COL_IDPRODUCT, $product->getIdProduct(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TransactionTableMap::COL_IDPRODUCT, $product->toKeyValue('PrimaryKey', 'IdProduct'), $comparison);
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type \ShoppingList\Model\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function joinProduct($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Product');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Product');
        }

        return $this;
    }

    /**
     * Use the Product relation Product object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShoppingList\Model\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\ShoppingList\Model\ProductQuery');
    }

    /**
     * Filter the query by a related \ShoppingList\Model\User object
     *
     * @param \ShoppingList\Model\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByReportedBy($user, $comparison = null)
    {
        if ($user instanceof \ShoppingList\Model\User) {
            return $this
                ->addUsingAlias(TransactionTableMap::COL_REPORTEDBY, $user->getIdUser(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TransactionTableMap::COL_REPORTEDBY, $user->toKeyValue('PrimaryKey', 'IdUser'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByReportedBy() only accepts arguments of type \ShoppingList\Model\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByReportedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function joinUserRelatedByReportedBy($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRelatedByReportedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserRelatedByReportedBy');
        }

        return $this;
    }

    /**
     * Use the UserRelatedByReportedBy relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShoppingList\Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByReportedByQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserRelatedByReportedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByReportedBy', '\ShoppingList\Model\UserQuery');
    }

    /**
     * Filter the query by a related \ShoppingList\Model\User object
     *
     * @param \ShoppingList\Model\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByEditedBy($user, $comparison = null)
    {
        if ($user instanceof \ShoppingList\Model\User) {
            return $this
                ->addUsingAlias(TransactionTableMap::COL_EDITEDBY, $user->getIdUser(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TransactionTableMap::COL_EDITEDBY, $user->toKeyValue('PrimaryKey', 'IdUser'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByEditedBy() only accepts arguments of type \ShoppingList\Model\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByEditedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function joinUserRelatedByEditedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRelatedByEditedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserRelatedByEditedBy');
        }

        return $this;
    }

    /**
     * Use the UserRelatedByEditedBy relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShoppingList\Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByEditedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUserRelatedByEditedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByEditedBy', '\ShoppingList\Model\UserQuery');
    }

    /**
     * Filter the query by a related \ShoppingList\Model\User object
     *
     * @param \ShoppingList\Model\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByBoughtBy($user, $comparison = null)
    {
        if ($user instanceof \ShoppingList\Model\User) {
            return $this
                ->addUsingAlias(TransactionTableMap::COL_BOUGHTBY, $user->getIdUser(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TransactionTableMap::COL_BOUGHTBY, $user->toKeyValue('PrimaryKey', 'IdUser'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByBoughtBy() only accepts arguments of type \ShoppingList\Model\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByBoughtBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function joinUserRelatedByBoughtBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRelatedByBoughtBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserRelatedByBoughtBy');
        }

        return $this;
    }

    /**
     * Use the UserRelatedByBoughtBy relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShoppingList\Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByBoughtByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUserRelatedByBoughtBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByBoughtBy', '\ShoppingList\Model\UserQuery');
    }

    /**
     * Filter the query by a related \ShoppingList\Model\User object
     *
     * @param \ShoppingList\Model\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByCancelledBy($user, $comparison = null)
    {
        if ($user instanceof \ShoppingList\Model\User) {
            return $this
                ->addUsingAlias(TransactionTableMap::COL_CANCELLEDBY, $user->getIdUser(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TransactionTableMap::COL_CANCELLEDBY, $user->toKeyValue('PrimaryKey', 'IdUser'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByCancelledBy() only accepts arguments of type \ShoppingList\Model\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByCancelledBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function joinUserRelatedByCancelledBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRelatedByCancelledBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserRelatedByCancelledBy');
        }

        return $this;
    }

    /**
     * Use the UserRelatedByCancelledBy relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShoppingList\Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByCancelledByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUserRelatedByCancelledBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByCancelledBy', '\ShoppingList\Model\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTransaction $transaction Object to remove from the list of results
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function prune($transaction = null)
    {
        if ($transaction) {
            $this->addUsingAlias(TransactionTableMap::COL_IDTRANSACTION, $transaction->getIdTransaction(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the transaction table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TransactionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TransactionTableMap::clearInstancePool();
            TransactionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TransactionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TransactionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            TransactionTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            TransactionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TransactionQuery
