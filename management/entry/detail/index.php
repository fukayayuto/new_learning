<?php

ini_set('display_errors', "On");
require_once "../../db/reservation_settings.php";
require_once "../../db/reservation.php";
require_once "../../db/entries.php";
require_once "../../db/accounts.php";
require_once "../../db/name_lists.php";

if (empty($_GET['id'])) {
    header('Location: https://promote.good-learning.jp/management/entry');
}
if (!empty($_GET['res'])) {
    $res = $_GET['res'];
}

$entry_id = $_GET['id'];
$entry_data = selectEntry($entry_id);

$reservation_data = getReservation($entry_data['reservation_id']);

$reserve_data = getReservatinData($reservation_data['place']);
$progress = (int) $reserve_data['progress'] - 1;

$reservation_id = $reservation_data['id'];
$reservation_name = $reserve_data['name'];
// $start_date = $reservation_data['start_date'];
$tmp_start_date = new DateTime($reservation_data['start_date']);
$start_date = $tmp_start_date->format('Y年n月j日');

$week = array("日", "月", "火", "水", "木", "金", "土");
$start_date_week = $week[$tmp_start_date->format("w")];

$start_date .= '(' . $start_date_week . ')';

$tmp_end_date = $tmp_start_date->modify('+' . $progress . 'days');
$end_date = $tmp_end_date->format('n月j日');
$end_date_week = $week[$tmp_end_date->format("w")];
$end_date .= '(' . $end_date_week . ')';


$tmp_created_at = new DateTime($entry_data['created_at']);
$created_at = $tmp_created_at->format('Y年n月j日');

$created_at_week = $week[$tmp_created_at->format("w")];
$created_at .= '(' . $created_at_week . ') ';
$created_at .= $tmp_created_at->format('G:i');

$status = $entry_data['status'];
$payment =  $entry_data['payment'];
if (!empty($entry_data['payment_date'])) {
    $tmp_payment_date = new DateTime($entry_data['payment_date']);
    $payment_date = $tmp_payment_date->format('Y年n月j日 G:i');
} else {
    $payment_date = '入金実績なし';
}

$payment_flg = $entry_data['payment_flg'];
$confirm_flg = $entry_data['confirm_flg'];
$claim_flg = $entry_data['claim_flg'];
$count = $entry_data['count'];
$certificate = $entry_data['certificate'];

$today = date('Y-m-d');
$end_date_format = $tmp_end_date->format('Y-m-d');

$price = $reserve_data['price'] * $count;

$name_list = $entry_data['name_1'];
if (!empty($entry_data['name_2'])) {
    $name_list .= ' , ' . $entry_data['name_2'];
}
if (!empty($entry_data['name_3'])) {
    $name_list .= ' , ' .  $entry_data['name_3'];
}
if (!empty($entry_data['name_4'])) {
    $name_list .=  ' , ' . $entry_data['name_4'];
}
if (!empty($entry_data['name_5'])) {
    $name_list .= ' , ' .  $entry_data['name_5'];
}

$account = getAccount($entry_data['account_id']);
$account_id = $account[0]['id'];

// $name_list_id = $account[0]['name_list_id'];
// $name_list = getNameListId($name_list_id);
// $name = '';
// foreach ($name_list as $val) {
//     $name .= ',' . $val['name'];
// }
// $account_name = mb_substr($name, 1);

// $account_name = $account[0]['name'];
$email = $account[0]['email'];

$company_name = $account[0]['company_name'];
$sales_office = $account[0]['sales_office'];
$phone = $account[0]['phone'];
$memo = $account[0]['memo'];







?>


<html lang="ja">

