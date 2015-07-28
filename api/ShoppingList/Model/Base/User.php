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
use ShoppingList\Model\CommunityHasUser as ChildCommunityHasUser;
use ShoppingList\Model\CommunityHasUserQuery as ChildCommunityHasUserQuery;
use ShoppingList\Model\RememberMeToken as ChildRememberMeToken;
use ShoppingList\Model\RememberMeTokenQuery as ChildRememberMeTokenQuery;
use ShoppingList\Model\Transaction as ChildTransaction;
use ShoppingList\Model\TransactionQuery as ChildTransactionQuery;
use ShoppingList\Model\User as ChildUser;
use ShoppingList\Model\UserQuery as ChildUserQuery;
use ShoppingList\Model\Map\UserTableMap;

/**
 * Base class that represents a row from the 'user' table.
 *
 * 
 *
* @package    propel.generator.ShoppingList.Model.Base
*/
abstract class User implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\ShoppingList\\Model\\Map\\UserTableMap';


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
     * The value for the iduser field.
     * @var        int
     */
    protected $iduser;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the password field.
     * @var        string
     */
    protected $password;

    /**
     * The value for the phone field.
     * @var        string
     */
    protected $phone;

    /**
     * @var        ObjectCollection|ChildCommunityHasUser[] Collection to store aggregation of ChildCommunityHasUser objects.
     */
    protected $collCommunityHasUsers;
    protected $collCommunityHasUsersPartial;

    /**
     * @var        ObjectCollection|ChildRememberMeToken[] Collection to store aggregation of ChildRememberMeToken objects.
     */
    protected $collRememberMeTokens;
    protected $collRememberMeTokensPartial;

    /**
     * @var        ObjectCollection|ChildTransaction[] Collection to store aggregation of ChildTransaction objects.
     */
    protected $collTransactionsRelatedByReportedBy;
    protected $collTransactionsRelatedByReportedByPartial;

    /**
     * @var        ObjectCollection|ChildTransaction[] Collection to store aggregation of ChildTransaction objects.
     */
    protected $collTransactionsRelatedByEditedBy;
    protected $collTransactionsRelatedByEditedByPartial;

    /**
     * @var        ObjectCollection|ChildTransaction[] Collection to store aggregation of ChildTransaction objects.
     */
    protected $collTransactionsRelatedByBoughtBy;
    protected $collTransactionsRelatedByBoughtByPartial;

    /**
     * @var        ObjectCollection|ChildTransaction[] Collection to store aggregation of ChildTransaction objects.
     */
    protected $collTransactionsRelatedByCancelledBy;
    protected $collTransactionsRelatedByCancelledByPartial;

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
     * @var ObjectCollection|ChildRememberMeToken[]
     */
    protected $rememberMeTokensScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTransaction[]
     */
    protected $transactionsRelatedByReportedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTransaction[]
     */
    protected $transactionsRelatedByEditedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTransaction[]
     */
    protected $transactionsRelatedByBoughtByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTransaction[]
     */
    protected $transactionsRelatedByCancelledByScheduledForDeletion = null;

    /**
     * Initializes internal state of ShoppingList\Model\Base\User object.
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
     * Compares this with another <code>User</code> instance.  If
     * <code>obj</code> is an instance of <code>User</code>, delegates to
     * <code>equals(User)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|User The current object, for fluid interface
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
     * Get the [iduser] column value.
     * 
     * @return int
     */
    public function getIdUser()
    {
        return $this->iduser;
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
     * Get the [email] column value.
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [password] column value.
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [phone] column value.
     * 
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of [iduser] column.
     * 
     * @param int $v new value
     * @return $this|\ShoppingList\Model\User The current object (for fluent API support)
     */
    public function setIdUser($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->iduser !== $v) {
            $this->iduser = $v;
            $this->modifiedColumns[UserTableMap::COL_IDUSER] = true;
        }

        return $this;
    } // setIdUser()

    /**
     * Set the value of [name] column.
     * 
     * @param string $v new value
     * @return $this|\ShoppingList\Model\User The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[UserTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [email] column.
     * 
     * @param string $v new value
     * @return $this|\ShoppingList\Model\User The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UserTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [password] column.
     * 
     * @param string $v new value
     * @return $this|\ShoppingList\Model\User The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[UserTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

    /**
     * Set the value of [phone] column.
     * 
     * @param string $v new value
     * @return $this|\ShoppingList\Model\User The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[UserTableMap::COL_PHONE] = true;
        }

        return $this;
    } // setPhone()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserTableMap::translateFieldName('IdUser', TableMap::TYPE_PHPNAME, $indexType)];
            $this->iduser = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UserTableMap::translateFieldName('Phone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phone = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = UserTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ShoppingList\\Model\\User'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCommunityHasUsers = null;

            $this->collRememberMeTokens = null;

            $this->collTransactionsRelatedByReportedBy = null;

            $this->collTransactionsRelatedByEditedBy = null;

            $this->collTransactionsRelatedByBoughtBy = null;

            $this->collTransactionsRelatedByCancelledBy = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see User::setDeleted()
     * @see User::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
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
                UserTableMap::addInstanceToPool($this);
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

            if ($this->rememberMeTokensScheduledForDeletion !== null) {
                if (!$this->rememberMeTokensScheduledForDeletion->isEmpty()) {
                    \ShoppingList\Model\RememberMeTokenQuery::create()
                        ->filterByPrimaryKeys($this->rememberMeTokensScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rememberMeTokensScheduledForDeletion = null;
                }
            }

            if ($this->collRememberMeTokens !== null) {
                foreach ($this->collRememberMeTokens as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->transactionsRelatedByReportedByScheduledForDeletion !== null) {
                if (!$this->transactionsRelatedByReportedByScheduledForDeletion->isEmpty()) {
                    \ShoppingList\Model\TransactionQuery::create()
                        ->filterByPrimaryKeys($this->transactionsRelatedByReportedByScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->transactionsRelatedByReportedByScheduledForDeletion = null;
                }
            }

            if ($this->collTransactionsRelatedByReportedBy !== null) {
                foreach ($this->collTransactionsRelatedByReportedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->transactionsRelatedByEditedByScheduledForDeletion !== null) {
                if (!$this->transactionsRelatedByEditedByScheduledForDeletion->isEmpty()) {
                    \ShoppingList\Model\TransactionQuery::create()
                        ->filterByPrimaryKeys($this->transactionsRelatedByEditedByScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->transactionsRelatedByEditedByScheduledForDeletion = null;
                }
            }

            if ($this->collTransactionsRelatedByEditedBy !== null) {
                foreach ($this->collTransactionsRelatedByEditedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->transactionsRelatedByBoughtByScheduledForDeletion !== null) {
                if (!$this->transactionsRelatedByBoughtByScheduledForDeletion->isEmpty()) {
                    \ShoppingList\Model\TransactionQuery::create()
                        ->filterByPrimaryKeys($this->transactionsRelatedByBoughtByScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->transactionsRelatedByBoughtByScheduledForDeletion = null;
                }
            }

            if ($this->collTransactionsRelatedByBoughtBy !== null) {
                foreach ($this->collTransactionsRelatedByBoughtBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->transactionsRelatedByCancelledByScheduledForDeletion !== null) {
                if (!$this->transactionsRelatedByCancelledByScheduledForDeletion->isEmpty()) {
                    \ShoppingList\Model\TransactionQuery::create()
                        ->filterByPrimaryKeys($this->transactionsRelatedByCancelledByScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->transactionsRelatedByCancelledByScheduledForDeletion = null;
                }
            }

            if ($this->collTransactionsRelatedByCancelledBy !== null) {
                foreach ($this->collTransactionsRelatedByCancelledBy as $referrerFK) {
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

        $this->modifiedColumns[UserTableMap::COL_IDUSER] = true;
        if (null !== $this->iduser) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserTableMap::COL_IDUSER . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserTableMap::COL_IDUSER)) {
            $modifiedColumns[':p' . $index++]  = 'idUser';
        }
        if ($this->isColumnModified(UserTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }
        if ($this->isColumnModified(UserTableMap::COL_PHONE)) {
            $modifiedColumns[':p' . $index++]  = 'phone';
        }

        $sql = sprintf(
            'INSERT INTO user (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'idUser':                        
                        $stmt->bindValue($identifier, $this->iduser, PDO::PARAM_INT);
                        break;
                    case 'name':                        
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'email':                        
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'password':                        
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case 'phone':                        
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);
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
        $this->setIdUser($pk);

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
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdUser();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getEmail();
                break;
            case 3:
                return $this->getPassword();
                break;
            case 4:
                return $this->getPhone();
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

        if (isset($alreadyDumpedObjects['User'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->hashCode()] = true;
        $keys = UserTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdUser(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getEmail(),
            $keys[3] => $this->getPassword(),
            $keys[4] => $this->getPhone(),
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
            if (null !== $this->collRememberMeTokens) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rememberMeTokens';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'remember_me_tokens';
                        break;
                    default:
                        $key = 'RememberMeTokens';
                }
        
                $result[$key] = $this->collRememberMeTokens->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTransactionsRelatedByReportedBy) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'transactions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'transactions';
                        break;
                    default:
                        $key = 'Transactions';
                }
        
                $result[$key] = $this->collTransactionsRelatedByReportedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTransactionsRelatedByEditedBy) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'transactions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'transactions';
                        break;
                    default:
                        $key = 'Transactions';
                }
        
                $result[$key] = $this->collTransactionsRelatedByEditedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTransactionsRelatedByBoughtBy) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'transactions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'transactions';
                        break;
                    default:
                        $key = 'Transactions';
                }
        
                $result[$key] = $this->collTransactionsRelatedByBoughtBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTransactionsRelatedByCancelledBy) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'transactions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'transactions';
                        break;
                    default:
                        $key = 'Transactions';
                }
        
                $result[$key] = $this->collTransactionsRelatedByCancelledBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\ShoppingList\Model\User
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ShoppingList\Model\User
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdUser($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setEmail($value);
                break;
            case 3:
                $this->setPassword($value);
                break;
            case 4:
                $this->setPhone($value);
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
        $keys = UserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdUser($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setEmail($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPassword($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPhone($arr[$keys[4]]);
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
     * @return $this|\ShoppingList\Model\User The current object, for fluid interface
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
        $criteria = new Criteria(UserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserTableMap::COL_IDUSER)) {
            $criteria->add(UserTableMap::COL_IDUSER, $this->iduser);
        }
        if ($this->isColumnModified(UserTableMap::COL_NAME)) {
            $criteria->add(UserTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL)) {
            $criteria->add(UserTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $criteria->add(UserTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(UserTableMap::COL_PHONE)) {
            $criteria->add(UserTableMap::COL_PHONE, $this->phone);
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
        $criteria = ChildUserQuery::create();
        $criteria->add(UserTableMap::COL_IDUSER, $this->iduser);

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
        $validPk = null !== $this->getIdUser();

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
        return $this->getIdUser();
    }

    /**
     * Generic method to set the primary key (iduser column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdUser($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdUser();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \ShoppingList\Model\User (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setPhone($this->getPhone());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCommunityHasUsers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCommunityHasUser($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRememberMeTokens() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRememberMeToken($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTransactionsRelatedByReportedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTransactionRelatedByReportedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTransactionsRelatedByEditedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTransactionRelatedByEditedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTransactionsRelatedByBoughtBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTransactionRelatedByBoughtBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTransactionsRelatedByCancelledBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTransactionRelatedByCancelledBy($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdUser(NULL); // this is a auto-increment column, so set to default value
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
     * @return \ShoppingList\Model\User Clone of current object.
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
        if ('RememberMeToken' == $relationName) {
            return $this->initRememberMeTokens();
        }
        if ('TransactionRelatedByReportedBy' == $relationName) {
            return $this->initTransactionsRelatedByReportedBy();
        }
        if ('TransactionRelatedByEditedBy' == $relationName) {
            return $this->initTransactionsRelatedByEditedBy();
        }
        if ('TransactionRelatedByBoughtBy' == $relationName) {
            return $this->initTransactionsRelatedByBoughtBy();
        }
        if ('TransactionRelatedByCancelledBy' == $relationName) {
            return $this->initTransactionsRelatedByCancelledBy();
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
     * If this ChildUser is new, it will return
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
                    ->filterByUser($this)
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
     * @return $this|ChildUser The current object (for fluent API support)
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
            $communityHasUserRemoved->setUser(null);
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
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collCommunityHasUsers);
    }

    /**
     * Method called to associate a ChildCommunityHasUser object to this object
     * through the ChildCommunityHasUser foreign key attribute.
     *
     * @param  ChildCommunityHasUser $l ChildCommunityHasUser
     * @return $this|\ShoppingList\Model\User The current object (for fluent API support)
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
        $communityHasUser->setUser($this);
    }

    /**
     * @param  ChildCommunityHasUser $communityHasUser The ChildCommunityHasUser object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
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
            $communityHasUser->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related CommunityHasUsers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCommunityHasUser[] List of ChildCommunityHasUser objects
     */
    public function getCommunityHasUsersJoinCommunity(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommunityHasUserQuery::create(null, $criteria);
        $query->joinWith('Community', $joinBehavior);

        return $this->getCommunityHasUsers($query, $con);
    }

    /**
     * Clears out the collRememberMeTokens collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRememberMeTokens()
     */
    public function clearRememberMeTokens()
    {
        $this->collRememberMeTokens = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRememberMeTokens collection loaded partially.
     */
    public function resetPartialRememberMeTokens($v = true)
    {
        $this->collRememberMeTokensPartial = $v;
    }

    /**
     * Initializes the collRememberMeTokens collection.
     *
     * By default this just sets the collRememberMeTokens collection to an empty array (like clearcollRememberMeTokens());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRememberMeTokens($overrideExisting = true)
    {
        if (null !== $this->collRememberMeTokens && !$overrideExisting) {
            return;
        }
        $this->collRememberMeTokens = new ObjectCollection();
        $this->collRememberMeTokens->setModel('\ShoppingList\Model\RememberMeToken');
    }

    /**
     * Gets an array of ChildRememberMeToken objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRememberMeToken[] List of ChildRememberMeToken objects
     * @throws PropelException
     */
    public function getRememberMeTokens(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRememberMeTokensPartial && !$this->isNew();
        if (null === $this->collRememberMeTokens || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRememberMeTokens) {
                // return empty collection
                $this->initRememberMeTokens();
            } else {
                $collRememberMeTokens = ChildRememberMeTokenQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRememberMeTokensPartial && count($collRememberMeTokens)) {
                        $this->initRememberMeTokens(false);

                        foreach ($collRememberMeTokens as $obj) {
                            if (false == $this->collRememberMeTokens->contains($obj)) {
                                $this->collRememberMeTokens->append($obj);
                            }
                        }

                        $this->collRememberMeTokensPartial = true;
                    }

                    return $collRememberMeTokens;
                }

                if ($partial && $this->collRememberMeTokens) {
                    foreach ($this->collRememberMeTokens as $obj) {
                        if ($obj->isNew()) {
                            $collRememberMeTokens[] = $obj;
                        }
                    }
                }

                $this->collRememberMeTokens = $collRememberMeTokens;
                $this->collRememberMeTokensPartial = false;
            }
        }

        return $this->collRememberMeTokens;
    }

    /**
     * Sets a collection of ChildRememberMeToken objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rememberMeTokens A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setRememberMeTokens(Collection $rememberMeTokens, ConnectionInterface $con = null)
    {
        /** @var ChildRememberMeToken[] $rememberMeTokensToDelete */
        $rememberMeTokensToDelete = $this->getRememberMeTokens(new Criteria(), $con)->diff($rememberMeTokens);

        
        $this->rememberMeTokensScheduledForDeletion = $rememberMeTokensToDelete;

        foreach ($rememberMeTokensToDelete as $rememberMeTokenRemoved) {
            $rememberMeTokenRemoved->setUser(null);
        }

        $this->collRememberMeTokens = null;
        foreach ($rememberMeTokens as $rememberMeToken) {
            $this->addRememberMeToken($rememberMeToken);
        }

        $this->collRememberMeTokens = $rememberMeTokens;
        $this->collRememberMeTokensPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RememberMeToken objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RememberMeToken objects.
     * @throws PropelException
     */
    public function countRememberMeTokens(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRememberMeTokensPartial && !$this->isNew();
        if (null === $this->collRememberMeTokens || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRememberMeTokens) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRememberMeTokens());
            }

            $query = ChildRememberMeTokenQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collRememberMeTokens);
    }

    /**
     * Method called to associate a ChildRememberMeToken object to this object
     * through the ChildRememberMeToken foreign key attribute.
     *
     * @param  ChildRememberMeToken $l ChildRememberMeToken
     * @return $this|\ShoppingList\Model\User The current object (for fluent API support)
     */
    public function addRememberMeToken(ChildRememberMeToken $l)
    {
        if ($this->collRememberMeTokens === null) {
            $this->initRememberMeTokens();
            $this->collRememberMeTokensPartial = true;
        }

        if (!$this->collRememberMeTokens->contains($l)) {
            $this->doAddRememberMeToken($l);
        }

        return $this;
    }

    /**
     * @param ChildRememberMeToken $rememberMeToken The ChildRememberMeToken object to add.
     */
    protected function doAddRememberMeToken(ChildRememberMeToken $rememberMeToken)
    {
        $this->collRememberMeTokens[]= $rememberMeToken;
        $rememberMeToken->setUser($this);
    }

    /**
     * @param  ChildRememberMeToken $rememberMeToken The ChildRememberMeToken object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeRememberMeToken(ChildRememberMeToken $rememberMeToken)
    {
        if ($this->getRememberMeTokens()->contains($rememberMeToken)) {
            $pos = $this->collRememberMeTokens->search($rememberMeToken);
            $this->collRememberMeTokens->remove($pos);
            if (null === $this->rememberMeTokensScheduledForDeletion) {
                $this->rememberMeTokensScheduledForDeletion = clone $this->collRememberMeTokens;
                $this->rememberMeTokensScheduledForDeletion->clear();
            }
            $this->rememberMeTokensScheduledForDeletion[]= clone $rememberMeToken;
            $rememberMeToken->setUser(null);
        }

        return $this;
    }

    /**
     * Clears out the collTransactionsRelatedByReportedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTransactionsRelatedByReportedBy()
     */
    public function clearTransactionsRelatedByReportedBy()
    {
        $this->collTransactionsRelatedByReportedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTransactionsRelatedByReportedBy collection loaded partially.
     */
    public function resetPartialTransactionsRelatedByReportedBy($v = true)
    {
        $this->collTransactionsRelatedByReportedByPartial = $v;
    }

    /**
     * Initializes the collTransactionsRelatedByReportedBy collection.
     *
     * By default this just sets the collTransactionsRelatedByReportedBy collection to an empty array (like clearcollTransactionsRelatedByReportedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTransactionsRelatedByReportedBy($overrideExisting = true)
    {
        if (null !== $this->collTransactionsRelatedByReportedBy && !$overrideExisting) {
            return;
        }
        $this->collTransactionsRelatedByReportedBy = new ObjectCollection();
        $this->collTransactionsRelatedByReportedBy->setModel('\ShoppingList\Model\Transaction');
    }

    /**
     * Gets an array of ChildTransaction objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTransaction[] List of ChildTransaction objects
     * @throws PropelException
     */
    public function getTransactionsRelatedByReportedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTransactionsRelatedByReportedByPartial && !$this->isNew();
        if (null === $this->collTransactionsRelatedByReportedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTransactionsRelatedByReportedBy) {
                // return empty collection
                $this->initTransactionsRelatedByReportedBy();
            } else {
                $collTransactionsRelatedByReportedBy = ChildTransactionQuery::create(null, $criteria)
                    ->filterByUserRelatedByReportedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTransactionsRelatedByReportedByPartial && count($collTransactionsRelatedByReportedBy)) {
                        $this->initTransactionsRelatedByReportedBy(false);

                        foreach ($collTransactionsRelatedByReportedBy as $obj) {
                            if (false == $this->collTransactionsRelatedByReportedBy->contains($obj)) {
                                $this->collTransactionsRelatedByReportedBy->append($obj);
                            }
                        }

                        $this->collTransactionsRelatedByReportedByPartial = true;
                    }

                    return $collTransactionsRelatedByReportedBy;
                }

                if ($partial && $this->collTransactionsRelatedByReportedBy) {
                    foreach ($this->collTransactionsRelatedByReportedBy as $obj) {
                        if ($obj->isNew()) {
                            $collTransactionsRelatedByReportedBy[] = $obj;
                        }
                    }
                }

                $this->collTransactionsRelatedByReportedBy = $collTransactionsRelatedByReportedBy;
                $this->collTransactionsRelatedByReportedByPartial = false;
            }
        }

        return $this->collTransactionsRelatedByReportedBy;
    }

    /**
     * Sets a collection of ChildTransaction objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $transactionsRelatedByReportedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setTransactionsRelatedByReportedBy(Collection $transactionsRelatedByReportedBy, ConnectionInterface $con = null)
    {
        /** @var ChildTransaction[] $transactionsRelatedByReportedByToDelete */
        $transactionsRelatedByReportedByToDelete = $this->getTransactionsRelatedByReportedBy(new Criteria(), $con)->diff($transactionsRelatedByReportedBy);

        
        $this->transactionsRelatedByReportedByScheduledForDeletion = $transactionsRelatedByReportedByToDelete;

        foreach ($transactionsRelatedByReportedByToDelete as $transactionRelatedByReportedByRemoved) {
            $transactionRelatedByReportedByRemoved->setUserRelatedByReportedBy(null);
        }

        $this->collTransactionsRelatedByReportedBy = null;
        foreach ($transactionsRelatedByReportedBy as $transactionRelatedByReportedBy) {
            $this->addTransactionRelatedByReportedBy($transactionRelatedByReportedBy);
        }

        $this->collTransactionsRelatedByReportedBy = $transactionsRelatedByReportedBy;
        $this->collTransactionsRelatedByReportedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Transaction objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Transaction objects.
     * @throws PropelException
     */
    public function countTransactionsRelatedByReportedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTransactionsRelatedByReportedByPartial && !$this->isNew();
        if (null === $this->collTransactionsRelatedByReportedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTransactionsRelatedByReportedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTransactionsRelatedByReportedBy());
            }

            $query = ChildTransactionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByReportedBy($this)
                ->count($con);
        }

        return count($this->collTransactionsRelatedByReportedBy);
    }

    /**
     * Method called to associate a ChildTransaction object to this object
     * through the ChildTransaction foreign key attribute.
     *
     * @param  ChildTransaction $l ChildTransaction
     * @return $this|\ShoppingList\Model\User The current object (for fluent API support)
     */
    public function addTransactionRelatedByReportedBy(ChildTransaction $l)
    {
        if ($this->collTransactionsRelatedByReportedBy === null) {
            $this->initTransactionsRelatedByReportedBy();
            $this->collTransactionsRelatedByReportedByPartial = true;
        }

        if (!$this->collTransactionsRelatedByReportedBy->contains($l)) {
            $this->doAddTransactionRelatedByReportedBy($l);
        }

        return $this;
    }

    /**
     * @param ChildTransaction $transactionRelatedByReportedBy The ChildTransaction object to add.
     */
    protected function doAddTransactionRelatedByReportedBy(ChildTransaction $transactionRelatedByReportedBy)
    {
        $this->collTransactionsRelatedByReportedBy[]= $transactionRelatedByReportedBy;
        $transactionRelatedByReportedBy->setUserRelatedByReportedBy($this);
    }

    /**
     * @param  ChildTransaction $transactionRelatedByReportedBy The ChildTransaction object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeTransactionRelatedByReportedBy(ChildTransaction $transactionRelatedByReportedBy)
    {
        if ($this->getTransactionsRelatedByReportedBy()->contains($transactionRelatedByReportedBy)) {
            $pos = $this->collTransactionsRelatedByReportedBy->search($transactionRelatedByReportedBy);
            $this->collTransactionsRelatedByReportedBy->remove($pos);
            if (null === $this->transactionsRelatedByReportedByScheduledForDeletion) {
                $this->transactionsRelatedByReportedByScheduledForDeletion = clone $this->collTransactionsRelatedByReportedBy;
                $this->transactionsRelatedByReportedByScheduledForDeletion->clear();
            }
            $this->transactionsRelatedByReportedByScheduledForDeletion[]= clone $transactionRelatedByReportedBy;
            $transactionRelatedByReportedBy->setUserRelatedByReportedBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related TransactionsRelatedByReportedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTransaction[] List of ChildTransaction objects
     */
    public function getTransactionsRelatedByReportedByJoinProduct(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTransactionQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

        return $this->getTransactionsRelatedByReportedBy($query, $con);
    }

    /**
     * Clears out the collTransactionsRelatedByEditedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTransactionsRelatedByEditedBy()
     */
    public function clearTransactionsRelatedByEditedBy()
    {
        $this->collTransactionsRelatedByEditedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTransactionsRelatedByEditedBy collection loaded partially.
     */
    public function resetPartialTransactionsRelatedByEditedBy($v = true)
    {
        $this->collTransactionsRelatedByEditedByPartial = $v;
    }

    /**
     * Initializes the collTransactionsRelatedByEditedBy collection.
     *
     * By default this just sets the collTransactionsRelatedByEditedBy collection to an empty array (like clearcollTransactionsRelatedByEditedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTransactionsRelatedByEditedBy($overrideExisting = true)
    {
        if (null !== $this->collTransactionsRelatedByEditedBy && !$overrideExisting) {
            return;
        }
        $this->collTransactionsRelatedByEditedBy = new ObjectCollection();
        $this->collTransactionsRelatedByEditedBy->setModel('\ShoppingList\Model\Transaction');
    }

    /**
     * Gets an array of ChildTransaction objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTransaction[] List of ChildTransaction objects
     * @throws PropelException
     */
    public function getTransactionsRelatedByEditedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTransactionsRelatedByEditedByPartial && !$this->isNew();
        if (null === $this->collTransactionsRelatedByEditedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTransactionsRelatedByEditedBy) {
                // return empty collection
                $this->initTransactionsRelatedByEditedBy();
            } else {
                $collTransactionsRelatedByEditedBy = ChildTransactionQuery::create(null, $criteria)
                    ->filterByUserRelatedByEditedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTransactionsRelatedByEditedByPartial && count($collTransactionsRelatedByEditedBy)) {
                        $this->initTransactionsRelatedByEditedBy(false);

                        foreach ($collTransactionsRelatedByEditedBy as $obj) {
                            if (false == $this->collTransactionsRelatedByEditedBy->contains($obj)) {
                                $this->collTransactionsRelatedByEditedBy->append($obj);
                            }
                        }

                        $this->collTransactionsRelatedByEditedByPartial = true;
                    }

                    return $collTransactionsRelatedByEditedBy;
                }

                if ($partial && $this->collTransactionsRelatedByEditedBy) {
                    foreach ($this->collTransactionsRelatedByEditedBy as $obj) {
                        if ($obj->isNew()) {
                            $collTransactionsRelatedByEditedBy[] = $obj;
                        }
                    }
                }

                $this->collTransactionsRelatedByEditedBy = $collTransactionsRelatedByEditedBy;
                $this->collTransactionsRelatedByEditedByPartial = false;
            }
        }

        return $this->collTransactionsRelatedByEditedBy;
    }

    /**
     * Sets a collection of ChildTransaction objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $transactionsRelatedByEditedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setTransactionsRelatedByEditedBy(Collection $transactionsRelatedByEditedBy, ConnectionInterface $con = null)
    {
        /** @var ChildTransaction[] $transactionsRelatedByEditedByToDelete */
        $transactionsRelatedByEditedByToDelete = $this->getTransactionsRelatedByEditedBy(new Criteria(), $con)->diff($transactionsRelatedByEditedBy);

        
        $this->transactionsRelatedByEditedByScheduledForDeletion = $transactionsRelatedByEditedByToDelete;

        foreach ($transactionsRelatedByEditedByToDelete as $transactionRelatedByEditedByRemoved) {
            $transactionRelatedByEditedByRemoved->setUserRelatedByEditedBy(null);
        }

        $this->collTransactionsRelatedByEditedBy = null;
        foreach ($transactionsRelatedByEditedBy as $transactionRelatedByEditedBy) {
            $this->addTransactionRelatedByEditedBy($transactionRelatedByEditedBy);
        }

        $this->collTransactionsRelatedByEditedBy = $transactionsRelatedByEditedBy;
        $this->collTransactionsRelatedByEditedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Transaction objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Transaction objects.
     * @throws PropelException
     */
    public function countTransactionsRelatedByEditedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTransactionsRelatedByEditedByPartial && !$this->isNew();
        if (null === $this->collTransactionsRelatedByEditedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTransactionsRelatedByEditedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTransactionsRelatedByEditedBy());
            }

            $query = ChildTransactionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByEditedBy($this)
                ->count($con);
        }

        return count($this->collTransactionsRelatedByEditedBy);
    }

    /**
     * Method called to associate a ChildTransaction object to this object
     * through the ChildTransaction foreign key attribute.
     *
     * @param  ChildTransaction $l ChildTransaction
     * @return $this|\ShoppingList\Model\User The current object (for fluent API support)
     */
    public function addTransactionRelatedByEditedBy(ChildTransaction $l)
    {
        if ($this->collTransactionsRelatedByEditedBy === null) {
            $this->initTransactionsRelatedByEditedBy();
            $this->collTransactionsRelatedByEditedByPartial = true;
        }

        if (!$this->collTransactionsRelatedByEditedBy->contains($l)) {
            $this->doAddTransactionRelatedByEditedBy($l);
        }

        return $this;
    }

    /**
     * @param ChildTransaction $transactionRelatedByEditedBy The ChildTransaction object to add.
     */
    protected function doAddTransactionRelatedByEditedBy(ChildTransaction $transactionRelatedByEditedBy)
    {
        $this->collTransactionsRelatedByEditedBy[]= $transactionRelatedByEditedBy;
        $transactionRelatedByEditedBy->setUserRelatedByEditedBy($this);
    }

    /**
     * @param  ChildTransaction $transactionRelatedByEditedBy The ChildTransaction object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeTransactionRelatedByEditedBy(ChildTransaction $transactionRelatedByEditedBy)
    {
        if ($this->getTransactionsRelatedByEditedBy()->contains($transactionRelatedByEditedBy)) {
            $pos = $this->collTransactionsRelatedByEditedBy->search($transactionRelatedByEditedBy);
            $this->collTransactionsRelatedByEditedBy->remove($pos);
            if (null === $this->transactionsRelatedByEditedByScheduledForDeletion) {
                $this->transactionsRelatedByEditedByScheduledForDeletion = clone $this->collTransactionsRelatedByEditedBy;
                $this->transactionsRelatedByEditedByScheduledForDeletion->clear();
            }
            $this->transactionsRelatedByEditedByScheduledForDeletion[]= $transactionRelatedByEditedBy;
            $transactionRelatedByEditedBy->setUserRelatedByEditedBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related TransactionsRelatedByEditedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTransaction[] List of ChildTransaction objects
     */
    public function getTransactionsRelatedByEditedByJoinProduct(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTransactionQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

        return $this->getTransactionsRelatedByEditedBy($query, $con);
    }

    /**
     * Clears out the collTransactionsRelatedByBoughtBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTransactionsRelatedByBoughtBy()
     */
    public function clearTransactionsRelatedByBoughtBy()
    {
        $this->collTransactionsRelatedByBoughtBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTransactionsRelatedByBoughtBy collection loaded partially.
     */
    public function resetPartialTransactionsRelatedByBoughtBy($v = true)
    {
        $this->collTransactionsRelatedByBoughtByPartial = $v;
    }

    /**
     * Initializes the collTransactionsRelatedByBoughtBy collection.
     *
     * By default this just sets the collTransactionsRelatedByBoughtBy collection to an empty array (like clearcollTransactionsRelatedByBoughtBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTransactionsRelatedByBoughtBy($overrideExisting = true)
    {
        if (null !== $this->collTransactionsRelatedByBoughtBy && !$overrideExisting) {
            return;
        }
        $this->collTransactionsRelatedByBoughtBy = new ObjectCollection();
        $this->collTransactionsRelatedByBoughtBy->setModel('\ShoppingList\Model\Transaction');
    }

    /**
     * Gets an array of ChildTransaction objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTransaction[] List of ChildTransaction objects
     * @throws PropelException
     */
    public function getTransactionsRelatedByBoughtBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTransactionsRelatedByBoughtByPartial && !$this->isNew();
        if (null === $this->collTransactionsRelatedByBoughtBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTransactionsRelatedByBoughtBy) {
                // return empty collection
                $this->initTransactionsRelatedByBoughtBy();
            } else {
                $collTransactionsRelatedByBoughtBy = ChildTransactionQuery::create(null, $criteria)
                    ->filterByUserRelatedByBoughtBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTransactionsRelatedByBoughtByPartial && count($collTransactionsRelatedByBoughtBy)) {
                        $this->initTransactionsRelatedByBoughtBy(false);

                        foreach ($collTransactionsRelatedByBoughtBy as $obj) {
                            if (false == $this->collTransactionsRelatedByBoughtBy->contains($obj)) {
                                $this->collTransactionsRelatedByBoughtBy->append($obj);
                            }
                        }

                        $this->collTransactionsRelatedByBoughtByPartial = true;
                    }

                    return $collTransactionsRelatedByBoughtBy;
                }

                if ($partial && $this->collTransactionsRelatedByBoughtBy) {
                    foreach ($this->collTransactionsRelatedByBoughtBy as $obj) {
                        if ($obj->isNew()) {
                            $collTransactionsRelatedByBoughtBy[] = $obj;
                        }
                    }
                }

                $this->collTransactionsRelatedByBoughtBy = $collTransactionsRelatedByBoughtBy;
                $this->collTransactionsRelatedByBoughtByPartial = false;
            }
        }

        return $this->collTransactionsRelatedByBoughtBy;
    }

    /**
     * Sets a collection of ChildTransaction objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $transactionsRelatedByBoughtBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setTransactionsRelatedByBoughtBy(Collection $transactionsRelatedByBoughtBy, ConnectionInterface $con = null)
    {
        /** @var ChildTransaction[] $transactionsRelatedByBoughtByToDelete */
        $transactionsRelatedByBoughtByToDelete = $this->getTransactionsRelatedByBoughtBy(new Criteria(), $con)->diff($transactionsRelatedByBoughtBy);

        
        $this->transactionsRelatedByBoughtByScheduledForDeletion = $transactionsRelatedByBoughtByToDelete;

        foreach ($transactionsRelatedByBoughtByToDelete as $transactionRelatedByBoughtByRemoved) {
            $transactionRelatedByBoughtByRemoved->setUserRelatedByBoughtBy(null);
        }

        $this->collTransactionsRelatedByBoughtBy = null;
        foreach ($transactionsRelatedByBoughtBy as $transactionRelatedByBoughtBy) {
            $this->addTransactionRelatedByBoughtBy($transactionRelatedByBoughtBy);
        }

        $this->collTransactionsRelatedByBoughtBy = $transactionsRelatedByBoughtBy;
        $this->collTransactionsRelatedByBoughtByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Transaction objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Transaction objects.
     * @throws PropelException
     */
    public function countTransactionsRelatedByBoughtBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTransactionsRelatedByBoughtByPartial && !$this->isNew();
        if (null === $this->collTransactionsRelatedByBoughtBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTransactionsRelatedByBoughtBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTransactionsRelatedByBoughtBy());
            }

            $query = ChildTransactionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByBoughtBy($this)
                ->count($con);
        }

        return count($this->collTransactionsRelatedByBoughtBy);
    }

    /**
     * Method called to associate a ChildTransaction object to this object
     * through the ChildTransaction foreign key attribute.
     *
     * @param  ChildTransaction $l ChildTransaction
     * @return $this|\ShoppingList\Model\User The current object (for fluent API support)
     */
    public function addTransactionRelatedByBoughtBy(ChildTransaction $l)
    {
        if ($this->collTransactionsRelatedByBoughtBy === null) {
            $this->initTransactionsRelatedByBoughtBy();
            $this->collTransactionsRelatedByBoughtByPartial = true;
        }

        if (!$this->collTransactionsRelatedByBoughtBy->contains($l)) {
            $this->doAddTransactionRelatedByBoughtBy($l);
        }

        return $this;
    }

    /**
     * @param ChildTransaction $transactionRelatedByBoughtBy The ChildTransaction object to add.
     */
    protected function doAddTransactionRelatedByBoughtBy(ChildTransaction $transactionRelatedByBoughtBy)
    {
        $this->collTransactionsRelatedByBoughtBy[]= $transactionRelatedByBoughtBy;
        $transactionRelatedByBoughtBy->setUserRelatedByBoughtBy($this);
    }

    /**
     * @param  ChildTransaction $transactionRelatedByBoughtBy The ChildTransaction object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeTransactionRelatedByBoughtBy(ChildTransaction $transactionRelatedByBoughtBy)
    {
        if ($this->getTransactionsRelatedByBoughtBy()->contains($transactionRelatedByBoughtBy)) {
            $pos = $this->collTransactionsRelatedByBoughtBy->search($transactionRelatedByBoughtBy);
            $this->collTransactionsRelatedByBoughtBy->remove($pos);
            if (null === $this->transactionsRelatedByBoughtByScheduledForDeletion) {
                $this->transactionsRelatedByBoughtByScheduledForDeletion = clone $this->collTransactionsRelatedByBoughtBy;
                $this->transactionsRelatedByBoughtByScheduledForDeletion->clear();
            }
            $this->transactionsRelatedByBoughtByScheduledForDeletion[]= $transactionRelatedByBoughtBy;
            $transactionRelatedByBoughtBy->setUserRelatedByBoughtBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related TransactionsRelatedByBoughtBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTransaction[] List of ChildTransaction objects
     */
    public function getTransactionsRelatedByBoughtByJoinProduct(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTransactionQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

        return $this->getTransactionsRelatedByBoughtBy($query, $con);
    }

    /**
     * Clears out the collTransactionsRelatedByCancelledBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTransactionsRelatedByCancelledBy()
     */
    public function clearTransactionsRelatedByCancelledBy()
    {
        $this->collTransactionsRelatedByCancelledBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTransactionsRelatedByCancelledBy collection loaded partially.
     */
    public function resetPartialTransactionsRelatedByCancelledBy($v = true)
    {
        $this->collTransactionsRelatedByCancelledByPartial = $v;
    }

    /**
     * Initializes the collTransactionsRelatedByCancelledBy collection.
     *
     * By default this just sets the collTransactionsRelatedByCancelledBy collection to an empty array (like clearcollTransactionsRelatedByCancelledBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTransactionsRelatedByCancelledBy($overrideExisting = true)
    {
        if (null !== $this->collTransactionsRelatedByCancelledBy && !$overrideExisting) {
            return;
        }
        $this->collTransactionsRelatedByCancelledBy = new ObjectCollection();
        $this->collTransactionsRelatedByCancelledBy->setModel('\ShoppingList\Model\Transaction');
    }

    /**
     * Gets an array of ChildTransaction objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTransaction[] List of ChildTransaction objects
     * @throws PropelException
     */
    public function getTransactionsRelatedByCancelledBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTransactionsRelatedByCancelledByPartial && !$this->isNew();
        if (null === $this->collTransactionsRelatedByCancelledBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTransactionsRelatedByCancelledBy) {
                // return empty collection
                $this->initTransactionsRelatedByCancelledBy();
            } else {
                $collTransactionsRelatedByCancelledBy = ChildTransactionQuery::create(null, $criteria)
                    ->filterByUserRelatedByCancelledBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTransactionsRelatedByCancelledByPartial && count($collTransactionsRelatedByCancelledBy)) {
                        $this->initTransactionsRelatedByCancelledBy(false);

                        foreach ($collTransactionsRelatedByCancelledBy as $obj) {
                            if (false == $this->collTransactionsRelatedByCancelledBy->contains($obj)) {
                                $this->collTransactionsRelatedByCancelledBy->append($obj);
                            }
                        }

                        $this->collTransactionsRelatedByCancelledByPartial = true;
                    }

                    return $collTransactionsRelatedByCancelledBy;
                }

                if ($partial && $this->collTransactionsRelatedByCancelledBy) {
                    foreach ($this->collTransactionsRelatedByCancelledBy as $obj) {
                        if ($obj->isNew()) {
                            $collTransactionsRelatedByCancelledBy[] = $obj;
                        }
                    }
                }

                $this->collTransactionsRelatedByCancelledBy = $collTransactionsRelatedByCancelledBy;
                $this->collTransactionsRelatedByCancelledByPartial = false;
            }
        }

        return $this->collTransactionsRelatedByCancelledBy;
    }

    /**
     * Sets a collection of ChildTransaction objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $transactionsRelatedByCancelledBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setTransactionsRelatedByCancelledBy(Collection $transactionsRelatedByCancelledBy, ConnectionInterface $con = null)
    {
        /** @var ChildTransaction[] $transactionsRelatedByCancelledByToDelete */
        $transactionsRelatedByCancelledByToDelete = $this->getTransactionsRelatedByCancelledBy(new Criteria(), $con)->diff($transactionsRelatedByCancelledBy);

        
        $this->transactionsRelatedByCancelledByScheduledForDeletion = $transactionsRelatedByCancelledByToDelete;

        foreach ($transactionsRelatedByCancelledByToDelete as $transactionRelatedByCancelledByRemoved) {
            $transactionRelatedByCancelledByRemoved->setUserRelatedByCancelledBy(null);
        }

        $this->collTransactionsRelatedByCancelledBy = null;
        foreach ($transactionsRelatedByCancelledBy as $transactionRelatedByCancelledBy) {
            $this->addTransactionRelatedByCancelledBy($transactionRelatedByCancelledBy);
        }

        $this->collTransactionsRelatedByCancelledBy = $transactionsRelatedByCancelledBy;
        $this->collTransactionsRelatedByCancelledByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Transaction objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Transaction objects.
     * @throws PropelException
     */
    public function countTransactionsRelatedByCancelledBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTransactionsRelatedByCancelledByPartial && !$this->isNew();
        if (null === $this->collTransactionsRelatedByCancelledBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTransactionsRelatedByCancelledBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTransactionsRelatedByCancelledBy());
            }

            $query = ChildTransactionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByCancelledBy($this)
                ->count($con);
        }

        return count($this->collTransactionsRelatedByCancelledBy);
    }

    /**
     * Method called to associate a ChildTransaction object to this object
     * through the ChildTransaction foreign key attribute.
     *
     * @param  ChildTransaction $l ChildTransaction
     * @return $this|\ShoppingList\Model\User The current object (for fluent API support)
     */
    public function addTransactionRelatedByCancelledBy(ChildTransaction $l)
    {
        if ($this->collTransactionsRelatedByCancelledBy === null) {
            $this->initTransactionsRelatedByCancelledBy();
            $this->collTransactionsRelatedByCancelledByPartial = true;
        }

        if (!$this->collTransactionsRelatedByCancelledBy->contains($l)) {
            $this->doAddTransactionRelatedByCancelledBy($l);
        }

        return $this;
    }

    /**
     * @param ChildTransaction $transactionRelatedByCancelledBy The ChildTransaction object to add.
     */
    protected function doAddTransactionRelatedByCancelledBy(ChildTransaction $transactionRelatedByCancelledBy)
    {
        $this->collTransactionsRelatedByCancelledBy[]= $transactionRelatedByCancelledBy;
        $transactionRelatedByCancelledBy->setUserRelatedByCancelledBy($this);
    }

    /**
     * @param  ChildTransaction $transactionRelatedByCancelledBy The ChildTransaction object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeTransactionRelatedByCancelledBy(ChildTransaction $transactionRelatedByCancelledBy)
    {
        if ($this->getTransactionsRelatedByCancelledBy()->contains($transactionRelatedByCancelledBy)) {
            $pos = $this->collTransactionsRelatedByCancelledBy->search($transactionRelatedByCancelledBy);
            $this->collTransactionsRelatedByCancelledBy->remove($pos);
            if (null === $this->transactionsRelatedByCancelledByScheduledForDeletion) {
                $this->transactionsRelatedByCancelledByScheduledForDeletion = clone $this->collTransactionsRelatedByCancelledBy;
                $this->transactionsRelatedByCancelledByScheduledForDeletion->clear();
            }
            $this->transactionsRelatedByCancelledByScheduledForDeletion[]= $transactionRelatedByCancelledBy;
            $transactionRelatedByCancelledBy->setUserRelatedByCancelledBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related TransactionsRelatedByCancelledBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTransaction[] List of ChildTransaction objects
     */
    public function getTransactionsRelatedByCancelledByJoinProduct(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTransactionQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

        return $this->getTransactionsRelatedByCancelledBy($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->iduser = null;
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->phone = null;
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
            if ($this->collRememberMeTokens) {
                foreach ($this->collRememberMeTokens as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTransactionsRelatedByReportedBy) {
                foreach ($this->collTransactionsRelatedByReportedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTransactionsRelatedByEditedBy) {
                foreach ($this->collTransactionsRelatedByEditedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTransactionsRelatedByBoughtBy) {
                foreach ($this->collTransactionsRelatedByBoughtBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTransactionsRelatedByCancelledBy) {
                foreach ($this->collTransactionsRelatedByCancelledBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCommunityHasUsers = null;
        $this->collRememberMeTokens = null;
        $this->collTransactionsRelatedByReportedBy = null;
        $this->collTransactionsRelatedByEditedBy = null;
        $this->collTransactionsRelatedByBoughtBy = null;
        $this->collTransactionsRelatedByCancelledBy = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserTableMap::DEFAULT_STRING_FORMAT);
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
