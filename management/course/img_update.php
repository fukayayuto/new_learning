<?php
require_once "../db/reservation.php";
ob_start();

$place = $_POST['place'];
$image_name = $_FILES['image']['name'];

$res = updateReserveImage($place, $image_name);


$save = '/home/tokyo-mytour/www/promote.good-learning.jp/management/common/img/management/' . basename($image_name);

if (move_uploaded_file($_FILES['image']['tmp_name'], $save)) {
} else {
}

if (!$res) {
    $res = 3;
} else {
    $res = 4;
}
header('Location: http://localhost:8888/management/course/?id=' . $place . '&res=' . $res);
