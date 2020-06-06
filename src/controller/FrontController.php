<?php

namespace App\src\controller;

use App\config\Parameter;

/**
 * Classe gérant les traitement front 
 */
class FrontController extends Controller
{
    /**
     * Méthode renvoyant à la page d'acceuil
     * @return void
     */
    public function home()
    {
        $articles = $this->articleDAO->getArticles();
        
        return $this->view->render('home', [
           'articles' => $articles
        ]);
    }

    /**
     * Méthode renvoyant un article
     * @param int $articleId
     * @return void
     */
    public function article($articleId)
    {
        $article = $this->articleDAO->getArticle($articleId);
        $comments = $this->commentDAO->getCommentsFromArticle($articleId); // A passer dans le ArticleDAO

        return $this->view->render('single', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    /**
     * Méthode permettant l'ajout d'un commentaire
     * @param Parameter $post
     * @param int $articleId
     * @return void
     */
    public function addComment(Parameter $post, $articleId)
    {
        if ($post->get('submit')) {
            $errors = $this->validation->validateComment($post);
            if (!$errors) {
                $this->commentDAO->addComment($post, $articleId);
                $this->session->set('add_comment', 'Le nouveau commentaire a bien été ajouté !');
                header('Location: ../public/index.php?route=article&articleId=' . $articleId);
            }
            $article = $this->articleDAO->getArticle($articleId);
            $comments = $this->commentDAO->getCommentsFromArticle($articleId);

            return $this->view->render('single', [
                'article' => $article,
                'comments' => $comments,
                'post' => $post,
                'errors' => $errors
            ]);
        }
    }

    /**
     * Méthode permmettant de signaler un commentaire
     * @param int $commentId
     * @param int $articleId
     * @return void
     */
    public function flagComment($commentId, $articleId)
    {
        $this->commentDAO->flagComment($commentId);
        $this->session->set('flag_comment', 'Le commentaire a bien été signalé');
        header('Location: ../public/index.php?route=article&articleId=' . $articleId);
    }

    /**
     * Méthode permettant se s'inscrire
     * @param Parameter $post données envoyées en POST par l'utilisateur
     * @return void
     */
    public function register(Parameter $post)
    {
        if ($post->get('submit')) {
            $errors = $this->validation->validateUser($post);
            if ($this->userDAO->checkUser($post)) {
                $errors['pseudo'] = $this->userDAO->checkUser($post);
            }
            if (!$errors) {
                $this->userDAO->register($post);
                $this->session->set('register', 'Votre inscription a bien été effectuée !');
                header('Location: ../public/index.php');
            }
            
            return $this->view->render('register', [
                'post' => $post,
                'errors' => $errors
            ]);
        }
        
        return $this->view->render('register');
    }

    /**
     * Méthode permettant de se connecter
     * @param Parameter $post données envoyées en POST par l'utilisateur
     * @return void
     */
    public function login(Parameter $post)
    {
        if ($post->get('submit')) {
            $result = $this->userDAO->login($post);
            if($result && $result['isPasswordValid']) {
                $this->session->set('login', 'Content de vous revoir !');
                $this->session->set('id', $result['result']['id']);
                $this->session->set('role', $result['result']['role']);
                $this->session->set('pseudo', $post->get('pseudo'));
            header('Location: ../public/index.php');
            }
            else {
                $this->session->set('error_login', 'Le pseudo et/ou le mot de passe sont incorrects');
                
                return $this->view->render('login', [
                    'post'=> $post
                ]);
            }
        }
        
        return $this->view->render('login');
    }
}
