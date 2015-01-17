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
        $application = $event->getTarget();
        $eventManager = $application->getEventManager();

        // We will need this to create the schema (if it's not created already) before the dispatch
        $this->connectionRegistry = new ConnectionRegistry($application->getConfig()['db']);

        // No need to check for the schema creation before we even reach the controller dispatch
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'initializeSchema'], 200);

        // This can be done here or in the controller (not yet decided if this is the right place)
        BaseTable::setConnectionRegistry($this->connectionRegistry);
    }

    /**
     * The method will first check to see if the DB schema is initialized and initializes it if not
     *
     * @param MvcEvent $event
     */
    public function initializeSchema(MvcEvent $event)
    {
        // Useless, I know
        unset($event);

        // Creates the databases if they don't exist
        $tables = ['authors', 'publishers', 'books'];
        $pdo = $this->connectionRegistry->getConnection('default');

        foreach ($tables as $table) {
            $sth = $pdo->prepare(file_get_contents('data/database/schema/' . $table . '.sql'));

            // These checks will basically print out on the screen (for now)
            if (!is_object($sth)) {
                var_dump($pdo->errorInfo());
                exit();
            } else {
                if (!$sth->execute()) {
                    var_dump($sth->errorInfo());
                    exit();
                }
            }
        }
    }
}
