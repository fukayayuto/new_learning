<?php
require_once "../../db/introduce.php";

$introducer_id = $_POST['introducer_id'];

$name = $_POST['name'];
$email = $_POST['email'];
$res = updateIntroducer($introducer_id, $name, $email);
if (!$res) {
    $res = 0;
} else {
    $res = 1;
}
header('Location: http://localhost:8888/management/introducer/detail/?id=' . $introducer_id . '&res=' . $res);
