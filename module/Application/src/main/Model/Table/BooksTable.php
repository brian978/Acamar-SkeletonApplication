<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Application\Model\Table;

use Application\Model\Book;
use Application\Model\Table\Maps\BooksMaps;
use Database\Model\Table\Components\MappableTable;
use Database\Model\Table\MappableBaseTable;

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

    /**
     * Returns an object identifying the requested book
     *
     * @param int $id
     * @return \Application\Model\Book
     */
    public function getBook($id)
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

        $select->where('id = :id');
        $select->bindValue('id', $id);

        $result = $this->executeSql($select)->fetch();
        if (!$result) {
            return new Book();
        }

        return $this->getObjectMapper()->populate($result, BooksMaps::MAP_BOOK);
    }

    /**
     * Returns an object identifying the requested book but in array format
     * Theoretically we don't need this but it looks nicer in the controller
     *
     * @param int $id
     * @return array
     */
    public function getBookArray($id)
    {
        $item = $this->getBook($id);
        if ($item->getId() !== 0) {
            return $this->getObjectMapper()->extract($item, BooksMaps::MAP_BOOK);
        }

        return $item;
    }
}
