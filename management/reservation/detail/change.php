<?php
ini_set('display_errors', "On");
require "../../db/reservation_settings.php"; 
require "../../db/entries.php"; 
require "../../db/accounts.php"; 
require "../../db/mail.php"; 

$id = $_POST['id'];
$place = $_POST['place'];
$start_date = $_POST['start_date'];
$progress = $_POST['progress'];
$count = $_POST['count'];
$display_flg = $_POST['display_flg'];



$res = updateReservation($place,$start_date,$progress,$count,$display_flg,$id);

if(!$res){
    die('更新に失敗しました');
}

header('Location: http://localhost:8888/management/reservation/');



?>
