<?php

namespace App\Entity;

use DateTime;

/**
 * Classe gérant l'entité commentaire
 */
class Comment
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $pseudo;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $articleId;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var bool
     */
    private $flag;

    /**
     * @var int
     */
    private $userId;

    // GETTERS

    /**
     * @return int
     */
    public function getId() : ?int
    {
        return $this->id;
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
    public function getContent()  : ?string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getArticleId()  : ?string
    {
        return $this->articleId;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return bool
     */
    public function isFlag() : ?bool
    {
        return $this->flag;
    }

    /**
     * @return int
     */
    public function getUserId() : ?int
    {
        return $this->userId;
    }

    // SETTERS

    /**
     * @param int $id
     * @return self
     */
    public function setId(?int $id) : self
    {
        $this->id = $id;

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
     * @param string $content
     * @return self
     */
    public function setContent(?string $content) : self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param string $articleId
     * @return self
     */
    public function setArticleId(?string $articleId) : self
    {
        $this->articleId = $articleId;

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
     * @param bool $flag
     * @return self
     */
    public function setFlag($flag) : self
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setUserId(?int $id) : self
    {
        $this->userId = $userId;

        return $this;
    }
}
