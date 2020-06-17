<?php

namespace App\Controller;

use App\Config\Request;
use App\Constraint\Validation;
use App\Model\ArticleDAO;
use App\Model\CommentDAO;
use App\Model\UserDAO;
use App\Entity\View;

/**
 * Classe permettant l'accès aux données nécessaires dans FrontController, BackController et ErrorController
 */
abstract class Controller
{
    /**
     * Objet permettant le gestion des articles en bdd
     * @var ArticleDAO
     */
    protected $articleDAO;

    /**
     * Objet permettant le gestion des commentaires en bdd
     * @var CommentDAO
     */
    protected $commentDAO;

    /**
     * Objet permettant le gestion des utilisateurs en bdd
     * @var UserDAO
     */
    protected $userDAO;

    /**
     * Objet permettant le gestion des vues
     * @var View
     */
    protected $view;

    /**
     * Objet permettant le gestion des requêtes en bdd
     * @var Request
     */
    private $request;

    /**
     * Variable renvoyant le contenu de GET
     * @var 
     */
    protected $get;

    /**
     * Variable renvoyant le contenu de POST
     * @var 
     */
    protected $post;

    /**
     * Variable renvoyant le contenu en SESSION
     * @var
     */
    protected $session;

    /**
     * Variable permettant la validation des données envoyées en POST
     * @var 
     */
    protected $validation;

    /**
     * Constructeur de la classe qui assigne les données spécifiées en paramètre aux attributs correspondants.
     * @return void
     */
    public function __construct()
    {
        $this->articleDAO = new ArticleDAO();
        $this->commentDAO = new CommentDAO();
        $this->userDAO = new UserDAO();
        $this->view = new View();
        $this->validation = new Validation();
        $this->request = new Request();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->session = $this->request->getSession();
    }
}
