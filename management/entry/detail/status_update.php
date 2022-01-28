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
$status = $_POST['status'];

if ($status != 2) {
    $entry_data = selectEntry($entry_id);
    $count = $entry_data['count'];
    $reservation_id = $entry_data['reservation_id'];
    $old_status = $entry_data['status'];

    if ($old_status == 2) {

        $entry = getEntry($reservation_id);
        $reservation_data = getReservation($reservation_id);
        $place = $reservation_data['place'];

        $reserve_data = getReservatinData($place);
        $left_seat = $reserve_data['count'];

        foreach ($entry as $val) {
            if ($val['status'] != 2) {
                $left_seat -= $val['count'];
            }
        }

        if ($left_seat < $count) {
            $res = 7;
            header('Location: https://promote.good-learning.jp/management/entry/detail?id=' . $entry_id . '&res=' . $res);
            exit();
        }
    }
}



$res = updateEntryStatus($entry_id, $status);
if (!$res) {
    $res = 0;
} else {
    $res = 1;
}
header('Location: https://promote.good-learning.jp/management/entry/detail?id=' . $entry_id . '&res=' . $res);
