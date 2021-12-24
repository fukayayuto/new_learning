<?php

require_once "db.php"; 

function getAllData(){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM reservation_settings ORDER BY id DESC");
    $res = $stmt->execute();
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $pdo = null;

    return $data;
}

function store($place,$start_date,$progress,$count){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("INSERT INTO reservation_settings (
        place, start_date, progress,count
    ) VALUES (
       :place, :start_date, :progress,:count
     )");
    $stmt->bindValue(':place', $place, PDO::PARAM_INT);
    $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
    $stmt->bindValue(':progress', $progress, PDO::PARAM_INT);
    $stmt->bindValue(':count', $count, PDO::PARAM_INT);
    $res = $stmt->execute();



    if($place == 1){
        $stmt = $pdo->prepare("INSERT INTO reservation_settings (
            place, start_date, progress,count
        ) VALUES (
           :place, :start_date, :progress,:count
         )");
        $stmt->bindValue(':place', 2, PDO::PARAM_INT);
        $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
        $stmt->bindValue(':progress', $progress, PDO::PARAM_INT);
        $stmt->bindValue(':count', $count, PDO::PARAM_INT);
        $res = $stmt->execute();
    }
    
    $pdo = null;

    return $res;
}


function getReservation($id){

    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM reservation_settings WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $res = $stmt->execute();
    
    if( $res ) {
        $data = $stmt->fetch();
    }

    $pdo = null;

    return $data;
}

// function updateReservation($place,$start_date,$progress,$count,$display_flg,$id){

//     $pdo = dbConect();
//     $id_2 = $id++;

//     if($place != 1){
//         $stmt = $pdo->prepare("UPDATE reservation_settings SET  place = :place, start_date = :start_date, progress = :progress, count = :count, display_flg = :display_flg WHERE  id = :id;");
//         $stmt->bindValue(':id', $id, PDO::PARAM_INT);
//         $stmt->bindValue(':place', $place, PDO::PARAM_INT);
//         $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
//         $stmt->bindValue(':progress', $progress, PDO::PARAM_INT);
//         $stmt->bindValue(':count', $count, PDO::PARAM_INT);
//         $stmt->bindValue(':display_flg', $display_flg, PDO::PARAM_INT);
//         $res = $stmt->execute();

//     }else{

//         $stmt = $pdo->prepare("UPDATE reservation_settings SET  place = :place, start_date = :start_date, progress = :progress, count = :count, display_flg = :display_flg WHERE  id = :id or id = :id_2;");
//         $stmt->bindValue(':id', $id, PDO::PARAM_INT);
//         $stmt->bindValue(':id_2', $id_2, PDO::PARAM_INT);
//         $stmt->bindValue(':place', $place, PDO::PARAM_INT);
//         $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
//         $stmt->bindValue(':progress', $progress, PDO::PARAM_INT);
//         $stmt->bindValue(':count', $count, PDO::PARAM_INT);
//         $stmt->bindValue(':display_flg', $display_flg, PDO::PARAM_INT);
//         $res = $stmt->execute();
//     }

//     $pdo = null;

//     return $res;
// }

function getSelectAll($place){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM reservation_settings WHERE place = :place ORDER BY start_date");
    $stmt->bindValue(':place', $place, PDO::PARAM_INT);
    $res = $stmt->execute();
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $pdo = null;

    return $data;
}

function reseveStore($place,$start_date){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("INSERT INTO reservation_settings (
        place, start_date
    ) VALUES (
       :place, :start_date
     )");
    $stmt->bindValue(':place', $place, PDO::PARAM_INT);
    $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
    $res = $stmt->execute();



    if($place == 1){
        $stmt = $pdo->prepare("INSERT INTO reservation_settings (
            place, start_date
        ) VALUES (
           :place, :start_date
         )");
        $stmt->bindValue(':place', 2, PDO::PARAM_INT);
        $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
        $res = $stmt->execute();
    }
    
    $pdo = null;

    return $res;
}

function getTomorrowData(){

    $pdo = dbConect();

    date_default_timezone_set ('Asia/Tokyo');
    $start_date = date('Y-m-d', strtotime('+1 day'));
  
    $stmt = $pdo->prepare("SELECT * FROM reservation_settings WHERE start_date = :start_date");
    $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $pdo = null;

    return $data;
}


function updateReservation($id,$start_date,$place){

        $pdo = dbConect();
    
        if($place == 11){
            $stmt = $pdo->prepare("UPDATE reservation_settings SET start_date = :start_date WHERE  id = :id;");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
            $res = $stmt->execute();

            $pdo = null;
            return $res;
        }

        if($place == 1){
            $stmt = $pdo->prepare("UPDATE reservation_settings SET start_date = :start_date WHERE  id = :id;");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
            $res = $stmt->execute();

            $id++;
            $stmt = $pdo->prepare("UPDATE reservation_settings SET start_date = :start_date WHERE  id = :id;");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
            $res = $stmt->execute();

            $pdo = null;
            return $res;

        }
       
    }

    function getSelectAllLast($place){
    
        $pdo = dbConect();

        date_default_timezone_set('Asia/Tokyo');
        $date = date("Y-m-d H:i:s",strtotime("-10 day"));
    
        $stmt = $pdo->prepare("SELECT * FROM reservation_settings WHERE place = :place and start_data > :date ORDER BY start_date DESC");
        $stmt->bindValue(':place', $place, PDO::PARAM_INT);
        $stmt->bindValue(':start_data', $date, PDO::PARAM_INT);
        $res = $stmt->execute();
        $data = null;
        
        if( $res ) {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        $pdo = null;
    
        return $data;
    }

    function deleteReserve($id){
    
        $pdo = dbConect();
    
        $stmt = $pdo->prepare("DELETE FROM reservation_settings WHERE id = :id LIMIT 1");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $res = $stmt->execute();    
    
        $pdo = null;
    
        return $res;
    }


    function getReservationFromPlace($place){
    
        $pdo = dbConect();

        date_default_timezone_set('Asia/Tokyo');
        $tmp_date = date("Y-m-d H:i:s",strtotime("-7 day"));
    
        $stmt = $pdo->prepare("SELECT * FROM reservation_settings WHERE place = :place and start_date > :date ORDER BY start_date");
        $stmt->bindValue(':place', $place, PDO::PARAM_INT);
        $stmt->bindValue(':date', $tmp_date, PDO::PARAM_STR);
        $res = $stmt->execute();
        $data = null;
        
        if( $res ) {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        $pdo = null;
    
        return $data;
    }




?>
