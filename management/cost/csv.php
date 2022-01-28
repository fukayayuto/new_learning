<?php
ini_set('display_errors', "On");
require "../db/reservation_settings.php";
require_once "../db/reservation.php";
require_once "../db/entries.php";
require_once "../db/accounts.php";


$month = $_GET['month'];
$year_str = date('Y', strtotime($month));
$month_str = date('m', strtotime($month));
$month_str = $year_str . '年' . $month_str . '月分';

if (!empty($_GET['place']) && $_GET['place'] != 0) {
    $place = $_GET['place'];
    $reservation_data = getReservationFromMonthPlace($month, $place);
} else {
    $reservation_data = getReservationFromMonth($month);
}

$cost_data = array();
$total_ok_count = 0;
$total_over_count = 0;
$total_stay_count = 0;
$total_price = 0;
$total_count = 0;
$total_member = 0;
$total_payment_price = 0;
$i = 0;

if (!empty($reservation_data)) {
    foreach ($reservation_data as $val) {
        $reservation_id = $val['id'];
        $entry_data = getEntryFromConfirmStatus($reservation_id);

        foreach ($entry_data as $entry) {
            $tmp = array();

            $reservation = getReservation($entry['reservation_id']);

            //検索なし
            $tmp = array();

            $week = array("日", "月", "火", "水", "木", "金", "土");

            $reserve_data = getReservatinData($reservation['place']);
            $price = $reserve_data['price'];

            $account = getAccount($entry['account_id']);

            $reservation_name = $reserve_data['name'];

            $start_date = new DateTime($reservation['start_date']);

            $tmp['start_date'] = $start_date->format('Y年m月j日');

            $start_date_week = $week[$start_date->format("w")];

            $tmp['start_date'] .= '(' . $start_date_week . ')';
            $tmp['company_name'] = $account[0]['company_name'];
            $tmp['reservation_name'] = $reservation_name;
            $tmp['count'] = $entry['count'];
            $tmp['price'] = $price * $entry['count'];
            $tmp['payment'] = $entry['payment'];

            if (!empty($entry['payment_date'])) {
                $payment_date = new DateTime($entry['payment_date']);
                $tmp['payment_date'] = $payment_date->format('n月j日');
            } else {
                $tmp['payment_date'] = '入金実績なし';
            }

            $tmp['difference'] =  $tmp['payment'] - $tmp['price'];

            $total_member +=  $tmp['count'];
            $total_price += $price * $entry['count'];
            $total_payment_price += $tmp['payment'];
            $total_count++;

            if ($tmp['payment'] == $tmp['price']) {
                $total_ok_count++;
            } elseif ($tmp['payment'] < $tmp['price']) {
                $total_stay_count++;
            } else {
                $total_over_count++;
            }

            $cost_data[$i] = $tmp;

            $i++;
        }
    }
}

$total_payment_difference =  $total_payment_price -  $total_price;

$total_cost_data = array(
    array(
        '件数' => $total_count,
        '正常処理件数' => $total_ok_count,
        '未払い件数' => $total_stay_count,
        '過払い金件数' => $total_over_count,
        '人数' => $total_member,
        '請求金額' => $total_price,
        '入金金額' => $total_payment_price,
        '差額' => $total_payment_difference
    )
);



function putCsv($data,$total_data,$month_str)
{

    try {

        //CSV形式で情報をファイルに出力のための準備
        $csvFileName = '/tmp/' . $month_str . '請求集計.csv';
        $fileName = $month_str . '請求集計.csv';
        $res = fopen($csvFileName, 'w');
        if ($res === FALSE) {
            throw new Exception('ファイルの書き込みに失敗しました。');
        }

        // 項目名先に出力
        $header = ["講座開始日", "会社名", "講座名", "人数", "請求額", "入金額","差額", "入金日" ];
        mb_convert_variables('SJIS', 'UTF-8', $header);
        fputcsv($res, $header);

        // ループしながら出力
        foreach ($data as $dataInfo) {
            // 文字コード変換。エクセルで開けるようにする
            mb_convert_variables('SJIS', 'UTF-8', $dataInfo);

            // ファイルに書き出しをする
            fputcsv($res, $dataInfo);
        }

        // 集計
        $header = ["件数", "正常処理件数", "未払い件数", "過払い金件数", "人数", "請求金額", "入金金額", "差額"];
        mb_convert_variables('SJIS', 'UTF-8', $header);
        fputcsv($res, $header);

         // ループしながら出力
         foreach ($total_data as $item) {
            // 文字コード変換。エクセルで開けるようにする
            mb_convert_variables('SJIS', 'UTF-8', $item);

            // ファイルに書き出しをする
            fputcsv($res, $item);
        }


        // ファイルを閉じる
        fclose($res);

        // ダウンロード開始

        // ファイルタイプ（csv）
        header('Content-Type: application/octet-stream');

        // ファイル名
        header('Content-Disposition: attachment; filename=' . $fileName);
        // ファイルのサイズ　ダウンロードの進捗状況が表示
        header('Content-Length: ' . filesize($csvFileName));
        header('Content-Transfer-Encoding: binary');
        // ファイルを出力する
        readfile($csvFileName);
    } catch (Exception $e) {

        // 例外処理をここに書きます
        echo $e->getMessage();
    }
}

putCsv($cost_data,$total_cost_data,$month_str);
