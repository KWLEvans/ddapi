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

        function addClass($class_id)
        {
            $exec = $GLOBALS['DB']->prepare("INSERT INTO class_spells (class_id, spell_id) VALUES (:class_id, :spell_id);");
            return $exec->execute([':class_id' => $class_id, ':spell_id' => $this->id]);
        }

        function addRacialAbility($racial_ability_id)
        {
            $exec = $GLOBALS['DB']->prepare("INSERT INTO racial_ability_spells (racial_ability_id, spell_id) VALUES (:racial_ability_id, :spell_id);");
            return $exec->execute([':racial_ability_id' => $racial_ability_id, ':spell_id' => $this->id]);
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

        static function buildAll()
        {
            $build = array();
            $spells = Spell::getAll();
            for ($i = 0; $i < count($spells); $i++) {
                $build[] = $spells[$i]->build();
            }
            return $build;
        }

        static function buildByClass($class_id)
        {
            $spells = Spell::getByClass($class_id);
            $builds = array();
            for ($i = 0; $i < count($spells); $i++) {
                $builds[] = $spells[$i]->build();
            }
            return $builds;
        }

        static function buildByRacialAbility($racial_ability_id)
        {
            $spells = Spell::getByRacialAbility($racial_ability_id);
            $builds = array();
            for ($i = 0; $i < count($spells); $i++) {
                $builds[] = $spells[$i]->build();
            }
            return $builds;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM spells;');
            $GLOBALS['DB']->exec('DELETE FROM racial_ability_spells;');
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

        static function getByClass($class_id)
        {
            $returned_spells = $GLOBALS['DB']->prepare("SELECT spells.name, spells.school_id, spells.level, spells.casting_time, spells.cast_range, spells.components, spells.duration, spells.description, spells.id FROM spells JOIN class_spells ON spells.id=class_spells.spell_id WHERE class_spells.class_id = :class_id");
            $returned_spells->bindParam(':class_id', $class_id);
            $returned_spells->execute();

            if ($returned_spells) {
                $spells = $returned_spells->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Spell', ['spells.name', 'spells.school_id', 'spells.level', 'spells.casting_time', 'spells.cast_range', 'spells.components', 'spells.duration', 'spells.description', 'spells.id']);
            } else {
                $spells = [];
            }
            return $spells;
        }

        static function getById($id)
        {
            $returned_spell = $GLOBALS['DB']->prepare("SELECT * FROM spells WHERE id = :id;");
            $returned_spell->execute(array(':id' => $id));
            if ($returned_spell) {
                $spell = $returned_spell->fetchAll();
                $name = $spell[0]['name'];
                $school_id = $spell[0]['school_id'];
                $level = $spell[0]['level'];
                $casting_time = $spell[0]['casting_time'];
                $cast_range = $spell[0]['cast_range'];
                $components = $spell[0]['components'];
                $duration = $spell[0]['duration'];
                $description = $spell[0]['description'];
                $id = $spell[0]['id'];
                $spell_output = new Spell($name, $school_id, $level, $casting_time, $cast_range, $components, $duration, $description, $id);
            } else {
                $spell_output = null;
            }
            return $spell_output;
        }

        static function getByRacialAbility($racial_ability_id)
        {
            $returned_spells = $GLOBALS['DB']->prepare("SELECT spells.name, spells.school_id, spells.level, spells.casting_time, spells.cast_range, spells.components, spells.duration, spells.description, spells.id FROM spells JOIN racial_ability_spells ON spells.id=racial_ability_spells.spell_id WHERE racial_ability_spells.racial_ability_id = :racial_ability_id");
            $returned_spells->bindParam(':racial_ability_id', $racial_ability_id);
            $returned_spells->execute();

            if ($returned_spells) {
                $spells = $returned_spells->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Spell', ['spells.name', 'spells.school_id', 'spells.level', 'spells.casting_time', 'spells.cast_range', 'spells.components', 'spells.duration', 'spells.description', 'spells.id']);
            } else {
                $spells = [];
            }
            return $spells;
        }
    }

?>
