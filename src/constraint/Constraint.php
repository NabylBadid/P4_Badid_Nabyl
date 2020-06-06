<?php

namespace App\src\constraint;

/**
 * Classe gérant les contraintes de validation pours les articles, commentaires et identifiants de l'utilisateur
 */
class Constraint
{
    // public function notBlank($name, $value)
    // {
    //     if (empty($value)) {
    //         return '<p>Le champ '.$name.' saisi est vide</p>';
    //     }
    // }
    
    /**
     * Méthode appliquant une longeur minimale à un champ
     * @param string $name nom du champ
     * @param string $value saisie utilsateur
     * @param int $minSize taille minimale
     * @return void
     */
    public function minLength($name, $value, $minSize)
    {
        if (strlen($value) < $minSize) {
            return '<p>Le champ '.$name.' doit contenir au moins '.$minSize.' caractères</p>';
        }
    }
    
    /**
     * Méthode appliquant une longeur maximale à un champ
     * @param string $name nom du champ
     * @param string $value saisie utilisateur
     * @param int $minSize taille maximale
     * @return void
     */
    public function maxLength($name, $value, $maxSize)
    {
        if (strlen($value) > $maxSize) {
            return '<p>Le champ '.$name.' doit contenir au maximum '.$maxSize.' caractères</p>';
        }
    }
    
    /**
     * Méthode désinfectant une valeur
     * @param string $value saisie utilisateur
     * @return void
     */
    public function sanitizeString($value)
    {
        return filter_var($value, FILTER_SANITIZE_STRING);
    }

    /**
     * Méthode validant un entier
     * @param int $value saisie utilisateur
     * @return void
     */
    public function validInt($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT);
    }
}