<head>
    <title>グットラーニング管理画面</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">
    <link href="../example.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="/management">
                                <span data-feather="home"></span>
                                <!-- Dashboard <span class="sr-only">(current)</span> -->
                                ホーム <span class="sr-only">(現在位置)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/management/reserve">
                                <span data-feather="file"></span>
                                <!-- Orders -->
                                予約講座
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/management/account">
                                <span data-feather="users"></span>
                                <!-- Products -->
                                顧客
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/management/mail">
                                <span data-feather="mail"></span>
                                <!-- Customers -->
                                メール配信
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/management/information">
                                <span data-feather="bar-chart-2"></span>
                                <!-- Reports -->
                                インフォメーション
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="/management/adopt">
                                <span data-feather="layers"></span>
                                <!-- Reports -->
                                実績
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="/management/introducer/">
                                <span data-feather="user"></span>
                                <!-- Reports -->
                                紹介者
                            </a>
                        </li>
                    </ul>


            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <!-- <h1 class="h2">Dashboard</h1> -->
                </div>

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <!-- <h1 class="h2">Dashboard</h1> -->
                    <h1 class="h3">申し込み詳細</h1>
                    <div class="text-right">
                        <a href="/management/reserve/list/?id=<?php echo $reservation_id; ?>"><button type="button" class="btn btn-primary">予約状況へ</button></a>
                        <a href="/management/entry/"><button type="button" class="btn btn-primary">申し込み一覧へ</button></a>
                    </div>
                </div>


                <?php if (!empty($data)) : ?>
                    <?php foreach ($data as $val) : ?>
                        <div class="card-deck mb-3 text-center">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header">
                                    <h4 class="my-0 font-weight-normal"><?php echo $val['name']; ?></h4>
                                </div>
                                <div class="card-body">
                                    <label>受講開始日: <?php echo $val['start_date']; ?></label><br>
                                    <label>人数: <?php echo $val['count']; ?>人</label>
                                    <button type="button" class="btn btn-lg btn-block btn-outline-primary">予約詳細を見る</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>



                <div class="row">
                    <table class="table">
                        <form action="edit.php" method="post">
                            <input type="hidden" name="id" id="id" value="<?php echo $entry_id; ?>">

                            <thead>
                                <tr>
                                    <th scope="col">予約情報</th>
                                    <th></th>
                                    <th></th>
                                    <!-- <th scope="col"><button class="btn btn-primary" type="submit">申し込み内容を変更する</button></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>講座名</td>
                                    <td colspan="2"><?php echo $reservation_name; ?></td>
                                </tr>
                                <tr>
                                    <td>講座期間</td>
                                    <td><?php echo $start_date . '〜' . $end_date; ?></td>
                                    <td><button class="btn-secondary ml-10" type="button" id="reschedule_btn">日程を変更する</button></td>
                                </tr>
                                <tr>
                                    <td>予約人数</td>
                                    <td><?php echo $count; ?></td>
                                    <td><button class="btn-secondary ml-10" type="button" id="rebook_btn">予約人数、予約者を編集する</button></td>
                                </tr>
                                <tr>
                                    <td>予約者氏名</td>
                                    <td><?php echo $name_list; ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>ステータス</td>
                                    <?php if ($status == 0) : ?>
                                        <td><button type="button" class="btn-warning">未確定</button></td>
                                    <?php elseif ($status == 1) : ?>
                                        <td>
                                            <button type="button" class="btn-success">確定</button>
                                        </td>
                                    <?php elseif ($status == 2) : ?>
                                        <td><button type="button" class="btn btn-danger">キャンセル</button></td>
                                    <?php endif; ?>
                                    <td><button class="btn-secondary ml-10" type="button" id="status_btn">ステータスを変更する</button></td>
                                </tr>

                                <?php if ($status == 1) : ?>
                                    <tr>
                                        <td>確定メール</td>
                                        <td>
                                            <?php if ($confirm_flg == 0) : ?>
                                                <a href="/management/mail/form.php?confirm=<?php echo $entry_id; ?>">
                                                    <button class="btn-info" type="button">確定をメール送信する</button>
                                                </a>
                                            <?php else : ?>
                                                確定メール送信済み
                                            <?php endif; ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                <?php endif; ?>

                                <tr>
                                    <td>請求金額</td>
                                    <td><?php echo number_format($price); ?>円</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>入金金額</td>
                                    <td><?php echo number_format($payment); ?>円</td>
                                    <td><button class="btn-secondary ml-10" type="button" id="payment_btn">入金登録をする</button></td>

                                </tr>

                                <tr>
                                    <td>入金日</td>
                                    <td><?php echo $payment_date; ?></td>
                                    <td></td>

                                </tr>

                                <!-- <tr>
                                    <td>入金ステータス</td>
                                    <?php if ($price > $payment) : ?>
                                        <td><button type="button" class="btn btn-warning">未入金</button>

                                            <?php if ($status == 1) : ?>
                                                <?php if ($claim_flg == 0) : ?>
                                                    <a href="/management/mail/form.php?claim=<?php echo $entry_id; ?>"><span data-feather="mail"></span>請求メールを送信する</a>
                                                <?php else : ?>
                                                    <span data-feather="mail"></span>請求メール送信済み
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>

                                    <?php elseif ($price == $payment) : ?>
                                        <td><button type="button" class="btn-success">入金済み</button></td>
                                    <?php else : ?>
                                        <td><button type="button" class="btn-danger">過払いあり</button></td>
                                    <?php endif; ?>
                                    <td></td>
                                </tr> -->

                                <?php if ($end_date_format < $today && $status == 1) : ?>
                                    <tr>
                                        <td>指導記録簿</td>
                                        <td>
                                            <?php if ($certificate == 0) : ?>
                                                <a href="/management/mail/form.php?certificate=<?php echo $entry_id; ?>"><button type="button" class="btn-info">指導記録簿を送付する</button></a>
                                            <?php else : ?>
                                                <span data-feather="mail"></span>送付済み
                                            <?php endif; ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                <?php endif; ?>

                                <tr>
                                    <td>予約申込日</td>
                                    <td><?php echo $created_at; ?></td>
                                    <td></td>
                                </tr>



                            </tbody>
                        </form>
                    </table>

                    <table class="table mt-5">

                        <thead>
                            <tr>
                                <th scope="col">顧客情報</th>
                                <th scope="col"><a href="/management/account/detail/?id=<?php echo $account_id; ?>"><button class="btn btn-primary" type="submit">顧客詳細を表示する</button></a></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>会社名</td>
                                <td><?php echo $company_name; ?></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>予約者メールアドレス</td>
                                <td><?php echo $email; ?></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>営業所</td>
                                <td><?php echo $sales_office; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>電話番号</td>
                                <td><?php echo $phone; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>顧客メモ</td>
                                <td style="white-space:pre-wrap;"><?php echo $memo; ?></td>
                                <td></td>
                            </tr>


                        </tbody>
                    </table>
                </div>

                </form>
        </div>
        </main>
    </div>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace()
    </script>

    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/docs/4.4/assets/js/vendor/anchor.min.js"></script>
    <script src="/docs/4.4/assets/js/vendor/clipboard.min.js"></script>
    <script src="/docs/4.4/assets/js/vendor/bs-custom-file-input.min.js"></script>
    <script src="/docs/4.4/assets/js/src/application.js"></script>
    <script src="/docs/4.4/assets/js/src/search.js"></script>
    <script src="/docs/4.4/assets/js/src/ie-emulation-modes-warning.js"></script>
    <script>
        $(function() {
            var res = <?php echo $res; ?>;
            if (res == 1) {
                swal('ステータスを変更しました。');
            }
            if (res == 0) {
                swal('ステータスの変更に失敗しました。');
            }
            if (res == 3) {
                swal('予約日程を変更しました');
            }
            if (res == 4) {
                swal('予約日程を変更に失敗しました');
            }
            if (res == 5) {
                swal('予約内容の変更をしました');
            }
            if (res == 6) {
                swal('予約内容の変更に失敗しました');
            }
            if (res == 7) {
                swal('ステータスの変更に失敗しました。定員オーバーになります');
            }
        });
    </script>
    <script>
        var entry_id = <?php echo $entry_id; ?>;
        // 確認ボタンをクリックするとイベント発動
        $('#btn').click(function() {

            // もしキャンセルをクリックしたら
            if (!confirm('予約のステータスを変更しますか？')) {

                // submitボタンの効果をキャンセルし、クリックしても何も起きない
                return false;

                // 「OK」をクリックした際の処理を記述
            } else {
                window.location.href = '/management/entry/detail/status_update.php?id=' + entry_id;

            }
        });
    </script>

    <script>
        var entry_id = <?php echo $entry_id; ?>;
        // 入金登録ボタンをクリックするとイベント発動
        $('#payment_btn').click(function() {

            // もしキャンセルをクリックしたら
            if (!confirm('入金登録をしますか？')) {

                // submitボタンの効果をキャンセルし、クリックしても何も起きない
                return false;

                // 「OK」をクリックした際の処理を記述
            } else {
                window.location.href = '/management/entry/detail/payment_edit.php?id=' + entry_id;

            }
        });
    </script>

    <script>
        var entry_id = <?php echo $entry_id; ?>;
        // ステータス変更をクリックするとイベント発動
        $('#status_btn').click(function() {

            // もしキャンセルをクリックしたら
            if (!confirm('ステータスの変更をしますか？')) {
                return false;

                // 「OK」をクリックした際の処理を記述
            } else {
                window.location.href = '/management/entry/detail/status_edit.php?id=' + entry_id;

            }
        });
    </script>

    <script>
        var entry_id = <?php echo $entry_id; ?>;
        // 人数変更をクリックするとイベント発動
        $('#rebook_btn').click(function() {

            // もしキャンセルをクリックしたら
            if (!confirm('人数、予約者の変更をしますか？')) {
                return false;

                // 「OK」をクリックした際の処理を記述
            } else {
                window.location.href = '/management/entry/detail/rebook.php?id=' + entry_id;

            }
        });
    </script>

    <script>
        var entry_id = <?php echo $entry_id; ?>;
        // 講座変更変更をクリックするとイベント発動
        $('#reschedule_btn').click(function() {

            // もしキャンセルをクリックしたら
            if (!confirm('講座日程をしますか？')) {
                return false;

                // 「OK」をクリックした際の処理を記述
            } else {
                window.location.href = '/management/reserve/reschedule/?id=' + entry_id;

            }
        });
    </script>



</body>

</html>