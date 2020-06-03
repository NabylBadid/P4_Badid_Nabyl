<?php

namespace App\src\model;

use DateTime;

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


    // SETTERS

    
    /**
     * @param int $id
     */
    public function setId(?int $id) : self // = prend en parametre soit un int soit un null et se renvoi lui-même
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $title
     */
    public function setTitle(?string $title) : self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $content
     */
    public function setContent(?string $content) : self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo(?string $pseudo) : self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @param string $imgName
     */
    public function setImgName(?string $imgName) : self
    {
        $this->imgName = $imgName;

        return $this;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt) : self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
