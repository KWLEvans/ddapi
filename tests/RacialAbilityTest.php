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

            //Assert
            $this->assertEquals($test_racial_ability, $result[0]);
        }

        function test_getByRace()
        {
            //Arrange
            $name = "test ability";
            $description = "This is a very long description of a racial ability. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... ";
            $test_racial_ability = new RacialAbility($name, $description);
            $test_racial_ability->save();
            $test_racial_ability->addRace(1);

            $name2 = "test ability2";
            $description2 = "This is a very long description of a racial ability. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... 2";
            $test_racial_ability2 = new RacialAbility($name2, $description2);
            $test_racial_ability2->save();
            $test_racial_ability2->addRace(2);

            //Act
            $test = RacialAbility::getByRace(2);

            //Assert
            $this->assertEquals($test_racial_ability2, $test[0]);
        }

        function test_build()
        {
            //Arrange
            $name = "test ability";
            $description = "This is a very long description of a racial ability. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... ";
            $test_racial_ability = new RacialAbility($name, $description);
            $test_racial_ability->save();

            $build = array();
            $build['name'] = $name;
            $build['description'] = $description;
            $build['id'] = $test_racial_ability->getId();

            //Act
            $result = $test_racial_ability->build();

            //Assert
            $this->assertEquals($build, $result);
        }

        function test_buildByRace()
        {
            //Arrange
            $name = "test ability";
            $description = "This is a very long description of a racial ability. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... ";
            $test_racial_ability = new RacialAbility($name, $description);
            $test_racial_ability->save();
            $test_racial_ability->addRace(1);

            $name2 = "test ability2";
            $description2 = "This is a very long description of a racial ability. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... 2";
            $test_racial_ability2 = new RacialAbility($name2, $description2);
            $test_racial_ability2->save();
            $test_racial_ability2->addRace(1);

            $build = array($test_racial_ability->build(), $test_racial_ability2->build());

            //Act
            $result = RacialAbility::buildByRace(1);

            //Assert
            $this->assertEquals($build, $result);
        }

        function test_buildAll()
        {
            //Arrange
            $name = "test ability";
            $description = "This is a very long description of a racial ability. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... ";
            $test_racial_ability = new RacialAbility($name, $description);
            $test_racial_ability->save();

            $name2 = "test ability2";
            $description2 = "This is a very long description of a racial ability. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... 2";
            $test_racial_ability2 = new RacialAbility($name2, $description2);
            $test_racial_ability2->save();

            $build = array($test_racial_ability->build(), $test_racial_ability2->build());

            //Act
            $result = RacialAbility::buildAll();

            //Assert
            $this->assertEquals($build, $result);
        }
    }

?>
