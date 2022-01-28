<?php
header('Content-Type: text/html; charset=UTF-8');
ini_set('display_errors', "On");
require_once "db/mail.php";
require_once "db/accounts.php";
require_once "db/reservation_settings.php";
require_once "db/reservation.php";
require_once "db/entries.php";

// エスケープ処理
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}


$reservation_data = getTomorrowData();

$err = '';
$end_week = '';
$end_date = '';
foreach ($reservation_data as $val) {

    $reserve_data = getReservatinData($val['place']);
    $progress = (int) $reserve_data['progress'] - 1;

    switch ($val['place']) {
        case '1':
            $reservation_name = '【ユーザー限定】グッドラーニング！初任運転者講習（受講開始日で予約、最長７日間まで受講可能）';
            break;
        case '2':
            $reservation_name = 'グッドラーニング！初任運転者講習（受講開始日で予約、最長７日間まで受講可能）';
            break;
        case '11':
            $reservation_name = '【三重県トラック協会】グッドラーニング！初任運転者講習（受講開始日で予約、最長５日間まで受講可能）';
            break;
        default:
            # code...
            break;
    }


    $entry_data = getEntry($val['id']);

    foreach ($entry_data as $data) {

        if ($data['status'] == 1) {

            $count = $data['count'];


            // $tmp_start_date = new DateTime($val['start_date']);
            $week = array("日", "月", "火", "水", "木", "金", "土");
            // $start_week = $week[$tmp_start_date->format("w")];

            // $tmp_start_date = new DateTime($val['start_date']);
            // $start_date = $tmp_start_date->format('Y年n月j日');

            $start_date = date('Y年n月j日', strtotime($val['start_date']));
            $start_week =$week[date('w', strtotime($val['start_date']))];

            $end_date = date('Y年n月j日', strtotime($val['start_date'] .'+' . $progress . ' day' ));
            $end_week =$week[date('w', strtotime($val['start_date'] .'+' . $progress . ' day' ))];

            // $tmp_start_date = new DateTime($val['start_date']);
            // $end_date = $tmp_start_date->modify('+' . $progress . ' day')->format('n月j日');

            // $tmp_end_date = new DateTime($val['start_date']);
            // $end_week = $week[$tmp_end_date->modify('+' . $progress . ' day')->format("w")];

            $account = getAccount($data['account_id']);
            $company_name = $account[0]['company_name'];
            $account_id =  $account[0]['id'];

            $mail_to_1 = $account[0]['email'];
            $mail_header_1 = "from:icts01@cab-station.com";

            $mail_body_1 = h($company_name) . "\n";
            $mail_body_1 .=  "担当者様\n\n";
            $mail_body_1 .=  h($reservation_name) . "の受講開始の前日となりました。\n";
            $mail_body_1 .= "受講に関するご不明点は、03-6880-1072（コールセンター／平日9:30～12:00 13:00～17:00）または、icts01@cab-station.com までご連絡ください。\n";
            $mail_body_1 .= "----\n";
            $mail_body_1 .= "◆ご予約内容:\n";
            $mail_body_1 .= h($reservation_name)  . "\n";
            $mail_body_1 .= "◆予約人数:\n";
            $mail_body_1 .= h($count) . "\n";
            $mail_body_1 .= "◆提供者:\n";
            $mail_body_1 .= "◆予約日時:\n";
            $mail_body_1 .= h($start_date) . '(' . h($start_week) . ')' . "08:00 ~ " . h($end_date) . '(' . h($end_week) . ')'  . "20:00\n";
            $mail_body_1 .= "----\n\n";
            $mail_body_1 .= "◆◆◆グッドラーニング！運営事務局◆◆◆\n";
            $mail_body_1 .= "株式会社キャブステーション　ICTソリューション事業部\n";
            $mail_body_1 .= "TEL：03-6880-1072　FAX：03-6880-1075\n";
            $mail_body_1 .= "Mail：icts01@cab-station.com\n";

            $mail_subject_1 = "【初任運転者講習の受講開始】の前日となりました。";

            //メール送信処理
            mb_language("Japanese");
            mb_internal_encoding("UTF-8");


            $res = mb_send_mail($mail_to_1, $mail_subject_1, $mail_body_1, $mail_header_1);

            if (!$res) {

                $mail_to    = "icts01@cab-station.com";
                $mail_subject    = "予約前日の自動送信に失敗しました";
                $mail_header    = "from:icts01@cab-station.com";
                $mail_body = $account_name . "様へのメール送信に失敗しました";

                mb_send_mail($mail_to, $mail_subject, $mail_body, $mail_header);
            }

            $adress_id = getAdressId();
            $adress_id++;

            $res = adressListStore($adress_id, $account_id);

            $email_content_id = emailContentStore($mail_subject_1, $mail_body_1, $adress_id);

            $res = emailStore($email_content_id);
        }
    }
}
