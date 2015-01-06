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
 * Class AuthorsTable
 *
 * @package Application\Model\Table
 */
class AuthorsTable extends BaseTable
{
    /**
     * The table name for the table that this object represents
     *
     * @var string
     */
    protected $tableName = 'authors';

    /**
     * Returns all the authors from the database
     *
     * @return array
     */
    public function getAuthors()
    {
        $select = $this->getSelect();

        return $this->executeSql($select)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
