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
