<?php


define('HOSTNAME', 'localhost');
define('DATABASE', 'drive_good_learning');
define('USERNAME', 'root');
define('PASSWORD', 'root');

function dbConect(){
    try {
    /// DB接続を試みる
    $pdo = null;

    
    $pdo  = new PDO('mysql:host=' . HOSTNAME . ';dbname=' . DATABASE, USERNAME, PASSWORD);
    } catch (PDOException $e) {
    $isConnect = false;
    }
    return $pdo;
}



?>
