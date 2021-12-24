<?php

require_once "db.php"; 

function getReservatinData($id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM  reservations WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $res = $stmt->execute();
    
    if( $res ) {
        $data = $stmt->fetch();
    }

    $pdo = null;

    return $data;
}

function getReserveAll(){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM  reservations");
    $res = $stmt->execute();
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $pdo = null;

    return $data;
}

function updateReserve($place,$name,$progress,$start_time ,$end_time,$count,$price,$detail){
    
    $pdo = dbConect();

    date_default_timezone_set('Asia/Tokyo');
    $date = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare("UPDATE reservations SET  name = :name, progress = :progress, start_time = :start_time, end_time = :end_time , count = :count , price = :price, detail = :detail, updated_at = :updated_at WHERE  id = :place;");
        $stmt->bindValue(':place', $place, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':progress', $progress, PDO::PARAM_INT);
        $stmt->bindValue(':start_time', $start_time, PDO::PARAM_STR);
        $stmt->bindValue(':end_time', $end_time, PDO::PARAM_STR);
        $stmt->bindValue(':count', $count, PDO::PARAM_INT);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR);
        $stmt->bindValue(':detail', $detail, PDO::PARAM_STR);
        $stmt->bindValue(':updated_at', $date, PDO::PARAM_STR);
        $res = $stmt->execute();

    $pdo = null;

    return $res;
}


function reserveStore($name, $progress, $start_time, $end_time, $count, $price,$detail,$img){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("INSERT INTO reservations (
        name, progress, start_time,end_time, count,price,detail,image
    ) VALUES (
       :name, :progress, :start_time,:end_time, :count,:price,:detail.:image
     )");
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':progress', $progress, PDO::PARAM_INT);
    $stmt->bindValue(':start_time', $start_time, PDO::PARAM_STR);
    $stmt->bindValue(':end_time', $end_time, PDO::PARAM_STR);
    $stmt->bindValue(':count', $count, PDO::PARAM_INT);
    $stmt->bindValue(':price', $price, PDO::PARAM_INT);
    $stmt->bindValue(':detail', $detail, PDO::PARAM_STR);
    $stmt->bindValue(':image', $img, PDO::PARAM_STR);
    $res = $stmt->execute();
    
    $pdo = null;

    return $res;
}

function updateReserveImage($place,$image_name){
    
    $pdo = dbConect();

    date_default_timezone_set('Asia/Tokyo');
    $date = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare("UPDATE reservations SET  image = :image,updated_at = :updated_at WHERE  id = :id;");
        $stmt->bindValue(':id', $place, PDO::PARAM_INT);
        $stmt->bindValue(':image', $image_name, PDO::PARAM_STR);
        $stmt->bindValue(':updated_at', $date, PDO::PARAM_STR);
        $res = $stmt->execute();

    $pdo = null;

    return $res;
}



?>