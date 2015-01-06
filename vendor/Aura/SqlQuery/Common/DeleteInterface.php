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
namespace Aura\SqlQuery\Common;

use Aura\SqlQuery\QueryInterface;

/**
 *
 * An interface for DELETE queries.
 *
 * @package Aura.SqlQuery
 *
 */
interface DeleteInterface extends QueryInterface, WhereInterface
{
    /**
     *
     * Sets the table to delete from.
     *
     * @param string $from The table to delete from.
     *
     * @return self
     *
     */
    public function from($from);
}
