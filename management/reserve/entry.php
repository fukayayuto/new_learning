<?php
ob_start();
ini_set('display_errors', "On");
require_once "../db/reservation_settings.php";
require_once "../db/reservation.php";
require_once "../db/entries.php";
require_once "../db/accounts.php";
require_once "../db/name_lists.php";

$reservation_id = $_POST['reservation_id'];
$reservation_data = getReservation($reservation_id);
$place = $reservation_data['place'];

$count = $_POST['count'];
$name_1 = $_POST['name_1'];
if (!empty($_POST['name_2'])) {
    $name_2 = $_POST['name_2'];
}
if (!empty($_POST['name_3'])) {
    $name_3 = $_POST['name_3'];
}
if (!empty($_POST['name_4'])) {
    $name_4 = $_POST['name_4'];
}
if (!empty($_POST['name_5'])) {
    $name_5 = $_POST['name_5'];
}

if (!empty($_POST['account_id'])) {
    $account_id = $_POST['account_id'];
    $res = entryStore($account_id, $reservation_id, $count, $name_1, $name_2, $name_3, $name_4, $name_5);

    if (!$res) {
        $res = 4;
    } else {
        $res = 3;
    }
    header('Location: http://localhost:8888/management/reserve/list/?id=' . $reservation_id . '&res=' .$res);
    exit();
}


$email = $_POST['email'];
$company_name = $_POST['company_name'];
$phone = $_POST['phone'];
$sales_office = $_POST['sales_office'];

$account_id = accountStore($email,$company_name,$phone,$sales_office);

$res = entryStore($account_id,$reservation_id,$count,$name_1,$name_2,$name_3,$name_4,$name_5);

if (!$res) {
    $res = 4;
} else {
    $res = 3;
}
header('Location: http://localhost:8888/management/reserve/list/?id=' . $reservation_id . '&res=' .$res);
exit();




