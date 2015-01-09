<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Application\Model\Table;

use Application\Model\Table\Maps\BooksMaps;
use Database\Model\Table\Components\MappableTable;

/**
 * Class BooksTable
 *
 * @package Application\Model\Table
 */
class BooksTable extends MappableBaseTable
{
    /**
     * The table name for the table that this object represents
     *
     * @var string
     */
    protected $tableName = 'books';

    /**
     * The property must contain the class name that will be used to determine the mappings for the objects
     *
     * @var string
     */
    protected $tableMapsClass = 'Application\Model\Table\Maps\BooksMaps';

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

        $result = $this->executeSql($select)->fetchAll();

        return $this->getObjectMapper()->populateCollection($result, BooksMaps::MAP_BOOK);
    }
}
