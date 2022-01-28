<?php

require_once "db.php"; 

function getMailTemplateAll(){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM mail_template ORDER BY ID DESC");
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}


// function getMailTemplate($id){
    
//     $username = 'root';
//     $password = 'root';
//     $pdo = new PDO("mysql:host=localhost;dbname=drive_good_learning;",  $username,  $password
//                ,  array(
//                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
//                       )
//               );

//     $stmt = $pdo->prepare("SELECT * FROM mail_template WHERE id = :id");
//     $stmt->bindValue(':id', $id, PDO::PARAM_INT);
//     $res = $stmt->execute();

//     $data = null;
    
//     if( $res ) {
//         $data = $stmt->fetch();
//     }
//     $pdo = null;

//     return $data;
// }

function getMailTemplate($id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM mail_template WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetch();
    }
    $pdo = null;

    return $data;
}

// function updateMailTemplate($title,$text,$id){
    
    // $username = 'root';
    // $password = 'root';
    // $pdo = new PDO("mysql:host=localhost;dbname=drive_good_learning;",  $username,  $password
    //            ,  array(
    //                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    //                   )
    //           );


//     $stmt = $pdo->prepare("UPDATE mail_template SET  title = :title, text = :text WHERE  id = :id;");
//     $stmt->bindValue(':id', $id, PDO::PARAM_INT);
//     $stmt->bindValue(':title', $title, PDO::PARAM_STR);
//     $stmt->bindValue(':mail_text', $text, PDO::PARAM_STR);
//     $res = $stmt->execute();

//     return $res;
// }

function getMailTemplateAll2(){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM mail_template ORDER BY ID");
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}

function mailTemplateStore($title,$method,$mail_text){
    
    $pdo = dbConect();
    $stmt = $pdo->prepare("INSERT INTO mail_template (
        title, text, method
    ) VALUES (
       :title, :text, :method
     )");
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':text', $mail_text, PDO::PARAM_STR);
    $stmt->bindValue(':method', $method, PDO::PARAM_STR);
    $res = $stmt->execute();
    
    $pdo = null;

    return $res;
}

function updateMailTemplate($title,$text,$method,$input_flg,$id){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("UPDATE mail_template SET  title = :title, text = :text,method = :method,input_flg = :input_flg WHERE  id = :id;");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':text', $text, PDO::PARAM_STR);
    $stmt->bindValue(':method', $method, PDO::PARAM_STR);
    $stmt->bindValue(':input_flg', $input_flg, PDO::PARAM_STR);
    $res = $stmt->execute();

    return $res;
}

function getMailTemplateInput(){
    
    $pdo = dbConect();

    $stmt = $pdo->prepare("SELECT * FROM mail_template WHERE input_flg = :input_flg");
    $stmt->bindValue(':input_flg', 1, PDO::PARAM_INT);
    $res = $stmt->execute();

    $data = null;
    
    if( $res ) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;

    return $data;
}
