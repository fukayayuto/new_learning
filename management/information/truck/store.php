<?php
ini_set('display_errors', "On");
require_once "../../db/information.php"; 

$title = $_POST['title'];
$link = $_POST['link'];
$link_part = '';
if(!empty($_POST['link_part'])){
    $link_part = $_POST['link_part'];
}
$priority = $_POST['priority'];
$blank_flg = $_POST['blank_flg'];
$publish_date = $_POST['publish_date'];

$place = 1;

$res = informationStore($title,$link,$link_part,$priority,$place,$blank_flg,$publish_date);

if(!$res){
    $res = 2;
}else{
    $res = 1;
}

header('Location: https://promote.good-learning.jp/management/information/truck/?res=' . $res);




?>