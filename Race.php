<?php

    class Race
    {
        private $name;
        private $flavor;
        private $size;
        private $speed;
        private $stats;
        private $abilities;
        private $id;

        function __construct($name, $flavor, $size, $speed, $stats = NULL, $abilities = NULL, $id = NULL)
        {
            $this->name = $name;
            $this->flavor = $flavor;
            $this->size = $size;
            $this->speed = (int) $speed;
            $this->id = $id;

            if ($stats == NULL) {
                $this->getStats();
            } else {
                $this->stats = $stats;
            }

            if ($abilities == NULL) {
                $this->getAbilities();
            } else {
                $this->abilities = $abilities;
            }
        }

        function build()
        {
            $build = array();
            $build['name'] = $this->name;
            $build['flavor'] = $this->flavor;
            $build['size'] = $this->size;
            $build['speed'] = $this->speed;
            $build['stats'] = $this->stats;

            $abilities = $this->getAbilities();

            for ($i = 0; $i < count($abilities); $i++) {
                $build['abilities'][] = $abilities[$i]->build();
            }

            $build['id'] = $this->id;

            return $build;
        }

        function getAbilities()
        {
            $this->abilities = array();
            $abilities = RacialAbility::getByRace($this->id);
            for ($i = 0; $i < count($abilities); $i++) {
                $this->abilities[] = $abilities[$i]->getId();
            }
            return $abilities;
        }

        function getId()
        {
            return $this->id;
        }

        function getStats()
        {
            $query = "SELECT name FROM race_stats WHERE race_id = " . $this->id . ";";
            $returned_stats = $GLOBALS['DB']->query($query);

            if ($returned_stats) {
                $returned_stats = $returned_stats->fetchAll();
                $stats = array();
                for ($i = 0; $i < count($returned_stats); $i++) {
                    $stats[] = $returned_stats[$i]['name'];
                }
            } else {
                $stats = array();
            }
            $this->stats = $stats;
            return $stats;
        }

        function save() {
            $save = $GLOBALS['DB']->prepare("INSERT INTO races (name, flavor, size, speed) VALUES (:name, :flavor, :size, :speed);");
            $save->execute([':name' => $this->name, ':flavor' => $this->flavor, ':size' => $this->size, ':speed' => $this->speed]);
            $this->id = $GLOBALS['DB']->lastInsertId();

            $this->saveStats();

            $this->saveRacialAbilities();
        }

        function saveRacialAbilities() {
            $save_statement = "";

            for ($i = 0; $i < count($this->abilities); $i++) {
                $save_statement = $save_statement . "INSERT INTO race_racial_abilities (race_id, racial_ability_id) VALUES (" . $this->id . ", " . $this->abilities[$i] . ");";
            }

            $save = $GLOBALS['DB']->prepare($save_statement);
            $save->execute();
        }

        function saveStats() {
            $save_statement = "";

            for ($i = 0; $i < count($this->stats); $i++) {
                $save_statement = $save_statement . "INSERT INTO race_stats (race_id, name) VALUES (" . $this->id . ", '" . $this->stats[$i] . "');";
            }

            $save = $GLOBALS['DB']->prepare($save_statement);
            $save->execute();
        }

        static function buildAll()
        {
            $build = array();
            $races = Race::getAll();
            for ($i = 0; $i < count($races); $i++) {
                $build[] = $races[$i]->build();
            }
            return $build;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM races;');
            $GLOBALS['DB']->exec('DELETE FROM race_stats;');
        }

        static function getAll()
        {
            $returned_races = $GLOBALS['DB']->query("SELECT * FROM races;");
            if ($returned_races) {
                $returned_races = $returned_races->fetchAll();
                $races = array();
                for ($i = 0; $i < count($returned_races); $i++) {
                    $name = $returned_races[$i]['name'];
                    $flavor = $returned_races[$i]['flavor'];
                    $size = $returned_races[$i]['size'];
                    $speed = $returned_races[$i]['speed'];
                    $stats = NULL;
                    $abilities = NULL;
                    $id = $returned_races[$i]['id'];
                    $races[] = new Race($name, $flavor, $size, $speed, $stats, $abilities, $id);
                }
            } else {
                $races = [];
            }
            return $races;
        }

        static function getById($id)
        {
            $returned_race = $GLOBALS['DB']->prepare("SELECT * FROM races WHERE id = :id;");
            $returned_race->execute(array(':id' => $id));
            if ($returned_race) {
                $race = $returned_race->fetchAll();
                $name = $race[0]['name'];
                $flavor = $race[0]['flavor'];
                $size = $race[0]['size'];
                $speed = $race[0]['speed'];
                $stats = NULL;
                $abilities = NULL;
                $id = $race[0]['id'];
                $race_output = new Race($name, $flavor, $size, $speed, $stats, $abilities, $id);
            } else {
                $race_output = null;
            }
            return $race_output;
        }
    }

?>
