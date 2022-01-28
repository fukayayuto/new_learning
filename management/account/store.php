<?php

ini_set('display_errors', "On");
require_once "../db/accounts.php"; 

$company_name = $_POST['company_name'];
$sales_office = $_POST['sales_office'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$res = accountsStore($email,$company_name,$phone,$sales_office);



if(!$res){
    $res = 4;
}else{
    $res = 3;
}

header('Location: http://localhost:8888/management/account/?res=' . $res);

?>