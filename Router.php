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
                //ARTICLES
                case "add_article":
                    return Router::addArticle($data);
                    break;
                case "get_all_article_titles":
                    return Article::getAllTitles();
                    break;
                //SPELLS
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

        static function addArticle($data)
        {
            $title = $data->title;
            $content = $data->content;
            $article = new Article($title, $content);
            return $article->save();
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
            return $spell->save();
        }

    }
?>
