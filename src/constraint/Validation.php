<?php

namespace App\Constraint;

/**
 * Classe validant les différentes entités (article, commentaire et utlisateur), appele les classes gérant les valations
 */
class Validation
{   
    /**
     * Méthode valiadant un article
     * @param  $data données POST envoyées par Jean 
     * @return void
     */
    public function validateArticle($data)
    {
        $articleValidation = new ArticleValidation();
    
        return $articleValidation->check($data);
    }

    /**
     * Méthode validant un commentaire
     * @param  $data données POST envoyées par l'utilisateur
     * @return void
     */
    public function validateComment($data)
    {
        $commentValidation = new CommentValidation();

        return $commentValidation->check($data);
    }

    /**
     * Méthode validant les données d'un utilisateur
     * @param  $data données POST envoyées par l'utilisateur
     * @return void
     */
    public function validateUser($data)
    {
        $userValidation = new UserValidation();

        return $userValidation->check($data);   
    }
}
