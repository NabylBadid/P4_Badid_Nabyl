<?php

namespace App\Controller;

use App\Config\Parameter;
use App\Controller\ErrorController;

/**
 * Classe gérant les traitemens backend
 */
class BackController extends Controller
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
     * Méthode vérifiant si le visiteur est connecté
     * @return void
     */
    private function checkLoggedIn()
    {
        if (!$this->session->get('pseudo')) {
            $this->session->set('need_login', 'Vous devez vous connecter pour accéder à cette page', 'flash');
            header('Location: ../public/index.php?route=login');
            exit;
        } else {
            return true;
        }
    }

    /**
     * Méthode vérifiant si le visiteur est un administrateur
     * @return void
     */
    private function checkAdmin()
    {
        $this->checkLoggedIn();
        if (!($this->session->get('role') === 'administrateur')) {
            $this->session->set('not_admin', 'Vous n\'avez pas le droit d\'accéder à cette page', 'flash');
            header('Location: ../public/index.php?route=profile');
            exit;
        } else {
            return true;
        }
    }

    /**
     * Méthode contrôlant l'accès à l'administration
     * @param Parameter $post
     * @return void
     */
    public function administration(Parameter $post)
    {
        $articles = $this->articleDAO->getArticles();
        $comments = $this->commentDAO->getFlagComments();
        $users = $this->userDAO->getUsers();
        $confirmed = $this->session->get('accesAdmin');

        // Déja confirmé ?
        if ($confirmed !== null) {
            return $this->view->render('administration', [
                'articles' => $articles,
                'comments' => $comments,
                'users' => $users
            ]);
        }

        // Formuliaire soumit
        if ($post->get('submit')) {
            $result = $this->userDAO->accesAdmin();
            if ($post->get('pseudo') === $result['pseudo'] && password_verify($post->get('password'), $result['password'])) {
                $this->session->set('accesAdmin', 'Bienvenue sur la page d\'administration');

                return $this->view->render('administration', [
                    'articles' => $articles,
                    'comments' => $comments,
                    'users' => $users
                ]);
            } else {
                $this->session->set('error_login', 'Le pseudo ou le mot de passe sont incorrects');
            }
        }

        return $this->view->render('administration');
    }

    /**
     * Méthode permettant d'ajouter un article
     * @param Parameter $post données POST envoyées par l'utilisateur
     * @return void
     */
    public function addArticle(Parameter $post)
    {
        if ($this->checkAdmin()) {
            if ($post->get('submit')) {
                $errors = $this->validation->validateArticle($post);
                if (!$errors) {
                    $this->articleDAO->addArticle($post, $this->session->get('id'));
                    $this->session->set('add_article', 'Le nouvel article a bien été ajouté !', 'flash');
                    header('Location: ../public/index.php?route=administration');
                    exit;
                }
                
                return $this->view->render('add_article', [
                    'post' => $post,
                    'errors' => $errors
                ]);
            }
            
            return $this->view->render('add_article');
        }
    }

    /**
     * Méthode permettant de modifier un article
     * @param Parameter $post données POST envoyées par l'utilisateur
     * @param int $articleId identifiant de l'article en bdd
     * @return void
     */
    public function editArticle(Parameter $post, $articleId)
    {
        if ($this->checkAdmin()) {
            $article = $this->articleDAO->getArticle($articleId);
            if ($post->get('submit')) {
                $errors = $this->validation->validateArticle($post);
                if (!$errors) {
                    $this->articleDAO->editArticle($post, $articleId, $this->session->get('id'));
                    $this->session->set('edit_article', 'L\' article a bien été modifié', 'flash');
                    header('Location: ../public/index.php?route=administration');
                    exit;
                }
                
                return $this->view->render('edit_article', [
                    'post' => $post,
                    'errors' => $errors
                ]);
            }
            $post->set('id', $article->getId());
            $post->set('title', $article->getTitle());
            $post->set('content', $article->getContent());
            $post->set('author', $article->getPseudo());
            $post->set('imgName', $article->getImgName());
            
            return $this->view->render('edit_article', [
                'post' => $post
            ]);
        }
    }

    /**
     * Méthode permettant de supprimer un article
     * @param int $articleId identifiant de l'article en bdd
     * @return void
     */
    public function deleteArticle($articleId)
    {
        if ($this->checkAdmin()) {
            $this->articleDAO->deleteArticle($articleId);
            $this->session->set('delete_article', 'L\' article a bien été supprimé', 'flash');
            header('Location: ../public/index.php?route=administration');
            exit;
        }
    }

    /**
     * Méthode permettant de modifier un commentaire
     * @param Parameter $post données POST envoyées par l'utilisateur
     * @param int $commentId identifiant du commentaire en bdd
     * @param int $articleId identifiant de l'article en bdd
     * @return void
     */
    public function editComment(Parameter $post, $commentId, $articleId)
    {
        $article = $this->articleDAO->getArticle($articleId);
        $comment = $this->commentDAO->getComment($commentId);
        if ($post->get('submit')) {
            $errors = $this->validation->validateComment($post);
            $invalidUserId = $this->userDAO->checkUserId($post->get('id'));
            if ($invalidUserId) {
                // Affichage de l'erreur
                // $errors['userId'] = $invalidUserId;
                // Redirection errorServer
                $this->errorController->errorServer();
            }
            if (!$errors) {
                $this->commentDAO->editComment($post, $commentId);
                $this->session->set('edit_comment', 'Le commentaire a bien été modifié', 'flash');
                header('Location: ../public/index.php?route=article&articleId=' . $articleId);
                exit;
            }
            
            return $this->view->render('edit_comment', [
                'post' => $post,
                'article' => $article,
                'comment' => $comment,
                'errors' => $errors
            ]);
        }
        $post->set('content', $comment->getContent());

        return $this->view->render('edit_comment', [
            'post' => $post,
            'comment' => $comment,
            'article' => $article,
            'commentId' => $commentId
        ]);
    }

    /**
     * Méthode permettant de désignaler un commentaire
     * @param int $commentId identifiant du commentaire en bdd
     * @return void
     */
    public function unflagComment($commentId)
    {
        if ($this->checkAdmin()) {
            $this->commentDAO->unflagComment($commentId);
            $this->session->set('unflag_comment', 'Le commentaire a bien été désignalé', 'flash');
            header('Location: ../public/index.php?route=administration');
        }
    }

    /**
     * Méthode permettant de supprimer un commentaire
     * @param int $commentId identifiant du commentaire en bdd
     * @param int $articleId identifiant de l'article en bdd
     * @return void
     */
    public function deleteComment($commentId, $articleId)
    {
        $this->commentDAO->deleteComment($commentId);
        $this->session->set('delete_comment', 'Le commentaire a bien été supprimé', 'flash');
        if (isset($articleId)) {
            header('Location: ../public/index.php?route=article&articleId=' . $articleId);
            exit;
        } else {
            header('Location: ../public/index.php?route=administration');
            exit;
        }
    }

    /**
     * Méthode renvoyant la page de profil de l'utilisateur
     * @param int $userId identifiant de l'utilisateur en bdd
     * @return void
     */
    public function profile($userId)
    {
        $user = $this->userDAO->getUser($userId);
        if ($this->checkLoggedIn()) {
            return $this->view->render('profile', [
                'user' => $user
            ]);
        }
    }

    /**
     * Méthode permettant de modifier son mot de passe
     * @param Parameter $post données POST envoyées par l'utilisateur
     * @return void
     */
    public function updatePassword(Parameter $post)
    {
        if ($this->checkLoggedIn()) {
            if ($post->get('submit')) {
                $this->userDAO->updatePassword($post, $this->session->get('pseudo'));
                $this->session->set('update_password', 'Le mot de passe a été mis à jour', 'flash');
                header('Location: ../public/index.php');
                exit;
            }
            
            return $this->view->render('update_password');
        }
    }

    /**
     * Méthode permettant de se déconnecter
     * @return void
     */
    public function logout()
    {
        if ($this->checkLoggedIn()) {
            $this->logoutOrDelete('logout');
        }
    }

    /**
     * Méthode permettant de supprimer son compte
     * @return void
     */
    public function deleteAccount()
    {
        if ($this->checkLoggedIn()) {
            $this->userDAO->deleteAccount($this->session->get('pseudo'));
            $this->logoutOrDelete('delete_account');
        }
    }

    /**
     * Méthode permettant de supprimer un utilisateur
     * @param int $userId idientifiant de l'utilisateur en bdd
     * @return void
     */
    public function deleteUser($userId)
    {
        if ($this->checkAdmin()) {
            $this->userDAO->deleteUser($userId);
            $this->session->set('delete_user', 'L\'utilisateur a bien été supprimé', 'flash');
            header('Location: ../public/index.php?route=administration');
            exit;
        }
    }

    /**
     * Méthode gérant la session lorsque l'utilisateur se déconnecte ou supprime son compte (méthode appelée dans $this->logout et $this->delete)
     * @param string $param 'logout' pour se déconncter et 'delete_account' pour supprimer son compte
     * @return void
     */
    private function logoutOrDelete($param)
    {
        $this->session->stop();
        $this->session->start();
        if ($param === 'logout') {
            $this->session->set($param, 'À bientôt', 'flash');
        } else {
            $this->session->set($param, 'Votre compte a bien été supprimé', 'flash');
        }
        header('Location: ../public/index.php');
        exit;
    }
}
