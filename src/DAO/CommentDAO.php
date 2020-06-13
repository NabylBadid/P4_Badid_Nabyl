<?php

namespace App\DAO;

use App\Config\Parameter;
use App\Model\Comment;
use PDO;

/**
 * Classe gérant les commentaires en bdd
 */
class CommentDAO extends DAO
{
    /**
     * Méthode créant un objet à partir des données récupérées
     * @param string $row ligne correspondant un élément d'une entrée en bdd
     * @return Comment
     */
    private function buildObject($row)
    {
        $comment = new Comment();
        $comment
            ->setId($row['id'])
            ->setPseudo($row['pseudo'])
            ->setContent($row['content'])
            ->setCreatedAt($row['createdAt'])
            ->setFlag($row['flag'])
            ->setArticleId($row['articleId'])
        ;

        return $comment;
    }

    /**
     * Méthode récuperant les commentaires liés à un article
     * @param int $articleId identifiant de l'article
     * @return Comment
     */
    public function getCommentsFromArticle($articleId)
    {
        $sql = 'SELECT id, pseudo, content, flag, DATE_FORMAT(createdAt, \'%d/%m/%Y à %Hh%imin%ss\') AS createdAt, articleId FROM comment WHERE articleId = ? ORDER BY createdAt DESC';        
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $articleId , PDO::PARAM_INT);
        $result->execute();
        $comments = [];
        
        foreach ($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        
        return $comments;
        
        // Code tuto
        // $result = $this->createQuery($sql, [$articleId]);
    }

    /**
     * Méthode renvoyant les commentaires liés à un utilisateur
     * @param string $pseudoUser nom de l'utilisateur
     * @return Comment
     */
    public function getCommentsFromUser($pseudoUser)
    {
        // Jointure avec INNER JOIN (normalisée)
        $sql = 'SELECT comment.id, comment.pseudo, comment.content, comment.flag, DATE_FORMAT(comment.createdAt, \'%d/%m/%Y à %Hh%imin%ss\') AS createdAt, comment.articleId, article.title FROM comment INNER JOIN article ON comment.articleId = article.id AND comment.pseudo = ? ORDER BY createdAt DESC';
        // Jointure avec WHERE (dénormalisée ou ancienne)
        // $sql = 'SELECT comment.id, comment.pseudo, comment.content, comment.flag, DATE_FORMAT(comment.createdAt, \'le %d/%m/%Y à %Hh%imin%ss\') AS createdAt, comment.articleId, article.title FROM comment, article WHERE comment.articleId = article.id AND comment.pseudo = ? ORDER BY comment.createdAt DESC';
        
        // Code tuto
        // $result = $this->createQuery($sql, [$userId]);

        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $pseudoUser , PDO::PARAM_STR);
        $result->execute();

        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();

        return $comments;
    }

    /**
     * Méthode récupérant un commentaire
     * @param int $commentId identifiant du commetaire
     * @return Comment
     */
    public function getComment($commentId)
    {
        $sql = 'SELECT * FROM comment WHERE id = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $commentId , PDO::PARAM_INT);
        $result->execute();       
        $comment = $result->fetch();
        $result->closeCursor();
        
        return $this->buildObject($comment);

        // Code tuto
        // $result = $this->createQuery($sql, [$commentId]);
    }

    /**
     * Méthode ajoutant un commentaire
     * @param Parameter $post données POST envoyées pas l'utilsateur 
     * @param int $articleId identifiant de l'article
     * @return void
     */
    public function addComment(Parameter $post, $articleId)
    {
        $sql = 'INSERT INTO comment (pseudo, content, createdAt, flag, articleId) VALUES (?, ?, NOW(), ?, ?)';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, htmlspecialchars($post->get('pseudo')), PDO::PARAM_STR);
        $result->bindValue(2, $post->get('content'), PDO::PARAM_STR);
        $result->bindValue(3, 0, PDO::PARAM_INT);
        $result->bindValue(4, $articleId, PDO::PARAM_INT);
        $result->execute();

        // Code tuto
        //$this->createQuery($sql, [htmlspecialchars($post->get('pseudo')),$post->get('content'), 0, $articleId]);
    }

    /**
     * Méthode modifiant un commentaire
     * @param Parameter $post données POST envoyées pas l'utilsateur
     * @param int $commentId identifiant du commentaire
     * @return void
     */
    public function editComment(Parameter $post, $commentId)
    {
        $sql = 'UPDATE comment SET content=:content WHERE id=:commentId';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':content', $post->get('content'), PDO::PARAM_STR);
        $result->bindValue(':commentId', $commentId, PDO::PARAM_INT);
        $result->execute();
        
        // $this->createQuery($sql, [
        //     'content' => $post->get('content'),
        //     'commentId' => $commentId
        //     ]);
    }

    /**
     * Méthode signalant un commentaire
     * @param int $commentId identifiant du commentaire
     * @return void
     */
    public function flagComment($commentId)
    {
        $sql = 'UPDATE comment SET flag = ? WHERE id = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, 1, PDO::PARAM_INT);
        $result->bindValue(2, $commentId, PDO::PARAM_INT);
        $result->execute();

        //Code tuto
        // $this->createQuery($sql, [1, $commentId]);
    }
    
    /**
     * Méthode désignalant un commentaire
     * @param int $commentId identifiant d'un commentaire
     * @return void
     */
    public function unflagComment($commentId)
    {
        $sql = 'UPDATE comment SET flag = ? WHERE id = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, 0, PDO::PARAM_INT);
        $result->bindValue(2, $commentId, PDO::PARAM_INT);
        $result->execute();

        // Code tuto
        // $this->createQuery($sql, [0, $commentId]);
    }

    /**
     * Méthode supprimant un commentaire
     * @param int $commentId identifiant du commentaire
     * @return void
     */
    public function deleteComment($commentId)
    {
        $sql = 'DELETE FROM comment WHERE id = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $commentId, PDO::PARAM_INT);
        $result->execute();
        
        // Code tuto
        // $this->createQuery($sql, [$commentId]);
    }

    /**
     * Méthode récupérant les commentaires signalés
     * @return Comment
     */
    public function getFlagComments()
    {
        $sql = 'SELECT id, pseudo, content, DATE_FORMAT(createdAt, \'le %d/%m/%Y à %Hh%imin%ss\') AS createdAt, flag, articleId FROM comment WHERE flag = ? ORDER BY createdAt DESC';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, 1, PDO::PARAM_INT);
        $result->execute();
        $comments = [];
        
        foreach ($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        
        return $comments;

        // Requête tuto
        // $result = $this->createQuery($sql, [1]);
    }
}
