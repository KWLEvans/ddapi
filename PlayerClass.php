<?php

    require_once "Spell.php";

    class PlayerClass
    {
        private $name;
        private $flavor;
        private $hit_die;
        private $primary_attribute;
        private $id;

        function __construct($name, $flavor, $hit_die, $primary_attribute, $id = NULL)
        {
            $this->name = $name;
            $this->flavor = $flavor;
            $this->hit_die = $hit_die;
            $this->primary_attribute = $primary_attribute;
            $this->id = $id;
        }

        function addProficiency($skill_id)
        {
            $save = $GLOBALS['DB']->prepare("INSERT INTO class_proficiencies (class_id, skill_id) VALUES (:class_id, :skill_id);");
            $save->execute([':class_id' => $this->id, ':skill_id' => $skill_id]);
        }

        function addSavingThrow($saving_throw_id)
        {
            $save = $GLOBALS['DB']->prepare("INSERT INTO class_saving_throws (class_id, saving_throw_id) VALUES (:class_id, :saving_throw_id);");
            $save->execute([':class_id' => $this->id, ':saving_throw_id' => $saving_throw_id]);
        }

        function addSpell($spell_id)
        {
            $save = $GLOBALS['DB']->prepare("INSERT INTO class_spells (class_id, spell_id) VALUES (:class_id, :spell_id);");
            $save->execute([':class_id' => $this->id, ':spell_id' => $spell_id]);
        }

        function build()
        {
            $build = array();
            $build['name'] = $this->name;
            $build['flavor'] = $this->flavor;
            $build['hit_die'] = $this->hit_die;
            $build['primary_attribute'] = $this->primary_attribute;
            $build['levels'] = $this->buildLevels();
            $build['spells'] = $this->buildSpells();
            $build['proficiencies'] = $this->buildProficiencies();
            $build['saving_throws'] = $this->buildSavingThrows();
            $build['id'] = $this->id;

            return $build;
        }

        function buildProficiencies()
        {
            $returned_proficiencies = $GLOBALS['DB']->prepare("SELECT skills.name, skills.stat, skills.id FROM skills JOIN class_proficiencies ON skills.id=class_proficiencies.skill_id WHERE class_proficiencies.class_id = :class_id");
            $returned_proficiencies->bindParam(':class_id', $this->id);
            $returned_proficiencies->execute();

            if ($returned_proficiencies) {
                $returned_proficiencies = $returned_proficiencies->fetchAll();
                $proficiencies = array();
                for ($i = 0; $i < count($returned_proficiencies); $i++) {
                    $proficiency = array();
                    $proficiency['name'] = $returned_proficiencies[$i]['name'];
                    $proficiency['stat'] = $returned_proficiencies[$i]['stat'];
                    $proficiency['id'] = $returned_proficiencies[$i]['id'];
                    $proficiencies[] = $proficiency;
                }
            } else {
                $proficiencies = array();
            }

            return $proficiencies;
        }

        function buildSavingThrows()
        {
            $returned_saving_throws = $GLOBALS['DB']->prepare("SELECT saving_throws.name, saving_throws.id FROM saving_throws JOIN class_saving_throws ON saving_throws.id=class_saving_throws.saving_throw_id WHERE class_saving_throws.class_id = :class_id");
            $returned_saving_throws->bindParam(':class_id', $this->id);
            $returned_saving_throws->execute();

            if ($returned_saving_throws) {
                $returned_saving_throws = $returned_saving_throws->fetchAll();
                $saving_throws = array();
                for ($i = 0; $i < count($returned_saving_throws); $i++) {
                    $saving_throw = array();
                    $saving_throw['name'] = $returned_saving_throws[$i]['name'];
                    $saving_throw['id'] = $returned_saving_throws[$i]['id'];
                    $saving_throws[] = $saving_throw;
                }
            } else {
                $saving_throws = array();
            }

            return $saving_throws;
        }

        function buildSpells()
        {
            $spells_build = Spell::buildByClass($this->id);
            return $spells_build;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $save = $GLOBALS['DB']->prepare("INSERT INTO classes (name, flavor, hit_die, primary_attribute) VALUES (:name, :flavor, :hit_die, :primary_attribute);");
            $save->execute([':name' => $this->name, ':flavor' => $this->flavor, ':hit_die' => $this->hit_die, ':primary_attribute' => $this->primary_attribute]);
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function buildAllSkills()
        {
            $returned_skills = $GLOBALS['DB']->prepare("SELECT skills.name, skills.stat, skills.id FROM skills");
            $returned_skills->execute();

            if ($returned_skills) {
                $returned_skills = $returned_skills->fetchAll();
                $skills = array();
                for ($i = 0; $i < count($returned_skills); $i++) {
                    $skill = array();
                    $skill['name'] = $returned_skills[$i]['name'];
                    $skill['stat'] = $returned_skills[$i]['stat'];
                    $skill['id'] = $returned_skills[$i]['id'];
                    $skills[] = $skill;
                }
            } else {
                $skills = array();
            }

            return $skills;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM classes;');
        }

        static function getAll()
        {
            $returned_classes = $GLOBALS['DB']->query("SELECT * FROM classes;");
            if ($returned_classes) {
                $classes = $returned_classes->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'PlayerClass', ['name', 'flavor', 'hit_die', 'primary_attribute', 'id']);
            } else {
                $classes = [];
            }
            return $classes;
        }
    }

?>
