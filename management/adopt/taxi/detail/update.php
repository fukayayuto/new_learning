<?php
ini_set('display_errors', "On");
require_once "../../../db/adopt.php"; 

$id = $_POST['id'];
$company_name = $_POST['company_name'];
$display_flg = $_POST['display_flg'];

$res = updateAdopt($company_name,$display_flg,$id);
if(!$res){
    $res = 4;
}else{
    $res = 3;
}
header('Location: http://localhost:8888//management/adopt/taxi/?res=' . $res);
