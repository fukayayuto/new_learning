<?php

require_once "db.php"; 

function getInformation($place){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM information WHERE place = :place ORDER BY publish_date DESC");
    $stmt->bindValue(':place', $place, PDO::PARAM_INT);
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}

function informationStore($title,$link,$link_part,$priority,$place,$blank_flg,$publish_date){

    if(!empty($link) && empty($link_part)){
        return false;
    }
    if(empty($link) && !empty($link_part)){
        return false;
    }
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("INSERT INTO information (
        title, link, link_part, priority, place, blank_flg, publish_date
    ) VALUES (
       :title, :link, :link_part, :priority, :place, :blank_flg, publish_date
     )");
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':link', $link, PDO::PARAM_STR);
    $stmt->bindValue(':link_part', $link_part, PDO::PARAM_STR);
    $stmt->bindValue(':priority', $priority, PDO::PARAM_INT);
    $stmt->bindValue(':place', $place, PDO::PARAM_INT);
    $stmt->bindValue(':blank_flg', $blank_flg, PDO::PARAM_INT);
    $stmt->bindValue(':publish_date', $publish_date, PDO::PARAM_STR);
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


function updateInformation($title,$link,$link_part,$display_flg,$id){

    if(!empty($link) && empty($link_part)){
        return false;
    }
    if(empty($link) && !empty($link_part)){
        return false;
    }
    
    $pdo = dbConect();
    // $date = '21-12-12';

    $stmt = $pdo->prepare("UPDATE information SET  title = :title, link = :link, link_part = :link_part, display_flg = :display_flg WHERE  id = :id;");
        $stmt->bindValue(':title', $title, PDO::PARAM_INT);
        $stmt->bindValue(':link', $link, PDO::PARAM_INT);
        $stmt->bindValue(':link_part', $link_part, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':display_flg', $display_flg, PDO::PARAM_INT);
        $res = $stmt->execute();

    $pdo = null;

    return $res;
}

function getPriorityiInformation($place){

    $pdo = dbConect(); 
    $stmt = $pdo->prepare("SELECT * FROM information WHERE priority = :priority and display_flg = :display_flg and place = :place  ORDER BY publish_date DESC");
    $stmt->bindValue(':priority', 1, PDO::PARAM_INT);
    $stmt->bindValue(':display_flg', 1, PDO::PARAM_INT);
    $stmt->bindValue(':place', $place, PDO::PARAM_INT);
    $res = $stmt->execute();

    $data = array();

    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $pdo = null;

    return $data;
}


function getNormalInformation($limit,$place){
    $pdo = dbConect(); 

    $stmt = $pdo->prepare("SELECT * FROM information WHERE priority = :priority and display_flg = :display_flg and place = :place ORDER BY publish_date DESC limit :limit");
    $stmt->bindValue(':priority', 0, PDO::PARAM_INT);
    $stmt->bindValue(':display_flg', 1, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':place', $place, PDO::PARAM_INT);
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}


?>
