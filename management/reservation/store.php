<?php
ini_set('display_errors', "On");
require "../db/reservation_settings.php"; 
require "../db/entries.php"; 
require "../db/accounts.php"; 
require "../db/mail.php"; 

$place = $_POST['place'];
$start_date = $_POST['start_date'];
$progress = $_POST['progress'];
$count = $_POST['count'];


$res = store($place,$start_date,$progress,$count);

if(!$res){
    die('登録に失敗しました');
}


header('Location: http://localhost:8888/management/reservation/');

?>