<?php
ini_set('display_errors', "On");
require_once "../../db/reservation_settings.php";
require_once "../../db/reservation.php";
require_once "../../db/entries.php";
require_once "../../db/accounts.php";
if (empty($_POST['id'])) {
    header('Location: https://promote.good-learning.jp/management/entry');
}
$entry_id = $_POST['id'];
$payment = $_POST['payment'];

$res = updateEntryPayment($entry_id,$payment);
if (!$res) {
    $res = 0;
} else {
    $res = 1;
}
header('Location: https://promote.good-learning.jp/management/entry/detail?id=' . $entry_id . '&res=' . $res);
