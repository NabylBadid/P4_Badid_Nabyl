<?php

namespace App\src\DAO;

use App\config\Parameter;
use App\src\model\Article;

class ArticleDAO extends DAO
{
    private function buildObject($row)
    {
        $article = new Article();
        $article // Principe de chaînage des methodes
            ->setId($row['id'])
            ->setTitle($row['title'])
            ->setContent($row['content'])
            ->setPseudo($row['pseudo'])
            ->setCreatedAt($row['createdAt'])
            ->setImgName($row['imgName'])
        ;
        
        return $article;
    }

    public function getArticles()
    {
        $sql = 'SELECT article.id, article.title, article.content, user.pseudo, article.imgName, DATE_FORMAT(article.createdAt, \'%d/%m/%Y à %Hh%imin%ss\') AS createdAt FROM article INNER JOIN user ON article.user_id = user.id ORDER BY article.id DESC';
        $result = $this->createQuery($sql);
        // $articles = [];
        // while ($data = $result->fetch(\PDO::FETCH_ASSOC)) {
        //     $articles[] = new Article($data);
        // }
        // return $articles;

        // $articles = [];

        // $result->setFetchMode(\PDO::FETCH_CLASS, \PDO::FETCH_PROPS_LATE, 'Article');

        // $articles = $result->fetchAll();

        // return $articles;
        foreach ($result as $row){
            $articleId = $row['id'];
            $articles[$articleId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $articles;
    }

    public function getArticle($articleId)
    {
        $sql = 'SELECT article.id, article.title, article.content, user.pseudo, DATE_FORMAT(article.createdAt, \' %d/%m/%Y à %Hh%imin%ss\') AS createdAt, article.imgName FROM article INNER JOIN user ON article.user_id = user.id WHERE article.id = ?';
        $result = $this->createQuery($sql, [$articleId]);
        // $data = $result->fetch(\PDO::FETCH_ASSOC);
        // $article = new Article($data);
        // return $article;

        $article = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($article);
    }

    public function addArticle(Parameter $post, $userId)
    {
        $sql = 'INSERT INTO article (title, content, createdAt, imgName, user_id) VALUES (?, ?, NOW(), ?, ?)';
        $this->createQuery($sql, [$post->get('title'), $post->get('content'), $post->get('imgName'), $userId]);
    }

    public function editArticle(Parameter $post, $articleId, $userId)
    {
        $sql = 'UPDATE article SET title=:title, content=:content, imgName=:imgName, user_id=:user_id WHERE id=:articleId';
        $this->createQuery($sql, [
            'title' => $post->get('title'),
            'content' => $post->get('content'),
            'imgName' => $post->get('imgName'),
            'user_id' => $userId,
            'articleId' => $articleId
        ]);
    }

    public function deleteArticle($articleId)
    {
        $sql = 'DELETE FROM comment WHERE articleId = ?';
        $this->createQuery($sql, [$articleId]);
        $sql = 'DELETE FROM article WHERE id = ?';
        $this->createQuery($sql, [$articleId]);
    }
}
