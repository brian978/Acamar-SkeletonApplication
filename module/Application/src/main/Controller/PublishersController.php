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
use Application\Model\Table\Maps\PublishersMaps;
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

    public function addAction()
    {
        $defaults = [
            'name' => '',
        ];

        $data = array_merge($defaults, $this->getRequest()->getPost());

        // We save the object
        if ($this->getRequest()->isPost()) {
            $data  = array_merge($data, $this->getRequest()->getPost());
            $table = new PublishersTable();
            $table->saveArray($data, PublishersMaps::MAP_PUBLISHER);

            $this->getResponse()
                ->getHeaders()
                ->set('Location', '/publishers/index');

            return 0;
        }

        return [
            'post' => $data
        ];
    }

    public function editAction()
    {
        $id    = (int) $this->getEvent()->getRoute()->getParam('id');
        $table = new PublishersTable();
        $data  = $table->getPublisherArray($id);

        if (empty($data)) {
            $this->getResponse()
                ->getHeaders()
                ->set('Location', '/publishers/index');

            return 0;
        }

        // We save the object
        if ($this->getRequest()->isPost()) {
            $data = array_merge($data, $this->getRequest()->getPost());
            $table->saveArray($data, PublishersMaps::MAP_PUBLISHER);
        }

        return [
            'post' => $data
        ];
    }

    public function deleteAction()
    {
        $id     = (int) $this->getEvent()->getRoute()->getParam('id');
        $table  = new PublishersTable();
        $object = $table->getPublisher($id);

        if ($object->getId() !== 0) {
            $table->deleteObject($object, PublishersMaps::MAP_PUBLISHER);
        }

        $this->getResponse()
            ->getHeaders()
            ->set('Location', '/publishers/index');

        return 0;
    }
}
