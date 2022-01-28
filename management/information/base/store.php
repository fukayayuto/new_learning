<?php

ini_set('display_errors', "On");
require_once "../../db/information.php"; 

$title = $_POST['title'];
$link = $_POST['link'];
if(!empty($_POST['link_part'])){
    $link_part = $_POST['link_part'];
}
$priority = $_POST['priority'];
$display_flg = $_POST['display_flg'];

$place = 0;

$res = informationStore($title,$link,$link_part,$priority,$display_flg,$place);


if(!$res){
    $res = 2;
}else{
    $res = 1;
}

header('Location: http://localhost:8888/management/information/base/?res=' . $res);




?>