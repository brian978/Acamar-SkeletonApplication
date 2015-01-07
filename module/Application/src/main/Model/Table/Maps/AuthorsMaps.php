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
 * Class AuthorsMaps
 *
 * @package Application\Model\Table\Maps
 */
class AuthorsMaps extends MapCollection
{
    const MAP_AUTHOR = 'author';

    /**
     * An array representing the data in the collection
     *
     * @var array
     */
    protected $collection = [
        self::MAP_AUTHOR => [
            'entity' => '\Application\Model\Author',
            'identField' => 'id',
            'specs' => [
                'id' => 'id',
                'firstName' => 'firstName',
                'lastName' => 'lastName',
            ]
        ]
    ];
}
