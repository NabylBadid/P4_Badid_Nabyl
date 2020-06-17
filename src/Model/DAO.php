<?php

//Pour toutes les classes dans DAO
namespace App\Model;

//Uniquement pour la classe DAO
use PDO;
use Exception;

/** 
 * Classe gérant la connection à la bdd et l'envoie des requêtes
 */
abstract class DAO
{
    /**
     * Connection à la bdd
     * @var 
     */
    private $connection;

    /**
     * Méthode vérifiant la connection à la bdd
     * @return void
     */
    protected function checkConnection()
    {
        //Vérifie si la connexion est nulle et fait appel à getConnection()
        if ($this->connection === null) {
            
            return $this->getConnection();
        }
        
        //Si la connexion existe, elle est renvoyée, inutile de refaire une connexion
        return $this->connection;
    }

    /**
     * Méthode de connexion à notre base de données
     * @return void
     */
    private function getConnection()
    {
        //Tentative de connexion à la base de données
        try {
            $this->connection = new PDO(DB_HOST, DB_USER, DB_PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //On renvoie la connexion
            return $this->connection;
        }
        //On lève une erreur si la connexion échoue
        catch (Exception $errorConnection) {
            die('Erreur de connection :'.$errorConnection->getMessage());
        }
    }

    /**
     * Méthode créant une requête SQL 
     * @param string $sql requête SQL
     * @param  $parameters paramètres de la requête
     * @return void
     */
    protected function createQuery($sql, $parameters = null)
    {
        if ($parameters) {
            $result = $this->checkConnection()->prepare($sql);
            $result->execute($parameters);
            
            return $result;
        }
        $result = $this->checkConnection()->query($sql);

        return $result;
    }
}
