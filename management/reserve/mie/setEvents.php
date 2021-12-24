
<?php

ini_set('display_errors', "On");
require_once "../../db/reservation_settings.php"; 
require_once "../../db/reservation.php"; 
require_once "../../db/entries.php"; 

  
     //データを配列にまとめる
     $newArr = array();

     $reservation_data = getSelectAll(11);
     $reserve_data = getReservatinData(11);
     $seat = $reserve_data['count'];

     foreach ($reservation_data as $k => $val) {
        $newItem = array();

        $entry = getEntry($val['id']);
        $count = 0;
      
        if(!empty($entry)){
            foreach ($entry as $item) {
           if($item['status'] != 2){
                $count = $count + $item['count'];
                }
             }
        }
        $left_seat = $seat - $count;

        $newItem['title'] = '(' . $left_seat . '/' . $seat .')'.'三重会場';
        $newItem["color"] = '#FF99FF';


        $newItem["textColor"] = 'black';

        $newItem['start'] = $val['start_date'];
        $newItem['url'] = 'http://localhost:8888/management/reserve/list/?id=' . $val["id"];


        $newArr[] = $newItem;
     }
     
     echo json_encode($newArr);



     

?>
