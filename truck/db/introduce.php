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


function channelStore($introducer_id,$entry_id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("INSERT INTO channel (
                introducer_id, entry_id
            ) VALUES (
               :introducer_id, :entry_id
             )");
    $stmt->bindValue(':introducer_id', $introducer_id, PDO::PARAM_INT);
    $stmt->bindValue(':entry_id', $entry_id, PDO::PARAM_INT);
    $res = $stmt->execute();

    return $res;
}