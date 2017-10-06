<?php

    class User {
        private $username;
        private $password;
        private $email;
        private $id;

        function __construct($username, $password, $email = NULL, $id = NULL)
        {
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->id = $id;
        }

        function getCharacters() {
            return Character::getAllByUser($this->id);
        }

        function save()
        {
            $save = $GLOBALS['DB']->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email);");
            $save->execute([':username' => $this->username, ':password' => $this->password, ':email' => $this->email]);
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM users;');
        }

        static function find($id)
        {
            $returned_user = $GLOBALS['DB']->query("SELECT * FROM users WHERE id = {$id};");
            $user = $returned_user->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User', ['username', 'password', 'email', 'id']);
            return $user[0];
        }

        static function findByUsername($username)
        {
            $returned_user = $GLOBALS['DB']->prepare("SELECT * FROM users WHERE username = ':username';");
            $returned_user->execute([':username' => $username]);
            $user = $returned_user->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User', ['username', 'password', 'email', 'id']);
            if ($user) {
                return $user[0];
            } else {
                return false;
            }
        }

        static function findByEmail($email)
        {
            $returned_user = $GLOBALS['DB']->prepare("SELECT * FROM users WHERE email = ':email';");
            $returned_user->execute([':email' => $email]);
            $user = $returned_user->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User', ['username', 'password', 'email', 'id']);
            if ($user) {
                return $user[0];
            } else {
                return false;
            }
        }

        static function getAll()
        {
            $returned_users = $GLOBALS['DB']->query("SELECT * FROM users;");
            if ($returned_users) {
                $users = $returned_users->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User', ['username', 'password', 'email', 'id']);
            } else {
                $users = [];
            }
            return $users;
        }

        static function newUser($username, $password, $email)
        {
            if (!findByUsername($username) && !findByEmail($email)) {
                $user = new User($username, $password, $email);
                $user->save();
            }
        }
    }

?>
