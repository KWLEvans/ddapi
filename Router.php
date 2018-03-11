<?php
    require_once __DIR__."/Article.php";
    require_once __DIR__."/Character.php";
    require_once __DIR__."/PlayerClass.php";
    require_once __DIR__."/Race.php";
    require_once __DIR__."/RacialAbility.php";
    require __DIR__."/Spell.php";
    require_once __DIR__."/User.php";

    class Router
    {
        static function route($route, $data)
        {
            switch ($route) {
                case "add_spell":
                    return Router::addSpell($data);
                    break;
                case "get_all_spells":
                    return Spell::buildAll();
                    break;
                case "get_spell_schools":
                    return Spell::getAllSchools();
                    break;
                case "get_saving_throws":
                    return PlayerClass::getAllSavingThrows();
                    break;
                default:
                    return "Invalid Route";
                    break;
            }
        }

        static function addSpell($data) {
            $name = $data->name;
            $school_id = $data->school_id;
            $level = $data->level;
            $casting_time = $data->casting_time;
            $cast_range = $data->cast_range;
            $components = $data->components;
            $duration = $data->duration;
            $description = $data->description;
            $ritual = $data->ritual;
            $spell = new Spell($name, $school_id, $level, $casting_time, $cast_range, $components, $duration, $description, $ritual);
            $spell->save();
            return $spell->getId();
        }

    }
?>
