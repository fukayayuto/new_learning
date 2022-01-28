
<?php

require_once 'db.php';


function nameListStore($name,$name_list_id,$number){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("INSERT INTO name_lists (
        name, id,number
    ) VALUES (
       :name, :id,:number
     )");
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':id', $name_list_id, PDO::PARAM_INT);
    $stmt->bindValue(':number', $number, PDO::PARAM_INT);
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


?>