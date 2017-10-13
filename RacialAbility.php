<?php

    class RacialAbility
    {
        private $name;
        private $description;
        private $id;

        function __construct($name, $description, $id = NULL)
        {
            $this->name = $name;
            $this->description = $description;
            $this->id = $id;
        }

        function addRace($race_id) {
            $exec = $GLOBALS['DB']->prepare("INSERT INTO race_racial_abilities (race_id, racial_ability_id) VALUES (:race_id, :racial_ability_id);");
            return $exec->execute([':race_id' => $race_id, ':racial_ability_id' => $this->id]);
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $save = $GLOBALS['DB']->prepare("INSERT INTO racial_abilities (name, description) VALUES (:name, :description);");
            $save->execute([':name' => $this->name, ':description' => $this->description]);
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM race_racial_abilities;');
            $GLOBALS['DB']->exec('DELETE FROM racial_abilities;');
        }

        static function getById($id)
        {
            $returned_racial_abilities = $GLOBALS['DB']->prepare("SELECT * FROM racial_abilities WHERE id = :id;");
            $returned_racial_abilities->execute(array(':id' => $id));
            if ($returned_racial_abilities) {
                $racial_abilities = $returned_racial_abilities->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'RacialAbility', ['name', 'description', 'id']);
            } else {
                $racial_abilities = [];
            }
            return $racial_abilities[0];
        }

        static function getByRace($race_id)
        {
            $returned_racial_abilities = $GLOBALS['DB']->prepare("SELECT racial_abilities.name, racial_abilities.description, racial_abilities.id FROM racial_abilities JOIN race_racial_abilities ON racial_abilities.id=race_racial_abilities.racial_ability_id WHERE race_racial_abilities.race_id = :race_id");
            $returned_racial_abilities->bindParam(':race_id', $race_id);
            $returned_racial_abilities->execute();

            if ($returned_racial_abilities) {
                $racial_abilities = $returned_racial_abilities->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'RacialAbility', ['racial_abilities.name', 'racial_abilities.description', 'racial_abilities.id']);
            } else {
                $racial_abilities = [];
            }
            return $racial_abilities;
        }

        static function getAll()
        {
            $returned_racial_abilities = $GLOBALS['DB']->query("SELECT * FROM racial_abilities;");
            if ($returned_racial_abilities) {
                $racial_abilities = $returned_racial_abilities->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'RacialAbility', ['name', 'description', 'id']);
            } else {
                $racial_abilities = [];
            }
            return $racial_abilities;
        }
    }


?>
