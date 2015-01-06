<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Application\Model\Table;

use Database\Model\Table\BaseTable;

/**
 * Class PublishersTable
 *
 * @package Application\Model\Table
 */
class PublishersTable extends BaseTable
{
    /**
     * The table name for the table that this object represents
     *
     * @var string
     */
    protected $tableName = 'publishers';

    /**
     * Returns all the authors from the database
     *
     * @return array
     */
    public function getPublishers()
    {
        return $this->executeSql($this->getSelect())->fetchAll(\PDO::FETCH_ASSOC);
    }
}
