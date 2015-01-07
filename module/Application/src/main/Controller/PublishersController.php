<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Application\Controller;

use Acamar\Mvc\Controller\AbstractController;
use Application\Model\Table\AuthorsTable;
use Application\Model\Table\PublishersTable;

/**
 * Class PublishersController
 *
 * @package Application\Controller
 */
class PublishersController extends AbstractController
{
    public function indexAction()
    {
        $table = new PublishersTable();

        return [
            'publishers' => $table->getPublishers(),
        ];
    }
}
