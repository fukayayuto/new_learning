<?php

require_once "db.php"; 

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

//     $pdo = null;

//     return $res;
// }

function getEntry($id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM entries WHERE reservation_id = :id ORDER BY updated_at DESC ");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}

function selectAccount($account_id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM entries WHERE account_id = :account_id ");
    $stmt->bindValue(':account_id', $account_id, PDO::PARAM_INT);
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}

function getEntryAll(){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM entries ORDER BY id DESC ");
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}

function selectEntry($id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM entries WHERE id = :id ");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetch();
    }
    $pdo = null;

    return $data;
}

function updateEntry($entry_id,$status){
    
    $pdo = dbConect();

    date_default_timezone_set('Asia/Tokyo');
    $date = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare("UPDATE entries SET  status = :status, updated_at = :updated_at  WHERE  id = :id;");
        $stmt->bindValue(':id', $entry_id, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->bindValue(':updated_at', $date, PDO::PARAM_STR);
        $res = $stmt->execute();

    
    $pdo = null;

    return $res;
}

function SelectPlaceEntry($place){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM entries WHERE place = :place ");
    $stmt->bindValue(':place', $place, PDO::PARAM_INT);
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}

function reschedule($entry_id,$new_reservation_id){
    
    $pdo = dbConect();

    date_default_timezone_set('Asia/Tokyo');
    $date = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare("UPDATE entries SET  reservation_id = :new_reservation_id , updated_at = :updated_at, status = :status WHERE  id = :id;");
        $stmt->bindValue(':new_reservation_id', $new_reservation_id, PDO::PARAM_INT);
        $stmt->bindValue(':id', $entry_id, PDO::PARAM_INT);
        $stmt->bindValue(':status', 0, PDO::PARAM_INT);
        $stmt->bindValue(':updated_at', $date, PDO::PARAM_STR);
        $res = $stmt->execute();

    
    $pdo = null;

    return $res;
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

function updateEntryNumber($count,$name_1,$name_2,$name_3,$name_4,$name_5,$entry_id){
    
    $pdo = dbConect();

    date_default_timezone_set('Asia/Tokyo');
    $date = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare("UPDATE entries SET  count = :count , name_1 = :name_1, name_2 = :name_2,name_3 = :name_3, name_4 = :name_4 , name_5 = :name_5,updated_at = :updated_at WHERE  id = :id;");
        $stmt->bindValue(':count', $count, PDO::PARAM_INT);
        $stmt->bindValue(':id', $entry_id, PDO::PARAM_INT);
        $stmt->bindValue(':name_1', $name_1, PDO::PARAM_STR);
        $stmt->bindValue(':name_2', $name_2, PDO::PARAM_STR);
        $stmt->bindValue(':name_3', $name_3, PDO::PARAM_STR);
        $stmt->bindValue(':name_4', $name_4, PDO::PARAM_STR);
        $stmt->bindValue(':name_5', $name_5, PDO::PARAM_STR);
        $stmt->bindValue(':updated_at', $date, PDO::PARAM_STR);
        $res = $stmt->execute();

    
    $pdo = null;

    return $res;
}

function updateConfirmStatus($entry_id,$confirm_flg){
    
    $pdo = dbConect();

    date_default_timezone_set('Asia/Tokyo');
    $date = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare("UPDATE entries SET  confirm_flg = :confirm_flg, updated_at = :updated_at  WHERE  id = :id;");
        $stmt->bindValue(':id', $entry_id, PDO::PARAM_INT);
        $stmt->bindValue(':confirm_flg', $confirm_flg, PDO::PARAM_INT);
        $stmt->bindValue(':updated_at', $date, PDO::PARAM_STR);
        $res = $stmt->execute();

    
    $pdo = null;

    return $res;
}


?>
