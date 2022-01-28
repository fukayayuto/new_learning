<?php

require_once "db.php"; 

function getAdopt($place){
    
    $pdo = dbConect();


    $stmt = $pdo->prepare("SELECT * FROM adopt WHERE place = :place ORDER BY id DESC");
    $stmt->bindValue(':place', $place, PDO::PARAM_INT);
    $res = $stmt->execute();

    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}