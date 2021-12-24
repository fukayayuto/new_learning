<?php
ini_set('display_errors', "On");
require_once "../../db/accounts.php";

if(!empty($_GET['id'])){
    $account_id = $_GET['id'];
}

$res = updateAccountDel($account_id);
if (!$res) {
    $res = 0;
} else {
    $res = 1;
}
header('Location: http://localhost:8888/management/account?res=' . $res);

?>