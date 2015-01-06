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
use Application\Model\Table\BooksTable;

/**
 * Class IndexController
 *
 * @package Application\Controller
 */
class IndexController extends AbstractController
{
    public function indexAction()
    {
        $books = new BooksTable();

        return [
            'books' => $books->getBooks(),
        ];
    }
}
