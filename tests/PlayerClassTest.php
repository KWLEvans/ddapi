<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "PlayerClass.php";
    use PHPUnit\Framework\TestCase;

    $server = 'mysql:host=localhost:8889;dbname=ddapi_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PlayerClassTest extends TestCase
    {
        protected function tearDown()
        {
            PlayerClass::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $name = "test ability";
            $flavor = "This is a very long description of a class. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... ";
            $hit_die = "d8";
            $primary_attribute = "Strength";
            $test_class = new PlayerClass($name, $flavor, $hit_die, $primary_attribute);

            //Act
            $test_class->save();
            $result = PlayerClass::getAll();

            //Assert
            $this->assertEquals($test_class, $result[0]);
        }
    }

?>
