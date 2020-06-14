<?php

namespace App\Config;

/**
 * Classe gérant la session ($_SESSION)
 */
class Session
{
    /**
     * @var string
     */
    private $session;

    /**
     * Constructeur de la classe qui assigne les données spécifiées en paramètre aux attributs correspondants.
     * @return void
     */
    public function __construct($session)
    {
        $this->session = $session;
    }

    /**
     * Setter session
     * @param string $name nom de la varible mise en session
     * @param string $value valeur de la variable
     * @return void
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Getter session
     * @param string $name nom de la varible mise en session
     * @return void
     */
    public function get($name)
    {
        if (isset($_SESSION[$name])) {
            
            return $_SESSION[$name];
        }
    }

    /**
     * Méthode 
     * @param string $name nom de la varible mise en session
     * @return void
     */
    public function show($name)
    {
        if (isset($_SESSION[$name])) {
            $key = $this->get($name);
            $this->remove($name);
            
            return $key;
        }
    }

    /**
     * Méthode effacant une variable en Session
     * @param string $name nom de la varible mise en session
     * @return void
     */
    public function remove($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * Méthode démarrant la Session
     * @return void
     */
    public function start()
    {
        session_start();
    }
    
    /**
     * Méthode arrêttant la Session
     * @return void
     */
    public function stop()
    {
        session_destroy(); // Détruit la session (et non les variables) (ne détruit pas les variables globales associées à la session, ni le cookie de session)
        session_unset(); // Détruit les variables de session, mais la session existe toujours. On peut détruire une seule variable avec unset. Voir la fonction remove juste au dessus
    }
}
