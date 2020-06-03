<?php

namespace App\src\controller;

class ErrorController extends Controller
{
    public function errorNotFound()
    {
        $this->session->set('error_404', 'Oops désolé, la page demandée n\'existe pas !');
        header('Location: ../public/index.php');
    }

    public function errorServer()
    {
        $this->session->set('error_500', 'Oops désolé, il y a eu un problème avec le serveur !');
        header('Location: ../public/index.php');
    }
}
