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
use Database\Model\Table\BaseTable;
use Database\Model\Table\Components\MappableTable;

/**
 * Class PublishersTable
 *
 * @package Application\Model\Table
 */
class PublishersTable extends BaseTable
{
    use MappableTable;

    /**
     * The table name for the table that this object represents
     *
     * @var string
     */
    protected $tableName = 'publishers';

    /**
     * Constructs the PublishersTable object
     *
     */
    public function __construct()
    {
        // Initializing the object mapper
        // TODO: Find better way to do this
        $this->getObjectMapper(new PublishersMaps());
    }

    /**
     * Returns all the publishers from the database
     *
     * @return array
     */
    public function getPublishers()
    {
        $result = $this->executeSql($this->getSelect())->fetchAll(\PDO::FETCH_ASSOC);

        return $this->getObjectMapper()->populateCollection($result, PublishersMaps::MAP_PUBLISHER);
    }
}
