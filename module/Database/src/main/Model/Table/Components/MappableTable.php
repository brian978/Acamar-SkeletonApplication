<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Database\Model\Table\Components;

use Acamar\Model\Mapper\MapCollection;
use Acamar\Model\Mapper\ObjectMapper;

/**
 * Class MappableTable
 *
 * @package Database\Model\Table\Components
 */
trait MappableTable
{
    /**
     * @var ObjectMapper
     */
    protected $objectMapper = null;

    /**
     * Returns an object mapper that can be used to transform arrays to objects
     *
     * @param \Acamar\Model\Mapper\MapCollection $mapCollection
     * @throws \InvalidArgumentException
     * @return ObjectMapper
     */
    public function getObjectMapper(MapCollection $mapCollection = null)
    {
        if (null === $this->objectMapper) {
            if (null === $mapCollection) {
                throw new \InvalidArgumentException('The object mapper is not created and to create it I need a \Acamar\Model\Mapper\MapCollection object');
            }

            $this->objectMapper = new ObjectMapper($mapCollection);
        }

        return $this->objectMapper;
    }
}
