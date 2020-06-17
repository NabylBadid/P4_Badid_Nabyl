<?php

namespace App\Entity;

use DateTime;

/**
 * Classe gérant l'entité article
 */
class Article
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $pseudo;

    /**
     * @var string
     */
    private $imgName;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var Comment
     */
    private $comments;

    // GETTERS

    /**
     * @return int
     */
    public function getId() : ?int // = retourne soit un int soit null
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle() : ?string
    {
        return $this->title;
    }
    
    /**
     * @return string
     */
    public function getContent() : ?string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getPseudo() : ?string
    {
        return $this->pseudo;
    }
    
    /**
     * @return string
     */
    public function getImgName() : ?string
    {
        return $this->imgName;
    }
    
    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return Comment
     */
    public function getComments()
    {
        return $this->comments;
    }

    // SETTERS

    /**
     * @param int $id
     * @return self
     */
    public function setId(?int $id) : self // = prend en parametre soit un int soit un null et se renvoi lui-même
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(?string $title) : self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $content
     * @return self
     */
    public function setContent(?string $content) : self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param string $pseudo
     * @return self
     */
    public function setPseudo(?string $pseudo) : self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @param string $imgName
     * @return self
     */
    public function setImgName(?string $imgName) : self
    {
        $this->imgName = $imgName;

        return $this;
    }

    /**
     * @param DateTime $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt) : self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param CommentDAO $comments
     * @return self
     */
    public function setComments($comments) : self
    {
        $this->comments = $comments;

        return $this;
    }

}
