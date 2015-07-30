<?php

namespace ShoppingList\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use ShoppingList\Model\Community as ChildCommunity;
use ShoppingList\Model\CommunityHasUser as ChildCommunityHasUser;
use ShoppingList\Model\CommunityHasUserQuery as ChildCommunityHasUserQuery;
use ShoppingList\Model\CommunityQuery as ChildCommunityQuery;
use ShoppingList\Model\Invite as ChildInvite;
use ShoppingList\Model\InviteQuery as ChildInviteQuery;
use ShoppingList\Model\Product as ChildProduct;
use ShoppingList\Model\ProductQuery as ChildProductQuery;
use ShoppingList\Model\Map\CommunityTableMap;

/**
 * Base class that represents a row from the 'community' table.
 *
 * 
 *
* @package    propel.generator.ShoppingList.Model.Base
*/
abstract class Community implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\ShoppingList\\Model\\Map\\CommunityTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the idcommunity field.
     * @var        int
     */
    protected $idcommunity;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * @var        ObjectCollection|ChildCommunityHasUser[] Collection to store aggregation of ChildCommunityHasUser objects.
     */
    protected $collCommunityHasUsers;
    protected $collCommunityHasUsersPartial;

    /**
     * @var        ObjectCollection|ChildInvite[] Collection to store aggregation of ChildInvite objects.
     */
    protected $collInvites;
    protected $collInvitesPartial;

    /**
     * @var        ObjectCollection|ChildProduct[] Collection to store aggregation of ChildProduct objects.
     */
    protected $collProducts;
    protected $collProductsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCommunityHasUser[]
     */
    protected $communityHasUsersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildInvite[]
     */
    protected $invitesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildProduct[]
     */
    protected $productsScheduledForDeletion = null;

    /**
     * Initializes internal state of ShoppingList\Model\Base\Community object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Community</code> instance.  If
     * <code>obj</code> is an instance of <code>Community</code>, delegates to
     * <code>equals(Community)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Community The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [idcommunity] column value.
     * 
     * @return int
     */
    public function getIdCommunity()
    {
        return $this->idcommunity;
    }

    /**
     * Get the [name] column value.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of [idcommunity] column.
     * 
     * @param int $v new value
     * @return $this|\ShoppingList\Model\Community The current object (for fluent API support)
     */
    public function setIdCommunity($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->idcommunity !== $v) {
            $this->idcommunity = $v;
            $this->modifiedColumns[CommunityTableMap::COL_IDCOMMUNITY] = true;
        }

        return $this;
    } // setIdCommunity()

    /**
     * Set the value of [name] column.
     * 
     * @param string $v new value
     * @return $this|\ShoppingList\Model\Community The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[CommunityTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CommunityTableMap::translateFieldName('IdCommunity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->idcommunity = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CommunityTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = CommunityTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ShoppingList\\Model\\Community'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CommunityTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCommunityQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCommunityHasUsers = null;

            $this->collInvites = null;

            $this->collProducts = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Community::setDeleted()
     * @see Community::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommunityTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCommunityQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommunityTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            // sluggable behavior
            
            if ($this->isColumnModified(CommunityTableMap::COL_NAME) && $this->getName()) {
                $this->setName($this->makeSlugUnique($this->getName()));
            } else {
                $this->setName($this->createSlug());
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                CommunityTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->communityHasUsersScheduledForDeletion !== null) {
                if (!$this->communityHasUsersScheduledForDeletion->isEmpty()) {
                    \ShoppingList\Model\CommunityHasUserQuery::create()
                        ->filterByPrimaryKeys($this->communityHasUsersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->communityHasUsersScheduledForDeletion = null;
                }
            }

            if ($this->collCommunityHasUsers !== null) {
                foreach ($this->collCommunityHasUsers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->invitesScheduledForDeletion !== null) {
                if (!$this->invitesScheduledForDeletion->isEmpty()) {
                    \ShoppingList\Model\InviteQuery::create()
                        ->filterByPrimaryKeys($this->invitesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->invitesScheduledForDeletion = null;
                }
            }

            if ($this->collInvites !== null) {
                foreach ($this->collInvites as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->productsScheduledForDeletion !== null) {
                if (!$this->productsScheduledForDeletion->isEmpty()) {
                    \ShoppingList\Model\ProductQuery::create()
                        ->filterByPrimaryKeys($this->productsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->productsScheduledForDeletion = null;
                }
            }

            if ($this->collProducts !== null) {
                foreach ($this->collProducts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[CommunityTableMap::COL_IDCOMMUNITY] = true;
        if (null !== $this->idcommunity) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CommunityTableMap::COL_IDCOMMUNITY . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CommunityTableMap::COL_IDCOMMUNITY)) {
            $modifiedColumns[':p' . $index++]  = 'idCommunity';
        }
        if ($this->isColumnModified(CommunityTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }

        $sql = sprintf(
            'INSERT INTO community (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'idCommunity':                        
                        $stmt->bindValue($identifier, $this->idcommunity, PDO::PARAM_INT);
                        break;
                    case 'name':                        
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setIdCommunity($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CommunityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getIdCommunity();
                break;
            case 1:
                return $this->getName();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Community'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Community'][$this->hashCode()] = true;
        $keys = CommunityTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdCommunity(),
            $keys[1] => $this->getName(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->collCommunityHasUsers) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'communityHasUsers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'community_has_users';
                        break;
                    default:
                        $key = 'CommunityHasUsers';
                }
        
                $result[$key] = $this->collCommunityHasUsers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collInvites) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'invites';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'invites';
                        break;
                    default:
                        $key = 'Invites';
                }
        
                $result[$key] = $this->collInvites->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProducts) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'products';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'products';
                        break;
                    default:
                        $key = 'Products';
                }
        
                $result[$key] = $this->collProducts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\ShoppingList\Model\Community
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CommunityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ShoppingList\Model\Community
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdCommunity($value);
                break;
            case 1:
                $this->setName($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = CommunityTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdCommunity($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\ShoppingList\Model\Community The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CommunityTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CommunityTableMap::COL_IDCOMMUNITY)) {
            $criteria->add(CommunityTableMap::COL_IDCOMMUNITY, $this->idcommunity);
        }
        if ($this->isColumnModified(CommunityTableMap::COL_NAME)) {
            $criteria->add(CommunityTableMap::COL_NAME, $this->name);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildCommunityQuery::create();
        $criteria->add(CommunityTableMap::COL_IDCOMMUNITY, $this->idcommunity);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getIdCommunity();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }
        
    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdCommunity();
    }

    /**
     * Generic method to set the primary key (idcommunity column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdCommunity($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdCommunity();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \ShoppingList\Model\Community (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCommunityHasUsers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCommunityHasUser($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getInvites() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addInvite($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProducts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProduct($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdCommunity(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \ShoppingList\Model\Community Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('CommunityHasUser' == $relationName) {
            return $this->initCommunityHasUsers();
        }
        if ('Invite' == $relationName) {
            return $this->initInvites();
        }
        if ('Product' == $relationName) {
            return $this->initProducts();
        }
    }

    /**
     * Clears out the collCommunityHasUsers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCommunityHasUsers()
     */
    public function clearCommunityHasUsers()
    {
        $this->collCommunityHasUsers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCommunityHasUsers collection loaded partially.
     */
    public function resetPartialCommunityHasUsers($v = true)
    {
        $this->collCommunityHasUsersPartial = $v;
    }

    /**
     * Initializes the collCommunityHasUsers collection.
     *
     * By default this just sets the collCommunityHasUsers collection to an empty array (like clearcollCommunityHasUsers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCommunityHasUsers($overrideExisting = true)
    {
        if (null !== $this->collCommunityHasUsers && !$overrideExisting) {
            return;
        }
        $this->collCommunityHasUsers = new ObjectCollection();
        $this->collCommunityHasUsers->setModel('\ShoppingList\Model\CommunityHasUser');
    }

    /**
     * Gets an array of ChildCommunityHasUser objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCommunity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCommunityHasUser[] List of ChildCommunityHasUser objects
     * @throws PropelException
     */
    public function getCommunityHasUsers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCommunityHasUsersPartial && !$this->isNew();
        if (null === $this->collCommunityHasUsers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCommunityHasUsers) {
                // return empty collection
                $this->initCommunityHasUsers();
            } else {
                $collCommunityHasUsers = ChildCommunityHasUserQuery::create(null, $criteria)
                    ->filterByCommunity($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCommunityHasUsersPartial && count($collCommunityHasUsers)) {
                        $this->initCommunityHasUsers(false);

                        foreach ($collCommunityHasUsers as $obj) {
                            if (false == $this->collCommunityHasUsers->contains($obj)) {
                                $this->collCommunityHasUsers->append($obj);
                            }
                        }

                        $this->collCommunityHasUsersPartial = true;
                    }

                    return $collCommunityHasUsers;
                }

                if ($partial && $this->collCommunityHasUsers) {
                    foreach ($this->collCommunityHasUsers as $obj) {
                        if ($obj->isNew()) {
                            $collCommunityHasUsers[] = $obj;
                        }
                    }
                }

                $this->collCommunityHasUsers = $collCommunityHasUsers;
                $this->collCommunityHasUsersPartial = false;
            }
        }

        return $this->collCommunityHasUsers;
    }

    /**
     * Sets a collection of ChildCommunityHasUser objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $communityHasUsers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCommunity The current object (for fluent API support)
     */
    public function setCommunityHasUsers(Collection $communityHasUsers, ConnectionInterface $con = null)
    {
        /** @var ChildCommunityHasUser[] $communityHasUsersToDelete */
        $communityHasUsersToDelete = $this->getCommunityHasUsers(new Criteria(), $con)->diff($communityHasUsers);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->communityHasUsersScheduledForDeletion = clone $communityHasUsersToDelete;

        foreach ($communityHasUsersToDelete as $communityHasUserRemoved) {
            $communityHasUserRemoved->setCommunity(null);
        }

        $this->collCommunityHasUsers = null;
        foreach ($communityHasUsers as $communityHasUser) {
            $this->addCommunityHasUser($communityHasUser);
        }

        $this->collCommunityHasUsers = $communityHasUsers;
        $this->collCommunityHasUsersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CommunityHasUser objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CommunityHasUser objects.
     * @throws PropelException
     */
    public function countCommunityHasUsers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCommunityHasUsersPartial && !$this->isNew();
        if (null === $this->collCommunityHasUsers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCommunityHasUsers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCommunityHasUsers());
            }

            $query = ChildCommunityHasUserQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCommunity($this)
                ->count($con);
        }

        return count($this->collCommunityHasUsers);
    }

    /**
     * Method called to associate a ChildCommunityHasUser object to this object
     * through the ChildCommunityHasUser foreign key attribute.
     *
     * @param  ChildCommunityHasUser $l ChildCommunityHasUser
     * @return $this|\ShoppingList\Model\Community The current object (for fluent API support)
     */
    public function addCommunityHasUser(ChildCommunityHasUser $l)
    {
        if ($this->collCommunityHasUsers === null) {
            $this->initCommunityHasUsers();
            $this->collCommunityHasUsersPartial = true;
        }

        if (!$this->collCommunityHasUsers->contains($l)) {
            $this->doAddCommunityHasUser($l);
        }

        return $this;
    }

    /**
     * @param ChildCommunityHasUser $communityHasUser The ChildCommunityHasUser object to add.
     */
    protected function doAddCommunityHasUser(ChildCommunityHasUser $communityHasUser)
    {
        $this->collCommunityHasUsers[]= $communityHasUser;
        $communityHasUser->setCommunity($this);
    }

    /**
     * @param  ChildCommunityHasUser $communityHasUser The ChildCommunityHasUser object to remove.
     * @return $this|ChildCommunity The current object (for fluent API support)
     */
    public function removeCommunityHasUser(ChildCommunityHasUser $communityHasUser)
    {
        if ($this->getCommunityHasUsers()->contains($communityHasUser)) {
            $pos = $this->collCommunityHasUsers->search($communityHasUser);
            $this->collCommunityHasUsers->remove($pos);
            if (null === $this->communityHasUsersScheduledForDeletion) {
                $this->communityHasUsersScheduledForDeletion = clone $this->collCommunityHasUsers;
                $this->communityHasUsersScheduledForDeletion->clear();
            }
            $this->communityHasUsersScheduledForDeletion[]= clone $communityHasUser;
            $communityHasUser->setCommunity(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Community is new, it will return
     * an empty collection; or if this Community has previously
     * been saved, it will retrieve related CommunityHasUsers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Community.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCommunityHasUser[] List of ChildCommunityHasUser objects
     */
    public function getCommunityHasUsersJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommunityHasUserQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getCommunityHasUsers($query, $con);
    }

    /**
     * Clears out the collInvites collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addInvites()
     */
    public function clearInvites()
    {
        $this->collInvites = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collInvites collection loaded partially.
     */
    public function resetPartialInvites($v = true)
    {
        $this->collInvitesPartial = $v;
    }

    /**
     * Initializes the collInvites collection.
     *
     * By default this just sets the collInvites collection to an empty array (like clearcollInvites());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initInvites($overrideExisting = true)
    {
        if (null !== $this->collInvites && !$overrideExisting) {
            return;
        }
        $this->collInvites = new ObjectCollection();
        $this->collInvites->setModel('\ShoppingList\Model\Invite');
    }

    /**
     * Gets an array of ChildInvite objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCommunity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildInvite[] List of ChildInvite objects
     * @throws PropelException
     */
    public function getInvites(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collInvitesPartial && !$this->isNew();
        if (null === $this->collInvites || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collInvites) {
                // return empty collection
                $this->initInvites();
            } else {
                $collInvites = ChildInviteQuery::create(null, $criteria)
                    ->filterByCommunity($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collInvitesPartial && count($collInvites)) {
                        $this->initInvites(false);

                        foreach ($collInvites as $obj) {
                            if (false == $this->collInvites->contains($obj)) {
                                $this->collInvites->append($obj);
                            }
                        }

                        $this->collInvitesPartial = true;
                    }

                    return $collInvites;
                }

                if ($partial && $this->collInvites) {
                    foreach ($this->collInvites as $obj) {
                        if ($obj->isNew()) {
                            $collInvites[] = $obj;
                        }
                    }
                }

                $this->collInvites = $collInvites;
                $this->collInvitesPartial = false;
            }
        }

        return $this->collInvites;
    }

    /**
     * Sets a collection of ChildInvite objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $invites A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCommunity The current object (for fluent API support)
     */
    public function setInvites(Collection $invites, ConnectionInterface $con = null)
    {
        /** @var ChildInvite[] $invitesToDelete */
        $invitesToDelete = $this->getInvites(new Criteria(), $con)->diff($invites);

        
        $this->invitesScheduledForDeletion = $invitesToDelete;

        foreach ($invitesToDelete as $inviteRemoved) {
            $inviteRemoved->setCommunity(null);
        }

        $this->collInvites = null;
        foreach ($invites as $invite) {
            $this->addInvite($invite);
        }

        $this->collInvites = $invites;
        $this->collInvitesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Invite objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Invite objects.
     * @throws PropelException
     */
    public function countInvites(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collInvitesPartial && !$this->isNew();
        if (null === $this->collInvites || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collInvites) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getInvites());
            }

            $query = ChildInviteQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCommunity($this)
                ->count($con);
        }

        return count($this->collInvites);
    }

    /**
     * Method called to associate a ChildInvite object to this object
     * through the ChildInvite foreign key attribute.
     *
     * @param  ChildInvite $l ChildInvite
     * @return $this|\ShoppingList\Model\Community The current object (for fluent API support)
     */
    public function addInvite(ChildInvite $l)
    {
        if ($this->collInvites === null) {
            $this->initInvites();
            $this->collInvitesPartial = true;
        }

        if (!$this->collInvites->contains($l)) {
            $this->doAddInvite($l);
        }

        return $this;
    }

    /**
     * @param ChildInvite $invite The ChildInvite object to add.
     */
    protected function doAddInvite(ChildInvite $invite)
    {
        $this->collInvites[]= $invite;
        $invite->setCommunity($this);
    }

    /**
     * @param  ChildInvite $invite The ChildInvite object to remove.
     * @return $this|ChildCommunity The current object (for fluent API support)
     */
    public function removeInvite(ChildInvite $invite)
    {
        if ($this->getInvites()->contains($invite)) {
            $pos = $this->collInvites->search($invite);
            $this->collInvites->remove($pos);
            if (null === $this->invitesScheduledForDeletion) {
                $this->invitesScheduledForDeletion = clone $this->collInvites;
                $this->invitesScheduledForDeletion->clear();
            }
            $this->invitesScheduledForDeletion[]= clone $invite;
            $invite->setCommunity(null);
        }

        return $this;
    }

    /**
     * Clears out the collProducts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProducts()
     */
    public function clearProducts()
    {
        $this->collProducts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collProducts collection loaded partially.
     */
    public function resetPartialProducts($v = true)
    {
        $this->collProductsPartial = $v;
    }

    /**
     * Initializes the collProducts collection.
     *
     * By default this just sets the collProducts collection to an empty array (like clearcollProducts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProducts($overrideExisting = true)
    {
        if (null !== $this->collProducts && !$overrideExisting) {
            return;
        }
        $this->collProducts = new ObjectCollection();
        $this->collProducts->setModel('\ShoppingList\Model\Product');
    }

    /**
     * Gets an array of ChildProduct objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCommunity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildProduct[] List of ChildProduct objects
     * @throws PropelException
     */
    public function getProducts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collProductsPartial && !$this->isNew();
        if (null === $this->collProducts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProducts) {
                // return empty collection
                $this->initProducts();
            } else {
                $collProducts = ChildProductQuery::create(null, $criteria)
                    ->filterByCommunity($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collProductsPartial && count($collProducts)) {
                        $this->initProducts(false);

                        foreach ($collProducts as $obj) {
                            if (false == $this->collProducts->contains($obj)) {
                                $this->collProducts->append($obj);
                            }
                        }

                        $this->collProductsPartial = true;
                    }

                    return $collProducts;
                }

                if ($partial && $this->collProducts) {
                    foreach ($this->collProducts as $obj) {
                        if ($obj->isNew()) {
                            $collProducts[] = $obj;
                        }
                    }
                }

                $this->collProducts = $collProducts;
                $this->collProductsPartial = false;
            }
        }

        return $this->collProducts;
    }

    /**
     * Sets a collection of ChildProduct objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $products A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCommunity The current object (for fluent API support)
     */
    public function setProducts(Collection $products, ConnectionInterface $con = null)
    {
        /** @var ChildProduct[] $productsToDelete */
        $productsToDelete = $this->getProducts(new Criteria(), $con)->diff($products);

        
        $this->productsScheduledForDeletion = $productsToDelete;

        foreach ($productsToDelete as $productRemoved) {
            $productRemoved->setCommunity(null);
        }

        $this->collProducts = null;
        foreach ($products as $product) {
            $this->addProduct($product);
        }

        $this->collProducts = $products;
        $this->collProductsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Product objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Product objects.
     * @throws PropelException
     */
    public function countProducts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collProductsPartial && !$this->isNew();
        if (null === $this->collProducts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProducts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getProducts());
            }

            $query = ChildProductQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCommunity($this)
                ->count($con);
        }

        return count($this->collProducts);
    }

    /**
     * Method called to associate a ChildProduct object to this object
     * through the ChildProduct foreign key attribute.
     *
     * @param  ChildProduct $l ChildProduct
     * @return $this|\ShoppingList\Model\Community The current object (for fluent API support)
     */
    public function addProduct(ChildProduct $l)
    {
        if ($this->collProducts === null) {
            $this->initProducts();
            $this->collProductsPartial = true;
        }

        if (!$this->collProducts->contains($l)) {
            $this->doAddProduct($l);
        }

        return $this;
    }

    /**
     * @param ChildProduct $product The ChildProduct object to add.
     */
    protected function doAddProduct(ChildProduct $product)
    {
        $this->collProducts[]= $product;
        $product->setCommunity($this);
    }

    /**
     * @param  ChildProduct $product The ChildProduct object to remove.
     * @return $this|ChildCommunity The current object (for fluent API support)
     */
    public function removeProduct(ChildProduct $product)
    {
        if ($this->getProducts()->contains($product)) {
            $pos = $this->collProducts->search($product);
            $this->collProducts->remove($pos);
            if (null === $this->productsScheduledForDeletion) {
                $this->productsScheduledForDeletion = clone $this->collProducts;
                $this->productsScheduledForDeletion->clear();
            }
            $this->productsScheduledForDeletion[]= clone $product;
            $product->setCommunity(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->idcommunity = null;
        $this->name = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collCommunityHasUsers) {
                foreach ($this->collCommunityHasUsers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collInvites) {
                foreach ($this->collInvites as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProducts) {
                foreach ($this->collProducts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCommunityHasUsers = null;
        $this->collInvites = null;
        $this->collProducts = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CommunityTableMap::DEFAULT_STRING_FORMAT);
    }

    // sluggable behavior
    
    /**
     * Wrap the setter for slug value
     *
     * @param   string
     * @return  $this|Community
     */
    public function setSlug($v)
    {
        return $this->setName($v);
    }
    
    /**
     * Wrap the getter for slug value
     *
     * @return  string
     */
    public function getSlug()
    {
        return $this->getName();
    }
    
    /**
     * Create a unique slug based on the object
     *
     * @return string The object slug
     */
    protected function createSlug()
    {
        $slug = $this->createRawSlug();
        $slug = $this->limitSlugSize($slug);
        $slug = $this->makeSlugUnique($slug);
    
        return $slug;
    }
    
    /**
     * Create the slug from the appropriate columns
     *
     * @return string
     */
    protected function createRawSlug()
    {
        return $this->cleanupSlugPart($this->__toString());
    }
    
    /**
     * Cleanup a string to make a slug of it
     * Removes special characters, replaces blanks with a separator, and trim it
     *
     * @param     string $slug        the text to slugify
     * @param     string $replacement the separator used by slug
     * @return    string               the slugified text
     */
    protected static function cleanupSlugPart($slug, $replacement = '-')
    {
        // transliterate
        if (function_exists('iconv')) {
            $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
        }
    
        // lowercase
        if (function_exists('mb_strtolower')) {
            $slug = mb_strtolower($slug);
        } else {
            $slug = strtolower($slug);
        }
    
        // remove accents resulting from OSX's iconv
        $slug = str_replace(array('\'', '`', '^'), '', $slug);
    
        // replace non letter or digits with separator
        $slug = preg_replace('/\W+/', $replacement, $slug);
    
        // trim
        $slug = trim($slug, $replacement);
    
        if (empty($slug)) {
            return 'n-a';
        }
    
        return $slug;
    }
    
    
    /**
     * Make sure the slug is short enough to accommodate the column size
     *
     * @param    string $slug            the slug to check
     *
     * @return string                        the truncated slug
     */
    protected static function limitSlugSize($slug, $incrementReservedSpace = 3)
    {
        // check length, as suffix could put it over maximum
        if (strlen($slug) > (200 - $incrementReservedSpace)) {
            $slug = substr($slug, 0, 200 - $incrementReservedSpace);
        }
    
        return $slug;
    }
    
    
    /**
     * Get the slug, ensuring its uniqueness
     *
     * @param    string $slug            the slug to check
     * @param    string $separator       the separator used by slug
     * @param    int    $alreadyExists   false for the first try, true for the second, and take the high count + 1
     * @return   string                   the unique slug
     */
    protected function makeSlugUnique($slug, $separator = '-', $alreadyExists = false)
    {
        if (!$alreadyExists) {
            $slug2 = $slug;
        } else {
            $slug2 = $slug . $separator;
    
            $count = \ShoppingList\Model\CommunityQuery::create()
                ->filterBySlug($this->getName())
                ->filterByPrimaryKey($this->getPrimaryKey())
            ->count();
    
            if (1 == $count) {
                return $this->getName();
            }
        }
    
        $adapter = \Propel\Runtime\Propel::getServiceContainer()->getAdapter('default');
        $col = 'q.Name';
        $compare = $alreadyExists ? $adapter->compareRegex($col, '?') : sprintf('%s = ?', $col);
    
        $query = \ShoppingList\Model\CommunityQuery::create('q')
            ->where($compare, $alreadyExists ? '^' . $slug2 . '[0-9]+$' : $slug2)
            ->prune($this)
        ;
    
        if (!$alreadyExists) {
            $count = $query->count();
            if ($count > 0) {
                return $this->makeSlugUnique($slug, $separator, true);
            }
    
            return $slug2;
        }
    
        $adapter = \Propel\Runtime\Propel::getServiceContainer()->getAdapter('default');
        // Already exists
        $object = $query
            ->addDescendingOrderByColumn($adapter->strLength('name'))
            ->addDescendingOrderByColumn('name')
        ->findOne();
    
        // First duplicate slug
        if (null == $object) {
            return $slug2 . '1';
        }
    
        $slugNum = substr($object->getName(), strlen($slug) + 1);
        if (0 == $slugNum[0]) {
            $slugNum[0] = 1;
        }
    
        return $slug2 . ($slugNum + 1);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
