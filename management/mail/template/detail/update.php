<?php

ini_set('display_errors', "On");
require_once "../../../db/mail_template.php"; 

$title = $_POST['title'];
$text = $_POST['text'];
$id = $_POST['id'];
$method = $_POST['method'];



$res = updateMailTemplate($title,$text,$method,$id);
if(!$res){
    $res = 1;
}else{
    $res = 2;
}
header('Location: http://localhost:8888/management/mail/template/detail?id=' . $id . '&res=' .$res);
exit();
