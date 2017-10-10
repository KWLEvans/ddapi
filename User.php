<?php

    class User {
        private $username;
        private $password;
        private $email;
        private $admin;
        private $token;
        private $id;

        function __construct($username, $password, $email = NULL, $token = NULL, $id = NULL)
        {
            $this->username = $username;
            $this->password = password_hash($password, PASSWORD_DEFAULT);
            $this->email = $email;
            $this->admin = 0;
            if ($token == NULL) {
                $this->token = uniqid();
            } else {
                $this->token = $token;
            }
            $this->id = $id;
        }

        function getUserName()
        {
            return $this->username;
        }

        function getEmail()
        {
            return $this->email;
        }

        function getToken()
        {
            return $this->token;
        }

        function save()
        {
            $save = $GLOBALS['DB']->prepare("INSERT INTO users (username, password, email, token) VALUES (:username, :password, :email, :token);");
            $save->execute([':username' => $this->username, ':password' => $this->password, ':email' => $this->email, ':token' => $this->token]);
            $this->id = $GLOBALS['DB']->lastInsertId();
            return $this->token;
        }

        function verifyPassword($password) {
            return password_verify($password, $this->password);
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM users;');
        }

        static function find($id)
        {
            $returned_user = $GLOBALS['DB']->query("SELECT * FROM users WHERE id = {$id};");
            $user = $returned_user->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User', ['username', 'password', 'email', 'token', 'id']);
            return $user[0];
        }

        static function findByUsername($username)
        {
            $returned_user = $GLOBALS['DB']->prepare("SELECT * FROM users WHERE username = :username;");
            $returned_user->execute([':username' => $username]);
            $user = $returned_user->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User', ['username', 'password', 'email', 'token', 'id']);
            if ($user) {
                return $user[0];
            } else {
                return false;
            }
        }

        static function findByEmail($email)
        {
            $returned_user = $GLOBALS['DB']->prepare("SELECT * FROM users WHERE email = :email;");
            $returned_user->execute([':email' => $email]);
            $user = $returned_user->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User', ['username', 'password', 'email', 'token', 'id']);
            if ($user) {
                return $user[0];
            } else {
                return false;
            }
        }

        static function findByToken($token)
        {
            $returned_user = $GLOBALS['DB']->prepare("SELECT * FROM users WHERE token = :token;");
            $returned_user->execute([':token' => $token]);
            $user = $returned_user->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User', ['username', 'password', 'email', 'token', 'id']);
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
                $users = $returned_users->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User', ['username', 'password', 'email', 'token', 'id']);
            } else {
                $users = [];
            }
            return $users;
        }

        static function new($username, $password, $email)
        {
            if (!User::findByUsername($username) && !User::findByEmail($email)) {
                $user = new User($username, $password, $email);
                return $user->save();
            } else {
                return false;
            }
        }

        static function verifyByPassword($username, $password)
        {
            $user = User::findByUsername($username);
            if ($user->verifyPassword($password)) {
                return true;
            } else {
                return false;
            }
        }

        static function verifyByToken($token)
        {
            if (User::findByToken($token)) {
                return true;
            } else {
                return false;
            }
        }
    }

?>
