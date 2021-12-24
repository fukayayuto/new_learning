<?php
require_once "../db/reservation.php";

$place = $_POST['place'];

$name = $_POST['name'];
$progress = $_POST['progress'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$count = $_POST['count'];
$price = $_POST['price'];
$detail = $_POST['detail'];

$res = updateReserve($place,$name,$progress,$start_time ,$end_time,$count,$price,$detail);
if (!$res) {
    $res = 0;
} else {
    $res = 1;
}
header('Location: http://localhost:8888/management/course/?id=' . $place . '&res=' . $res);
