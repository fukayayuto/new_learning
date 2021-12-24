<?php

require_once "db.php"; 

function getInformation(){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM information ORDER BY ID DESC");
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}

function informationStore($title,$link,$link_part,$priority,$display_flg){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("INSERT INTO information (
        title, link, link_part,priority, display_flg
    ) VALUES (
       :title, :link, :link_part,:priority, :display_flg
     )");
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':link', $link, PDO::PARAM_STR);
    $stmt->bindValue(':link_part', $link_part, PDO::PARAM_STR);
    $stmt->bindValue(':priority', $priority, PDO::PARAM_INT);
    $stmt->bindValue(':display_flg', $display_flg, PDO::PARAM_INT);
    $res = $stmt->execute();
    
    $pdo = null;

    return $res;
}

function selectInformation($id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM information WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}


function updateInformation($title,$link,$link_part,$display_flg,$id,$priority){
    
    $pdo = dbConect();
    // $date = '21-12-12';

    $stmt = $pdo->prepare("UPDATE information SET  title = :title, link = :link, link_part = :link_part, display_flg = :display_flg,priority = :priority WHERE  id = :id;");
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':link', $link, PDO::PARAM_STR);
        $stmt->bindValue(':link_part', $link_part, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':display_flg', $display_flg, PDO::PARAM_INT);
        $stmt->bindValue(':priority', $priority, PDO::PARAM_INT);

        $res = $stmt->execute();

    $pdo = null;

    return $res;
}


?>
