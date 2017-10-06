<?php

    class Race {
        private $name;
        private $flavor;
        private $size;
        private $speed;
        private $stats;
        private $abilities;
        private $id;

        function __construct($name, $flavor, $size, $speed, $stats, $id = NULL)
        {
            $this->name = $name;
            $this->flavor = $flavor;
            $this->size = $size;
            $this->speed = $speed;
            $this->stats = $stats;
            $this->abilities = $abilities;
            $this->id = $id;
        }

        function save() {
            //save to races
            $save = $GLOBALS['DB']->prepare("INSERT INTO races (name, flavor, size, speed) VALUES (:name, :flavor, :size, :speed);");
            $save->execute([':name' => $this->name, ':flavor' => $this->flavor, ':size' => $this->size, ':speed' => $this->speed]);
            $this->id = $GLOBALS['DB']->lastInsertId();


            //save racial stat boosts
            $save_statement = "";
            $execute_array = [':race_id' => $this->id];

            for ($i = 0; $i < count($this->stats); $i++) {
                $save_statement . "INSERT INTO race_stats (race_id, name) VALUES (:race_id, :name" . $i . ");";
                $execute_array[':name' . $i] = $this->stats[$i];
            }

            $save_statement . "INSERT INTO race_stats (race_id, name) VALUES (:race_id, :name2);";
            $save = $GLOBALS['DB']->prepare($save_statement);
            $save->execute($execute_array);


            //save racial abilities from array of ids
            $save_statement = "";
            $execute_array = [':race_id' => $this->id];
            for ($i = 0; $i < count($this->abilities); $i++) {
                $save_statement . "INSERT INTO race_racial_abilities (race_id, racial_ability_id) VALUES (:race_id, :racial_ability_id" . $i . ");";
                $execute_array[':racial_ability_id' . $i] = $this->abilities[$i];
            }
            $save = $GLOBALS['DB']->prepare($save_statement);
            $save->execute($execute_array);
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM races;');
            $GLOBALS['DB']->exec('DELETE FROM race_stats;');
            $GLOBALS['DB']->exec('DELETE FROM race_racial_abilities;');
            $GLOBALS['DB']->exec('DELETE FROM racial_abilities;');
        }

    }

?>
