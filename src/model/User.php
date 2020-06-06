<?php

namespace App\src\model;

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
    
    // SETTERS
    
    /**
     * @param int $id
     */
    public function setId(?int $id) : self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo(?string $pseudo)  : self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt)  : self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param string $password
     */
    public function setPassword(?string $password)  : self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $role
     */
    public function setRole($role)  : self
    {
        $this->role = $role;

        return $this;
    }
}
