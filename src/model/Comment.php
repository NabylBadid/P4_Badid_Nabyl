<?php

namespace App\Model;

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
     * Constructeur de la classe qui assigne les données spécifiées en paramètre aux attributs correspondants.
     * @param $valeurs array Les valeurs à assigner
     * @return void
     */
    public function __construct($values = [])
    {
        if (!empty($values)) {
            $this->hydrate($values);
        }
    }

    /**
     * Méthode assignant les valeurs spécifiées aux attributs correspondant.
     * @param $donnees array Les données à assigner
     * @return void
     */
    public function hydrate($data)
    {
        foreach ($data as $attribut => $value) {
            $method = 'set'.ucfirst($attribut);
    
            if (is_callable([$this, $method])) {
                $this->$method($value);
            }
        }
    }

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
}
