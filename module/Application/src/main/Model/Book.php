<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

namespace Application\Model;

use Acamar\Model\Entity\AbstractEntity;

/**
 * Class Book
 *
 * @package Application\Model
 */
class Book extends AbstractEntity
{
    /**
     * @var int
     */
    protected $id = 0;

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $isbn = '';

    /**
     * @var Publisher
     */
    protected $publisher = null;

    /**
     * @var Author
     */
    protected $author = null;

    /**
     * @param int $id
     *
     * @return Book
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     *
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $isbn
     *
     * @return Book
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @param Publisher $publisher
     *
     * @return Book
     */
    public function setPublisher(Publisher $publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * @return Book
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param Author $author
     *
     * @return Book
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
