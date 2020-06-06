<?php

namespace App\src\controller;

/**
 * Classe gérant les erreurs de traitement
 */
class ErrorController extends Controller
{
    /**
     * Erreur 404 : Page non trouvée
     * @return void
     */
    public function errorNotFound()
    {
        $this->session->set('error_404', 'Oops désolé, la page demandée n\'existe pas !');
        header('Location: ../public/index.php');
    }

    /**
     * Erreur 500 : Problème avec le serveur
     * @return void
     */
    public function errorServer()
    {
        $this->session->set('error_500', 'Oops désolé, il y a eu un problème avec le serveur !');
        header('Location: ../public/index.php');
    }
}
