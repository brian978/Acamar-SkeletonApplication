<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Application;

use Acamar\Mvc\Event\MvcEvent;

/**
 * Class Setup
 *
 * This object will be called on the MvcEvent::EVENT_BOOTSTRAP event
 * if the "runSetup" configuration key is set to "true"
 *
 * @package Application
 */
class Setup
{
    /**
     * Runs the setup for this module
     *
     * @param MvcEvent $event
     */
    public function __construct(MvcEvent $event)
    {

    }
} 
