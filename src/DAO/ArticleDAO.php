<?php

namespace App\DAO;

use App\Config\Parameter;
use App\Model\Article;
use App\DAO\CommentDAO;
use PDO;

/**
 * Classe gérant les articles en bdd
 */
class ArticleDAO extends DAO
{
    /**
     * Objet permettant le gestion des commentaires en bdd
     * @var CommentDAO
     */
    private $commentDAO;

    /**
     * Constructeur de la classe qui assigne les données spécifiées en paramètre aux attributs correspondants.
     * @param $valeurs array Les valeurs à assigner
     * @return void
     */
    public function __construct() 
    {
        $this->commentDAO = new CommentDAO;
    }

    /**
     * Méthode créant un objet à partir des données récupérer en bdd
     * @param string $row ligne correspondant un élément d'une entrée en bdd
     * @return Article
     */
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
            ->setComments($this->commentDAO->getCommentsFromArticle($row['id']))
        ;
        
        return $article;
    }

    /**
     * Méthodes renvoyant tous les articles
     * @return Article
     */
    public function getArticles()
    {
        $sql = 'SELECT article.id, article.title, article.content, user.pseudo, article.imgName, DATE_FORMAT(article.createdAt, \'%d/%m/%Y à %Hh%imin%ss\') AS createdAt FROM article INNER JOIN user ON article.user_id = user.id ORDER BY article.id DESC';
        $result = $this->createQuery($sql);

        foreach ($result as $row) {
            $articleId = $row['id'];
            $articles[$articleId] = $this->buildObject($row);
        }
        $result->closeCursor();
        
        return $articles;
    }

    /**
     * Méthode renvoyant un article
     * @param int $articleId identifiant de l'article
     * @return Article
     */
    public function getArticle($articleId)
    {
        $sql = 'SELECT article.id, article.title, article.content, user.pseudo, DATE_FORMAT(article.createdAt, \' %d/%m/%Y à %Hh%imin%ss\') AS createdAt, article.imgName FROM article INNER JOIN user ON article.user_id = user.id WHERE article.id =:articleId';

        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':articleId', $articleId, PDO::PARAM_INT);
        $result->execute();
        $article = $result->fetch();
        $result->closeCursor();
        
        return $this->buildObject($article);
    }

    /**
     * Méthode ajoutant un article 
     * @param Parameter $post données POST envoyées par l'utilisateur
     * @param int $userId identifiant de l'utilisateur
     * @return void
     */
    public function addArticle(Parameter $post, $userId)
    {
        $sql = 'INSERT INTO article (title, content, createdAt, imgName, user_id) VALUES (?, ?, NOW(), ?, ?)';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $post->get('title'), PDO::PARAM_STR);
        $result->bindValue(2, $post->get('content'), PDO::PARAM_STR);
        $result->bindValue(3, $post->get('imgName'), PDO::PARAM_STR);
        $result->bindValue(4, $userId, PDO::PARAM_INT);
        $result->execute();
    }

    /**
     * Méthode modifiant un article 
     * @param Parameter $post données envoyés par l'utilisateur
     * @param int $articleId identifiant de l'article
     * @param int $userId identifiant de l'utilisateur
     * @return void
     */
    public function editArticle(Parameter $post, $articleId, $userId)
    {
        $sql = 'UPDATE article SET title=:title, content=:content, imgName=:imgName, user_id=:user_id WHERE id=:articleId';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':title', $post->get('title'), PDO::PARAM_STR);
        $result->bindValue(':content', $post->get('content'), PDO::PARAM_STR);
        $result->bindValue(':imgName', $post->get('imgName'), PDO::PARAM_STR);
        $result->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $result->bindValue(':articleId', $articleId, PDO::PARAM_INT);
        $result->execute();
    }

    /**
     * Méthode supprimant un article
     * @param int $articleId identifiant de l'article
     * @return void
     */
    public function deleteArticle($articleId)
    {
        $sql = 'DELETE FROM comment WHERE articleId = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $articleId, PDO::PARAM_INT);
        $result->execute();

        $sql = 'DELETE FROM article WHERE id = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $articleId, PDO::PARAM_INT);
        $result->execute();
    }
}
