<?php

ini_set('display_errors', "On");
require_once "../../db/mail_template.php";

$data = array();

$title = $_POST['title'];
$method = $_POST['method'];
$mail_text = $_POST['mail_text'];

$res = mailTemplateStore($title,$method,$mail_text);

if(!$res){
    $res = 2;
}else{
    $res = 1;
}

header('Location: http://localhost:8888/management/mail/template/?res=' . $res);

?>