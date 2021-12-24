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

function adoptStore($company_name){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("INSERT INTO adopt (
        company_name
    ) VALUES (
       :company_name
     )");
    $stmt->bindValue(':company_name', $company_name, PDO::PARAM_STR);
    $res = $stmt->execute();
    
    $pdo = null;

    return $res;
}

function selectAdopt($id){
    
    $pdo = dbConect();


    $stmt = $pdo->prepare("SELECT * FROM adopt WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $res = $stmt->execute();

    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}

function updateAdopt($company_name,$display_flg,$id){
    
    $pdo = dbConect();

    date_default_timezone_set('Asia/Tokyo');
    $date = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare("UPDATE adopt SET  company_name = :company_name, updated_at = :updated_at,display_flg = :display_flg  WHERE  id = :id;");
        $stmt->bindValue(':company_name', $company_name, PDO::PARAM_STR);
        $stmt->bindValue(':display_flg', $display_flg, PDO::PARAM_INT);
        $stmt->bindValue(':updated_at', $date, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $res = $stmt->execute();

    
    $pdo = null;

    return $res;
}
