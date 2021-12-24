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




?>