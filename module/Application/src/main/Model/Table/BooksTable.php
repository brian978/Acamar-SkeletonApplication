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
 * Class BooksTable
 *
 * @package Application\Model\Table
 */
class BooksTable extends BaseTable
{
    /**
     * The table name for the table that this object represents
     *
     * @var string
     */
    protected $tableName = 'books';

    /**
     * Returns all the authors from the database
     *
     * @return array
     */
    public function getBooks()
    {
        $select = $this->getSelect(true)
            ->cols([
                $this->tableName . '.*',
                'publishers.name AS publisherName',
                'authors.firstName AS authorFirstName',
                'authors.lastName AS authorLastName',
            ])
            ->join('LEFT', 'publishers', $this->tableName . '.publisherId = publishers.id')
            ->join('LEFT', 'authors', $this->tableName . '.authorId = authors.id');


        return $this->executeSql($select)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
