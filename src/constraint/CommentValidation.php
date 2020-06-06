<?php

namespace App\src\constraint;

use App\config\Parameter;

/**
 * Classe gérant la validation d'un commentaire
 */
class CommentValidation extends Validation
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
        if ($name === 'pseudo') {
            $error = $this->checkPseudo($name, $value);
            // $this->addError($name, $error);
        } else
        if ($name === 'content') {
            $error = $this->checkContent($name, $value);
            // $this->addError($name, $error);
        }
    }

    /**
     * Méthode ajoutant les erreurs de saisies
     * @param string $name nom du champ 
     * @param string $error message d'erreur renvoyé
     * @return array
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
     * Méthode vériiant le pseudo du commentaire
     * @param string $name nom du champ
     * @param string $value saisie utilisateur
     * @return array
     */
    private function checkPseudo($name, $value)
    {
        $value = $this->constraint->sanitizeString($value);

        return array (
            $this->addError('pseudo', $this->constraint->minLength('pseudo', $value, 2)),
            $this->addError('pseudo', $this->constraint->maxLength('pseudo', $value, 100))
        );


    //     // if ($this->constraint->notBlank($name, $value)) {
    //     //     return $this->constraint->notBlank('pseudo', $value);
    //     // }
    //     // if ($this->constraint->minLength($name, $value, 2)) {
    //     //     return $this->constraint->minLength('pseudo', $value, 2);
    //     // }
    //     // if ($this->constraint->maxLength($name, $value, 255)) {
    //     //     return $this->constraint->maxLength('pseudo', $value, 255);
    //     // }
    }

    /**
     * Méthode vériiant le contenu du commentaire
     * @param string $name nom du champ
     * @param string $value saisie utilisateur
     * @return array
     */
    private function checkContent($name, $value)
    {
        $value = $this->constraint->sanitizeString($value);

        return array (
            $this->addError('content', $this->constraint->minLength('content', $value, 2)),
        );


        // if ($this->constraint->notBlank($name, $value)) {
        //     return $this->constraint->notBlank('contenu', $value);
        // }
        // if ($this->constraint->minLength($name, $value, 2)) {
        //     return $this->constraint->minLength('contenu', $value, 2);
        // }
    }
}
