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
use Database\Model\Table\BaseTable;
use Database\Model\Table\Components\MappableTable;

/**
 * Class AuthorsTable
 *
 * @package Application\Model\Table
 */
class AuthorsTable extends BaseTable
{
    use MappableTable;

    /**
     * The table name for the table that this object represents
     *
     * @var string
     */
    protected $tableName = 'authors';

    /**
     * Constructs the AuthorsTable object
     *
     */
    public function __construct()
    {
        // Initializing the object mapper
        // TODO: Find better way to do this
        $this->getObjectMapper(new AuthorsMaps());
    }

    /**
     * Returns all the authors from the database
     *
     * @return array
     */
    public function getAuthors()
    {
        $result = $this->executeSql($this->getSelect())->fetchAll(\PDO::FETCH_ASSOC);

        return $this->getObjectMapper()->populateCollection($result, AuthorsMaps::MAP_AUTHOR);
    }
}
