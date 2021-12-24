<?php

require_once "db.php"; 
require_once "entries.php"; 

function accountStore($email,$compnay_name,$phone,$sales_office){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("INSERT INTO accounts (
             email, company_name, sales_office, phone
            ) VALUES (
             :email, :company_name,:sales_office, :phone
             )");
    $date = new DateTime();
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':company_name', $compnay_name, PDO::PARAM_STR);
    $stmt->bindValue(':sales_office', $sales_office, PDO::PARAM_STR);
    $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
    $res = $stmt->execute();

    if( $res ) {
        $id = $pdo -> lastInsertId();
    }
    $pdo = null;

    return $id;
}

function getAccount($id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE id = :id ");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $res = $stmt->execute();

    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $pdo = null;

    return $data;

    
}

// function getAccountAll(){
    
//     $pdo = dbConect();

//     $stmt = $pdo->prepare("SELECT * FROM accounts ORDER BY ID DESC");
//     $res = $stmt->execute();

//     if( $res ) {
//         $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }

//     $pdo = null;

//     return $data;

    
// }

function getAccountAll(){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE del_flg = :del_flg ORDER BY ID DESC");
    $stmt->bindValue(':del_flg', 0, PDO::PARAM_INT);
    $res = $stmt->execute();

    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}

function updateAccount($id,$email,$company_name,$sales_office,$phone,$memo){
    
    $pdo = dbConect();

    date_default_timezone_set('Asia/Tokyo');
    $date = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare("UPDATE accounts SET  email = :email, company_name = :company_name, sales_office = :sales_office, phone = :phone , memo = :memo , updated_at = :updated_at  WHERE  id = :id;");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':company_name', $company_name, PDO::PARAM_STR);
        $stmt->bindValue(':sales_office', $sales_office, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
        $stmt->bindValue(':updated_at', $date, PDO::PARAM_STR);
        $res = $stmt->execute();

    $pdo = null;

    return $res;
}

function emailSearch($email){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE email = :email" );
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $res = $stmt->execute();

    if( $res ) {
        $data = $stmt->fetch();
    }

    $pdo = NULL;

    return $data;
}

function getSearchFromName($name){
    
    $pdo = dbConect();
    $name = '%' . $name . '%';

    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE name like :name" );
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $res = $stmt->execute();

    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $pdo = NULL;

    return $data;
}

function getSearchFromEmail($email){
    
    $pdo = dbConect();
    $email = '%' . $email . '%';

    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE email like :email" );
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $res = $stmt->execute();

    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $pdo = NULL;

    return $data;
}

function getSearchFromCompanyname($company_name){
    
    $pdo = dbConect();
    $company_name = '%' . $company_name . '%';

    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE company_name like :company_name" );
    $stmt->bindValue(':company_name', $company_name, PDO::PARAM_STR);
    $res = $stmt->execute();

    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $pdo = NULL;

    return $data;
}

function updateAccountDel($account_id){
    
    $pdo = dbConect();

    date_default_timezone_set('Asia/Tokyo');
    $date = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare("UPDATE accounts SET  updated_at = :updated_at,del_flg = :del_flg WHERE  id = :id;");
        $stmt->bindValue(':id', $account_id, PDO::PARAM_INT);
        $stmt->bindValue(':updated_at', $date, PDO::PARAM_STR);
        $stmt->bindValue(':del_flg', 1, PDO::PARAM_STR);
        $res = $stmt->execute();

    $pdo = null;

    return $res;
}





?>
