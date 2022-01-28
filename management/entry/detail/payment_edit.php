<?php

ini_set('display_errors', "On");
require_once "../../db/reservation_settings.php";
require_once "../../db/reservation.php";
require_once "../../db/entries.php";
require_once "../../db/accounts.php";

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

$reservation_id = $reservation_data['id'];
$reservation_name = $reserve_data['name'];
$progress = $reserve_data['progress'];
$price = $reserve_data['price'];
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
$payment = $entry_data['payment'];
$payment_flg = $entry_data['payment_flg'];
$count = $entry_data['count'];
$price = $price * $count;
$name_list = $entry_data['name_1'];
$name_1 = $entry_data['name_1'];
$name_2 = '';
$name_3 = '';
$name_4 = '';
$name_5 = '';
if (!empty($entry_data['name_2'])) {
    $name_list .= ' , ' . $entry_data['name_2'];
    $name_2 = $entry_data['name_2'];
}
if (!empty($entry_data['name_3'])) {
    $name_list .= ' , ' .  $entry_data['name_3'];
    $name_3 = $entry_data['name_3'];
}
if (!empty($entry_data['name_4'])) {
    $name_list .=  ' , ' . $entry_data['name_4'];
    $name_4 = $entry_data['name_4'];
}
if (!empty($entry_data['name_5'])) {
    $name_list .= ' , ' .  $entry_data['name_5'];
    $name_5 = $entry_data['name_5'];
}

$account = getAccount($entry_data['account_id']);
$email = $account[0]['email'];

$company_name = $account[0]['company_name'];
$sales_office = $account[0]['sales_office'];
$phone = $account[0]['phone'];
$memo = $account[0]['memo'];

$left_seat = $reserve_data['count'];
$entry = getEntry($entry_data['reservation_id']);

foreach ($entry as $val) {
    if ($val['status'] != 2) {
        $left_seat = $left_seat - $val['count'];
    }
}

$left_seat = $left_seat + $count;




?>


<html lang="ja">

<head>
    <title>グットラーニング管理画面</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">
    <link href="../example.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


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
                    <h1 class="h3">申し込み変更画面</h1>
                    <div class="text-right">
                        <a href="/management/entry/detail/?id=<?php echo $entry_id; ?>"><button type="button" class="btn btn-primary">申し込み詳細へ</button></a>
                    </div>
                </div>


                <div class="col-md-8 order-md-1">
                    <form class="needs-validation" action="payment_update.php" method="post" id="form">
                        <input type="hidden" name="id" id="id" value="<?php echo $entry_id; ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="firstName">講座名: <?php echo $reservation_name; ?></label>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="lastName">講座期間: <?php echo $start_date . '〜' . $end_date; ?></label><br>

                                <!-- <div class="text-right">
                                </div> -->
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="lastName">予約人数: <?php echo $count; ?></label>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="lastName">予約者氏名1 : <?php echo $name_1; ?></label>
                            </div>
                        </div>
                        <?php if (!empty($name_2)) : ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="lastName">予約者氏名2 : <?php echo $name_2; ?></label>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($name_3)) : ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="lastName">予約者氏名3 : <?php echo $name_3; ?></label>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($name_4)) : ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="lastName">予約者氏名4 : <?php echo $name_4; ?></label>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($name_5)) : ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="lastName">予約者氏名5 : <?php echo $name_5; ?></label>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label for="lastName">請求金額 : <?php echo number_format($price); ?>円</label>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <label for="lastName">入金金額:</label>
                                <input class="form-control" type="number" id="payment" name="payment" value="<?php echo $payment;?>">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label for="lastName">予約申込日:<?php echo $created_at; ?></label>
                            </div>
                        </div>

                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">入金登録する</button>
                    </form>
                </div>
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

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery-slim.min.js"><\/script>')
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/docs/4.4/assets/js/vendor/anchor.min.js"></script>
    <script src="/docs/4.4/assets/js/vendor/clipboard.min.js"></script>
    <script src="/docs/4.4/assets/js/vendor/bs-custom-file-input.min.js"></script>
    <script src="/docs/4.4/assets/js/src/application.js"></script>
    <script src="/docs/4.4/assets/js/src/search.js"></script>
    <script src="/docs/4.4/assets/js/src/ie-emulation-modes-warning.js"></script>
    <script>
        $(function() {
            $("#form").submit(function() {
                if (window.confirm('入金登録しますか？')) {
                    return true;
                } else {
                    return false;
                }
            });
        });
    </script>

</body>

</html>