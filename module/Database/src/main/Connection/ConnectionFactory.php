<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Database\Connection;

/**
 * Class ConnectionFactory
 *
 * @package Database\Connection
 */
class ConnectionFactory
{
    /**
     * Creates a new PDO object using the given configuration
     *
     * @param array $config
     * @return \PDO
     */
    public static function factory(array $config)
    {
        $class = new \ReflectionClass('PDO');
        $pdo   = $class->newInstanceArgs($config);

        return $pdo;
    }
}
