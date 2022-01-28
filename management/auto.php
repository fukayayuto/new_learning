<?php
require_once "db/reservation_settings.php";
ini_set('display_errors', "On");

$place = array();
$place[0] = 1;
$place[1] = 2;
$place[2] = 11;


foreach ($place as $val) {

    $reservation_data = searchReserveLastStartDate($val);

    $start_date = $reservation_data['start_date'];

    // $today = date('Y-m-d');

    $three_month = date('Y-m-d',strtotime('+3 month'));
    
}

?>