<?php

ini_set('display_errors', "On");
require_once "../../db/reservation_settings.php"; 
require_once "../../db/reservation.php"; 

//初任者講習登録用
$id = 1;
if(!empty($_POST['start_date'])){
    $start_date = $_POST['start_date'];
}

foreach ($start_date as $val) {

    if(!empty($val)){
        $place = $id;
        $res = reseveStore($place,$val);
    }
  
}


if(!$res){
    $res = 0;
}else{
    $res = 1;
}

header('Location: http://localhost:8888/management/reserve/member/?res=' . $res);

?>