<?php

namespace App\src\DAO;

use App\config\Parameter;
use App\src\model\User;
use PDO;

class UserDAO extends DAO
{
    private function buildObject($row)
    {
        $user = new User();
        $user
            ->setId($row['id'])
            ->setPseudo($row['pseudo'])
            ->setCreatedAt($row['createdAt'])
            ->setRole($row['role'])
        ;

        return $user;
    }

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

    public function updatePassword(Parameter $post, $pseudo)
    {
        $sql = 'UPDATE user SET password = ? WHERE pseudo = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, password_hash($post->get('password'), PASSWORD_BCRYPT), PDO::PARAM_STR);
        $result->bindValue(2, $pseudo, PDO::PARAM_STR);
        $result->execute();
        
        // $this->createQuery($sql, [password_hash($post->get('password'), PASSWORD_BCRYPT), $pseudo]);
    }

    public function deleteAccount($pseudo)
    {
        $sql = 'DELETE FROM user WHERE pseudo = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $pseudo, PDO::PARAM_STR);
        $result->execute();

        // Code tuto
        // $this->createQuery($sql, [$pseudo]);
    }

    public function deleteUser($userId)
    {
        $sql = 'DELETE FROM user WHERE id = ?';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(1, $userId, PDO::PARAM_INT);
        $result->execute();

        // Code tuto
        // $this->createQuery($sql, [$userId]);
    }

    public function accesAdmin()
    {
        $sql = 'SELECT * FROM user WHERE id = 8';
        $data = $this->createQuery($sql);
        $result = $data->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
