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
 * Class BaseTable
 *
 * @package Database\Model\Table
 */
class BaseTable
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
     * The table name for the table that this object represents
     *
     * @var string
     */
    protected $tableName = '';

    /**
     * @var QueryFactory
     */
    protected $queryFactory = null;

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
     * @return \PDOStatement
     */
    protected function executeSql(QueryInterface $query)
    {
        $sth = static::getConnectionRegistry()->getConnection($this->connectionName)->prepare($query->__toString());
        $sth->execute($query->getBindValues());

        return $sth;
    }

    /**
     * Returns a select object that results in the following statement: "SELECT * FROM `$tableName`"
     *
     * @return \Aura\SqlQuery\Common\SelectInterface
     */
    protected function getSelect()
    {
        return $this->getQueryFactory()->newSelect()->from($this->tableName)->cols(['*']);
    }
}
