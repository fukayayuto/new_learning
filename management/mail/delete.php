<?php
ini_set('display_errors', "On");
require_once "../db/mail.php";

$select = $_POST['select'];

foreach($select as $id){
    $res = deleteMail($id);
    if(!$res){
        $res = 8;
        header('Location: https://promote.good-learning.jp/management/mail/?res=' . $res);
    }
}

$res = 9;

header('Location: https://promote.good-learning.jp/management/mail/?res=' . $res);