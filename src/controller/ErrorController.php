<?php

namespace App\src\controller;
use App\src\model\View;

class ErrorController
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function errorNotFound()
    {
        return $this->view->render('error_404');
        // require '../templates/error_404.php';
    }

    public function errorServer()
    {
        return $this->view->render('error_500');
        // require '../templates/error_500.php';
    }
}