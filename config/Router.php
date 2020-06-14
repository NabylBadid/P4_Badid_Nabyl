<?php

namespace App\Config;

use App\Controller\BackController;
use App\Controller\ErrorController;
use App\Controller\FrontController;
use Exception;

/**
 * Classe gérant les routes
 */
class Router
{
    /**
     * @var FrontController
     */
    private $frontController;

    /**
     * @var BackController
     */
    private $backController;

    /**
     * @var ErrorController
     */
    private $errorController;
    
    /**
     * @var Request
     */
    private $request;

    /**
     * Constructeur de la classe qui assigne les données spécifiées en paramètre aux attributs correspondants.
     * @return void
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->frontController = new FrontController();
        $this->backController = new BackController();
        $this->errorController = new ErrorController();
    }

    /**
     * Méthode contrôlant les routes
     * @return void
     */
    public function run()
    {
        $route = $this->request->getGet()->get('route');
        try {
            if (isset($route)) {
                if ($route === 'article') {
                    $this->frontController->article($this->request->getGet()->get('articleId'));
                } elseif ($route === 'addArticle') {
                    $this->backController->addArticle($this->request->getPost());
                } elseif ($route === 'editArticle') {
                    $this->backController->editArticle($this->request->getPost(), $this->request->getGet()->get('articleId'));
                } elseif ($route === 'deleteArticle') {
                    $this->backController->deleteArticle($this->request->getGet()->get('articleId'));
                } elseif ($route === 'addComment') {
                    $this->frontController->addComment($this->request->getPost(), $this->request->getGet()->get('articleId'));
                } elseif ($route === 'editComment') {
                    $this->backController->editComment($this->request->getPost(), $this->request->getGet()->get('commentId'), $this->request->getGet()->get('articleId'));
                } elseif ($route === 'flagComment') {
                    $this->frontController->flagComment($this->request->getGet()->get('commentId'), $this->request->getGet()->get('articleId'));
                } elseif ($route === 'unflagComment') {
                    $this->backController->unflagComment($this->request->getGet()->get('commentId'));
                } elseif ($route === 'deleteComment') {
                    $this->backController->deleteComment($this->request->getGet()->get('commentId'), $this->request->getGet()->get('articleId'));
                } elseif ($route === 'register') {
                    $this->frontController->register($this->request->getPost());
                } elseif ($route === 'login') {
                    $this->frontController->login($this->request->getPost());
                } elseif ($route === 'profile') {
                    $this->backController->profile($this->request->getGet()->get('userId'));
                } elseif ($route === 'updatePassword') {
                    $this->backController->updatePassword($this->request->getPost());
                } elseif ($route === 'logout') {
                    $this->backController->logout();
                } elseif ($route === 'deleteAccount') {
                    $this->backController->deleteAccount();
                } elseif ($route === 'deleteUser') {
                    $this->backController->deleteUser($this->request->getGet()->get('userId'));
                } elseif ($route === 'administration') {
                    $this->backController->administration($this->request->getPost());
                } else {
                    $this->errorController->errorNotFound();
                }
            } else {
                $this->frontController->home();
            }
        } catch (Exception $e) {
            $this->errorController->errorServer();
        }
    }
}
