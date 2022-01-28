<?php
ini_set('display_errors', "On");
require_once "../../db/information.php"; 
$id = $_GET['id'];

$res = deleteInformation($id);

if(!$res){
    $res = 4;
}else{
    $res = 3;
}

header('Location: https://promote.good-learning.jp/management/information/truck/?res=' . $res);