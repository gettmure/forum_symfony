<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Messages
 *
 * @ORM\Table(name="messages")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessagesRepository")
 */
class Messages
{
    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=false)
     */
    private $text;

    /**
     * @var guid
     *
     * @ORM\Column(name="category_id", type="guid", nullable=false)
     */
    private $categoryId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="posted_at", type="datetime", nullable=false)
     */
    private $postedAt;

    /**
     * @var guid
     *
     * @ORM\Column(name="author_id", type="guid", nullable=false)
     */
    private $authorId;

    /**
     * @var guid
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     */
    private $id;

    public function __construct($author, $category, $text)
    {
        $this->id = Uuid::uuid4();
        $this->setAuthorId($author);
        $this->setCategoryId($category);
        $this->setPostedAt(new \DateTime());
        $this->setText($text);
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Messages
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set categoryId
     *
     * @param guid $categoryId
     *
     * @return Messages
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return guid
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set postedAt
     *
     * @param \DateTime $postedAt
     *
     * @return Messages
     */
    public function setPostedAt($postedAt)
    {
        $this->postedAt = $postedAt;

        return $this;
    }

    /**
     * Get postedAt
     *
     * @return \DateTime
     */
    public function getPostedAt()
    {
        return $this->postedAt;
    }

    /**
     * Set authorId
     *
     * @param guid $authorId
     *
     * @return Messages
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * Get authorId
     *
     * @return guid
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * Get id
     *
     * @return guid
     */
    public function getId()
    {
        return $this->id;
    }
}
