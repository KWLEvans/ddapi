<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "User.php";
    use PHPUnit\Framework\TestCase;

    $server = 'mysql:host=localhost:8889;dbname=ddapi_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class UserTest extends TestCase
    {

        protected function tearDown()
        {
            User::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $username = "test_user";
            $password = "password";
            $email = "test@email.com";
            $test_user = new User($username, $password, $email);

            //Act
            $test_user->save();
            $result = User::getAll();

            // Assert
            $this->assertEquals($username, $result[0]->getUserName());
            $this->assertEquals($email, $result[0]->getEmail());
            $this->assertTrue(User::verifyUser($username, $password));
        }

        function test_findByEmail()
        {
            //Arrange
            $username = "test_user";
            $password = "password";
            $email = "test@email.com";
            $test_user = new User($username, $password, $email);
            $test_user->save();

            //Act
            $result = User::findByEmail($email);

            // Assert
            $this->assertEquals($username, $result->getUserName());
            $this->assertEquals($email, $result->getEmail());
            $this->assertTrue(User::verifyUser($username, $password));
        }

        function test_findByUsername()
        {
            //Arrange
            $username = "test_user";
            $password = "password";
            $email = "test@email.com";
            $test_user = new User($username, $password, $email);
            $test_user->save();

            //Act
            $result = User::findByUsername($username);

            // Assert
            $this->assertEquals($username, $result->getUserName());
            $this->assertEquals($email, $result->getEmail());
            $this->assertTrue(User::verifyUser($username, $password));
        }

        function test_getAll()
        {
            //Arrange
            $username1 = "test_user";
            $password1 = "password";
            $email1 = "test@email.com";
            $test_user = new User($username1, $password1, $email1);
            $test_user->save();
            $username2 = "test_user2";
            $password2 = "password2";
            $email2 = "test2@email.com";
            $test_user2 = new User($username2, $password2, $email2);
            $test_user2->save();

            //Act
            $result = User::getAll();

            // Assert
            $this->assertEquals($username1, $result[0]->getUserName());
            $this->assertEquals($email1, $result[0]->getEmail());
            $this->assertTrue(User::verifyUser($username1, $password1));
            $this->assertEquals($username2, $result[1]->getUserName());
            $this->assertEquals($email2, $result[1]->getEmail());
            $this->assertTrue(User::verifyUser($username1, $password1));
        }

        function test_new()
        {
            //Arrange
            $username = "test_user";
            $password = "password";
            $email = "test@email.com";

            //Act
            User::new($username, $password, $email);
            $result = User::getAll();

            //Assert
            $this->assertEquals($username, $result[0]->getUserName());
            $this->assertEquals($email, $result[0]->getEmail());
            $this->assertTrue(User::verifyUser($username, $password));
        }

        function test_new_duplicate_username()
        {
            //Arrange
            $username = "test_user";
            $password = "password";
            $email = "test@email.com";
            $test_user = new User($username, $password, $email);
            $test_user->save();

            //Act
            $result = User::new($username, $password, 'test2@email.com');

            //Assert
            $this->assertEquals(false, $result);
        }

        function test_new_duplicate_email()
        {
            //Arrange
            $username = "test_user";
            $password = "password";
            $email = "test@email.com";
            $test_user = new User($username, $password, $email);
            $test_user->save();

            //Act
            $result = User::new('test_user2', $password, $email);

            //Assert
            $this->assertEquals(false, $result);
        }

    }

?>
