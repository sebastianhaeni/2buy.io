<?php

namespace ShoppingList\Model\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use ShoppingList\Model\RememberMeToken;
use ShoppingList\Model\RememberMeTokenQuery;


/**
 * This class defines the structure of the 'remember_me_token' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class RememberMeTokenTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ShoppingList.Model.Map.RememberMeTokenTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'remember_me_token';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ShoppingList\\Model\\RememberMeToken';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ShoppingList.Model.RememberMeToken';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the idToken field
     */
    const COL_IDTOKEN = 'remember_me_token.idToken';

    /**
     * the column name for the idUser field
     */
    const COL_IDUSER = 'remember_me_token.idUser';

    /**
     * the column name for the token field
     */
    const COL_TOKEN = 'remember_me_token.token';

    /**
     * the column name for the ip field
     */
    const COL_IP = 'remember_me_token.ip';

    /**
     * the column name for the userAgent field
     */
    const COL_USERAGENT = 'remember_me_token.userAgent';

    /**
     * the column name for the timestampCreated field
     */
    const COL_TIMESTAMPCREATED = 'remember_me_token.timestampCreated';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('IdToken', 'IdUser', 'Token', 'IP', 'UserAgent', 'TimestampCreated', ),
        self::TYPE_CAMELNAME     => array('idToken', 'idUser', 'token', 'iP', 'userAgent', 'timestampCreated', ),
        self::TYPE_COLNAME       => array(RememberMeTokenTableMap::COL_IDTOKEN, RememberMeTokenTableMap::COL_IDUSER, RememberMeTokenTableMap::COL_TOKEN, RememberMeTokenTableMap::COL_IP, RememberMeTokenTableMap::COL_USERAGENT, RememberMeTokenTableMap::COL_TIMESTAMPCREATED, ),
        self::TYPE_FIELDNAME     => array('idToken', 'idUser', 'token', 'ip', 'userAgent', 'timestampCreated', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdToken' => 0, 'IdUser' => 1, 'Token' => 2, 'IP' => 3, 'UserAgent' => 4, 'TimestampCreated' => 5, ),
        self::TYPE_CAMELNAME     => array('idToken' => 0, 'idUser' => 1, 'token' => 2, 'iP' => 3, 'userAgent' => 4, 'timestampCreated' => 5, ),
        self::TYPE_COLNAME       => array(RememberMeTokenTableMap::COL_IDTOKEN => 0, RememberMeTokenTableMap::COL_IDUSER => 1, RememberMeTokenTableMap::COL_TOKEN => 2, RememberMeTokenTableMap::COL_IP => 3, RememberMeTokenTableMap::COL_USERAGENT => 4, RememberMeTokenTableMap::COL_TIMESTAMPCREATED => 5, ),
        self::TYPE_FIELDNAME     => array('idToken' => 0, 'idUser' => 1, 'token' => 2, 'ip' => 3, 'userAgent' => 4, 'timestampCreated' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('remember_me_token');
        $this->setPhpName('RememberMeToken');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ShoppingList\\Model\\RememberMeToken');
        $this->setPackage('ShoppingList.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('idToken', 'IdToken', 'INTEGER', true, null, null);
        $this->addForeignKey('idUser', 'IdUser', 'INTEGER', 'user', 'idUser', true, null, null);
        $this->addColumn('token', 'Token', 'VARCHAR', false, 255, null);
        $this->addColumn('ip', 'IP', 'VARCHAR', false, 45, null);
        $this->addColumn('userAgent', 'UserAgent', 'VARCHAR', false, 150, null);
        $this->addColumn('timestampCreated', 'TimestampCreated', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', '\\ShoppingList\\Model\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':idUser',
    1 => ':idUser',
  ),
), 'CASCADE', 'CASCADE', null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdToken', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdToken', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('IdToken', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? RememberMeTokenTableMap::CLASS_DEFAULT : RememberMeTokenTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (RememberMeToken object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = RememberMeTokenTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = RememberMeTokenTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + RememberMeTokenTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RememberMeTokenTableMap::OM_CLASS;
            /** @var RememberMeToken $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            RememberMeTokenTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = RememberMeTokenTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = RememberMeTokenTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var RememberMeToken $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RememberMeTokenTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(RememberMeTokenTableMap::COL_IDTOKEN);
            $criteria->addSelectColumn(RememberMeTokenTableMap::COL_IDUSER);
            $criteria->addSelectColumn(RememberMeTokenTableMap::COL_TOKEN);
            $criteria->addSelectColumn(RememberMeTokenTableMap::COL_IP);
            $criteria->addSelectColumn(RememberMeTokenTableMap::COL_USERAGENT);
            $criteria->addSelectColumn(RememberMeTokenTableMap::COL_TIMESTAMPCREATED);
        } else {
            $criteria->addSelectColumn($alias . '.idToken');
            $criteria->addSelectColumn($alias . '.idUser');
            $criteria->addSelectColumn($alias . '.token');
            $criteria->addSelectColumn($alias . '.ip');
            $criteria->addSelectColumn($alias . '.userAgent');
            $criteria->addSelectColumn($alias . '.timestampCreated');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(RememberMeTokenTableMap::DATABASE_NAME)->getTable(RememberMeTokenTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(RememberMeTokenTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(RememberMeTokenTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new RememberMeTokenTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a RememberMeToken or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or RememberMeToken object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RememberMeTokenTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ShoppingList\Model\RememberMeToken) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RememberMeTokenTableMap::DATABASE_NAME);
            $criteria->add(RememberMeTokenTableMap::COL_IDTOKEN, (array) $values, Criteria::IN);
        }

        $query = RememberMeTokenQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            RememberMeTokenTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                RememberMeTokenTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the remember_me_token table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return RememberMeTokenQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a RememberMeToken or Criteria object.
     *
     * @param mixed               $criteria Criteria or RememberMeToken object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RememberMeTokenTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from RememberMeToken object
        }

        if ($criteria->containsKey(RememberMeTokenTableMap::COL_IDTOKEN) && $criteria->keyContainsValue(RememberMeTokenTableMap::COL_IDTOKEN) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.RememberMeTokenTableMap::COL_IDTOKEN.')');
        }


        // Set the correct dbName
        $query = RememberMeTokenQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // RememberMeTokenTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
RememberMeTokenTableMap::buildTableMap();
