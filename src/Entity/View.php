<?php

namespace App\Entity;

use App\Config\Request;

/**
 * Classe gérant la vue
 */
class View
{
    /**
     * Nom du fichier
     * @var string
     */
    private $file;

    /**
     * Titre affiché dans la vue 
     * @var string
     */
    private $title;

    /**
     * Balise javascript
     * @var string
     */
    private $script;

    /**
     * Requête utilisateur
     * @var Request
     */
    private $request;

    /**
     * Renvoie un élément en session
     * @var 
     */
    private $session;

    /**
     * Constructeur de la classe qui assigne les données spécifiées en paramètre aux attributs correspondants.
     * @return void
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->session = $this->request->getSession();
    }

    /**
     * Méthode renvoyant une vue
     * @param string $template nom de la vue
     * @param array $data données envoyées à la vue
     * @return void
     */
    public function render($template, $data = [])
    {
        $this->file = '../templates/'.$template.'.php';
        $content  = $this->renderFile($this->file, $data);
        $view = $this->renderFile('../templates/base.php', [
            'title' => $this->title,
            'content' => $content,
            'session' => $this->session,
            'script' => $this->script
        ]);
        echo $view;
    }

    /**
     * Méthode renvoyant un fichier 
     * @param string $file nom du fichier 
     * @param array $data données présentes dans la page ($content)
     * @return void
     */
    private function renderFile($file, $data)
    {
        if (file_exists($file)) {
            extract($data);
            ob_start();
            require $file;
            
            return ob_get_clean();
        }
        header('Location: index.php?route=notFound');
    }
}
