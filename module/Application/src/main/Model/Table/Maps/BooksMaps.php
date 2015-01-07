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
 * Class BooksMaps
 *
 * @package Application\Model\Table\Maps
 */
class BooksMaps extends MapCollection
{
    const MAP_BOOK = 'book';

    /**
     * An array representing the data in the collection
     *
     * @var array
     */
    protected $collection = [
        self::MAP_BOOK => [
            'entity' => '\Application\Model\Book',
            'identField' => 'id',
            'specs' => [
                'id' => 'id',
                'title' => 'title',
                'isbn' => 'isbn',
                'publisherId' => [
                    'toProperty' => 'publisher',
                    'map' => 'joinedPublisher'
                ],
                'authorId' => [
                    'toProperty' => 'author',
                    'map' => 'joinedAuthor'
                ]
            ]
        ],
        'joinedPublisher' => [
            'entity' => '\Application\Model\Publisher',
            'identField' => 'publisherId',
            'specs' => [
                'publisherId' => 'id',
                'publisherName' => 'name'
            ]
        ],
        'joinedAuthor' => [
            'entity' => '\Application\Model\Author',
            'identField' => 'authorId',
            'specs' => [
                'authorId' => 'id',
                'authorFirstName' => 'firstName',
                'authorLastName' => 'lastName',
            ]
        ]
    ];
}
