<?php
ob_start();
ini_set('display_errors', "On");
require_once "../../db/adopt.php"; 

$company_name = $_POST['company_name'];

$place = 0;
$res = adoptStore($company_name, $place);

if(!$res){
    $res = 2;
}else{
    $res = 1;
}

header('Location: http://localhost:8888/management/adopt/bus/?res=' . $res);




?>