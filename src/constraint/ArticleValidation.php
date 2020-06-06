<?php

namespace App\src\constraint;

use App\config\Parameter;

/**
 * Classe gérant la validation d'un article
 */
class ArticleValidation extends Validation
{
    /**
     * erreurs de saisies de l'utilisateur
     * @var array
     */
    private $errors = [];

    /**
     * @var Constraint
     */
    private $constraint;

    /**
     * Constructeur de la classe qui assigne les données spécifiées en paramètre aux attributs correspondants.
     * @return void
     */
    public function __construct()
    {
        $this->constraint = new Constraint();
    }

    /**
     * Méthode vérifiant tous les champs du formulaire
     * @param Parameter $post données POST envoyées par l'utilisateur
     * @return void
     */
    public function check(Parameter $post)
    {
        foreach ($post->all() as $key => $value) {
            $this->checkField($key, $value);
        }
        return $this->errors;
    }

    /**
     * Méthode affiliant à chaque champ sont la vérification qui lui est propre
     * @param string $name nom du champ
     * @param string $value saisie utilisateur
     * @return void
     */
    private function checkField($name, $value)
    {
        if ($name === 'title') {
            $error = $this->checkTitle($name, $value);
            // $this->addError($name, $error);
        } elseif ($name === 'content') {
            $error = $this->checkContent($name, $value);
            // $this->addError($name, $error);
        } elseif ($name === 'imgName') {
            $error = $this->checkImgName($name, $value);
            // $this->addError($name, $error);
        }
    }

    /**
     * Méthode ajoutant les erreurs de saisies
     * @param string $name nom du champ
     * @param string $error message d'erreur renvoyé 
     * @return void
     */
    private function addError($name, $error)
    {
        if ($error) {
            $this->errors += [
                $name => $error
            ];
        }
    }

    /**
     * Méthode vériiant le titre de l'article
     * @param string $name nom du champ
     * @param string $value saisie utilisateur
     * @return void
     */
    private function checkTitle($name, $value)
    {
        $value = $this->constraint->sanitizeString($value);

        return array (
            $this->addError('title', $this->constraint->minLength('title', $value, 2)),
            $this->addError('title', $this->constraint->maxLength('title', $value, 255))
        );

        // if ($this->constraint->notBlank($name, $value)) {
        //     return $this->constraint->notBlank('titre', $value);
        // }
        // if ($this->constraint->minLength($name, $value, 2)) {
        //     return $this->constraint->minLength('titre', $value, 2);
        // }
        // if ($this->constraint->maxLength($name, $value, 255)) {
        //     return $this->constraint->maxLength('titre', $value, 255);
        // }
    }

    /**
     * Méthode vériiant le contenu de l'article
     * @param string $name nom du champ
     * @param string $value saisie utilisateur
     * @return void
     */
    private function checkContent($name, $value)
    {
        $value = $this->constraint->sanitizeString($value);

        return array (
            $this->addError('content', $this->constraint->minLength('content', $value, 2))
        );

        // if ($this->constraint->notBlank($name, $value)) {
        //     return $this->constraint->notBlank('contenu', $value);
        // }
        // if ($this->constraint->minLength($name, $value, 2)) {
        //     return $this->constraint->minLength('contenu', $value, 2);
        // }
    }

    /**
     * Méthode vériiant le nom de l'image de l'article
     * @param string $name nom du champ
     * @param string $value saisie utilisateur
     * @return void
     */
    private function checkImgName($name, $value)
    {
        $value = $this->constraint->sanitizeString($value);

        return array (
            $this->addError('imgName', $this->constraint->minLength('imgName', $value, 3)),
            $this->addError('imgName', $this->constraint->maxLength('imgName', $value, 100))
        );

        // if ($this->constraint->notBlank($name, $value)) {
        //     return $this->constraint->notBlank('imgName', $value);
        // }
        // if ($this->constraint->minLength($name, $value, 3)) {
        //     return $this->constraint->minLength('imgName', $value, 3);
        // }
        // if ($this->constraint->maxLength($name, $value, 100)) {
        //     return $this->constraint->maxLength('imgName', $value, 100);
        // }
    }
}
