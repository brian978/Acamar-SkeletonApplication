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

/**
 * Class ProductsController
 *
 * @package Application\Controller
 */
class AuthorsController extends AbstractController
{
    public function indexAction()
    {
        return [
            'someVar' => 'This is the index action for the products controller'
        ];
    }

    public function addAction()
    {
        return [
            'someVar' => 'This is the add action for the products controller'
        ];
    }
}
