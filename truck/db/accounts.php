<?php

require_once 'db.php';

// function accountStore($email,$company_name,$phone,$sales_office,$name_1,$name_2,$name_3,$name_4,$name_5){
    
//     $pdo = dbConect();
    
//     $stmt = $pdo->prepare("INSERT INTO accounts (
//                  email, company_name, sales_office, phone,name_1,name_2,name_3,name_4,name_5
//             ) VALUES (
//                :email, :company_name,:sales_office, :phone,:name_1,:name_2, :name_3, :name_4, :name_5
//              )");
//     $stmt->bindValue(':email', $email, PDO::PARAM_STR);
//     $stmt->bindValue(':company_name', $company_name, PDO::PARAM_STR);
//     $stmt->bindValue(':sales_office', $sales_office, PDO::PARAM_STR);
//     $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
//     $stmt->bindValue(':name_1', $name_1, PDO::PARAM_STR);
//     $stmt->bindValue(':name_2', $name_2, PDO::PARAM_STR);
//     $stmt->bindValue(':name_3', $name_3, PDO::PARAM_STR);
//     $stmt->bindValue(':name_4', $name_4, PDO::PARAM_STR);
//     $stmt->bindValue(':name_5', $name_5, PDO::PARAM_STR);
//     $res = $stmt->execute();

//     if( $res ) {
//         $id = $pdo -> lastInsertId();
//     }

//     return $id;
// }

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

function accountStore($email,$company_name,$phone,$sales_office){
    
    $pdo = dbConect();
    
    $stmt = $pdo->prepare("INSERT INTO accounts (
                 email, company_name, sales_office, phone
            ) VALUES (
               :email, :company_name,:sales_office, :phone
             )");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':company_name', $company_name, PDO::PARAM_STR);
    $stmt->bindValue(':sales_office', $sales_office, PDO::PARAM_STR);
    $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
    $res = $stmt->execute();

    if( $res ) {
        $id = $pdo -> lastInsertId();
    }

    return $id;
}




?>
