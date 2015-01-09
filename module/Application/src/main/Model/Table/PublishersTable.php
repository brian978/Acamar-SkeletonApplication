<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Application\Model\Table;

use Application\Model\Table\Maps\PublishersMaps;
use Database\Model\Table\Components\MappableTable;

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
}
