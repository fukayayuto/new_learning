<?php
ini_set('display_errors', "On");
require_once "../../db/mail.php";

if($_GET['id']){
    $id = $_GET['id'];
}

$res = deleteMail($id);


if(!$res){
    $res = 6;
}else{
    $res = 5;
}

header('Location: https://promote.good-learning.jp/management/mail/?res=' . $res);