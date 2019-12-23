<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Messages
 *
 * @ORM\Table(name="messages")
 *
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
     * @ORM\ManyToOne(targetEntity="Categories", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     * @return Categories
     */
    public function setCategory(Categories $category)
    {
        $this->category = $category;
    }

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
