<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Database;

use Acamar\Mvc\Event\MvcEvent;

/**
 * Class Setup
 *
 * This object will be called on the MvcEvent::EVENT_BOOTSTRAP event
 * if the "runSetup" configuration key is set to "true"
 *
 * Important: All the setup classes will run even if the stopPropagation() method is called on the event
 *
 * @package Database
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
