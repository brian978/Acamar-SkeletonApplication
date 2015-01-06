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
 * Class ConnectionRegistry
 *
 * @package Database\Connection
 */
class ConnectionRegistry
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $connections = [];

    /**
     * Creates the configuration registry object
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Retrieves an existing connection by name or it creates it if it does not exist
     *
     * @param string $name
     * @return \PDO
     */
    public function getConnection($name)
    {
        if (!isset($this->connections[$name])) {
            $this->connections[$name] = $this->createConnection($name);
        }

        return $this->connections[$name];
    }

    /**
     * Searches for the configuration for the connection and creates it. If the configuration is not found then it will
     * return NULL
     *
     * @param string $name
     * @return null|\PDO
     */
    protected function createConnection($name)
    {
        if (!isset($this->config[$name])) {
            return null;
        }

        return ConnectionFactory::factory($this->config[$name]);
    }
}
