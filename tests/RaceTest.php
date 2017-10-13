<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "Race.php";
    require_once "RacialAbility.php";
    use PHPUnit\Framework\TestCase;

    $server = 'mysql:host=localhost:8889;dbname=ddapi_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RaceTest extends TestCase
    {
        protected function tearDown()
        {
            Race::deleteAll();
            RacialAbility::deleteAll();
        }

        function testSave()
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

            $name = "test race";
            $flavor = "This is the coolest race for sure. Definitely a long text field...This is the coolest race for sure. Definitely a long text field...This is the coolest race for sure. Definitely a long text field...This is the coolest race for sure. Definitely a long text field...This is the coolest race for sure. Definitely a long text field...This is the coolest race for sure. Definitely a long text field...This is the coolest race for sure. Definitely a long text field...This is the coolest race for sure. Definitely a long text field...";
            $size = "medium";
            $speed = 30;
            $stats = ['strength', 'constitution'];
            $abilities = [$test_racial_ability->getId(), $test_racial_ability2->getId()];

            //Act
            $test_race = new Race($name, $flavor, $size, $speed, $stats, $abilities);
            $test_race->save();
            $races = Race::getAll();

            //Assert
            $this->assertEquals($test_race, $races[0]);
        }
    }

?>
