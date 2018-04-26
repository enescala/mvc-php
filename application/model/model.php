<?php

class Model
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    /**
     * Create user table
     */
    public function createTable()
    {
        $this->db->exec('CREATE TABLE IF NOT EXISTS user (
                        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                        name TEXT,
                        email TEXT,
                        password TEXT,
                        hash TEXT,
                        active INTEGER);');
    }

    /**
     * Get user data
     */
    public function getUser($email)
    {
        $this->createTable();

        $query = $this->db->prepare('SELECT * FROM user WHERE email = :email');

        $query->execute(array('email' => $email));

        return $query->fetch();
    }

    /**
     * Create new user account
     */
    public function addUser($name, $email, $password, $hash)
    {
        $query = $this->db->prepare('INSERT INTO user (name, email, password, hash, active) VALUES (:name, :email, :password, :hash, 0)');

        $query->execute(array(
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
            'hash'     => $hash
        ));
    }

    /**
     * Activate user account
     */
    public function activateUser($user_id)
    {
        $query = $this->db->prepare('UPDATE user SET active = 1 WHERE id = :id');

        $query->execute(array('id' => $user_id));
    }

    /**
     * Update user data
     */
    public function editUser($user_id, $name, $email)
    {
        $query = $this->db->prepare('UPDATE user SET name = :name, email = :email WHERE id = :id');

        $query->execute(array(
            'name'     => $name,
            'email'    => $email,
            'id'       => $user_id
        ));
    }

    /**
     * Update user password
     */
    public function updatePassword($user_id, $password)
    {
        $query = $this->db->prepare('UPDATE user SET password = :password WHERE id = :id');

        $query->execute(array(
            'password' => $password,
            'id'       => $user_id
        ));
    }

    /**
     * Detele user account
     */
    public function deleteUser($user_id)
    {
        $query = $this->db->prepare('DELETE FROM user WHERE id = :user_id');

        $query->execute(array('user_id' => $user_id));
    }
}
