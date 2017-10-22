<?php

    class PlayerClass
    {
        private $name;
        private $flavor;
        private $hit_die;
        private $primary_attribute;

        function __construct($name, $flavor, $hit_die, $primary_attribute, $id = NULL)
        {
            $this->name = $name;
            $this->flavor = $flavor;
            $this->hit_die = $hit_die;
            $this->primary_attribute = $primary_attribute;
            $this->id = $id;
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
