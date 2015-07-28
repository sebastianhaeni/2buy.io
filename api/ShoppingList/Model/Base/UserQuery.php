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
use ShoppingList\Model\User as ChildUser;
use ShoppingList\Model\UserQuery as ChildUserQuery;
use ShoppingList\Model\Map\UserTableMap;

/**
 * Base class that represents a query for the 'user' table.
 *
 * 
 *
 * @method     ChildUserQuery orderByIdUser($order = Criteria::ASC) Order by the idUser column
 * @method     ChildUserQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildUserQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildUserQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildUserQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 *
 * @method     ChildUserQuery groupByIdUser() Group by the idUser column
 * @method     ChildUserQuery groupByName() Group by the name column
 * @method     ChildUserQuery groupByEmail() Group by the email column
 * @method     ChildUserQuery groupByPassword() Group by the password column
 * @method     ChildUserQuery groupByPhone() Group by the phone column
 *
 * @method     ChildUserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserQuery leftJoinCommunityHasUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the CommunityHasUser relation
 * @method     ChildUserQuery rightJoinCommunityHasUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CommunityHasUser relation
 * @method     ChildUserQuery innerJoinCommunityHasUser($relationAlias = null) Adds a INNER JOIN clause to the query using the CommunityHasUser relation
 *
 * @method     ChildUserQuery leftJoinRememberMeToken($relationAlias = null) Adds a LEFT JOIN clause to the query using the RememberMeToken relation
 * @method     ChildUserQuery rightJoinRememberMeToken($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RememberMeToken relation
 * @method     ChildUserQuery innerJoinRememberMeToken($relationAlias = null) Adds a INNER JOIN clause to the query using the RememberMeToken relation
 *
 * @method     ChildUserQuery leftJoinTransactionRelatedByReportedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TransactionRelatedByReportedBy relation
 * @method     ChildUserQuery rightJoinTransactionRelatedByReportedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TransactionRelatedByReportedBy relation
 * @method     ChildUserQuery innerJoinTransactionRelatedByReportedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TransactionRelatedByReportedBy relation
 *
 * @method     ChildUserQuery leftJoinTransactionRelatedByEditedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TransactionRelatedByEditedBy relation
 * @method     ChildUserQuery rightJoinTransactionRelatedByEditedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TransactionRelatedByEditedBy relation
 * @method     ChildUserQuery innerJoinTransactionRelatedByEditedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TransactionRelatedByEditedBy relation
 *
 * @method     ChildUserQuery leftJoinTransactionRelatedByBoughtBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TransactionRelatedByBoughtBy relation
 * @method     ChildUserQuery rightJoinTransactionRelatedByBoughtBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TransactionRelatedByBoughtBy relation
 * @method     ChildUserQuery innerJoinTransactionRelatedByBoughtBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TransactionRelatedByBoughtBy relation
 *
 * @method     ChildUserQuery leftJoinTransactionRelatedByCancelledBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TransactionRelatedByCancelledBy relation
 * @method     ChildUserQuery rightJoinTransactionRelatedByCancelledBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TransactionRelatedByCancelledBy relation
 * @method     ChildUserQuery innerJoinTransactionRelatedByCancelledBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TransactionRelatedByCancelledBy relation
 *
 * @method     \ShoppingList\Model\CommunityHasUserQuery|\ShoppingList\Model\RememberMeTokenQuery|\ShoppingList\Model\TransactionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUser findOne(ConnectionInterface $con = null) Return the first ChildUser matching the query
 * @method     ChildUser findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUser matching the query, or a new ChildUser object populated from the query conditions when no match is found
 *
 * @method     ChildUser findOneByIdUser(int $idUser) Return the first ChildUser filtered by the idUser column
 * @method     ChildUser findOneByName(string $name) Return the first ChildUser filtered by the name column
 * @method     ChildUser findOneByEmail(string $email) Return the first ChildUser filtered by the email column
 * @method     ChildUser findOneByPassword(string $password) Return the first ChildUser filtered by the password column
 * @method     ChildUser findOneByPhone(string $phone) Return the first ChildUser filtered by the phone column *

 * @method     ChildUser requirePk($key, ConnectionInterface $con = null) Return the ChildUser by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOne(ConnectionInterface $con = null) Return the first ChildUser matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUser requireOneByIdUser(int $idUser) Return the first ChildUser filtered by the idUser column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByName(string $name) Return the first ChildUser filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByEmail(string $email) Return the first ChildUser filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByPassword(string $password) Return the first ChildUser filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByPhone(string $phone) Return the first ChildUser filtered by the phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUser[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUser objects based on current ModelCriteria
 * @method     ChildUser[]|ObjectCollection findByIdUser(int $idUser) Return ChildUser objects filtered by the idUser column
 * @method     ChildUser[]|ObjectCollection findByName(string $name) Return ChildUser objects filtered by the name column
 * @method     ChildUser[]|ObjectCollection findByEmail(string $email) Return ChildUser objects filtered by the email column
 * @method     ChildUser[]|ObjectCollection findByPassword(string $password) Return ChildUser objects filtered by the password column
 * @method     ChildUser[]|ObjectCollection findByPhone(string $phone) Return ChildUser objects filtered by the phone column
 * @method     ChildUser[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ShoppingList\Model\Base\UserQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ShoppingList\\Model\\User', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserQuery) {
            return $criteria;
        }
        $query = new ChildUserQuery();
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
     * @return ChildUser|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UserTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
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
     * @return ChildUser A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idUser, name, email, password, phone FROM user WHERE idUser = :p0';
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
            /** @var ChildUser $obj */
            $obj = new ChildUser();
            $obj->hydrate($row);
            UserTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildUser|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserTableMap::COL_IDUSER, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserTableMap::COL_IDUSER, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the idUser column
     *
     * Example usage:
     * <code>
     * $query->filterByIdUser(1234); // WHERE idUser = 1234
     * $query->filterByIdUser(array(12, 34)); // WHERE idUser IN (12, 34)
     * $query->filterByIdUser(array('min' => 12)); // WHERE idUser > 12
     * </code>
     *
     * @param     mixed $idUser The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByIdUser($idUser = null, $comparison = null)
    {
        if (is_array($idUser)) {
            $useMinMax = false;
            if (isset($idUser['min'])) {
                $this->addUsingAlias(UserTableMap::COL_IDUSER, $idUser['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idUser['max'])) {
                $this->addUsingAlias(UserTableMap::COL_IDUSER, $idUser['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_IDUSER, $idUser, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%'); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $password)) {
                $password = str_replace('*', '%', $password);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the phone column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE phone = 'fooValue'
     * $query->filterByPhone('%fooValue%'); // WHERE phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $phone)) {
                $phone = str_replace('*', '%', $phone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_PHONE, $phone, $comparison);
    }

    /**
     * Filter the query by a related \ShoppingList\Model\CommunityHasUser object
     *
     * @param \ShoppingList\Model\CommunityHasUser|ObjectCollection $communityHasUser the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByCommunityHasUser($communityHasUser, $comparison = null)
    {
        if ($communityHasUser instanceof \ShoppingList\Model\CommunityHasUser) {
            return $this
                ->addUsingAlias(UserTableMap::COL_IDUSER, $communityHasUser->getIdUser(), $comparison);
        } elseif ($communityHasUser instanceof ObjectCollection) {
            return $this
                ->useCommunityHasUserQuery()
                ->filterByPrimaryKeys($communityHasUser->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCommunityHasUser() only accepts arguments of type \ShoppingList\Model\CommunityHasUser or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CommunityHasUser relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinCommunityHasUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CommunityHasUser');

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
            $this->addJoinObject($join, 'CommunityHasUser');
        }

        return $this;
    }

    /**
     * Use the CommunityHasUser relation CommunityHasUser object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShoppingList\Model\CommunityHasUserQuery A secondary query class using the current class as primary query
     */
    public function useCommunityHasUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCommunityHasUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CommunityHasUser', '\ShoppingList\Model\CommunityHasUserQuery');
    }

    /**
     * Filter the query by a related \ShoppingList\Model\RememberMeToken object
     *
     * @param \ShoppingList\Model\RememberMeToken|ObjectCollection $rememberMeToken the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByRememberMeToken($rememberMeToken, $comparison = null)
    {
        if ($rememberMeToken instanceof \ShoppingList\Model\RememberMeToken) {
            return $this
                ->addUsingAlias(UserTableMap::COL_IDUSER, $rememberMeToken->getIdUser(), $comparison);
        } elseif ($rememberMeToken instanceof ObjectCollection) {
            return $this
                ->useRememberMeTokenQuery()
                ->filterByPrimaryKeys($rememberMeToken->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRememberMeToken() only accepts arguments of type \ShoppingList\Model\RememberMeToken or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RememberMeToken relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinRememberMeToken($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RememberMeToken');

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
            $this->addJoinObject($join, 'RememberMeToken');
        }

        return $this;
    }

    /**
     * Use the RememberMeToken relation RememberMeToken object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShoppingList\Model\RememberMeTokenQuery A secondary query class using the current class as primary query
     */
    public function useRememberMeTokenQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRememberMeToken($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RememberMeToken', '\ShoppingList\Model\RememberMeTokenQuery');
    }

    /**
     * Filter the query by a related \ShoppingList\Model\Transaction object
     *
     * @param \ShoppingList\Model\Transaction|ObjectCollection $transaction the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByTransactionRelatedByReportedBy($transaction, $comparison = null)
    {
        if ($transaction instanceof \ShoppingList\Model\Transaction) {
            return $this
                ->addUsingAlias(UserTableMap::COL_IDUSER, $transaction->getReportedBy(), $comparison);
        } elseif ($transaction instanceof ObjectCollection) {
            return $this
                ->useTransactionRelatedByReportedByQuery()
                ->filterByPrimaryKeys($transaction->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTransactionRelatedByReportedBy() only accepts arguments of type \ShoppingList\Model\Transaction or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TransactionRelatedByReportedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinTransactionRelatedByReportedBy($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TransactionRelatedByReportedBy');

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
            $this->addJoinObject($join, 'TransactionRelatedByReportedBy');
        }

        return $this;
    }

    /**
     * Use the TransactionRelatedByReportedBy relation Transaction object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShoppingList\Model\TransactionQuery A secondary query class using the current class as primary query
     */
    public function useTransactionRelatedByReportedByQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTransactionRelatedByReportedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TransactionRelatedByReportedBy', '\ShoppingList\Model\TransactionQuery');
    }

    /**
     * Filter the query by a related \ShoppingList\Model\Transaction object
     *
     * @param \ShoppingList\Model\Transaction|ObjectCollection $transaction the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByTransactionRelatedByEditedBy($transaction, $comparison = null)
    {
        if ($transaction instanceof \ShoppingList\Model\Transaction) {
            return $this
                ->addUsingAlias(UserTableMap::COL_IDUSER, $transaction->getEditedBy(), $comparison);
        } elseif ($transaction instanceof ObjectCollection) {
            return $this
                ->useTransactionRelatedByEditedByQuery()
                ->filterByPrimaryKeys($transaction->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTransactionRelatedByEditedBy() only accepts arguments of type \ShoppingList\Model\Transaction or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TransactionRelatedByEditedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinTransactionRelatedByEditedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TransactionRelatedByEditedBy');

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
            $this->addJoinObject($join, 'TransactionRelatedByEditedBy');
        }

        return $this;
    }

    /**
     * Use the TransactionRelatedByEditedBy relation Transaction object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShoppingList\Model\TransactionQuery A secondary query class using the current class as primary query
     */
    public function useTransactionRelatedByEditedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTransactionRelatedByEditedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TransactionRelatedByEditedBy', '\ShoppingList\Model\TransactionQuery');
    }

    /**
     * Filter the query by a related \ShoppingList\Model\Transaction object
     *
     * @param \ShoppingList\Model\Transaction|ObjectCollection $transaction the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByTransactionRelatedByBoughtBy($transaction, $comparison = null)
    {
        if ($transaction instanceof \ShoppingList\Model\Transaction) {
            return $this
                ->addUsingAlias(UserTableMap::COL_IDUSER, $transaction->getBoughtBy(), $comparison);
        } elseif ($transaction instanceof ObjectCollection) {
            return $this
                ->useTransactionRelatedByBoughtByQuery()
                ->filterByPrimaryKeys($transaction->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTransactionRelatedByBoughtBy() only accepts arguments of type \ShoppingList\Model\Transaction or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TransactionRelatedByBoughtBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinTransactionRelatedByBoughtBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TransactionRelatedByBoughtBy');

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
            $this->addJoinObject($join, 'TransactionRelatedByBoughtBy');
        }

        return $this;
    }

    /**
     * Use the TransactionRelatedByBoughtBy relation Transaction object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShoppingList\Model\TransactionQuery A secondary query class using the current class as primary query
     */
    public function useTransactionRelatedByBoughtByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTransactionRelatedByBoughtBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TransactionRelatedByBoughtBy', '\ShoppingList\Model\TransactionQuery');
    }

    /**
     * Filter the query by a related \ShoppingList\Model\Transaction object
     *
     * @param \ShoppingList\Model\Transaction|ObjectCollection $transaction the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByTransactionRelatedByCancelledBy($transaction, $comparison = null)
    {
        if ($transaction instanceof \ShoppingList\Model\Transaction) {
            return $this
                ->addUsingAlias(UserTableMap::COL_IDUSER, $transaction->getCancelledBy(), $comparison);
        } elseif ($transaction instanceof ObjectCollection) {
            return $this
                ->useTransactionRelatedByCancelledByQuery()
                ->filterByPrimaryKeys($transaction->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTransactionRelatedByCancelledBy() only accepts arguments of type \ShoppingList\Model\Transaction or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TransactionRelatedByCancelledBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinTransactionRelatedByCancelledBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TransactionRelatedByCancelledBy');

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
            $this->addJoinObject($join, 'TransactionRelatedByCancelledBy');
        }

        return $this;
    }

    /**
     * Use the TransactionRelatedByCancelledBy relation Transaction object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShoppingList\Model\TransactionQuery A secondary query class using the current class as primary query
     */
    public function useTransactionRelatedByCancelledByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTransactionRelatedByCancelledBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TransactionRelatedByCancelledBy', '\ShoppingList\Model\TransactionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUser $user Object to remove from the list of results
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function prune($user = null)
    {
        if ($user) {
            $this->addUsingAlias(UserTableMap::COL_IDUSER, $user->getIdUser(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserTableMap::clearInstancePool();
            UserTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            UserTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            UserTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UserQuery
