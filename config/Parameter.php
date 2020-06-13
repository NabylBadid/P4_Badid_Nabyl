<?php

namespace App\Config;

/**
 * Classe gérant les paramètres envoyés ($_GET, $_POST)
 */
class Parameter
{
    /**
     * @var string
     */
    private $parameter;

    /**
     * Constructeur de la classe qui assigne les données spécifiées en paramètre aux attributs correspondants.
     * @param $parameter superglobales Les données à assigner
     * @return void
    */
    public function __construct($parameter)
    {
        $this->parameter = $parameter;
    }

    /**
     * Méthode retournant une varible présentes dans une superglobales
     * @param $name nom de la variable
     * @return string
    */
    public function get($name)
    {
        if (isset($this->parameter[$name])) { 

            return $this->parameter[$name];
        }
    }

    /**
    * Méthode assignant une variable à une superglobale
     * @param string $name nom de la variable 
     * @param string $value valeur de la variable
     * @return void
     */
    public function set($name, $value)
    {
        $this->parameter[$name] = $value;
    }

    /**
     * Méthode retournant tout les variables présentes dans une supergloblaes
     * @return void
     */
    public function all()
    {
        return $this->parameter;
    }
}
