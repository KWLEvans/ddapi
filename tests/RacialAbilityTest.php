<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "RacialAbility.php";
    require_once "Spell.php";
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
            Spell::deleteAll();
        }

        function testSave()
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

        function testGetById()
        {
            //Arrange
            $name = "test ability";
            $description = "This is a very long description of a racial ability. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... ";
            $test_racial_ability = new RacialAbility($name, $description);

            //Act
            $test_racial_ability->save();
            $id = $test_racial_ability->getId();
            $result = RacialAbility::getById($id);

            //Assert
            $this->assertEquals($test_racial_ability, $result);
        }

        function testGetByRace()
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

        function testBuild()
        {
            //Arrange
            $name = "test ability";
            $description = "This is a very long description of a racial ability. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... ";
            $test_racial_ability = new RacialAbility($name, $description);
            $test_racial_ability->save();

            $name2 = "Test Spell";
            $school2 = 3;
            $level2 = 2;
            $casting_time2 = "1 round";
            $cast_range2 = "25 feet";
            $components2 = "V, S, M (a tiny strip of white cloth)";
            $duration2 = "5 rounds";
            $description2 = "This is a very complex description of what this spell does. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects.";
            $test_spell = new Spell($name2, $school2, $level2, $casting_time2, $cast_range2, $components2, $duration2, $description2, false);
            $test_spell->save();
            $test_spell->addRacialAbility($test_racial_ability->getId());

            $build = array();
            $build['name'] = $name;
            $build['description'] = $description;
            $build['spells'] = array($test_spell->build());
            $build['id'] = $test_racial_ability->getId();

            //Act
            $result = $test_racial_ability->build();

            //Assert
            $this->assertEquals($build, $result);
        }

        function testBuildByRace()
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

        function testBuildAll()
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
