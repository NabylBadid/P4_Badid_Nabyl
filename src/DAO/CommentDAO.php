<?php

namespace App\src\DAO;

use App\config\Parameter;
use App\src\model\Comment;

class CommentDAO extends DAO
{
    private function buildObject($row)
    {
        $comment = new Comment();
        $comment->setId($row['id']);
        $comment->setPseudo($row['pseudo']);
        $comment->setContent($row['content']);
        $comment->setCreatedAt($row['createdAt']);
        $comment->setFlag($row['flag']);
        return $comment;
    }

    public function getCommentsFromArticle($articleId)
    {
        $sql = 'SELECT id, pseudo, content, flag, DATE_FORMAT(createdAt, \'le %d/%m/%Y à %Hh%imin%ss\') AS createdAt FROM comment WHERE articleId = ? ORDER BY createdAt DESC';
        $result = $this->createQuery($sql, [$articleId]);
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
    }

    public function getCommentsFromUser($userId)
    {
        // Jointure avec INNER JOIN (normalisée)
        $sql = 'SELECT comment.id, comment.pseudo, comment.content, comment.flag, DATE_FORMAT(comment.createdAt, \'le %d/%m/%Y à %Hh%imin%ss\') AS createdAt, comment.articleId, article.title FROM comment INNER JOIN article ON comment.articleId = article.id AND comment.pseudo = ? ORDER BY createdAt DESC';
        // Jointure avce WHERE (dénormalisée ou ancienne)
        // $sql = 'SELECT comment.id, comment.pseudo, comment.content, comment.flag, DATE_FORMAT(comment.createdAt, \'le %d/%m/%Y à %Hh%imin%ss\') AS createdAt, comment.articleId, article.title FROM comment, article WHERE comment.articleId = article.id AND comment.pseudo = ? ORDER BY comment.createdAt DESC';

        $result = $this->createQuery($sql, [$userId]);
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
        $result = $this->createQuery($sql, [$commentId]);
        $comment = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($comment);
    }

    public function addComment(Parameter $post, $articleId)
    {
        $sql = 'INSERT INTO comment (pseudo, content, createdAt, flag, articleId) VALUES (?, ?, NOW(), ?, ?)';
        $this->createQuery($sql, [$post->get('pseudo'), $post->get('content'), 0, $articleId]);
    }

    public function editComment(Parameter $post, $commentId)
    {
        $sql = 'UPDATE comment SET content=:content WHERE id=:commentId';
        $this->createQuery($sql, [
            'content' => $post->get('content'),
            'commentId' => $commentId
            ]);
    }

    public function flagComment($commentId)
    {
        $sql = 'UPDATE comment SET flag = ? WHERE id = ?';
        $this->createQuery($sql, [1, $commentId]);
    }
    
    public function unflagComment($commentId)
    {
        $sql = 'UPDATE comment SET flag = ? WHERE id = ?';
        $this->createQuery($sql, [0, $commentId]);
    }

    public function deleteComment($commentId)
    {
        $sql = 'DELETE FROM comment WHERE id = ?';
        $this->createQuery($sql, [$commentId]);
    }

    public function getFlagComments()
    {
        $sql = 'SELECT id, pseudo, content, createdAt, flag, articleId FROM comment WHERE flag = ? ORDER BY createdAt DESC';
        $result = $this->createQuery($sql, [1]);
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
    }
}