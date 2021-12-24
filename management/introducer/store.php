<?php
ob_start();
ini_set('display_errors', "On");
require_once "../db/introduce.php"; 

$name = $_POST['name'];
$email = $_POST['email'];

$res = introcducerStore($name,$email);

if(!$res){
    $res = 2;
}else{
    $res = 1;
}

header('Location: http://localhost:8888/management/introducer/list.php?res=' . $res);



?>