<?php

ini_set('display_errors', "On");
require_once "../db/reservation_settings.php";
require_once "../db/reservation.php";
require_once "../db/entries.php";
require_once "../db/accounts.php";

$reservaton_id = $_GET['id'];

$reservation_data = getReservation($reservaton_id);
$place = $reservation_data['place'];

$entry_data = getEntry($reservaton_id);

$count = 0;

foreach ($entry_data as $enrty) {
    if ($enrty['status'] != 2) {
        $count = $count + $enrty['count'];
    }
}
if ($count != 0) {
    header('Location: http://localhost:8888/management/reserve/edit.php?id=' . $reservaton_id . '&del=1');
}

if ($place == 1) {

    $reservaton_id++;
    $entry_data = getEntry($reservaton_id);
    $count = 0;
    foreach ($entry_data as $enrty) {
        if ($enrty['status'] != 2) {
            $count = $count + $enrty['count'];
        }
    }
    if ($count != 0) {
        header('Location: http://localhost:8888/management/reserve/edit.php?id=' . $reservaton_id . '&del=2');
    }
}

if ($count == 0) {
    $res = deleteReserve($reservaton_id);
    if ($place == 1) {
        $reservaton_id--;
        $res = deleteReserve($reservaton_id);
    }

    switch ($place) {
        case 1:
            header('Location: http://localhost:8888/management/reserve/member/index.php?res=3');
            break;
        case 11:
            header('Location: http://localhost:8888/management/reserve/mie/index.php?res=3');
            break;
        default:

            break;
    }
}
