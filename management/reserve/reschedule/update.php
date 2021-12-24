<?php
ini_set('display_errors', "On");
require_once "../../db/entries.php";
$entry_id = $_POST['id'];
$new_reservation_id = $_POST['new_reservation_id'];
$count = $_POST['count'];

$res = reschedule($entry_id,$new_reservation_id);

if(!$res){
    $res = 4;
}else{
    $res = 3;
}
header('Location: http://localhost:8888/management/entry/detail/?id=' . $entry_id . '&res=' . $res);


?>