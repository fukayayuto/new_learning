<?php
require_once "db/reservation_settings.php";
$place = 1;
$resservation_data = searchReserveLastStartDate($place);
var_dump($resservation_data);die();

?>

<?php

// $start    = new DateTime('2021-12-28'); // 16/11/02 から
// $end      = new DateTime('2023-03-31'); // 16/11/08 まで
// $interval = new DateInterval('P5D');    // 2日間隔で（最初に P）

// $period = new DatePeriod($start, $interval, $end); // 順番注意
// $place = 11;

// foreach ($period as $date) {
//     $tmp = $date->format('Y-m-d');
//     reseveStore($place,$tmp);
// }

// $place = 1;
// for($i = 1; $i <= 100; $i++){
//     var_dump($date);
//     // reseveStoreAuto($place,$date);
//     $num = (int) 7;
//     $date = $date->modify('+' . $progress . 'days');

// }

?>