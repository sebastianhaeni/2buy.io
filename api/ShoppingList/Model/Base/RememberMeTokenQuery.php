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
use ShoppingList\Model\RememberMeToken as ChildRememberMeToken;
use ShoppingList\Model\RememberMeTokenQuery as ChildRememberMeTokenQuery;
use ShoppingList\Model\Map\RememberMeTokenTableMap;

/**
 * Base class that represents a query for the 'remember_me_token' table.
 *
 * 
 *
 * @method     ChildRememberMeTokenQuery orderByIdToken($order = Criteria::ASC) Order by the idToken column
 * @method     ChildRememberMeTokenQuery orderByIdUser($order = Criteria::ASC) Order by the idUser column
 * @method     ChildRememberMeTokenQuery orderByToken($order = Criteria::ASC) Order by the token column
 * @method     ChildRememberMeTokenQuery orderByIP($order = Criteria::ASC) Order by the ip column
 * @method     ChildRememberMeTokenQuery orderByUserAgent($order = Criteria::ASC) Order by the userAgent column
 * @method     ChildRememberMeTokenQuery orderByTimestampCreated($order = Criteria::ASC) Order by the timestampCreated column
 *
 * @method     ChildRememberMeTokenQuery groupByIdToken() Group by the idToken column
 * @method     ChildRememberMeTokenQuery groupByIdUser() Group by the idUser column
 * @method     ChildRememberMeTokenQuery groupByToken() Group by the token column
 * @method     ChildRememberMeTokenQuery groupByIP() Group by the ip column
 * @method     ChildRememberMeTokenQuery groupByUserAgent() Group by the userAgent column
 * @method     ChildRememberMeTokenQuery groupByTimestampCreated() Group by the timestampCreated column
 *
 * @method     ChildRememberMeTokenQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRememberMeTokenQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRememberMeTokenQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRememberMeTokenQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildRememberMeTokenQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildRememberMeTokenQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     \ShoppingList\Model\UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRememberMeToken findOne(ConnectionInterface $con = null) Return the first ChildRememberMeToken matching the query
 * @method     ChildRememberMeToken findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRememberMeToken matching the query, or a new ChildRememberMeToken object populated from the query conditions when no match is found
 *
 * @method     ChildRememberMeToken findOneByIdToken(int $idToken) Return the first ChildRememberMeToken filtered by the idToken column
 * @method     ChildRememberMeToken findOneByIdUser(int $idUser) Return the first ChildRememberMeToken filtered by the idUser column
 * @method     ChildRememberMeToken findOneByToken(string $token) Return the first ChildRememberMeToken filtered by the token column
 * @method     ChildRememberMeToken findOneByIP(string $ip) Return the first ChildRememberMeToken filtered by the ip column
 * @method     ChildRememberMeToken findOneByUserAgent(string $userAgent) Return the first ChildRememberMeToken filtered by the userAgent column
 * @method     ChildRememberMeToken findOneByTimestampCreated(string $timestampCreated) Return the first ChildRememberMeToken filtered by the timestampCreated column *

 * @method     ChildRememberMeToken requirePk($key, ConnectionInterface $con = null) Return the ChildRememberMeToken by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRememberMeToken requireOne(ConnectionInterface $con = null) Return the first ChildRememberMeToken matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRememberMeToken requireOneByIdToken(int $idToken) Return the first ChildRememberMeToken filtered by the idToken column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRememberMeToken requireOneByIdUser(int $idUser) Return the first ChildRememberMeToken filtered by the idUser column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRememberMeToken requireOneByToken(string $token) Return the first ChildRememberMeToken filtered by the token column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRememberMeToken requireOneByIP(string $ip) Return the first ChildRememberMeToken filtered by the ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRememberMeToken requireOneByUserAgent(string $userAgent) Return the first ChildRememberMeToken filtered by the userAgent column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRememberMeToken requireOneByTimestampCreated(string $timestampCreated) Return the first ChildRememberMeToken filtered by the timestampCreated column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRememberMeToken[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRememberMeToken objects based on current ModelCriteria
 * @method     ChildRememberMeToken[]|ObjectCollection findByIdToken(int $idToken) Return ChildRememberMeToken objects filtered by the idToken column
 * @method     ChildRememberMeToken[]|ObjectCollection findByIdUser(int $idUser) Return ChildRememberMeToken objects filtered by the idUser column
 * @method     ChildRememberMeToken[]|ObjectCollection findByToken(string $token) Return ChildRememberMeToken objects filtered by the token column
 * @method     ChildRememberMeToken[]|ObjectCollection findByIP(string $ip) Return ChildRememberMeToken objects filtered by the ip column
 * @method     ChildRememberMeToken[]|ObjectCollection findByUserAgent(string $userAgent) Return ChildRememberMeToken objects filtered by the userAgent column
 * @method     ChildRememberMeToken[]|ObjectCollection findByTimestampCreated(string $timestampCreated) Return ChildRememberMeToken objects filtered by the timestampCreated column
 * @method     ChildRememberMeToken[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RememberMeTokenQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ShoppingList\Model\Base\RememberMeTokenQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ShoppingList\\Model\\RememberMeToken', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRememberMeTokenQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRememberMeTokenQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRememberMeTokenQuery) {
            return $criteria;
        }
        $query = new ChildRememberMeTokenQuery();
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
     * @return ChildRememberMeToken|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RememberMeTokenTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RememberMeTokenTableMap::DATABASE_NAME);
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
     * @return ChildRememberMeToken A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idToken, idUser, token, ip, userAgent, timestampCreated FROM remember_me_token WHERE idToken = :p0';
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
            /** @var ChildRememberMeToken $obj */
            $obj = new ChildRememberMeToken();
            $obj->hydrate($row);
            RememberMeTokenTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRememberMeToken|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRememberMeTokenQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RememberMeTokenTableMap::COL_IDTOKEN, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRememberMeTokenQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RememberMeTokenTableMap::COL_IDTOKEN, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the idToken column
     *
     * Example usage:
     * <code>
     * $query->filterByIdToken(1234); // WHERE idToken = 1234
     * $query->filterByIdToken(array(12, 34)); // WHERE idToken IN (12, 34)
     * $query->filterByIdToken(array('min' => 12)); // WHERE idToken > 12
     * </code>
     *
     * @param     mixed $idToken The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRememberMeTokenQuery The current query, for fluid interface
     */
    public function filterByIdToken($idToken = null, $comparison = null)
    {
        if (is_array($idToken)) {
            $useMinMax = false;
            if (isset($idToken['min'])) {
                $this->addUsingAlias(RememberMeTokenTableMap::COL_IDTOKEN, $idToken['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idToken['max'])) {
                $this->addUsingAlias(RememberMeTokenTableMap::COL_IDTOKEN, $idToken['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RememberMeTokenTableMap::COL_IDTOKEN, $idToken, $comparison);
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
     * @return $this|ChildRememberMeTokenQuery The current query, for fluid interface
     */
    public function filterByIdUser($idUser = null, $comparison = null)
    {
        if (is_array($idUser)) {
            $useMinMax = false;
            if (isset($idUser['min'])) {
                $this->addUsingAlias(RememberMeTokenTableMap::COL_IDUSER, $idUser['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idUser['max'])) {
                $this->addUsingAlias(RememberMeTokenTableMap::COL_IDUSER, $idUser['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RememberMeTokenTableMap::COL_IDUSER, $idUser, $comparison);
    }

    /**
     * Filter the query on the token column
     *
     * Example usage:
     * <code>
     * $query->filterByToken('fooValue');   // WHERE token = 'fooValue'
     * $query->filterByToken('%fooValue%'); // WHERE token LIKE '%fooValue%'
     * </code>
     *
     * @param     string $token The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRememberMeTokenQuery The current query, for fluid interface
     */
    public function filterByToken($token = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($token)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $token)) {
                $token = str_replace('*', '%', $token);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RememberMeTokenTableMap::COL_TOKEN, $token, $comparison);
    }

    /**
     * Filter the query on the ip column
     *
     * Example usage:
     * <code>
     * $query->filterByIP('fooValue');   // WHERE ip = 'fooValue'
     * $query->filterByIP('%fooValue%'); // WHERE ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $iP The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRememberMeTokenQuery The current query, for fluid interface
     */
    public function filterByIP($iP = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($iP)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $iP)) {
                $iP = str_replace('*', '%', $iP);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RememberMeTokenTableMap::COL_IP, $iP, $comparison);
    }

    /**
     * Filter the query on the userAgent column
     *
     * Example usage:
     * <code>
     * $query->filterByUserAgent('fooValue');   // WHERE userAgent = 'fooValue'
     * $query->filterByUserAgent('%fooValue%'); // WHERE userAgent LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userAgent The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRememberMeTokenQuery The current query, for fluid interface
     */
    public function filterByUserAgent($userAgent = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userAgent)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userAgent)) {
                $userAgent = str_replace('*', '%', $userAgent);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RememberMeTokenTableMap::COL_USERAGENT, $userAgent, $comparison);
    }

    /**
     * Filter the query on the timestampCreated column
     *
     * Example usage:
     * <code>
     * $query->filterByTimestampCreated('2011-03-14'); // WHERE timestampCreated = '2011-03-14'
     * $query->filterByTimestampCreated('now'); // WHERE timestampCreated = '2011-03-14'
     * $query->filterByTimestampCreated(array('max' => 'yesterday')); // WHERE timestampCreated > '2011-03-13'
     * </code>
     *
     * @param     mixed $timestampCreated The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRememberMeTokenQuery The current query, for fluid interface
     */
    public function filterByTimestampCreated($timestampCreated = null, $comparison = null)
    {
        if (is_array($timestampCreated)) {
            $useMinMax = false;
            if (isset($timestampCreated['min'])) {
                $this->addUsingAlias(RememberMeTokenTableMap::COL_TIMESTAMPCREATED, $timestampCreated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timestampCreated['max'])) {
                $this->addUsingAlias(RememberMeTokenTableMap::COL_TIMESTAMPCREATED, $timestampCreated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RememberMeTokenTableMap::COL_TIMESTAMPCREATED, $timestampCreated, $comparison);
    }

    /**
     * Filter the query by a related \ShoppingList\Model\User object
     *
     * @param \ShoppingList\Model\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRememberMeTokenQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \ShoppingList\Model\User) {
            return $this
                ->addUsingAlias(RememberMeTokenTableMap::COL_IDUSER, $user->getIdUser(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RememberMeTokenTableMap::COL_IDUSER, $user->toKeyValue('PrimaryKey', 'IdUser'), $comparison);
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
     * @return $this|ChildRememberMeTokenQuery The current query, for fluid interface
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
     * @param   ChildRememberMeToken $rememberMeToken Object to remove from the list of results
     *
     * @return $this|ChildRememberMeTokenQuery The current query, for fluid interface
     */
    public function prune($rememberMeToken = null)
    {
        if ($rememberMeToken) {
            $this->addUsingAlias(RememberMeTokenTableMap::COL_IDTOKEN, $rememberMeToken->getIdToken(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the remember_me_token table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RememberMeTokenTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RememberMeTokenTableMap::clearInstancePool();
            RememberMeTokenTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RememberMeTokenTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RememberMeTokenTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            RememberMeTokenTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            RememberMeTokenTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RememberMeTokenQuery
