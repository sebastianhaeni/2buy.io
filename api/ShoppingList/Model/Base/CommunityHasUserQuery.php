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
use ShoppingList\Model\CommunityHasUser as ChildCommunityHasUser;
use ShoppingList\Model\CommunityHasUserQuery as ChildCommunityHasUserQuery;
use ShoppingList\Model\Map\CommunityHasUserTableMap;

/**
 * Base class that represents a query for the 'community_has_user' table.
 *
 * 
 *
 * @method     ChildCommunityHasUserQuery orderByIdCommunity($order = Criteria::ASC) Order by the idCommunity column
 * @method     ChildCommunityHasUserQuery orderByIdUser($order = Criteria::ASC) Order by the idUser column
 * @method     ChildCommunityHasUserQuery orderByAdmin($order = Criteria::ASC) Order by the admin column
 * @method     ChildCommunityHasUserQuery orderByReceiveNotifications($order = Criteria::ASC) Order by the receiveNotifications column
 *
 * @method     ChildCommunityHasUserQuery groupByIdCommunity() Group by the idCommunity column
 * @method     ChildCommunityHasUserQuery groupByIdUser() Group by the idUser column
 * @method     ChildCommunityHasUserQuery groupByAdmin() Group by the admin column
 * @method     ChildCommunityHasUserQuery groupByReceiveNotifications() Group by the receiveNotifications column
 *
 * @method     ChildCommunityHasUserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCommunityHasUserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCommunityHasUserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCommunityHasUserQuery leftJoinCommunity($relationAlias = null) Adds a LEFT JOIN clause to the query using the Community relation
 * @method     ChildCommunityHasUserQuery rightJoinCommunity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Community relation
 * @method     ChildCommunityHasUserQuery innerJoinCommunity($relationAlias = null) Adds a INNER JOIN clause to the query using the Community relation
 *
 * @method     ChildCommunityHasUserQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildCommunityHasUserQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildCommunityHasUserQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     \ShoppingList\Model\CommunityQuery|\ShoppingList\Model\UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCommunityHasUser findOne(ConnectionInterface $con = null) Return the first ChildCommunityHasUser matching the query
 * @method     ChildCommunityHasUser findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCommunityHasUser matching the query, or a new ChildCommunityHasUser object populated from the query conditions when no match is found
 *
 * @method     ChildCommunityHasUser findOneByIdCommunity(int $idCommunity) Return the first ChildCommunityHasUser filtered by the idCommunity column
 * @method     ChildCommunityHasUser findOneByIdUser(int $idUser) Return the first ChildCommunityHasUser filtered by the idUser column
 * @method     ChildCommunityHasUser findOneByAdmin(boolean $admin) Return the first ChildCommunityHasUser filtered by the admin column
 * @method     ChildCommunityHasUser findOneByReceiveNotifications(boolean $receiveNotifications) Return the first ChildCommunityHasUser filtered by the receiveNotifications column *

 * @method     ChildCommunityHasUser requirePk($key, ConnectionInterface $con = null) Return the ChildCommunityHasUser by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommunityHasUser requireOne(ConnectionInterface $con = null) Return the first ChildCommunityHasUser matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCommunityHasUser requireOneByIdCommunity(int $idCommunity) Return the first ChildCommunityHasUser filtered by the idCommunity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommunityHasUser requireOneByIdUser(int $idUser) Return the first ChildCommunityHasUser filtered by the idUser column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommunityHasUser requireOneByAdmin(boolean $admin) Return the first ChildCommunityHasUser filtered by the admin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommunityHasUser requireOneByReceiveNotifications(boolean $receiveNotifications) Return the first ChildCommunityHasUser filtered by the receiveNotifications column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCommunityHasUser[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCommunityHasUser objects based on current ModelCriteria
 * @method     ChildCommunityHasUser[]|ObjectCollection findByIdCommunity(int $idCommunity) Return ChildCommunityHasUser objects filtered by the idCommunity column
 * @method     ChildCommunityHasUser[]|ObjectCollection findByIdUser(int $idUser) Return ChildCommunityHasUser objects filtered by the idUser column
 * @method     ChildCommunityHasUser[]|ObjectCollection findByAdmin(boolean $admin) Return ChildCommunityHasUser objects filtered by the admin column
 * @method     ChildCommunityHasUser[]|ObjectCollection findByReceiveNotifications(boolean $receiveNotifications) Return ChildCommunityHasUser objects filtered by the receiveNotifications column
 * @method     ChildCommunityHasUser[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CommunityHasUserQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ShoppingList\Model\Base\CommunityHasUserQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ShoppingList\\Model\\CommunityHasUser', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCommunityHasUserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCommunityHasUserQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCommunityHasUserQuery) {
            return $criteria;
        }
        $query = new ChildCommunityHasUserQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$idCommunity, $idUser] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCommunityHasUser|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CommunityHasUserTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CommunityHasUserTableMap::DATABASE_NAME);
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
     * @return ChildCommunityHasUser A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idCommunity, idUser, admin, receiveNotifications FROM community_has_user WHERE idCommunity = :p0 AND idUser = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCommunityHasUser $obj */
            $obj = new ChildCommunityHasUser();
            $obj->hydrate($row);
            CommunityHasUserTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildCommunityHasUser|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildCommunityHasUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CommunityHasUserTableMap::COL_IDCOMMUNITY, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CommunityHasUserTableMap::COL_IDUSER, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCommunityHasUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CommunityHasUserTableMap::COL_IDCOMMUNITY, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CommunityHasUserTableMap::COL_IDUSER, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the idCommunity column
     *
     * Example usage:
     * <code>
     * $query->filterByIdCommunity(1234); // WHERE idCommunity = 1234
     * $query->filterByIdCommunity(array(12, 34)); // WHERE idCommunity IN (12, 34)
     * $query->filterByIdCommunity(array('min' => 12)); // WHERE idCommunity > 12
     * </code>
     *
     * @see       filterByCommunity()
     *
     * @param     mixed $idCommunity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommunityHasUserQuery The current query, for fluid interface
     */
    public function filterByIdCommunity($idCommunity = null, $comparison = null)
    {
        if (is_array($idCommunity)) {
            $useMinMax = false;
            if (isset($idCommunity['min'])) {
                $this->addUsingAlias(CommunityHasUserTableMap::COL_IDCOMMUNITY, $idCommunity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCommunity['max'])) {
                $this->addUsingAlias(CommunityHasUserTableMap::COL_IDCOMMUNITY, $idCommunity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommunityHasUserTableMap::COL_IDCOMMUNITY, $idCommunity, $comparison);
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
     * @see       filterByUser()
     *
     * @param     mixed $idUser The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommunityHasUserQuery The current query, for fluid interface
     */
    public function filterByIdUser($idUser = null, $comparison = null)
    {
        if (is_array($idUser)) {
            $useMinMax = false;
            if (isset($idUser['min'])) {
                $this->addUsingAlias(CommunityHasUserTableMap::COL_IDUSER, $idUser['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idUser['max'])) {
                $this->addUsingAlias(CommunityHasUserTableMap::COL_IDUSER, $idUser['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommunityHasUserTableMap::COL_IDUSER, $idUser, $comparison);
    }

    /**
     * Filter the query on the admin column
     *
     * Example usage:
     * <code>
     * $query->filterByAdmin(true); // WHERE admin = true
     * $query->filterByAdmin('yes'); // WHERE admin = true
     * </code>
     *
     * @param     boolean|string $admin The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommunityHasUserQuery The current query, for fluid interface
     */
    public function filterByAdmin($admin = null, $comparison = null)
    {
        if (is_string($admin)) {
            $admin = in_array(strtolower($admin), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CommunityHasUserTableMap::COL_ADMIN, $admin, $comparison);
    }

    /**
     * Filter the query on the receiveNotifications column
     *
     * Example usage:
     * <code>
     * $query->filterByReceiveNotifications(true); // WHERE receiveNotifications = true
     * $query->filterByReceiveNotifications('yes'); // WHERE receiveNotifications = true
     * </code>
     *
     * @param     boolean|string $receiveNotifications The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommunityHasUserQuery The current query, for fluid interface
     */
    public function filterByReceiveNotifications($receiveNotifications = null, $comparison = null)
    {
        if (is_string($receiveNotifications)) {
            $receiveNotifications = in_array(strtolower($receiveNotifications), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CommunityHasUserTableMap::COL_RECEIVENOTIFICATIONS, $receiveNotifications, $comparison);
    }

    /**
     * Filter the query by a related \ShoppingList\Model\Community object
     *
     * @param \ShoppingList\Model\Community|ObjectCollection $community The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCommunityHasUserQuery The current query, for fluid interface
     */
    public function filterByCommunity($community, $comparison = null)
    {
        if ($community instanceof \ShoppingList\Model\Community) {
            return $this
                ->addUsingAlias(CommunityHasUserTableMap::COL_IDCOMMUNITY, $community->getIdCommunity(), $comparison);
        } elseif ($community instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommunityHasUserTableMap::COL_IDCOMMUNITY, $community->toKeyValue('PrimaryKey', 'IdCommunity'), $comparison);
        } else {
            throw new PropelException('filterByCommunity() only accepts arguments of type \ShoppingList\Model\Community or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Community relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommunityHasUserQuery The current query, for fluid interface
     */
    public function joinCommunity($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Community');

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
            $this->addJoinObject($join, 'Community');
        }

        return $this;
    }

    /**
     * Use the Community relation Community object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShoppingList\Model\CommunityQuery A secondary query class using the current class as primary query
     */
    public function useCommunityQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCommunity($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Community', '\ShoppingList\Model\CommunityQuery');
    }

    /**
     * Filter the query by a related \ShoppingList\Model\User object
     *
     * @param \ShoppingList\Model\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCommunityHasUserQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \ShoppingList\Model\User) {
            return $this
                ->addUsingAlias(CommunityHasUserTableMap::COL_IDUSER, $user->getIdUser(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommunityHasUserTableMap::COL_IDUSER, $user->toKeyValue('PrimaryKey', 'IdUser'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \ShoppingList\Model\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommunityHasUserQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShoppingList\Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\ShoppingList\Model\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCommunityHasUser $communityHasUser Object to remove from the list of results
     *
     * @return $this|ChildCommunityHasUserQuery The current query, for fluid interface
     */
    public function prune($communityHasUser = null)
    {
        if ($communityHasUser) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CommunityHasUserTableMap::COL_IDCOMMUNITY), $communityHasUser->getIdCommunity(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CommunityHasUserTableMap::COL_IDUSER), $communityHasUser->getIdUser(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the community_has_user table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommunityHasUserTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CommunityHasUserTableMap::clearInstancePool();
            CommunityHasUserTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CommunityHasUserTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CommunityHasUserTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            CommunityHasUserTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CommunityHasUserTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CommunityHasUserQuery
