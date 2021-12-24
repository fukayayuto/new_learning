<?php
ob_start();
ini_set('display_errors', "On");
require_once "../../db/reservation_settings.php";
require_once "../../db/reservation.php";
require_once "../../db/entries.php";
require_once "../../db/accounts.php";
if (empty($_POST['id'])) {
    header('Location: http://localhost:8888/management/entry');
}
$entry_id = $_POST['id'];
$count = $_POST['count'];
$name_1 = $_POST['name_1'];
$name_2 = '';
$name_3 = '';
$name_4 = '';
$name_5 = '';

if($count >= 2){
    $name_2 = $_POST['name_2'];
}
if($count >= 3){
    $name_3 = $_POST['name_3'];
}
if($count >= 4){
    $name_4 = $_POST['name_4'];
}
if($count >= 5){
    $name_5 = $_POST['name_5'];
}
$res = updateEntryNumber($count,$name_1,$name_2,$name_3,$name_4,$name_5,$entry_id);
if(!$res){
    $res = 6;
}else{
    $res = 5;
}
header('Location: http://localhost:8888/management/entry/detail?id=' . $entry_id . '&res=' . $res);

?>