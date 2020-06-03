<?php

namespace App\src\DAO;

use App\config\Parameter;
use App\src\model\Comment;
use PDO;

class CommentDAO extends DAO
{
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

    public function getCommentsFromUser($userId)
    {
        // Jointure avec INNER JOIN (normalisée)
        $sql = 'SELECT comment.id, comment.pseudo, comment.content, comment.flag, DATE_FORMAT(comment.createdAt, \'%d/%m/%Y à %Hh%imin%ss\') AS createdAt, comment.articleId, article.title FROM comment INNER JOIN article ON comment.articleId = article.id AND comment.pseudo = ? ORDER BY createdAt DESC';
        // Jointure avec WHERE (dénormalisée ou ancienne)
        // $sql = 'SELECT comment.id, comment.pseudo, comment.content, comment.flag, DATE_FORMAT(comment.createdAt, \'le %d/%m/%Y à %Hh%imin%ss\') AS createdAt, comment.articleId, article.title FROM comment, article WHERE comment.articleId = article.id AND comment.pseudo = ? ORDER BY comment.createdAt DESC';
        
        // Code tuto
        // $result = $this->createQuery($sql, [$userId]);

        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $userId , PDO::PARAM_STR);
        $result->execute();

        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();

        return $comments;
    }

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

    public function deleteComment($commentId)
    {
        $sql = 'DELETE FROM comment WHERE id = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $commentId, PDO::PARAM_INT);
        $result->execute();
        
        // Code tuto
        // $this->createQuery($sql, [$commentId]);
    }

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
