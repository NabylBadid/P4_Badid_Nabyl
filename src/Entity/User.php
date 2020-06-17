<?php

namespace App\Entity;

use DateTime;

/**
 * Classe gérant l'entité utilisateur
 */
class User
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
    private $password;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $role;

    /**
     * @var Comment
     */
    private $comments;

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
    public function getPassword() : ?string
    {
        return $this->password;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getRole()  : ?string
    {
        return $this->role;
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
    public function setId(?int $id) : self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $pseudo
     * @return self
     */
    public function setPseudo(?string $pseudo)  : self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @param DateTime $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)  : self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param string $password
     * @return self
     */
    public function setPassword(?string $password)  : self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $role
     * @return self
     */
    public function setRole($role)  : self
    {
        $this->role = $role;

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
