<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "RacialAbility.php";
    use PHPUnit\Framework\TestCase;

    $server = 'mysql:host=localhost:8889;dbname=ddapi_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RacialAbilityTest extends TestCase
    {
        protected function tearDown()
        {
            RacialAbility::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $name = "test ability";
            $description = "This is a very long description of a racial ability. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... ";
            $test_racial_ability = new RacialAbility($name, $description);

            //Act
            $test_racial_ability->save();
            $result = RacialAbility::getAll();

            // Assert
            $this->assertEquals($test_racial_ability, $result[0]);
        }
    }

?>
