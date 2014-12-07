<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license Creative Commons Attribution-ShareAlike 3.0
 */

namespace Application\Controller;

use Acamar\Mvc\Controller\AbstractController;

/**
 * Class ProductsController
 *
 * @package Application\Controller
 */
class ProductsController extends AbstractController
{
    public function indexAction()
    {
        return [
            'someVar' => 'This is the index action for the products controller'
        ];
    }
}
