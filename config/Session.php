<?php

namespace App\config;

class Session
{
    private $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }

    public function show($name)
    {
        if (isset($_SESSION[$name])) {
            $key = $this->get($name);
            $this->remove($name);
            return $key;
        }
    }

    public function remove($name)
    {
        unset($_SESSION[$name]);
    }

    public function start()
    {
        session_start();
    }
    
    public function stop()
    {
        session_destroy(); // Détruit la session (et non les variables) (ne détruit pas les variables globales associées à la session, ni le cookie de session)
        session_unset(); // Détruit les variables de session, mais la session existe toujours. On peut détruire une seule variable avec unset. Voir la fonction remove juste au dessus
    }
}
