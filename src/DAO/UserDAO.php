<?php

namespace App\src\DAO;

use App\config\Parameter;
use App\src\model\User;
use App\src\DAO\CommentDAO;
use PDO;

/**
 * Classe gérant les utilisateurs en bdd
 */
class UserDAO extends DAO
{
    /**
     * Objet permettant le gestion des commentaires en bdd
     * @var CommentDAO
     */
    private $commentDAO;

    /**
     * Constructeur de la classe qui assigne les données spécifiées en paramètre aux attributs correspondants.
     * @param $valeurs array Les valeurs à assigner
     * @return void
     */
    public function __construct() 
    {
        $this->commentDAO = new CommentDAO;
    }

    /**
     * Méthode créant un objet à partir des données récupérées
     * @param string $row ligne correspondant un élément d'une entrée en bdd
     * @return User
     */
    private function buildObject($row)
    {
        $user = new User();
        $user
            ->setId($row['id'])
            ->setPseudo($row['pseudo'])
            ->setCreatedAt($row['createdAt'])
            ->setRole($row['role'])
            ->setComments($this->commentDAO->getCommentsFromUser($row['pseudo']))
        ;

        return $user;
    }

    /**
     * Méthode récuperant les utilisateurs
     * @return User
     */
    public function getUsers()
    {
        $sql = 'SELECT id, pseudo, DATE_FORMAT(createdAt, \'le %d/%m/%Y\') AS createdAt, role FROM user ORDER BY user.id DESC';
        $result = $this->createQuery($sql);
        $users = [];

        foreach ($result as $row){
            $userId = $row['id'];
            $users[$userId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $users;
    }

    /**
     * Méthode récupérant un utilisateur
     * @param int $userId
     * @return User
     */
    public function getUser($userId)
    {
        $sql = 'SELECT id, pseudo, DATE_FORMAT(createdAt, \'%d/%m/%Y à %Hh%imin%ss\') AS createdAt, role FROM user WHERE id =:userId';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':userId', $userId, PDO::PARAM_INT);
        $result->execute();
        $user = $result->fetch();
        $result->closeCursor();

        return $this->buildObject($user);
    }

    /**
     * Méthode enregistrant un nouvel utilisateur 
     * @param Parameter $post données POST envoyés pas l'utilisateur
     * @return void
     */
    public function register(Parameter $post)
    {
        $this->checkUser($post);
        $sql = 'INSERT INTO user (pseudo, password, createdAt, role) VALUES (?, ?, NOW(), ?)';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $post->get('pseudo'), PDO::PARAM_STR);
        $result->bindValue(2, password_hash($post->get('password'), PASSWORD_BCRYPT), PDO::PARAM_STR);
        $result->bindValue(3, 'utilisateur', PDO::PARAM_STR);
        $result->execute();

        // Code tuto
        // $this->createQuery($sql, [$post->get('pseudo'), password_hash($post->get('password'), PASSWORD_BCRYPT), 2]);
    }

    /**
     * Méthode vérifiant que le pseudo entré n'existe pas déjà
     * @param Parameter $post données POST envoyées par l'utilisateur
     * @return void
     */
    public function checkUser(Parameter $post)
    {
        $sql = 'SELECT COUNT(pseudo) FROM user WHERE pseudo = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $post->get('pseudo'), PDO::PARAM_STR);
        $result->execute();

        $isUnique = $result->fetchColumn();
        if ($isUnique) {
            return '<p>Le pseudo existe déjà</p>';
        }

        // Code tuto
        // $result = $this->createQuery($sql, [$post->get('pseudo')]);
    }

    /**
     * Méthode vérifiant que le visiteur se bien identifier
     * @param Parameter $post données POST envoyées par l'utilisateur
     * @return array
     */
    public function login(Parameter $post)
    {
        $sql = 'SELECT id, password, role FROM user WHERE pseudo = ?';
        $data = $this->checkConnection()->prepare($sql);
        $data->bindValue(1, $post->get('pseudo'), PDO::PARAM_STR);
        $data->execute();
        $result = $data->fetch();
        $isPasswordValid = password_verify($post->get('password'), $result['password']);
        return [
            'result' => $result,
            'isPasswordValid' => $isPasswordValid,
        ];

        // Code tuto
        // $data = $this->createQuery($sql, [$post->get('pseudo')]);
    }

    /**
     * Méthode modifiant un mot de passe
     * @param Parameter $post données POST envoyées par l'utilisateur
     * @param string $pseudo pseudo de l'utilisateur
     * @return void
     */
    public function updatePassword(Parameter $post, $pseudo)
    {
        $sql = 'UPDATE user SET password = ? WHERE pseudo = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, password_hash($post->get('password'), PASSWORD_BCRYPT), PDO::PARAM_STR);
        $result->bindValue(2, $pseudo, PDO::PARAM_STR);
        $result->execute();
        
        // $this->createQuery($sql, [password_hash($post->get('password'), PASSWORD_BCRYPT), $pseudo]);
    }

    /**
     * Méthode supprimant un compte
     * @param string $pseudo pseudo de l'utilisateur
     * @return void
     */
    public function deleteAccount($pseudo)
    {
        $sql = 'DELETE FROM user WHERE pseudo = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $pseudo, PDO::PARAM_STR);
        $result->execute();

        // Code tuto
        // $this->createQuery($sql, [$pseudo]);
    }

    /**
     * Méthode supprimant un utilisateur
     * @param int $userId identifiant de l'utilisateur
     * @return void
     */
    public function deleteUser($userId)
    {
        $sql = 'DELETE FROM user WHERE id = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $userId, PDO::PARAM_INT);
        $result->execute();

        // Code tuto
        // $this->createQuery($sql, [$userId]);
    }

    /**
     * Méthode récupérant l'identifiant et mot de passe d'accès à l'adminstration
     * @return array
     */
    public function accesAdmin()
    {
        $sql = 'SELECT * FROM user WHERE id = 8';
        $data = $this->createQuery($sql);
        $result = $data->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
