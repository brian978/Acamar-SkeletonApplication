<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Application\Model\Table;

use Application\Model\Table\Maps\AuthorsMaps;
use Database\Model\Table\Components\MappableTable;
use Database\Model\Table\MappableBaseTable;

/**
 * Class AuthorsTable
 *
 * @package Application\Model\Table
 */
class AuthorsTable extends MappableBaseTable
{
    /**
     * The table name for the table that this object represents
     *
     * @var string
     */
    protected $tableName = 'authors';

    /**
     * The property must contain the class name that will be used to determine the mappings for the objects
     *
     * @var string
     */
    protected $tableMapsClass = 'Application\Model\Table\Maps\AuthorsMaps';

    /**
     * Returns all the authors from the database
     *
     * @return array
     */
    public function getAuthors()
    {
        $result = $this->executeSql($this->getSelect())->fetchAll();

        return $this->getObjectMapper()->populateCollection($result, AuthorsMaps::MAP_AUTHOR);
    }

    /**
     * Returns an object identifying the requested author
     *
     * @param int $id
     * @return \Application\Model\Author|array
     */
    public function getAuthor($id)
    {
        $select = $this->getSelect();
        $select->where('id = :id');
        $select->bindValue('id', $id);

        $result = $this->executeSql($select)->fetch();
        if (!$result) {
            return [];
        }

        return $this->getObjectMapper()->populate($result, AuthorsMaps::MAP_AUTHOR);
    }

    /**
     * Returns an object identifying the requested author but in array format
     * Theoretically we don't need this but it looks nicer in the controller
     *
     * @param int $id
     * @return \Application\Model\Author|array
     */
    public function getAuthorArray($id)
    {
        $item = $this->getAuthor($id);
        if (!empty($item)) {
            return $this->getObjectMapper()->extract($item, AuthorsMaps::MAP_AUTHOR);
        }

        return $item;
    }
}
