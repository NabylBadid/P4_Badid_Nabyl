<?php

namespace App\Constraint;

use App\Config\Parameter;

/**
 * Classe gérant la validation des identifiants d'un utilisateur
 */
class UserValidation extends Validation
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
     * @param string $value saisie utlisateur
     * @return void
     */
    private function checkField($name, $value)
    {
        if ($name === 'pseudo') {
            $error = $this->checkPseudo($name, $value);
        } elseif ($name === 'password') {
            $error = $this->checkPassword($name, $value);
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
     * Méthode vériiant le pseudo du l'utilisateur
     * @param string $name nom du champ
     * @param string $value saisie utilisateur
     * @return array
     */
    private function checkPseudo($name, $value)
    {
        $value = $this->constraint->sanitizeString($value);
        $name = $this->constraint->getMethodName(__CLASS__, __METHOD__);

        return array (
            $this->addError($name, $this->constraint->minLength($name, $value, 2)),
            $this->addError($name, $this->constraint->maxLength($name, $value, 255))
        );
    }

    /**
     * Méthode vériiant le mot de passe de l'utilisateur
     * @param string $name nom du champ
     * @param string $value saisie utilisateur
     * @return array
     */
    private function checkPassword($name, $value)
    {
        $value = $this->constraint->sanitizeString($value);
        $name = $this->constraint->getMethodName(__CLASS__, __METHOD__);

        return array (
            $this->addError($name, $this->constraint->minLength($name, $value, 2)),
            $this->addError($name, $this->constraint->maxLength($name, $value, 255))
        );
    }
}
