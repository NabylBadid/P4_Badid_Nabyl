<?php

namespace App\src\controller;

use App\config\Parameter;

class BackController extends Controller
{
    private function checkLoggedIn()
    {
        if (!$this->session->get('pseudo')) {
            $this->session->set('need_login', 'Vous devez vous connecter pour accéder à cette page');
            header('Location: ../public/index.php?route=login');
        } else {
            return true;
        }
    }

    private function checkAdmin()
    {
        $this->checkLoggedIn();
        if (!($this->session->get('role') === 'admin')) {
            $this->session->set('not_admin', 'Vous n\'avez pas le droit d\'accéder à cette page');
            header('Location: ../public/index.php?route=profile');
        } else {
            return true;
        }
    }

    public function administration(Parameter $post)
    {
        $articles = $this->articleDAO->getArticles();
        $comments = $this->commentDAO->getFlagComments();
        $users = $this->userDAO->getUsers();
        $confirmed = $this->session->get('accesAdmin');

        // Déja confirmé ?
        if ($confirmed) {
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

    public function addArticle(Parameter $post)
    {
        if ($this->checkAdmin()) {
            if ($post->get('submit')) {
                $errors = $this->validation->validate($post, 'Article');
                if (!$errors) {
                    $this->articleDAO->addArticle($post, $this->session->get('id'));
                    $this->session->set('add_article', 'Le nouvel article a bien été ajouté !');
                    header('Location: ../public/index.php?route=administration');
                }
                return $this->view->render('add_article', [
                    'post' => $post,
                    'errors' => $errors
                ]);
            }
            return $this->view->render('add_article');
        }
    }

    public function editArticle(Parameter $post, $articleId)
    {
        if ($this->checkAdmin()) {
            $article = $this->articleDAO->getArticle($articleId);
            if ($post->get('submit')) {
                $errors = $this->validation->validate($post, 'Article');
                if (!$errors) {
                    $this->articleDAO->editArticle($post, $articleId, $this->session->get('id'));
                    $this->session->set('edit_article', 'L\' article a bien été modifié');
                    header('Location: ../public/index.php?route=administration');
                }
                return $this->view->render('edit_article', [
                    'post' => $post,
                    'errors' => $errors
                ]);
            }
            $post->set('id', $article->getId());
            $post->set('title', $article->getTitle());
            $post->set('content', $article->getContent());
            $post->set('author', $article->getAuthor());
            $post->set('imgName', $article->getImgName());
            

            return $this->view->render('edit_article', [
                'post' => $post
            ]);
        }
    }

    public function deleteArticle($articleId)
    {
        if ($this->checkAdmin()) {
            $this->articleDAO->deleteArticle($articleId);
            $this->session->set('delete_article', 'L\' article a bien été supprimé');
            header('Location: ../public/index.php?route=administration');
        }
    }

    public function editComment(Parameter $post, $commentId, $articleId)
    {
        $article = $this->articleDAO->getArticle($articleId);
        $comments = $this->commentDAO->getCommentsFromArticle($articleId);
        $comment = $this->commentDAO->getComment($commentId);
        if ($post->get('submit')) {
            $errors = $this->validation->validate($post, 'Comment');
            if (!$errors) {
                $this->commentDAO->editComment($post, $commentId);
                $this->session->set('edit_comment', 'Le commentaire a bien été modifié');
                header('Location: ../public/index.php?route=article&articleId=' . $articleId);
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

    public function unflagComment($commentId)
    {
        if ($this->checkAdmin()) {
            $this->commentDAO->unflagComment($commentId);
            $this->session->set('unflag_comment', 'Le commentaire a bien été désignalé');
            header('Location: ../public/index.php?route=administration');
        }
    }

    public function deleteComment($commentId, $articleId)
    {
        $this->commentDAO->getComment($commentId);
        if ($this->checkAdmin()) {
            $this->commentDAO->deleteComment($commentId);
            $this->session->set('delete_comment', 'Le commentaire a bien été supprimé');
            header('Location: ../public/index.php?route=article&articleId=' . $articleId);
        }
    }

    public function profile($userId)
    {
        $comments = $this->commentDAO->getCommentsFromUser($userId);
        if ($this->checkLoggedIn()) {
            return $this->view->render('profile', [
                'comments' => $comments,
                'userId' => $userId
            ]);
        }
    }

    public function updatePassword(Parameter $post)
    {
        if ($this->checkLoggedIn()) {
            if ($post->get('submit')) {
                $this->userDAO->updatePassword($post, $this->session->get('pseudo'));
                $this->session->set('update_password', 'Le mot de passe a été mis à jour');
                header('Location: ../public/index.php?route=profile');
            }
            return $this->view->render('update_password');
        }
    }

    public function logout()
    {
        if ($this->checkLoggedIn()) {
            $this->logoutOrDelete('logout');
        }
    }

    public function deleteAccount()
    {
        if ($this->checkLoggedIn()) {
            $this->userDAO->deleteAccount($this->session->get('pseudo'));
            $this->logoutOrDelete('delete_account');
        }
    }

    public function deleteUser($userId)
    {
        if ($this->checkAdmin()) {
            $this->userDAO->deleteUser($userId);
            $this->session->set('delete_user', 'L\'utilisateur a bien été supprimé');
            header('Location: ../public/index.php?route=administration');
        }
    }

    private function logoutOrDelete($param)
    {
        $this->session->stop();
        $this->session->start();
        if ($param === 'logout') {
            $this->session->set($param, 'À bientôt');
        } else {
            $this->session->set($param, 'Votre compte a bien été supprimé');
        }
        header('Location: ../public/index.php');
    }
}
