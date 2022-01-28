<?php
require_once 'db.php';

// function entryStore($account_id,$reservation_id,$count){
    
//     $pdo = dbConect();

//     $stmt = $pdo->prepare("INSERT INTO entries (
//                 account_id, reservation_id, count
//             ) VALUES (
//                :account_id, :reservation_id, :count
//              )");
//     $stmt->bindValue(':account_id', $account_id, PDO::PARAM_INT);
//     $stmt->bindValue(':reservation_id', $reservation_id, PDO::PARAM_INT);
//     $stmt->bindValue(':count', $count, PDO::PARAM_INT);
//     $res = $stmt->execute();

//     $id = $pdo -> lastInsertId();

//     return $id;
// }

function getEntry($id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM entries WHERE reservation_id = :id ");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}

function entryStore($account_id,$reservation_id,$count,$name_1,$name_2,$name_3,$name_4,$name_5){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("INSERT INTO entries (
                account_id, reservation_id, count, name_1,name_2,name_3, name_4, name_5
            ) VALUES (
               :account_id, :reservation_id, :count,:name_1, :name_2, :name_3,:name_4,:name_5
             )");
    $stmt->bindValue(':account_id', $account_id, PDO::PARAM_INT);
    $stmt->bindValue(':reservation_id', $reservation_id, PDO::PARAM_INT);
    $stmt->bindValue(':count', $count, PDO::PARAM_INT);
    $stmt->bindValue(':name_1', $name_1, PDO::PARAM_STR);
    $stmt->bindValue(':name_2', $name_2, PDO::PARAM_STR);
    $stmt->bindValue(':name_3', $name_3, PDO::PARAM_STR);
    $stmt->bindValue(':name_4', $name_4, PDO::PARAM_STR);
    $stmt->bindValue(':name_5', $name_5, PDO::PARAM_STR);
    $res = $stmt->execute();

    $id = $pdo -> lastInsertId();

    return $id;
}



?>
