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
use ShoppingList\Model\Transaction;
use ShoppingList\Model\TransactionQuery;


/**
 * This class defines the structure of the 'transaction' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TransactionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ShoppingList.Model.Map.TransactionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'transaction';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ShoppingList\\Model\\Transaction';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ShoppingList.Model.Transaction';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the idTransaction field
     */
    const COL_IDTRANSACTION = 'transaction.idTransaction';

    /**
     * the column name for the idProduct field
     */
    const COL_IDPRODUCT = 'transaction.idProduct';

    /**
     * the column name for the reportedBy field
     */
    const COL_REPORTEDBY = 'transaction.reportedBy';

    /**
     * the column name for the reportedDate field
     */
    const COL_REPORTEDDATE = 'transaction.reportedDate';

    /**
     * the column name for the editedBy field
     */
    const COL_EDITEDBY = 'transaction.editedBy';

    /**
     * the column name for the amount field
     */
    const COL_AMOUNT = 'transaction.amount';

    /**
     * the column name for the boughtBy field
     */
    const COL_BOUGHTBY = 'transaction.boughtBy';

    /**
     * the column name for the cancelled field
     */
    const COL_CANCELLED = 'transaction.cancelled';

    /**
     * the column name for the cancelledBy field
     */
    const COL_CANCELLEDBY = 'transaction.cancelledBy';

    /**
     * the column name for the closeDate field
     */
    const COL_CLOSEDATE = 'transaction.closeDate';

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
        self::TYPE_PHPNAME       => array('IdTransaction', 'IdProduct', 'ReportedBy', 'ReportedDate', 'EditedBy', 'Amount', 'BoughtBy', 'Cancelled', 'CancelledBy', 'CloseDate', ),
        self::TYPE_CAMELNAME     => array('idTransaction', 'idProduct', 'reportedBy', 'reportedDate', 'editedBy', 'amount', 'boughtBy', 'cancelled', 'cancelledBy', 'closeDate', ),
        self::TYPE_COLNAME       => array(TransactionTableMap::COL_IDTRANSACTION, TransactionTableMap::COL_IDPRODUCT, TransactionTableMap::COL_REPORTEDBY, TransactionTableMap::COL_REPORTEDDATE, TransactionTableMap::COL_EDITEDBY, TransactionTableMap::COL_AMOUNT, TransactionTableMap::COL_BOUGHTBY, TransactionTableMap::COL_CANCELLED, TransactionTableMap::COL_CANCELLEDBY, TransactionTableMap::COL_CLOSEDATE, ),
        self::TYPE_FIELDNAME     => array('idTransaction', 'idProduct', 'reportedBy', 'reportedDate', 'editedBy', 'amount', 'boughtBy', 'cancelled', 'cancelledBy', 'closeDate', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdTransaction' => 0, 'IdProduct' => 1, 'ReportedBy' => 2, 'ReportedDate' => 3, 'EditedBy' => 4, 'Amount' => 5, 'BoughtBy' => 6, 'Cancelled' => 7, 'CancelledBy' => 8, 'CloseDate' => 9, ),
        self::TYPE_CAMELNAME     => array('idTransaction' => 0, 'idProduct' => 1, 'reportedBy' => 2, 'reportedDate' => 3, 'editedBy' => 4, 'amount' => 5, 'boughtBy' => 6, 'cancelled' => 7, 'cancelledBy' => 8, 'closeDate' => 9, ),
        self::TYPE_COLNAME       => array(TransactionTableMap::COL_IDTRANSACTION => 0, TransactionTableMap::COL_IDPRODUCT => 1, TransactionTableMap::COL_REPORTEDBY => 2, TransactionTableMap::COL_REPORTEDDATE => 3, TransactionTableMap::COL_EDITEDBY => 4, TransactionTableMap::COL_AMOUNT => 5, TransactionTableMap::COL_BOUGHTBY => 6, TransactionTableMap::COL_CANCELLED => 7, TransactionTableMap::COL_CANCELLEDBY => 8, TransactionTableMap::COL_CLOSEDATE => 9, ),
        self::TYPE_FIELDNAME     => array('idTransaction' => 0, 'idProduct' => 1, 'reportedBy' => 2, 'reportedDate' => 3, 'editedBy' => 4, 'amount' => 5, 'boughtBy' => 6, 'cancelled' => 7, 'cancelledBy' => 8, 'closeDate' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('transaction');
        $this->setPhpName('Transaction');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ShoppingList\\Model\\Transaction');
        $this->setPackage('ShoppingList.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('idTransaction', 'IdTransaction', 'INTEGER', true, null, null);
        $this->addForeignKey('idProduct', 'IdProduct', 'INTEGER', 'product', 'idProduct', true, null, null);
        $this->addForeignKey('reportedBy', 'ReportedBy', 'INTEGER', 'user', 'idUser', true, null, null);
        $this->addColumn('reportedDate', 'ReportedDate', 'TIMESTAMP', true, null, null);
        $this->addForeignKey('editedBy', 'EditedBy', 'INTEGER', 'user', 'idUser', false, null, null);
        $this->addColumn('amount', 'Amount', 'INTEGER', true, null, null);
        $this->addForeignKey('boughtBy', 'BoughtBy', 'INTEGER', 'user', 'idUser', false, null, null);
        $this->addColumn('cancelled', 'Cancelled', 'BOOLEAN', true, 1, false);
        $this->addForeignKey('cancelledBy', 'CancelledBy', 'INTEGER', 'user', 'idUser', false, null, null);
        $this->addColumn('closeDate', 'CloseDate', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Product', '\\ShoppingList\\Model\\Product', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':idProduct',
    1 => ':idProduct',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('UserRelatedByReportedBy', '\\ShoppingList\\Model\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':reportedBy',
    1 => ':idUser',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('UserRelatedByEditedBy', '\\ShoppingList\\Model\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':editedBy',
    1 => ':idUser',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('UserRelatedByBoughtBy', '\\ShoppingList\\Model\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':boughtBy',
    1 => ':idUser',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('UserRelatedByCancelledBy', '\\ShoppingList\\Model\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':cancelledBy',
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTransaction', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTransaction', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdTransaction', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? TransactionTableMap::CLASS_DEFAULT : TransactionTableMap::OM_CLASS;
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
     * @return array           (Transaction object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TransactionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TransactionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TransactionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TransactionTableMap::OM_CLASS;
            /** @var Transaction $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TransactionTableMap::addInstanceToPool($obj, $key);
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
            $key = TransactionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TransactionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Transaction $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TransactionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TransactionTableMap::COL_IDTRANSACTION);
            $criteria->addSelectColumn(TransactionTableMap::COL_IDPRODUCT);
            $criteria->addSelectColumn(TransactionTableMap::COL_REPORTEDBY);
            $criteria->addSelectColumn(TransactionTableMap::COL_REPORTEDDATE);
            $criteria->addSelectColumn(TransactionTableMap::COL_EDITEDBY);
            $criteria->addSelectColumn(TransactionTableMap::COL_AMOUNT);
            $criteria->addSelectColumn(TransactionTableMap::COL_BOUGHTBY);
            $criteria->addSelectColumn(TransactionTableMap::COL_CANCELLED);
            $criteria->addSelectColumn(TransactionTableMap::COL_CANCELLEDBY);
            $criteria->addSelectColumn(TransactionTableMap::COL_CLOSEDATE);
        } else {
            $criteria->addSelectColumn($alias . '.idTransaction');
            $criteria->addSelectColumn($alias . '.idProduct');
            $criteria->addSelectColumn($alias . '.reportedBy');
            $criteria->addSelectColumn($alias . '.reportedDate');
            $criteria->addSelectColumn($alias . '.editedBy');
            $criteria->addSelectColumn($alias . '.amount');
            $criteria->addSelectColumn($alias . '.boughtBy');
            $criteria->addSelectColumn($alias . '.cancelled');
            $criteria->addSelectColumn($alias . '.cancelledBy');
            $criteria->addSelectColumn($alias . '.closeDate');
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
        return Propel::getServiceContainer()->getDatabaseMap(TransactionTableMap::DATABASE_NAME)->getTable(TransactionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TransactionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TransactionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TransactionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Transaction or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Transaction object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TransactionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ShoppingList\Model\Transaction) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TransactionTableMap::DATABASE_NAME);
            $criteria->add(TransactionTableMap::COL_IDTRANSACTION, (array) $values, Criteria::IN);
        }

        $query = TransactionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TransactionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TransactionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the transaction table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TransactionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Transaction or Criteria object.
     *
     * @param mixed               $criteria Criteria or Transaction object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TransactionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Transaction object
        }

        if ($criteria->containsKey(TransactionTableMap::COL_IDTRANSACTION) && $criteria->keyContainsValue(TransactionTableMap::COL_IDTRANSACTION) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TransactionTableMap::COL_IDTRANSACTION.')');
        }


        // Set the correct dbName
        $query = TransactionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TransactionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TransactionTableMap::buildTableMap();
