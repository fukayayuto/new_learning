<?php
require_once "../db/reservation.php";
ob_start();
$name = $_POST['name'];
$progress = $_POST['progress'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$count = $_POST['count'];
$price = $_POST['price'];
$detail = $_POST['detail'];
$img = '';
if (!empty($_FILES['icon'])) {
    $img_name = $_FILES['icon']['name'];
    $save = '/home/tokyo-mytour/www/promote.good-learning.jp/management/common/img/management' . basename($img_name);

    if (move_uploaded_file($_FILES['icon']['tmp_name'], $save)) {
    } else {
    }
}
$res = reserveStore($name, $progress, $start_time, $end_time, $count, $price,$detail,$img);

if (!$res) {
    $res = 2;
} else {
    $res = 1;
}
header('Location: http://localhost:8888/management/reserve/?res=' . $res);
