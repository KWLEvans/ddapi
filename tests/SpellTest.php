<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "Spell.php";
    require_once "RacialAbility.php";
    use PHPUnit\Framework\TestCase;

    $server = 'mysql:host=localhost:8889;dbname=ddapi_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class SpellTest extends TestCase
    {
        protected function tearDown()
        {
            Spell::deleteAll();
            RacialAbility::deleteAll();
        }

        function testSave()
        {
            //Arrange
            $name = "Test Spell";
            $school = 3;
            $level = 2;
            $casting_time = "1 round";
            $cast_range = "25 feet";
            $components = "V, S, M (a tiny strip of white cloth)";
            $duration = "5 rounds";
            $description = "This is a very complex description of what this spell does. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects.";
            $test_spell = new Spell($name, $school, $level, $casting_time, $cast_range, $components, $duration, $description);

            //Act
            $test_spell->save();
            $result = Spell::getAll();

            //Assert
            $this->assertEquals($test_spell, $result[0]);
        }

        function testBuild()
        {
            //Arrange
            $name = "Test Spell";
            $school = 3;
            $level = 2;
            $casting_time = "1 round";
            $cast_range = "25 feet";
            $components = "V, S, M (a tiny strip of white cloth)";
            $duration = "5 rounds";
            $description = "This is a very complex description of what this spell does. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects.";
            $test_spell = new Spell($name, $school, $level, $casting_time, $cast_range, $components, $duration, $description);
            $test_spell->save();

            $build = array();
            $build['name'] = $name;
            $build['school'] = $test_spell->getSchool();
            $build['level'] = $level;
            $build['casting_time'] = $casting_time;
            $build['cast_range'] = $cast_range;
            $build['components'] = $components;
            $build['duration'] = $duration;
            $build['description'] = $description;
            $build['id'] = $test_spell->getId();

            //Act
            $result = $test_spell->build();

            //Assert
            $this->assertEquals($build, $result);
        }

        function testBuildByRacialAbility()
        {
            //Arrange
            $name = "Test Spell";
            $school = 3;
            $level = 2;
            $casting_time = "1 round";
            $cast_range = "25 feet";
            $components = "V, S, M (a tiny strip of white cloth)";
            $duration = "5 rounds";
            $description = "This is a very complex description of what this spell does. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects.";
            $test_spell = new Spell($name, $school, $level, $casting_time, $cast_range, $components, $duration, $description);
            $test_spell->save();

            $name2 = "Test Spell2";
            $school2 = 3;
            $level2 = 2;
            $casting_time2 = "1 round";
            $cast_range2 = "25 feet";
            $components2 = "V, S, M (a tiny strip of white cloth)";
            $duration2 = "5 rounds";
            $description2 = "This is a very complex description of what this spell does. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects. This is a sentece about one of its effects.";
            $test_spell2 = new Spell($name2, $school2, $level2, $casting_time2, $cast_range2, $components2, $duration2, $description2);
            $test_spell2->save();

            $name = "test ability";
            $description = "This is a very long description of a racial ability. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... ";
            $test_racial_ability = new RacialAbility($name, $description);
            $test_racial_ability->save();
            $test_racial_ability->addSpell($test_spell2->getId());

            $build = array();
            $build['name'] = $name2;
            $build['school'] = $test_spell2->getSchool();
            $build['level'] = $level2;
            $build['casting_time'] = $casting_time2;
            $build['cast_range'] = $cast_range2;
            $build['components'] = $components2;
            $build['duration'] = $duration2;
            $build['description'] = $description2;
            $build['id'] = $test_spell2->getId();

            //Act
            $result = Spell::buildByRacialAbility($test_racial_ability->getId());

            //Assert
            $this->assertEquals($build, $result[0]);
        }
    }
?>
