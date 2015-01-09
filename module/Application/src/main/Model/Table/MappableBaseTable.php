<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Application\Model\Table;

use Acamar\Model\Entity\EntityInterface;
use Aura\SqlQuery\Common\InsertInterface;
use Database\Model\Table\BaseTable;
use Database\Model\Table\Components\MappableTable;

/**
 * Class MappableBaseTable
 *
 * The class extends the functionality of the \Database\Model\BaseTable class and adds ORM like mapping capabilities
 * and save/delete methods
 *
 * @package Application\Model\Table
 */
abstract class MappableBaseTable extends BaseTable
{
    use MappableTable;

    /**
     * The property must contain the class name that will be used to determine the mappings for the objects
     *
     * @var string
     */
    protected $tableMapsClass = '';

    /**
     * The property will contain a MapCollection object with maps specific to the child class
     *
     * @var \Acamar\Model\Mapper\MapCollection
     */
    private $tableMaps = null;

    /**
     * Constructs the object and initializes the ObjectMapper object
     *
     */
    public function __construct()
    {
        $this->getObjectMapper($this->getTableMaps());
    }

    /**
     * Returns a MapCollection object
     *
     * @return \Acamar\Model\Mapper\MapCollection
     */
    protected function getTableMaps()
    {
        if (null === $this->tableMaps) {
            $this->tableMaps = new $this->tableMapsClass;
        }

        return $this->tableMaps;
    }

    /**
     * Saves an object with a given map and updates the primary key
     *
     * @param EntityInterface $object
     * @param $map
     * @return void
     * @throws \RuntimeException
     */
    public function saveObject(EntityInterface $object, $map)
    {
        $primaryKey = $this->getTableMaps()->getIdentField($map);
        if (empty($primaryKey)) {
            throw new \RuntimeException(
                "Check the 'identField' for the $map map and make sure it contains the primary key"
            );
        }

        $objectMapper = $this->getObjectMapper();
        $query        = $this->save($objectMapper->extract($object, $map), $primaryKey);

        // We need to update the primary key of the object if this is an insert
        if ($query instanceof InsertInterface) {
            $id = $this->getConnection()->lastInsertId($this->tableName . '.' . $primaryKey);
            $objectMapper->populate([$primaryKey => $id], $map, $object);
        }
    }

    /**
     * Saves an array with a given map and updates the primary key
     *
     * @param array $data
     * @param $map
     * @return void
     * @throws \RuntimeException
     */
    public function saveArray(array &$data, $map)
    {
        $primaryKey = $this->getTableMaps()->getIdentField($map);
        if (empty($primaryKey)) {
            throw new \RuntimeException(
                "Check the 'identField' for the $map map and make sure it contains the primary key"
            );
        }

        $query = $this->save($data, $primaryKey);

        // We need to update the primary key of the object if this is an insert
        if ($query instanceof InsertInterface) {
            $id                = $this->getConnection()->lastInsertId($this->tableName . '.' . $primaryKey);
            $data[$primaryKey] = $id;
        }
    }
}
