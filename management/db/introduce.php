<?php

require_once 'db.php';

function introduceStore($introducer_id,$entry_id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("INSERT INTO channel (
                introducer_id, entry_id
            ) VALUES (
               :introducer_id, :entry_id
             )");
    $stmt->bindValue(':introducer_id', $introducer_id, PDO::PARAM_INT);
    $stmt->bindValue(':entry_id', $entry_id, PDO::PARAM_INT);
    $res = $stmt->execute();

    $pdo = null;

    return $res;
}

function getIntroduceAll(){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM introducer ORDER BY id DESC");
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}

function getChanelAll(){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM channel ORDER BY id DESC");
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}

function selectIntroducer($introducer_id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM introducer WHERE id = :introducer_id");
    $stmt->bindValue(':introducer_id', $introducer_id, PDO::PARAM_INT);
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetch();
    }
    $pdo = null;

    return $data;
}

function selectChannel($id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM channel WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetch();
    }
    $pdo = null;

    return $data;
}

function getChannelFromIntroducerId($introducer_id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM channel WHERE introducer_id = :introducer_id");
    $stmt->bindValue(':introducer_id', $introducer_id, PDO::PARAM_INT);
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}

function updateIntroducer($introducer_id, $name, $email){
    
    $pdo = dbConect();

    date_default_timezone_set('Asia/Tokyo');
    $date = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare("UPDATE introducer SET  email = :email, name = :name, updated_at = :updated_at WHERE  id = :id;");
        $stmt->bindValue(':id', $introducer_id, PDO::PARAM_INT);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':updated_at', $date, PDO::PARAM_STR);
        $res = $stmt->execute();

    $pdo = null;

    return $res;
}

function introcducerStore($name,$email){
    
    $pdo = dbConect();

    $number = mt_rand(10000, 99999);

    $stmt = $pdo->prepare("INSERT INTO introducer (
        name, email,number
    ) VALUES (
       :name, :email,:number
     )");
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':number', $number, PDO::PARAM_STR);
    $res = $stmt->execute();
    
    $pdo = null;

    return $res;
}

