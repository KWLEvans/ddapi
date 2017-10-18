<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "Spell.php";
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
    }
?>
