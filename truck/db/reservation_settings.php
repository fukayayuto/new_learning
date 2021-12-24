<?php

require_once 'db.php';


function getData(){
    
    try {
        /// DB接続を試みる
        $pdo  = new PDO('mysql:host=' . HOSTNAME . ';dbname=' . DATABASE, USERNAME, PASSWORD);
        $msg = "MySQL への接続確認が取れました。";
        } catch (PDOException $e) {
        $isConnect = false;
        $msg       = "MySQL への接続に失敗しました。<br>(" . $e->getMessage() . ")";
        }


    $stmt = $pdo->prepare("SELECT * FROM reservation_settings WHERE place between :place_1 and :place_2 ");
    $stmt->bindValue(':place_1', 1, PDO::PARAM_INT);
    $stmt->bindValue(':place_2', 2, PDO::PARAM_INT);
    $res = $stmt->execute();
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $pdo = null;

    return $data;
}

function getDataDef(){

    $pdo = dbConect();
    date_default_timezone_set('Asia/Tokyo');
    $three_month = date("Y-m-d H:i:s",strtotime("+3 month"));

    $three_days = date("Y-m-d H:i:s",strtotime("+2 day"));

    $stmt = $pdo->prepare("SELECT * FROM reservation_settings WHERE place = :place and start_date >= :today and start_date <= :three_month ORDER BY start_date");
    $stmt->bindValue(':place', 1, PDO::PARAM_INT);
    $stmt->bindValue(':today', $three_days, PDO::PARAM_STR);
    $stmt->bindValue(':three_month', $three_month, PDO::PARAM_STR);
    $res = $stmt->execute();
    $data = null;
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $pdo = null;

    return $data;
}

function getDataNomember($start_date){

    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM reservation_settings WHERE place = :place and start_date = :today ");
    $stmt->bindValue(':place', 2, PDO::PARAM_INT);
    $stmt->bindValue(':today', $start_date, PDO::PARAM_STR);
    $res = $stmt->execute();
    
    if( $res ) {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    $pdo = null;

    return $data;
}


function getDataMie(){

    $pdo = dbConect();
    date_default_timezone_set('Asia/Tokyo');
    $three_month = date("Y-m-d H:i:s",strtotime("+3 month"));
    $three_days = date("Y-m-d H:i:s",strtotime("+2 day"));

    $stmt = $pdo->prepare("SELECT * FROM reservation_settings WHERE place = :place and start_date >= :today and start_date <= :three_month ORDER BY start_date");
    $stmt->bindValue(':place', 11, PDO::PARAM_INT);
    $stmt->bindValue(':today', $three_days, PDO::PARAM_STR);
    $stmt->bindValue(':three_month', $three_month, PDO::PARAM_STR);
    $res = $stmt->execute();
    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $pdo = null;

    return $data;
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





?>
