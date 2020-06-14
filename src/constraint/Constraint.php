<?php

namespace App\Constraint;

/**
 * Classe gérant les contraintes de validation pours les articles, commentaires et identifiants de l'utilisateur
 */
class Constraint
{
    /**
     * Méthode appliquant une longeur minimale à un champ
     * @param string $name nom du champ
     * @param string $value saisie utilsateur
     * @param int $minSize taille minimale
     * @return string
     */
    public function minLength($name, $value, $minSize)
    {
        $name = str_replace(['title', 'content', 'imgName', 'password'], ['"titre"', '"contenu"', '"nom de l\'image"', '"mot de passe"'], $name);
        if (strlen($value) < $minSize) {
           
            return '<p>Le champ '.$name.' doit contenir au moins '.$minSize.' caractères</p>';
        }
    }
    
    /**
     * Méthode appliquant une longeur maximale à un champ
     * @param string $name nom du champ
     * @param string $value saisie utilisateur
     * @param int $minSize taille maximale
     * @return string
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
     * @return string
     */
    public function sanitizeString($value)
    {
        return filter_var($value, FILTER_SANITIZE_STRING);
    }

    /**
     * Méthode validant un entier
     * @param int $value saisie utilisateur
     * @return int
     */
    public function validInt($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT);
    }

    /**
     * Méthode renvoyant dynamiquement le nom d'une méthode
     * @param string $name variable magique __METHOD__
     * @return string
     */
    public function getMethodName($className, $name) 
    {        
        return lcfirst(str_replace($className . '::check', '', $name));
    }
}
