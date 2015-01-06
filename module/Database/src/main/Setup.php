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
use Database\Connection\ConnectionRegistry;
use Database\Model\Table\BaseTable;

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
    const EVENT_PARAM_DB_CONN_REGISTRY = 'connectionRegistry';

    /**
     * @var ConnectionRegistry
     */
    private $connectionRegistry = null;

    /**
     * Runs the setup for this module
     *
     * @param MvcEvent $event
     */
    public function __construct(MvcEvent $event)
    {
        $application  = $event->getTarget();
        $eventManager = $application->getEventManager();

        // We will need this to create the schema (if it's not created already) before the dispatch
        $this->connectionRegistry = new ConnectionRegistry($application->getConfig()['db']);

        // We set this here so we have access to it in the controller
        $event->setParam(self::EVENT_PARAM_DB_CONN_REGISTRY, $this->connectionRegistry);

        // No need to check for the schema creation before we even reach the controller dispatch
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'initializeSchema'), 200);

        // This can be done here or in the controller (not decided if this is the right place yet)
        BaseTable::setConnectionRegistry($this->connectionRegistry);
    }

    /**
     * The method will first check to see if the DB schema is initialized and initializes it if not
     *
     * @param MvcEvent $event
     */
    public function initializeSchema(MvcEvent $event)
    {
    }
}
