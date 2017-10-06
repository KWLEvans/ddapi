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
            $username = "Ollie Lundergern";
            $password = "butts";
            $email = "leChatlier@chem.com";
            $test_user = new User($username, $password, $email);

            //Act
            $test_user->save();
            $result = User::getAll();

            // Assert
            $this->assertEquals($test_user, $result[0]);
        }

    }

?>
