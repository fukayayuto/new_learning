
<?php

require_once 'db.php';


function nameListStore($name,$name_list_id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("INSERT INTO name_lists (
        name, id
    ) VALUES (
       :name, :id
     )");
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':id', $name_list_id, PDO::PARAM_INT);
    $res = $stmt->execute();

    $pdo = null;

    return $res;
}


function getNameListLastId(){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT MAX(id) as id FROM name_lists");
    $res = $stmt->execute();
    
    $id = 1;
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $id = $data[0]['id'];
    }
    
    $pdo = null;

    return $id;
}

function getNameListId($id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM name_lists WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $res = $stmt->execute();

    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    $pdo = null;

    return $data;
}

function updateNameList($name_list_id,$name,$number){
    
    $pdo = dbConect();

    date_default_timezone_set('Asia/Tokyo');
    $date = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare("UPDATE name_lists SET  name = :name, updated_at = :updated_at WHERE  id = :id and number = :number;");
        $stmt->bindValue(':id', $name_list_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':number', $number, PDO::PARAM_INT);
        $stmt->bindValue(':updated_at', $date, PDO::PARAM_STR);
        $res = $stmt->execute();

    $pdo = null;

    return $res;
}


?>