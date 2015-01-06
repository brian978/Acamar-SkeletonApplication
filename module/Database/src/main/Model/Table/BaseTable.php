<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Database\Model\Table;

use Database\Connection\ConnectionRegistry;

/**
 * Class BaseTable
 *
 * @package Database\Model\Table
 */
class BaseTable
{
    /**
     * @var ConnectionRegistry
     */
    private static $connectionRegistry = null;

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
    protected  static function getConnectionRegistry()
    {
        return self::$connectionRegistry;
    }
}
