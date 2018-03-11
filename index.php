<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: *");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/dbconnect.php";
    require_once __DIR__."/Router.php";


    $headers = getallheaders();
    if (array_key_exists('Target', $headers)) {
      $post_data = json_decode(file_get_contents('php://input'));
      $route = $headers['Target'];
      echo json_encode(Router::route($route, $post_data));
    }
?>
