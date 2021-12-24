<?php
require_once "../../db/accounts.php";

$id = $_POST['id'];
$account = getAccount($id);

$email = $_POST['email'];
$company_name = $_POST['company_name'];
$sales_office = $_POST['sales_office'];
$phone = $_POST['phone'];
$memo = $_POST['memo'];
$res = updateAccount($id, $email, $company_name, $sales_office, $phone, $memo);
if (!$res) {
    $res = 0;
} else {
    $res = 1;
}
header('Location: http://localhost:8888/management/account/detail/?id=' . $id . '&res=' . $res);
