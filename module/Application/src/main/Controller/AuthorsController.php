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
use Application\Model\Table\Maps\AuthorsMaps;

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

        // We save the object
        if ($this->getRequest()->isPost()) {
            $data  = array_merge($data, $this->getRequest()->getPost());
            $table = new AuthorsTable();
            $table->saveArray($data, AuthorsMaps::MAP_AUTHOR);

            $this->getResponse()
                ->getHeaders()
                ->set('Location', '/authors/index');

            return 0;
        }

        return [
            'post' => $data
        ];
    }

    public function editAction()
    {
        $id    = (int) $this->getEvent()->getRoute()->getParam('id');
        $table = new AuthorsTable();
        $data  = $table->getAuthorArray($id);

        if (empty($data)) {
            $this->getResponse()
                ->getHeaders()
                ->set('Location', '/authors/index');

            return 0;
        }

        // We save the object
        if ($this->getRequest()->isPost()) {
            $data = array_merge($data, $this->getRequest()->getPost());
            $table->saveArray($data, AuthorsMaps::MAP_AUTHOR);
        }

        return [
            'post' => $data
        ];
    }

    public function deleteAction()
    {
        $id     = (int) $this->getEvent()->getRoute()->getParam('id');
        $table  = new AuthorsTable();
        $object = $table->getAuthor($id);

        if ($object->getId() !== 0) {
            $table->deleteObject($object, AuthorsMaps::MAP_AUTHOR);
        }

        $this->getResponse()
            ->getHeaders()
            ->set('Location', '/authors/index');

        return 0;
    }
}
