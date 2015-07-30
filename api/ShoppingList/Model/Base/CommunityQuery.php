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
use ShoppingList\Model\Community as ChildCommunity;
use ShoppingList\Model\CommunityQuery as ChildCommunityQuery;
use ShoppingList\Model\Map\CommunityTableMap;

/**
 * Base class that represents a query for the 'community' table.
 *
 * 
 *
 * @method     ChildCommunityQuery orderByIdCommunity($order = Criteria::ASC) Order by the idCommunity column
 * @method     ChildCommunityQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildCommunityQuery groupByIdCommunity() Group by the idCommunity column
 * @method     ChildCommunityQuery groupByName() Group by the name column
 *
 * @method     ChildCommunityQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCommunityQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCommunityQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCommunityQuery leftJoinCommunityHasUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the CommunityHasUser relation
 * @method     ChildCommunityQuery rightJoinCommunityHasUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CommunityHasUser relation
 * @method     ChildCommunityQuery innerJoinCommunityHasUser($relationAlias = null) Adds a INNER JOIN clause to the query using the CommunityHasUser relation
 *
 * @method     ChildCommunityQuery leftJoinInvite($relationAlias = null) Adds a LEFT JOIN clause to the query using the Invite relation
 * @method     ChildCommunityQuery rightJoinInvite($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Invite relation
 * @method     ChildCommunityQuery innerJoinInvite($relationAlias = null) Adds a INNER JOIN clause to the query using the Invite relation
 *
 * @method     ChildCommunityQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildCommunityQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildCommunityQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     \ShoppingList\Model\CommunityHasUserQuery|\ShoppingList\Model\InviteQuery|\ShoppingList\Model\ProductQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCommunity findOne(ConnectionInterface $con = null) Return the first ChildCommunity matching the query
 * @method     ChildCommunity findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCommunity matching the query, or a new ChildCommunity object populated from the query conditions when no match is found
 *
 * @method     ChildCommunity findOneByIdCommunity(int $idCommunity) Return the first ChildCommunity filtered by the idCommunity column
 * @method     ChildCommunity findOneByName(string $name) Return the first ChildCommunity filtered by the name column *

 * @method     ChildCommunity requirePk($key, ConnectionInterface $con = null) Return the ChildCommunity by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommunity requireOne(ConnectionInterface $con = null) Return the first ChildCommunity matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCommunity requireOneByIdCommunity(int $idCommunity) Return the first ChildCommunity filtered by the idCommunity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommunity requireOneByName(string $name) Return the first ChildCommunity filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCommunity[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCommunity objects based on current ModelCriteria
 * @method     ChildCommunity[]|ObjectCollection findByIdCommunity(int $idCommunity) Return ChildCommunity objects filtered by the idCommunity column
 * @method     ChildCommunity[]|ObjectCollection findByName(string $name) Return ChildCommunity objects filtered by the name column
 * @method     ChildCommunity[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CommunityQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ShoppingList\Model\Base\CommunityQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ShoppingList\\Model\\Community', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCommunityQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCommunityQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCommunityQuery) {
            return $criteria;
        }
        $query = new ChildCommunityQuery();
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
     * @return ChildCommunity|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CommunityTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CommunityTableMap::DATABASE_NAME);
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
     * @return ChildCommunity A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idCommunity, name FROM community WHERE idCommunity = :p0';
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
            /** @var ChildCommunity $obj */
            $obj = new ChildCommunity();
            $obj->hydrate($row);
            CommunityTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCommunity|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCommunityQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CommunityTableMap::COL_IDCOMMUNITY, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCommunityQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CommunityTableMap::COL_IDCOMMUNITY, $keys, Criteria::IN);
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
     * @param     mixed $idCommunity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommunityQuery The current query, for fluid interface
     */
    public function filterByIdCommunity($idCommunity = null, $comparison = null)
    {
        if (is_array($idCommunity)) {
            $useMinMax = false;
            if (isset($idCommunity['min'])) {
                $this->addUsingAlias(CommunityTableMap::COL_IDCOMMUNITY, $idCommunity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCommunity['max'])) {
                $this->addUsingAlias(CommunityTableMap::COL_IDCOMMUNITY, $idCommunity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommunityTableMap::COL_IDCOMMUNITY, $idCommunity, $comparison);
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
     * @return $this|ChildCommunityQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CommunityTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related \ShoppingList\Model\CommunityHasUser object
     *
     * @param \ShoppingList\Model\CommunityHasUser|ObjectCollection $communityHasUser the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCommunityQuery The current query, for fluid interface
     */
    public function filterByCommunityHasUser($communityHasUser, $comparison = null)
    {
        if ($communityHasUser instanceof \ShoppingList\Model\CommunityHasUser) {
            return $this
                ->addUsingAlias(CommunityTableMap::COL_IDCOMMUNITY, $communityHasUser->getIdCommunity(), $comparison);
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
     * @return $this|ChildCommunityQuery The current query, for fluid interface
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
     * Filter the query by a related \ShoppingList\Model\Invite object
     *
     * @param \ShoppingList\Model\Invite|ObjectCollection $invite the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCommunityQuery The current query, for fluid interface
     */
    public function filterByInvite($invite, $comparison = null)
    {
        if ($invite instanceof \ShoppingList\Model\Invite) {
            return $this
                ->addUsingAlias(CommunityTableMap::COL_IDCOMMUNITY, $invite->getIdCommunity(), $comparison);
        } elseif ($invite instanceof ObjectCollection) {
            return $this
                ->useInviteQuery()
                ->filterByPrimaryKeys($invite->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByInvite() only accepts arguments of type \ShoppingList\Model\Invite or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Invite relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommunityQuery The current query, for fluid interface
     */
    public function joinInvite($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Invite');

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
            $this->addJoinObject($join, 'Invite');
        }

        return $this;
    }

    /**
     * Use the Invite relation Invite object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShoppingList\Model\InviteQuery A secondary query class using the current class as primary query
     */
    public function useInviteQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInvite($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Invite', '\ShoppingList\Model\InviteQuery');
    }

    /**
     * Filter the query by a related \ShoppingList\Model\Product object
     *
     * @param \ShoppingList\Model\Product|ObjectCollection $product the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCommunityQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \ShoppingList\Model\Product) {
            return $this
                ->addUsingAlias(CommunityTableMap::COL_IDCOMMUNITY, $product->getIdCommunity(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            return $this
                ->useProductQuery()
                ->filterByPrimaryKeys($product->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildCommunityQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildCommunity $community Object to remove from the list of results
     *
     * @return $this|ChildCommunityQuery The current query, for fluid interface
     */
    public function prune($community = null)
    {
        if ($community) {
            $this->addUsingAlias(CommunityTableMap::COL_IDCOMMUNITY, $community->getIdCommunity(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the community table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommunityTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CommunityTableMap::clearInstancePool();
            CommunityTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CommunityTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CommunityTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            CommunityTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CommunityTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // sluggable behavior
    
    /**
     * Filter the query on the slug column
     *
     * @param     string $slug The value to use as filter.
     *
     * @return    $this|ChildCommunityQuery The current query, for fluid interface
     */
    public function filterBySlug($slug)
    {
        return $this->addUsingAlias(CommunityTableMap::COL_NAME, $slug, Criteria::EQUAL);
    }
    
    /**
     * Find one object based on its slug
     *
     * @param     string $slug The value to use as filter.
     * @param     ConnectionInterface $con The optional connection object
     *
     * @return    ChildCommunity the result, formatted by the current formatter
     */
    public function findOneBySlug($slug, $con = null)
    {
        return $this->filterBySlug($slug)->findOne($con);
    }

} // CommunityQuery
