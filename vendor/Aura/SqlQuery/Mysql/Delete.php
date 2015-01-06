<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @package Aura.SqlQuery
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace Aura\SqlQuery\Mysql;

use Aura\SqlQuery\Common;

/**
 *
 * An object for MySQL UPDATE queries.
 *
 * @package Aura.SqlQuery
 *
 */
class Delete extends Common\Delete implements Common\OrderByInterface, Common\LimitInterface
{
    /**
     *
     * Adds or removes LOW_PRIORITY flag.
     *
     * @param bool $enable Set or unset flag (default true).
     *
     * @return self
     *
     */
    public function lowPriority($enable = true)
    {
        $this->setFlag('LOW_PRIORITY', $enable);
        return $this;
    }

    /**
     *
     * Adds or removes IGNORE flag.
     *
     * @param bool $enable Set or unset flag (default true).
     *
     * @return self
     *
     */
    public function ignore($enable = true)
    {
        $this->setFlag('IGNORE', $enable);
        return $this;
    }

    /**
     *
     * Adds or removes QUICK flag.
     *
     * @param bool $enable Set or unset flag (default true).
     *
     * @return self
     *
     */
    public function quick($enable = true)
    {
        $this->setFlag('QUICK', $enable);
        return $this;
    }

    /**
     *
     * Sets a limit count on the query.
     *
     * @param int $limit The number of rows to select.
     *
     * @return self
     *
     */
    public function limit($limit)
    {
        $this->limit = (int) $limit;
        return $this;
    }

    /**
     *
     * Adds a column order to the query.
     *
     * @param array $spec The columns and direction to order by.
     *
     * @return self
     *
     */
    public function orderBy(array $spec)
    {
        return $this->addOrderBy($spec);
    }
}
