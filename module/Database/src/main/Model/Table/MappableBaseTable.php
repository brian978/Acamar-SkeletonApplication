<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Database\Model\Table;

use Acamar\Model\Entity\EntityInterface;
use Aura\SqlQuery\Common\InsertInterface;
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
            if ("" === $this->tableMapsClass) {
                if (!$this->autodetect) {
                    throw new \RuntimeException("No maps class for the `" . get_class($this) . "` object was provided");
                }

                $this->detectTableMapsClass();
            }

            $this->tableMaps = new $this->tableMapsClass;
        }

        return $this->tableMaps;
    }

    /**
     * The method is used by the autodetect feature to determine what is the name of the class that contains the
     * mappings specific to $this object
     *
     * @return void
     */
    private function detectTableMapsClass()
    {
        $class = get_class($this);
        $classBaseNamespace = substr($class, 0, strrpos($class, "\\"));
        $classWithoutPrefix = str_replace([$classBaseNamespace . "\\", "Table"], ["", ""], $class);

        $this->tableMapsClass = $this->buildTableMapsClassName($classBaseNamespace, $classWithoutPrefix);
    }

    /**
     * The method is used to make it easier to customize the name of the table maps class
     *
     * @param string $classBaseNamespace
     * @param string $classWithoutPrefix
     * @return string
     */
    protected function buildTableMapsClassName($classBaseNamespace, $classWithoutPrefix)
    {
        return $classBaseNamespace . "\\Maps\\" . $classWithoutPrefix . "Maps";
    }

    /**
     * Saves an object using the given map and updates the primary key
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
        $query = $this->save($objectMapper->extract($object, $map), $primaryKey);

        // We need to update the primary key of the object if this is an insert
        if ($query instanceof InsertInterface) {
            $id = $this->getConnection()->lastInsertId($this->tableName . '.' . $primaryKey);
            $objectMapper->populate([$primaryKey => $id], $map, $object);
        }
    }

    /**
     * Saves an array using the given map and updates the primary key
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
            $id = $this->getConnection()->lastInsertId($this->tableName . '.' . $primaryKey);
            $data[$primaryKey] = $id;
        }
    }

    /**
     * Deletes an object using the given map
     *
     * @param EntityInterface $object
     * @param $map
     * @return void
     * @throws \RuntimeException
     */
    public function deleteObject(EntityInterface $object, $map)
    {
        $primaryKey = $this->getTableMaps()->getIdentField($map);
        if (empty($primaryKey)) {
            throw new \RuntimeException(
                "Check the 'identField' for the $map map and make sure it contains the primary key"
            );
        }

        $objectMapper = $this->getObjectMapper();

        $this->delete($objectMapper->extract($object, $map), $primaryKey);
    }

    /**
     * Deletes an object using the given map
     *
     * @param array $data
     * @param $map
     * @return void
     * @throws \RuntimeException
     */
    public function deleteArray(array $data, $map)
    {
        $primaryKey = $this->getTableMaps()->getIdentField($map);
        if (empty($primaryKey)) {
            throw new \RuntimeException(
                "Check the 'identField' for the $map map and make sure it contains the primary key"
            );
        }

        $this->delete($data, $primaryKey);
    }
}
