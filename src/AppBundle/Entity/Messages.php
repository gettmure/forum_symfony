<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\SequenceGenerator;
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
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="posted_at", type="datetime", nullable=false)
     */
    private $postedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Users")
     */
    private $author;

    /**
     * @var guid
     *
     * @ORM\Column(name="id", type="guid", nullable=false)
     * @ORM\Id
     * @GeneratedValue(strategy="UUID")
     */
    private $id;

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
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return Messages
     */
    public function setAuthor($author)
    {
        $this->author = $author;
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
}
