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
use Database\Model\Table\BaseTable;
use Database\Model\Table\Components\MappableTable;

/**
 * Class BooksTable
 *
 * @package Application\Model\Table
 */
class BooksTable extends BaseTable
{
    use MappableTable;

    /**
     * The table name for the table that this object represents
     *
     * @var string
     */
    protected $tableName = 'books';

    /**
     * Constructs the BooksTable object
     *
     */
    public function __construct()
    {
        // Initializing the object mapper
        // TODO: Find better way to do this
        $this->getObjectMapper(new BooksMaps());
    }

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

        $result = $this->executeSql($select)->fetchAll(\PDO::FETCH_ASSOC);

        return $this->getObjectMapper()->populateCollection($result, BooksMaps::MAP_BOOK);
    }
}
