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
use ShoppingList\Model\Invite as ChildInvite;
use ShoppingList\Model\InviteQuery as ChildInviteQuery;
use ShoppingList\Model\Map\InviteTableMap;

/**
 * Base class that represents a query for the 'invite' table.
 *
 * 
 *
 * @method     ChildInviteQuery orderByIdInvite($order = Criteria::ASC) Order by the idInvite column
 * @method     ChildInviteQuery orderByIdCommunity($order = Criteria::ASC) Order by the idCommunity column
 * @method     ChildInviteQuery orderByEmail($order = Criteria::ASC) Order by the email column
 *
 * @method     ChildInviteQuery groupByIdInvite() Group by the idInvite column
 * @method     ChildInviteQuery groupByIdCommunity() Group by the idCommunity column
 * @method     ChildInviteQuery groupByEmail() Group by the email column
 *
 * @method     ChildInviteQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInviteQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInviteQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInviteQuery leftJoinCommunity($relationAlias = null) Adds a LEFT JOIN clause to the query using the Community relation
 * @method     ChildInviteQuery rightJoinCommunity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Community relation
 * @method     ChildInviteQuery innerJoinCommunity($relationAlias = null) Adds a INNER JOIN clause to the query using the Community relation
 *
 * @method     \ShoppingList\Model\CommunityQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInvite findOne(ConnectionInterface $con = null) Return the first ChildInvite matching the query
 * @method     ChildInvite findOneOrCreate(ConnectionInterface $con = null) Return the first ChildInvite matching the query, or a new ChildInvite object populated from the query conditions when no match is found
 *
 * @method     ChildInvite findOneByIdInvite(int $idInvite) Return the first ChildInvite filtered by the idInvite column
 * @method     ChildInvite findOneByIdCommunity(int $idCommunity) Return the first ChildInvite filtered by the idCommunity column
 * @method     ChildInvite findOneByEmail(string $email) Return the first ChildInvite filtered by the email column *

 * @method     ChildInvite requirePk($key, ConnectionInterface $con = null) Return the ChildInvite by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvite requireOne(ConnectionInterface $con = null) Return the first ChildInvite matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInvite requireOneByIdInvite(int $idInvite) Return the first ChildInvite filtered by the idInvite column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvite requireOneByIdCommunity(int $idCommunity) Return the first ChildInvite filtered by the idCommunity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvite requireOneByEmail(string $email) Return the first ChildInvite filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInvite[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildInvite objects based on current ModelCriteria
 * @method     ChildInvite[]|ObjectCollection findByIdInvite(int $idInvite) Return ChildInvite objects filtered by the idInvite column
 * @method     ChildInvite[]|ObjectCollection findByIdCommunity(int $idCommunity) Return ChildInvite objects filtered by the idCommunity column
 * @method     ChildInvite[]|ObjectCollection findByEmail(string $email) Return ChildInvite objects filtered by the email column
 * @method     ChildInvite[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class InviteQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ShoppingList\Model\Base\InviteQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ShoppingList\\Model\\Invite', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInviteQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInviteQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildInviteQuery) {
            return $criteria;
        }
        $query = new ChildInviteQuery();
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
     * @return ChildInvite|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = InviteTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InviteTableMap::DATABASE_NAME);
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
     * @return ChildInvite A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idInvite, idCommunity, email FROM invite WHERE idInvite = :p0';
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
            /** @var ChildInvite $obj */
            $obj = new ChildInvite();
            $obj->hydrate($row);
            InviteTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildInvite|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildInviteQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(InviteTableMap::COL_IDINVITE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildInviteQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(InviteTableMap::COL_IDINVITE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the idInvite column
     *
     * Example usage:
     * <code>
     * $query->filterByIdInvite(1234); // WHERE idInvite = 1234
     * $query->filterByIdInvite(array(12, 34)); // WHERE idInvite IN (12, 34)
     * $query->filterByIdInvite(array('min' => 12)); // WHERE idInvite > 12
     * </code>
     *
     * @param     mixed $idInvite The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInviteQuery The current query, for fluid interface
     */
    public function filterByIdInvite($idInvite = null, $comparison = null)
    {
        if (is_array($idInvite)) {
            $useMinMax = false;
            if (isset($idInvite['min'])) {
                $this->addUsingAlias(InviteTableMap::COL_IDINVITE, $idInvite['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idInvite['max'])) {
                $this->addUsingAlias(InviteTableMap::COL_IDINVITE, $idInvite['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InviteTableMap::COL_IDINVITE, $idInvite, $comparison);
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
     * @return $this|ChildInviteQuery The current query, for fluid interface
     */
    public function filterByIdCommunity($idCommunity = null, $comparison = null)
    {
        if (is_array($idCommunity)) {
            $useMinMax = false;
            if (isset($idCommunity['min'])) {
                $this->addUsingAlias(InviteTableMap::COL_IDCOMMUNITY, $idCommunity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCommunity['max'])) {
                $this->addUsingAlias(InviteTableMap::COL_IDCOMMUNITY, $idCommunity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InviteTableMap::COL_IDCOMMUNITY, $idCommunity, $comparison);
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
     * @return $this|ChildInviteQuery The current query, for fluid interface
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

        return $this->addUsingAlias(InviteTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query by a related \ShoppingList\Model\Community object
     *
     * @param \ShoppingList\Model\Community|ObjectCollection $community The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInviteQuery The current query, for fluid interface
     */
    public function filterByCommunity($community, $comparison = null)
    {
        if ($community instanceof \ShoppingList\Model\Community) {
            return $this
                ->addUsingAlias(InviteTableMap::COL_IDCOMMUNITY, $community->getIdCommunity(), $comparison);
        } elseif ($community instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InviteTableMap::COL_IDCOMMUNITY, $community->toKeyValue('PrimaryKey', 'IdCommunity'), $comparison);
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
     * @return $this|ChildInviteQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildInvite $invite Object to remove from the list of results
     *
     * @return $this|ChildInviteQuery The current query, for fluid interface
     */
    public function prune($invite = null)
    {
        if ($invite) {
            $this->addUsingAlias(InviteTableMap::COL_IDINVITE, $invite->getIdInvite(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the invite table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InviteTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InviteTableMap::clearInstancePool();
            InviteTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(InviteTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InviteTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            InviteTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            InviteTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // InviteQuery
