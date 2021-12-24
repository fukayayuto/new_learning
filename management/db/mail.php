<?php

require_once "db.php"; 

function getAdressId(){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT MAX(adress_id) as id FROM adress_lists ");
    $res = $stmt->execute();
    $id = 1;
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $id = $data[0]['id'];
    }
    
    $pdo = null;

    return $id;
}

function adressListStore($adress_id, $account_id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("INSERT INTO adress_lists (
            account_id, adress_id
        ) VALUES (
           :account_id, :adress_id
         )");
    $stmt->bindValue(':account_id', $account_id, PDO::PARAM_INT);
    $stmt->bindValue(':adress_id', $adress_id, PDO::PARAM_INT);
    $res = $stmt->execute();

    $pdo = null;

    return $res;
}
    
function emailContentStore($title, $mail_text,$adress_id){
    
    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
    ); 
    $pdo = new PDO(
        'mysql:host=mysql627.db.sakura.ne.jp;dbname=tokyo-mytour_good_learning',
        'tokyo-mytour', 'mnpp8bz36x', $options
    );

        $stmt = $pdo->prepare("INSERT INTO email_contents (
                title, mail_text,adress_id
            ) VALUES (
               :title, :mail_text, :adress_id
             )");
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':mail_text', $mail_text, PDO::PARAM_STR);
        $stmt->bindValue(':adress_id', $adress_id, PDO::PARAM_INT);
        $res = $stmt->execute();

        $id = 1;
        if( $res ) {
            $id = $pdo -> lastInsertId();
        }
        
        $pdo = null;
    
        return $id;
}
    
function emailStore($email_content_id){
    
    $pdo = dbConect();
    
    $stmt = $pdo->prepare("INSERT INTO emails (
            email_content_id
        ) VALUES (
           :email_content_id
         )");
    $stmt->bindValue(':email_content_id', $email_content_id, PDO::PARAM_INT);
    $res = $stmt->execute();

    $pdo = null;

    return $res;
}

function getEmailAll(){
    
    $pdo = dbConect();
 
     $stmt = $pdo->prepare("SELECT * FROM emails ORDER BY id DESC");
     $res = $stmt->execute();

     if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
 
     $pdo = null;
 
     return $data;
 }

 function getEmailContent($id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM email_contents WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_STR);
    $res = $stmt->execute();

    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     
     $pdo = null;
 
     return $data;
}

function getAccountList($adress_id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM adress_lists WHERE adress_id = :adress_id");
    $stmt->bindValue(':adress_id', $adress_id, PDO::PARAM_INT);
    $res = $stmt->execute();

    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     
     $pdo = null;
 
     return $data;
}

function emailContentStoreAuto($adress_id){
    
    $pdo = dbConect();

     $stmt = $pdo->prepare("INSERT INTO email_contents (
             adress_id
         ) VALUES (
            :adress_id
          )");
     $stmt->bindValue(':adress_id', $adress_id, PDO::PARAM_INT);
     $res = $stmt->execute();

     $id = 1;
     if( $res ) {
         $id = $pdo -> lastInsertId();
     }
     
     $pdo = null;
 
     return $id;
}

function getAdressListFromAccount(array $account_id_list){
    
    $pdo = dbConect();
    $data = array();
    foreach ($account_id_list as $k => $account_id) {
        $tmp = array();
        $stmt = $pdo->prepare("SELECT * FROM adress_lists WHERE account_id = :account_id");
        $stmt->bindValue(':account_id', $account_id, PDO::PARAM_INT);
        $res = $stmt->execute();

        if ($res) {
            $tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data[$k] = $tmp;
        }

    }
     $pdo = null;
 
     return $data;
}

function getEmailContentFromAdressID($adress_id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM email_contents WHERE adress_id = :adress_id");
    $stmt->bindValue(':adress_id', $adress_id, PDO::PARAM_INT);
    $res = $stmt->execute();

    if( $res ) {
        $data = $stmt->fetch();
        $id = $data['id'];
    }
     
     $pdo = null;
 
     return $id;
}

function getEmailFromContentID($email_content_id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM emails WHERE email_content_id = :email_content_id");
    $stmt->bindValue(':email_content_id', $email_content_id, PDO::PARAM_INT);
    $res = $stmt->execute();

    if( $res ) {
        $data = $stmt->fetch();
    }
     
     $pdo = null;
 
     return $data;
}



?>
