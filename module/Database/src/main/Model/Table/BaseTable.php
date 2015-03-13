<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Database\Model\Table;

use Aura\SqlQuery\QueryFactory;
use Aura\SqlQuery\QueryInterface;
use Database\Connection\ConnectionRegistry;

/**
 * Abstract class BaseTable
 *
 * @package Database\Model\Table
 */
abstract class BaseTable
{
    /**
     * A connection registry for the database connections
     *
     * @var ConnectionRegistry
     */
    private static $connectionRegistry = null;

    /**
     * The database connection identifier that will be used when doing a database query
     *
     * @var string
     */
    protected $connectionName = 'default';

    /**
     * The connection object for the $connectionName
     *
     * @var \PDO|null
     */
    private $connection = null;

    /**
     * The table name for the table that this object represents
     * When the autodetect feature is used the table names are considered to be camel cased: someTableName
     *
     * @var string
     */
    protected $tableName = '';

    /**
     * Object that facilitates the creating of CRUD query objects
     *
     * @var QueryFactory
     */
    protected $queryFactory = null;

    /**
     * The autodetect feature allows the table to determine things like the table name or, for the mappable tables,
     * what is the map class that needs to be used
     *
     * @var bool
     */
    protected $autodetect = true;

    /**
     * Used as a cache by the BaseTable::getClassNameDetails() method
     *
     * @var array
     */
    protected $classNameDetails = [];

    /**
     * Constructor for the BaseTable objects.
     *
     * It must be called with parent::__construct() to keep the autodetect features for the table name
     *
     */
    public function __construct()
    {
        if ($this->autodetect && "" === $this->tableName) {
            $this->detectTableName();
        }
    }

    /**
     * The method is used by the autodetect feature to determine the name of the table name for the class
     *
     * @return void
     */
    private function detectTableName()
    {
        list(, , $classWithoutPrefix) = $this->getClassNameDetails();

        $this->tableName = $this->buildTableName($classWithoutPrefix);
    }

    /**
     * The method is used to make it easier to customize the name of the table name when the autodetect feature is
     * used
     *
     * @param string $classWithoutPrefix
     * @return string
     */
    protected function buildTableName($classWithoutPrefix)
    {
        return lcfirst($classWithoutPrefix);
    }

    /**
     * Returns different pieces of information from the class name (which includes the namespace)
     *
     * @return array
     */
    protected function getClassNameDetails()
    {
        if (empty($this->classNameDetails)) {
            $class = get_class($this);
            $classBaseNamespace = substr($class, 0, strrpos($class, "\\"));
            $classWithoutPrefix = str_replace([$classBaseNamespace . "\\", "Table"], ["", ""], $class);

            $this->classNameDetails = [
                $class,
                $classBaseNamespace,
                $classWithoutPrefix
            ];
        }

        return $this->classNameDetails;
    }

    /**
     * Sets the connection registry that will be used by the table models to query the database
     *
     * @param ConnectionRegistry $connectionRegistry
     */
    public static function setConnectionRegistry(ConnectionRegistry $connectionRegistry)
    {
        self::$connectionRegistry = $connectionRegistry;
    }

    /**
     * Returns the connection registry that will be used by the table models to query the database
     *
     * This method is recommended to remain "protected" to avoid turning the BaseTable class into a "registry" for the
     * connection registry object
     *
     * @return ConnectionRegistry
     */
    protected static function getConnectionRegistry()
    {
        return self::$connectionRegistry;
    }

    /**
     * Returns the connection object that will be used to query the database
     *
     * @return \PDO|null
     */
    protected function getConnection()
    {
        if (null === $this->connection) {
            $this->connection = static::getConnectionRegistry()->getConnection($this->connectionName);
        }

        return $this->connection;
    }

    /**
     * Creates, on demand, a query factory object
     *
     * @return QueryFactory
     */
    protected function getQueryFactory()
    {
        if (null === $this->queryFactory) {
            $this->queryFactory = new QueryFactory(
                self::getConnectionRegistry()->getConnectionSqlMode($this->connectionName)
            );
        }

        return $this->queryFactory;
    }

    /**
     * Executes a query along with the binded parameters and returns the statement object
     *
     * @param QueryInterface $query
     * @throws \RuntimeException
     * @return \PDOStatement
     */
    protected function executeSql(QueryInterface $query)
    {
        $sth = $this->getConnection()->prepare($query->__toString());

        if (!$sth) {
            throw new \RuntimeException($this->getConnection()->errorInfo()[2]);
        }

        $sth->setFetchMode(\PDO::FETCH_ASSOC);

        if (!$sth->execute($query->getBindValues())) {
            throw new \RuntimeException($sth->errorInfo());
        }

        return $sth;
    }

    /**
     * The method will insert a new entry or update an existing one, depending on the contents of the $data parameter
     *
     * @param array $data
     * @param string $primaryKey The name of the primary key column
     * @return \Aura\SqlQuery\Common\InsertInterface|\Aura\SqlQuery\Common\UpdateInterface
     */
    public function save(array $data, $primaryKey)
    {
        if (!isset($data[$primaryKey]) || empty($data[$primaryKey])) {
            $query = $this->getInsert();
        } else {
            $query = $this->getUpdate();
            $query->where("$primaryKey = :$primaryKey");
        }

        $query->cols(array_keys($data));
        $query->bindValues($data);

        // Executing
        $this->executeSql($query);

        // The SQL is returned instead of other information to provide greater flexibility
        return $query;
    }

    /**
     * The method will delete an entry from the database using the information from the $data parameter
     *
     * @param array $data
     * @param string $primaryKey The name of the primary key column
     * @return \Aura\SqlQuery\Common\DeleteInterface
     * @throws \InvalidArgumentException
     */
    public function delete(array $data, $primaryKey)
    {
        if (!isset($data[$primaryKey]) || empty($data[$primaryKey])) {
            throw new \InvalidArgumentException("Primary key data not found");
        }

        $query = $this->getDelete();
        $query->where("$primaryKey = :$primaryKey");
        $query->bindValue($primaryKey, $data[$primaryKey]);

        // Executing
        $this->executeSql($query);

        // The SQL is returned instead of other information to provide greater flexibility
        return $query;
    }

    /**
     * Returns a select object that results in the following statement: "SELECT * FROM `$tableName`"
     *
     * @param bool $skipCols Set this to true when you need custom columns instead of "*"
     * @return \Aura\SqlQuery\Common\SelectInterface
     */
    protected function getSelect($skipCols = false)
    {
        $select = $this->getQueryFactory()->newSelect()->from($this->tableName);
        if (false === $skipCols) {
            $select->cols(['*']);
        }

        return $select;
    }

    /**
     * Returns an insert object that can be used to insert data into the table
     *
     * @return \Aura\SqlQuery\Common\InsertInterface
     */
    protected function getInsert()
    {
        return $this->getQueryFactory()->newInsert()->into($this->tableName);
    }

    /**
     * Returns an update object that can be used to update the data from the table
     *
     * @return \Aura\SqlQuery\Common\UpdateInterface
     */
    protected function getUpdate()
    {
        return $this->getQueryFactory()->newUpdate()->table($this->tableName);
    }

    /**
     * Returns a delete object that can be used to delete data from the table
     *
     * @return \Aura\SqlQuery\Common\DeleteInterface
     */
    protected function getDelete()
    {
        return $this->getQueryFactory()->newDelete()->from($this->tableName);
    }
}
