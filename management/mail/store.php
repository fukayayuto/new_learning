<?php
ini_set('display_errors', "On");
require_once "../db/mail.php";
require_once "../db/accounts.php";
require_once "../db/entries.php";

// $account_id_list = $_POST['account_id'];
// $mail_subject = $_POST['title'];
// $mail_text = $_POST['mail_text'];


// if($_POST['confirm_flg'] == 1){
//     $entry_id = $_POST['entry_id'];
//     $confirm_flg = 1;
//     $res = updateConfirmStatus($entry_id,$confirm_flg);
// }

$data = array();

$account_id_list = $_POST['account_id'];
$mail_subject = $_POST['title'];
$mail_text = $_POST['mail_text'];

$data = array();
$file_name_list = array();
$file_path_list = array();
$file_name_jp_list = array();

if ($_POST['confirm_flg'] == 1) {
    $entry_id = $_POST['entry_id'];
    $confirm_flg = 1;
    $res = updateConfirmStatus($entry_id, $confirm_flg);
}

if ($_POST['claim_flg'] == 1) {
    $entry_id = $_POST['entry_id'];
    $claim_flg = 1;
    $res = updateClaimStatus($entry_id, $claim_flg);
}

if ($_POST['certificate'] == 1) {
    $entry_id = $_POST['entry_id'];
    $certificate = 1;
    $res = updateCertificateStatus($entry_id, $certificate);
}

//メール送信処理
mb_language("Japanese");
mb_internal_encoding("UTF-8");

foreach ($account_id_list as $k => $account_id) {
    $account_data = getAccount($account_id);
    $email = $account_data[0]['email'];
    $mail_to = $email;

    // // 送信元の設定
    $sender_email = 'icts01@cab-station.com';
    $org = '株式会社キャブステーション';
    $from = '株式会社キャブステーション <icts01@cab-station.com>';

    if ($_FILES['file_1']['name'][0] != "") {
        // ヘッダー設定
        $header = '';
        $header .= "Content-Type: multipart/mixed;boundary=\"__BOUNDARY__\"\n";
        $header .= "Return-Path: " . $sender_email . " \n";
        $header .= "From: " . $from . " \n";
        $header .= "Sender: " . $from . " \n";
        $header .= "Reply-To: " . $sender_email . " \n";
        $header .= "Organization: " . $org . " \n";
        $header .= "X-Sender: " . $org . " \n";
        $header .= "X-Priority: 3 \n";

        $mail_body = "--__BOUNDARY__\n";
        // $mail_body .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"\n\n";
        $mail_body .= $mail_text . "\n\n\n";
        $mail_body .= "--__BOUNDARY__\n";

        for ($i = 0; $i < count($_FILES['file_1']['name']); $i++) {
            if ($_FILES['file_1']['name'][$i] != '') {
                $file_1 = mb_encode_mimeheader($_FILES['file_1']['name'][$i], "ISO-2022-JP", "UTF-8");
                $file_path_1 = $_FILES['file_1']['tmp_name'][$i];
                $mail_body .= "Content-Type: application/octet-stream; name=\"{$file_1}\"\n";
                $mail_body .= "Content-Disposition: attachment; filename=\"{$file_1}\"\n";
                $mail_body .= "Content-Transfer-Encoding: base64\n";
                $mail_body .= "\n";
                $mail_body .= chunk_split(base64_encode(file_get_contents($file_path_1)));
                $mail_body .= "--__BOUNDARY__\n";


                $file_name = hash('sha256',$_FILES['file_1']['name'][$i]);
                $file_name_ja = $_FILES['file_1']['name'][$i];
                $file_path = $_FILES['file_1']['tmp_name'][$i];

                $save = '/home/tokyo-mytour/www/promote.good-learning.jp/management/common/file/' . basename($file_name);

                if (move_uploaded_file($file_path, $save)) {
                } else {
                }
                $file_name_list[$i] = $file_name;
                $file_name_jp_list[$i] = $file_name_ja;
                $file_path_list[$i] = $file_path;
            }
        }
        // $mailsousin = mb_send_mail($mail_to, $mail_subject, $mail_body, $header);
    } else {
        $mail_body = $mail_text;
        $mail_to = $email;
        $mail_header    = "from:icts01@cab-station.com";
        // $mailsousin = mb_send_mail($mail_to, $mail_subject, $mail_body, $mail_header);
    }
    $data[$k]['account_id'] = $account_data[0]['id'];
}

$adress_id = getAdressId();
$adress_id++;

// $res = adressListStore($adress_id, $val['account_id']);

foreach ($data as $val) {

    $res = adressListStore($adress_id, $val['account_id']);

    if (!$res) {
        $res = 2;
        header('Location: https://promote.good-learning.jp/management/mail/?res=' . $res);
    }
}

if ($file_name_list[0] != ''){
    $last_file_id = lastFileId();

    for ($i = 0; $i < count($file_name_list); $i++) {
        
        $number = $i + 1;
       
        $file_name = $file_name_list[$i];
        $file_name_jp = $file_name_jp_list[$i];
        InsertFileId($last_file_id, $number, $file_name,$file_name_jp);
    }
    $email_content_id = emailContentStoreToFile($mail_subject, $mail_text, $adress_id, $last_file_id);
} else {
    $email_content_id = emailContentStore($mail_subject, $mail_text, $adress_id);
}


if (empty($email_content_id)) {
    $res = 3;
    header('Location: https://promote.good-learning.jp/management/mail/?res=' . $res);
    exit();
}
$res = emailStore($email_content_id);
if (!$res) {
    $res = 4;
    header('Location: https://promote.good-learning.jp/management/mail/?res=' . $res);
    exit();
}else{
    $res = 5;
    header('Location: https://promote.good-learning.jp/management/mail/?res=' . $res);
    exit();
}






// foreach ($account_id_list as $k => $account_id) {
//     $account_data = getAccount($account_id);
//     $company_name =  $account_data[0]['company_name'];
//     $email = $account_data[0]['email'];
//     $mail_body = $mail_text;
//     $mail_to = $email;
//     $mail_header    = "from:icts01@cab-station.com";
//     $mailsousin = true;
//     $mailsousin = mb_send_mail($mail_to, $mail_subject, $mail_body, $mail_header);
//     if ($mailsousin == false) {
//         $res = 1;
//         header('Location: https://promote.good-learning.jp/management/mail/?res=' . $res);
//     }
    
//     $data[$k]['account_id'] = $account_data[0]['id'];
// }
// $adress_id = getAdressId();
// $adress_id++;
// foreach ($data as $val) {

//     $res = adressListStore($adress_id, $val['account_id']);

//     if (!$res) {
//         $res = 2;
//         header('Location: https://promote.good-learning.jp/management/mail/?res=' . $res);

//     }
// }
// $title = $mail_subject;
// $mail_text = $mail_body;
// $email_content_id = emailContentStore($title, $mail_text, $adress_id);
// if (empty($email_content_id)) {
//     $res = 3;
//     header('Location: https://promote.good-learning.jp/management/mail/?res=' . $res);

// }
// $res = emailStore($email_content_id);
// if (!$res) {
//     $res = 4;
//     header('Location: https://promote.good-learning.jp/management/mail/?res=' . $res);

// }
// if($res){
// $res = 5;
// header('Location: https://promote.good-learning.jp/management/mail/?res=' . $res);
// }
