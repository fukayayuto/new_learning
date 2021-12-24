<?php

header('Content-type: application/json; charset=utf-8'); // ヘッダ（データ形式、文字コードなど指定）
require_once "../../db/entries.php";
require_once "../../db/accounts.php";
require_once "../../db/reservation_settings.php";
require_once "../../db/reservation.php";
require_once "../../db/mail_template.php";
require_once "../../db/mail.php";

$entry_id = $_POST['entry_id'];

$entry_data = selectEntry($entry_id);

//確定メールテンプレート
$mailTemplateData = getMailTemplate(4);
$search = array('{{会社名}}', '{{予約名}}', '{{開始日}}', '{{開始曜日}}', '{{終了日}}', '{{終了曜日}}', '{{予約人数}}','{{講座詳細}}');
$replace = array($company_name, $reservation_name, $start_date, $start_week, $end_date, $end_week, $count);
$mail_template = str_replace($search, $replace, $mail_template);
