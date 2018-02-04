<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: *");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    date_default_timezone_set("America/Los_Angeles");
    // require_once __DIR__."/Character.php";
    require_once __DIR__."/PlayerClass.php";
    // require_once __DIR__."/Race.php";
    // require_once __DIR__."/RacialAbility.php";
    // require __DIR__."/Spell.php";
    // require_once __DIR__."/User.php";

    $server = 'mysql:host=localhost:8889;dbname=ddapi';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $headers = getallheaders();

    if ($headers['target'] == "add_spell") {
        $post_data = json_decode(file_get_contents('php://input'));
        $name = $post_data->name;
        $school_id = $post_data->school_id;
        $level = $post_data->level;
        $casting_time = $post_data->casting_time;
        $cast_range = $post_data->cast_range;
        $components = $post_data->components;
        $duration = $post_data->duration;
        $description = $post_data->description;
        $ritual = $post_data->ritual;
        $spell = new Spell($name, $school_id, $level, $casting_time, $cast_range, $components, $duration, $description, $ritual);
        $spell->save();
        echo json_encode($spell->getId());
        return;
    } else if ($headers['target'] == "get_saving_throws") {
        echo json_encode(PlayerClass::getAllSavingThrows());
        return;
    } else if ($headers['target'] == "get_spell_schools") {
        echo json_encode(Spell::getAllSchools());
        return;
    } else if ($headers['target'] == "get_all_spells") {
        echo json_encode(Spell::buildAll());
        return;
    }
?>
