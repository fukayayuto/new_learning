<?php

require_once "db.php"; 

function getAdopt(){
    
    $pdo = dbConect();


    $stmt = $pdo->prepare("SELECT * FROM adopt ORDER BY id DESC");
    $res = $stmt->execute();

    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}