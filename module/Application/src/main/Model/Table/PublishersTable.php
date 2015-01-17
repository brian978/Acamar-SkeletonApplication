<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Application\Model\Table;

use Application\Model\Publisher;
use Application\Model\Table\Maps\PublishersMaps;
use Database\Model\Table\MappableBaseTable;

/**
 * Class PublishersTable
 *
 * @package Application\Model\Table
 */
class PublishersTable extends MappableBaseTable
{
    /**
     * The table name for the table that this object represents
     *
     * @var string
     */
    protected $tableName = 'publishers';

    /**
     * The property must contain the class name that will be used to determine the mappings for the objects
     *
     * @var string
     */
    protected $tableMapsClass = 'Application\Model\Table\Maps\PublishersMaps';

    /**
     * Returns all the publishers from the database
     *
     * @return array
     */
    public function getPublishers()
    {
        $result = $this->executeSql($this->getSelect())->fetchAll();

        return $this->getObjectMapper()->populateCollection($result, PublishersMaps::MAP_PUBLISHER);
    }

    /**
     * Returns an object identifying the requested publisher
     *
     * @param int $id
     * @return \Application\Model\Publisher
     */
    public function getPublisher($id)
    {
        $select = $this->getSelect();
        $select->where('id = :id');
        $select->bindValue('id', $id);

        $result = $this->executeSql($select)->fetch();
        if (!$result) {
            return new Publisher();
        }

        return $this->getObjectMapper()->populate($result, PublishersMaps::MAP_PUBLISHER);
    }

    /**
     * Returns an object identifying the requested publisher but in array format
     * Theoretically we don't need this but it looks nicer in the controller
     *
     * @param int $id
     * @return array
     */
    public function getPublisherArray($id)
    {
        $item = $this->getPublisher($id);
        if ($item->getId() !== 0) {
            return $this->getObjectMapper()->extract($item, PublishersMaps::MAP_PUBLISHER);
        }

        return $item;
    }
}
