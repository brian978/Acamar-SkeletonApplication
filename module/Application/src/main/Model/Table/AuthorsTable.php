<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Application\Model\Table;

use Aura\SqlQuery\QueryFactory;
use Database\Model\Table\BaseTable;

/**
 * Class Authors
 *
 * @package Application\Model\Table
 */
class AuthorsTable extends BaseTable
{
    /**
     * Returns all the authors from the database
     *
     * @return array
     */
    public function getAuthors()
    {
        $queryFactory = new QueryFactory('sqlite');
        $select       = $queryFactory->newSelect()
            ->from('authors')
            ->cols(['*']);

        $sth = static::getConnectionRegistry()->getConnection('main')->prepare($select->__toString());
        $sth->execute();

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }
}
