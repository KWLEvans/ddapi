<?php

    class PlayerClass
    {
        private $name;
        private $flavor;
        private $hit_die;
        private $primary_attribute;
        private $total_skills;
        private $id;

        function __construct($name, $flavor, $hit_die, $primary_attribute, $total_skills, $id = NULL)
        {
            $this->name = $name;
            $this->flavor = $flavor;
            $this->hit_die = $hit_die;
            $this->primary_attribute = $primary_attribute;
            $this->total_skills = (int) $total_skills;
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
            $build['hitDie'] = $this->hit_die;
            $build['primaryAttribute'] = $this->primary_attribute;
            $build['totalSkills'] = $this->total_skills;
            $build['levels'] = $this->buildLevels();
            $build['spells'] = $this->buildSpells();
            $build['proficiencies'] = $this->buildProficiencies();
            $build['savingThrows'] = $this->buildSavingThrows();
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
            $save = $GLOBALS['DB']->prepare("INSERT INTO classes (name, flavor, hit_die, primary_attribute, total_skills) VALUES (:name, :flavor, :hit_die, :primary_attribute, :total_skills);");
            $save->execute([':name' => $this->name, ':flavor' => $this->flavor, ':hit_die' => $this->hit_die, ':primary_attribute' => $this->primary_attribute, ':total_skills' => $this->total_skills]);
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
            $class_output = array();
            $returned_classes = $GLOBALS['DB']->query("SELECT * FROM classes;");
            if ($returned_classes) {
                $classes = $returned_classes->fetchAll();
                for ($i = 0; $i < count($classes); $i++) {
                  $name = $classes[$i]['name'];
                  $flavor = $classes[$i]['flavor'];
                  $hit_die = $classes[$i]['hit_die'];
                  $primary_attribute = $classes[$i]['primary_attribute'];
                  $total_skills = $classes[$i]['total_skills'];
                  $id = $classes[$i]['id'];
                  $class = new PlayerClass($name, $flavor, $hit_die, $primary_attribute, $total_skills, $id);
                  $class_output[] = $class;
                }
            } else {
                $class_output = array();
            }
            return $class_output;
        }

        static function getAllSavingThrows() {
          $saving_throws = [];
          $returned_saving_throws = $GLOBALS['DB']->query("SELECT * FROM saving_throws;");
          if ($returned_saving_throws) {
              $fetched_saving_throws = $returned_saving_throws->fetchAll();
              for ($i = 0; $i < count($fetched_saving_throws); $i++) {
                  $saving_throws[] = array('name' => $fetched_saving_throws[$i]['name'], 'id' => $fetched_saving_throws[$i]['id']);
              }
          }
          return $saving_throws;
        }

        static function getById($id)
        {
            $returned_class = $GLOBALS['DB']->prepare("SELECT * FROM classes WHERE id = :id;");
            $returned_class->execute(array(':id' => $id));
            if ($returned_class) {
                $class = $returned_class->fetchAll();
                $name = $class[0]['name'];
                $flavor = $class[0]['flavor'];
                $hit_die = $class[0]['hit_die'];
                $primary_attribute = $class[0]['primary_attribute'];
                $total_skills = $class[0]['total_skills'];
                $id = $class[0]['id'];
                $class_output = new PlayerClass($name, $flavor, $hit_die, $primary_attribute, $total_skills, $id);
            } else {
                $class_output = null;
            }
            return $class_output;
        }
    }

?>
