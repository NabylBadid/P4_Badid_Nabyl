<?php

namespace App\Constraint;

use App\Config\Parameter;

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
     * @return array
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
        if ($name === 'userId') {
            $error = $this->checkUserId($name, $value);
        } else
        if ($name === 'content') {
            $error = $this->checkContent($name, $value);
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
    private function checkUserId($name, $value)
    {
        $value = $this->constraint->validInt($value);
        $name = $this->constraint->getMethodName(__CLASS__, __METHOD__);

        return array (
            $this->addError($name, $this->constraint->minLength($name, $value, 1)),
            $this->addError($name, $this->constraint->maxLength($name, $value, 255))
        );
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
        $name = $this->constraint->getMethodName(__CLASS__, __METHOD__);

        return array (
            $this->addError($name, $this->constraint->minLength($name, $value, 2)),
        );
    }
}
