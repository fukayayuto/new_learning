<?php

require_once "db.php"; 

function errorStore($number,$text){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("INSERT INTO error (
        number, text
    ) VALUES (
       :number ,:text
     )");
    $stmt->bindValue(':number', $number, PDO::PARAM_INT);
    $stmt->bindValue(':text', $text, PDO::PARAM_STR);
    $res = $stmt->execute();
    
    $pdo = null;

    return $res;
}