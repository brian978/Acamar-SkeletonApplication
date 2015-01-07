<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Application\Model\Table\Maps;

use Acamar\Model\Mapper\MapCollection;


/**
 * Class PublishersMaps
 *
 * @package Application\Model\Table\Maps
 */
class PublishersMaps extends MapCollection
{
    const MAP_PUBLISHER = 'publisher';

    /**
     * An array representing the data in the collection
     *
     * @var array
     */
    protected $collection = [
        self::MAP_PUBLISHER => [
            'entity' => '\Application\Model\Publisher',
            'identField' => 'id',
            'specs' => [
                'id' => 'id',
                'name' => 'name'
            ]
        ]
    ];
}
