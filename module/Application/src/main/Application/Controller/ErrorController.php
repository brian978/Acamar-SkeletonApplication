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
 * Class ErrorController
 *
 * @package Application\Controller
 */
class ErrorController extends AbstractController
{
    public function indexAction()
    {
        return [
            'exception' => $this->event->getError()
        ];
    }
}
