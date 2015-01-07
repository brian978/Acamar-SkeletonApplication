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

/**
 * Class ProductsController
 *
 * @package Application\Controller
 */
class AuthorsController extends AbstractController
{
    public function indexAction()
    {
        $table = new AuthorsTable();

        return [
            'authors' => $table->getAuthors(),
        ];
    }

    public function addAction()
    {
        $defaults = [
            'firstName' => '',
            'lastName' => '',
        ];

        $data = array_merge($defaults, $this->getRequest()->getPost());

        return [
            'post' => $data
        ];
    }
}
