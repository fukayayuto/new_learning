<?php
require_once "../db/mail.php";
require_once "../db/accounts.php";
require_once "../db/entries.php";

$account_id_list = $_POST['account_id'];
$mail_subject = $_POST['title'];
$mail_text = $_POST['mail_text'];


if($_POST['confirm_flg'] == 1){
    $entry_id = $_POST['entry_id'];
    $confirm_flg = 1;
    $res = updateConfirmStatus($entry_id,$confirm_flg);
}

$data = array();

//メール送信処理
mb_language("Japanese");
mb_internal_encoding("UTF-8");

foreach ($account_id_list as $k => $account_id) {
    $account_data = getAccount($account_id);
    $company_name =  $account_data[0]['company_name'];
    $email = $account_data[0]['email'];
    $mail_body = $mail_text;
    $mail_to = $email;
    $mail_header    = "from:icts01@cab-station.com";
    $mailsousin = true;
    $mailsousin = mb_send_mail($mail_to, $mail_subject, $mail_body, $mail_header);
    if ($mailsousin == false) {
        $res = 1;
        header('Location: http://localhost:8888/management/mail/?res=' . $res);
    }
    
    $data[$k]['account_id'] = $account_data[0]['id'];
}
$adress_id = getAdressId();
$adress_id++;
foreach ($data as $val) {

    $res = adressListStore($adress_id, $val['account_id']);

    if (!$res) {
        $res = 2;
        header('Location: http://localhost:8888/management/mail/?res=' . $res);

    }
}
$title = $mail_subject;
$mail_text = $mail_body;
$email_content_id = emailContentStore($title, $mail_text, $adress_id);
if (empty($email_content_id)) {
    $res = 3;
    header('Location: http://localhost:8888/management/mail/?res=' . $res);

}
$res = emailStore($email_content_id);
if (!$res) {
    $res = 4;
    header('Location: http://localhost:8888/management/mail/?res=' . $res);

}
if($res){
$res = 5;
header('Location: http://localhost:8888/management/mail/?res=' . $res);
}
