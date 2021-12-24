<?php
ob_start();
ini_set('display_errors', "On");
require_once "../db/adopt.php"; 

$company_name = $_POST['company_name'];

$res = adoptStore($company_name);

if(!$res){
    $res = 2;
}else{
    $res = 1;
}

header('Location: http://localhost:8888/management/adopt/?res=' . $res);




?>