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
use Application\Model\Table\BooksTable;
use Application\Model\Table\Maps\BooksMaps;
use Application\Model\Table\PublishersTable;

/**
 * Class IndexController
 *
 * @package Application\Controller
 */
class IndexController extends AbstractController
{
    public function indexAction()
    {
        $books = new BooksTable();

        return [
            'books' => $books->getBooks(),
        ];
    }

    public function addAction()
    {
        $defaults = [
            'title' => '',
            'isbn' => '',
        ];

        $data = array_merge($defaults, $this->getRequest()->getPost());

        // We save the object
        if ($this->getRequest()->isPost()) {
            $data = array_merge($data, $this->getRequest()->getPost());
            $table = new BooksTable();
            $table->saveArray($data, BooksMaps::MAP_BOOK);

            $this->getResponse()
                ->getHeaders()
                ->set('Location', '/index/index');

            return 0;
        }

        $publishers = (new PublishersTable())->getPublishers();
        $authors = (new AuthorsTable())->getAuthors();

        return [
            'post' => $data,
            'publishers' => $publishers,
            'authors' => $authors,
        ];
    }

    public function editAction()
    {
        $id = (int) $this->getEvent()->getRoute()->getParam('id');
        $table = new BooksTable();
        $data = $table->getBookArray($id);

        if (empty($data)) {
            $this->getResponse()
                ->getHeaders()
                ->set('Location', '/index/index');

            return 0;
        }

        // We save the object
        if ($this->getRequest()->isPost()) {
            $data = array_merge($data, $this->getRequest()->getPost());

            // Converting the data structure
            $object = $table->getObjectMapper()->populate($data, BooksMaps::MAP_BOOK);
            $data = $table->getObjectMapper()->extract($object, BooksMaps::MAP_BOOK_DB_SAVE);

            $table->saveArray($data, BooksMaps::MAP_BOOK_DB_SAVE);
        }

        $publishers = (new PublishersTable())->getPublishers();
        $authors = (new AuthorsTable())->getAuthors();

        return [
            'post' => $data,
            'publishers' => $publishers,
            'authors' => $authors,
        ];
    }

    public function deleteAction()
    {
        $id = (int) $this->getEvent()->getRoute()->getParam('id');
        $table = new BooksTable();
        $object = $table->getBook($id);

        if ($object->getId() !== 0) {
            $table->deleteObject($object, BooksMaps::MAP_BOOK);
        }

        $this->getResponse()
            ->getHeaders()
            ->set('Location', '/index/index');

        return 0;
    }
}
