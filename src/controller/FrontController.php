<?php

namespace App\Controller;

use App\Config\Parameter;

/**
 * Classe gérant les traitement front
 */
class FrontController extends Controller
{
    /**
     * @var ErrorController
     */
    private $errorController;

    public function __construct()
    {
        // Appel du constructeur de la classe mère (car celui-ci n'est pas appelé automatiquement)
        parent::__construct();
        // Création d'une instance d'errorController
        $this->errorController = new ErrorController();
    }
    
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

        return $this->view->render('single', [
            'article' => $article
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
            $userId = $this->post->get('userId');
            $sessionId = $this->session->get('id');
            if ($userId != $sessionId) { // Si l'utilisateur a changé l'input "userId" alors on le redirige
                // Affichage de l'erreur
                // $errors['userId'] = 'L\'utilisateur n\'existe pas';
                // Redirection errorServer
                $this->errorController->errorServer();
            }
            if (!$errors) {
                $this->commentDAO->addComment($post, $articleId);
                $this->session->set('add_comment', 'Le nouveau commentaire a bien été ajouté !', 'flash');
                header('Location: ../public/index.php?route=article&articleId=' . $articleId);
                exit;
            }
            $article = $this->articleDAO->getArticle($articleId);

            return $this->view->render('single', [
                'article' => $article,
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
        $this->session->set('flag_comment', 'Le commentaire a bien été signalé', 'flash');
        header('Location: ../public/index.php?route=article&articleId=' . $articleId);
        exit;
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
                $this->session->set('register', 'Votre inscription a bien été effectuée !', 'flash');
                header('Location: ../public/index.php');
                exit;
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
            if ($result && $result['isPasswordValid']) {
                $this->session->set('login', 'Content de vous revoir !', 'flash');
                $this->session->set('id', $result['result']['id']);
                $this->session->set('role', $result['result']['role']);
                $this->session->set('pseudo', $post->get('pseudo'));
                header('Location: ../public/index.php');
                exit;
            } else {
                $this->session->set('error_login', 'Le pseudo et/ou le mot de passe sont incorrects');
                
                return $this->view->render('login', [
                    'post'=> $post
                ]);
            }
        }
        
        return $this->view->render('login');
    }
}
