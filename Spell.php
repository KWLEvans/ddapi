<?php

    class Spell
    {
        private $name;
        private $school_id;
        private $level;
        private $casting_time;
        private $cast_range;
        private $components;
        private $duration;
        private $description;
        private $id;

        function __construct($name, $school_id, $level, $casting_time, $cast_range, $components, $duration, $description, $id = NULL)
        {
            $this->name = $name;
            $this->school_id = intval($school_id);
            $this->level = intval($level);
            $this->casting_time = $casting_time;
            $this->cast_range = $cast_range;
            $this->components = $components;
            $this->duration = $duration;
            $this->description = $description;
            $this->id = $id;
        }

        function build()
        {
            $build = array();
            $build['name'] = $this->name;
            $build['school'] = $this->getSchool();
            $build['level'] = $this->level;
            $build['casting_time'] = $this->casting_time;
            $build['cast_range'] = $this->cast_range;
            $build['components'] = $this->components;
            $build['duration'] = $this->duration;
            $build['description'] = $this->description;
            $build['id'] = $this->id;

            return $build;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $save = $GLOBALS['DB']->prepare("INSERT INTO spells (name, school_id, level, casting_time, cast_range, components, duration, description) VALUES (:name, :school_id, :level, :casting_time, :cast_range, :components, :duration, :description);");
            $save->execute(array(':name' => $this->name, ':school_id' => $this->school_id, ':level' => $this->level, ':casting_time' => $this->casting_time, ':cast_range' => $this->cast_range, ':components' => $this->components, ':duration' => $this->duration, ':description' => $this->description));
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function getSchool()
        {
            $query = $GLOBALS['DB']->query("SELECT * FROM schools WHERE id = {$this->school_id}");
            $school_info = $query->fetchAll();
            return array($school_info[0]['name'], $school_info[0]['id']);
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM spells;');
        }

        static function getAll()
        {
            $returned_spells = $GLOBALS['DB']->query("SELECT * FROM spells;");
            if ($returned_spells) {
                $spells = $returned_spells->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Spell', ['name', 'school_id', 'level', 'casting_time', 'cast_range', 'components', 'duration', 'description', 'id']);
            } else {
                $spells = [];
            }
            return $spells;
        }
    }

?>
