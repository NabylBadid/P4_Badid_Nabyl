<?php

namespace App\Model;

use App\Config\Parameter;
use App\Entity\Comment;
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
        // $sql = 'SELECT id, pseudo, content, flag, DATE_FORMAT(createdAt, \'%d/%m/%Y à %Hh%imin%ss\') AS createdAt, articleId FROM comment WHERE articleId = ? ORDER BY createdAt DESC';        
        $sql = 'SELECT comment.id, user.pseudo, comment.content, comment.flag, DATE_FORMAT(comment.createdAt, \'%d/%m/%Y à %Hh%imin%ss\') AS createdAt, comment.articleId FROM comment, article, user WHERE comment.articleId = ? AND comment.userId = user.id ORDER BY comment.createdAt DESC';

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
    }

    /**
     * Méthode renvoyant les commentaires liés à un utilisateur
     * @param int $userId id de l'utilisateur
     * @return Comment
     */
    public function getCommentsFromUser($userId)
    {
        // $sql = 'SELECT comment.id, comment.pseudo, comment.content, comment.flag, DATE_FORMAT(comment.createdAt, \'%d/%m/%Y à %Hh%imin%ss\') AS createdAt, comment.articleId, article.title FROM comment INNER JOIN article ON comment.articleId = article.id AND comment.pseudo = ? ORDER BY createdAt DESC';
        $sql = 'SELECT comment.id, user.pseudo, comment.content, comment.flag, DATE_FORMAT(comment.createdAt, \'%d/%m/%Y à %Hh%imin%ss\') AS createdAt, comment.articleId FROM comment INNER JOIN user ON comment.userId = user.id AND comment.userId = ? ORDER BY createdAt DESC';

        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $userId , PDO::PARAM_INT);
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
        $sql = 'SELECT comment.id, user.pseudo, comment.content, comment.flag, DATE_FORMAT(comment.createdAt, \'%d/%m/%Y à %Hh%imin%ss\') AS createdAt, comment.articleId FROM comment INNER JOIN user ON comment.userId = user.id WHERE comment.id = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $commentId , PDO::PARAM_INT);
        $result->execute();       
        $comment = $result->fetch();
        $result->closeCursor();
        
        return $this->buildObject($comment);
    }

    /**
     * Méthode ajoutant un commentaire
     * @param Parameter $post données POST envoyées pas l'utilsateur 
     * @param int $articleId identifiant de l'article
     * @return void
     */
    public function addComment(Parameter $post, $articleId)
    {
        $sql = 'INSERT INTO comment (content, createdAt, flag, articleId, userId) VALUES (?, NOW(), ?, ?, ?)';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $post->get('content'), PDO::PARAM_STR);
        $result->bindValue(2, 0, PDO::PARAM_INT);
        $result->bindValue(3, $articleId, PDO::PARAM_INT);
        $result->bindValue(4, $post->get('userId'), PDO::PARAM_STR);
        $result->execute();
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
    }
}
