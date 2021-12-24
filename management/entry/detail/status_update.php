<?php
ini_set('display_errors', "On");
require_once "../../db/reservation_settings.php";
require_once "../../db/reservation.php";
require_once "../../db/entries.php";
if (empty($_GET['id'])) {
    header('Location: http://localhost:8888/management/entry');
}
$entry_id = $_GET['id'];
$status = 1;
$res = updateEntry($entry_id,$status);
if(!$res){
    $res = 0;
}else{
    $res = 1;
}
var_dump($entry_id);
var_dump($res);
die();

header('Location: http://localhost:8888/management/entry/detail?id=' . $entry_id . '&res=' . $res);

?>