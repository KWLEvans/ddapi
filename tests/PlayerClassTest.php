<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "PlayerClass.php";
    require_once "Spell.php";
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

        function testSave()
        {
            //Arrange
            $name = "test class";
            $flavor = "This is a very long description of a class. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... ";
            $hit_die = "d8";
            $primary_attribute = "Strength";
            $total_skills = 2;
            $test_class = new PlayerClass($name, $flavor, $hit_die, $primary_attribute, $total_skills);

            //Act
            $test_class->save();
            $result = PlayerClass::getAll();

            //Assert
            $this->assertEquals($test_class, $result[0]);
        }

        function testGetById()
        {
            //Arrange
            $name = "test class";
            $flavor = "This is a very long description of a class. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... ";
            $hit_die = "d8";
            $primary_attribute = "Strength";
            $total_skills = 2;
            $test_class = new PlayerClass($name, $flavor, $hit_die, $primary_attribute, $total_skills);

            //Act
            $test_class->save();
            $id = $test_class->getId();
            $result = PlayerClass::getById($id);

            //Assert
            $this->assertEquals($test_class, $result);
        }

        function testBuildProficiencies()
        {
            //Arrange
            $name = "test class";
            $flavor = "This is a very long description of a class. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... ";
            $hit_die = "d8";
            $primary_attribute = "Strength";
            $total_skills = 2;
            $test_class = new PlayerClass($name, $flavor, $hit_die, $primary_attribute, $total_skills);
            $test_class->save();

            $test_class->addProficiency(4);
            $test_class->addProficiency(6);
            $test_class->addProficiency(13);
            $test_class->addProficiency(17);

            $proficiencies = array(
                array(
                    'name' => 'Athletics',
                    'stat' => 'Strength',
                    'id' => 4
                ),
                array(
                    'name' => 'History',
                    'stat' => 'Intelligence',
                    'id' => 6
                ),
                array(
                    'name' => 'Performance',
                    'stat' => 'Charisma',
                    'id' => 13
                ),
                array(
                    'name' => 'Stealth',
                    'stat' => 'Dexterity',
                    'id' => 17
                )
            );

            //Act
            $result = $test_class->buildProficiencies();

            //Assert
            $this->assertEquals($proficiencies, $result);
        }

        function testBuildSavingThrows()
        {
            //Arrange
            $name = "test class";
            $flavor = "This is a very long description of a class. So long in fact that it's longer than 255 characters just to make sure that it's saving as text and not as a varchar situation. I don't know how many characters 255 is, so I guess I'll just keep typing. Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... Test... ";
            $hit_die = "d8";
            $primary_attribute = "Strength";
            $total_skills = 2;
            $test_class = new PlayerClass($name, $flavor, $hit_die, $primary_attribute, $total_skills);
            $test_class->save();

            $test_class->addSavingThrow(4);
            $test_class->addSavingThrow(6);

            $saving_throws = array(
                array(
                    'name' => 'Intelligence',
                    'id' => 4
                ),
                array(
                    'name' => 'Charisma',
                    'id' => 6
                )
            );

            //Act
            $result = $test_class->buildSavingThrows();

            //Assert
            $this->assertEquals($saving_throws, $result);
        }
    }

?>
