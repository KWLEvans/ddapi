<?php

    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/User.php";
    require_once __DIR__."/Character.php";

    $server = 'mysql:host=localhost:8889;dbname=ddapi';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);



?>
