<?php

ini_set('display_errors', "On");
require_once "../../db/reservation_settings.php";
require_once "../../db/reservation.php";
require_once "../../db/entries.php";
require_once "../../db/accounts.php";

$new_reservation_id = $_GET['id'];

$entry_id = $_GET['entry'];

//以前の予約内容
$entry_data = selectEntry($entry_id);
$count = $entry_data['count'];
$reservation_data = getReservation($new_reservation_id);
$reserve_data = getReservatinData($reservation_data['place']);

$reservation_id = $entry_data['reservation_id'];
$reservation_name = $reserve_data['name'];
// $start_date = $reservation_data['start_date'];
$tmp_start_date = new DateTime($reservation_data['start_date']);
$start_date = $tmp_start_date->format('Y年n月j日');


$week = array("日", "月", "火", "水", "木", "金", "土");
$start_date_week = $week[$tmp_start_date->format("w")];

$start_date .= '(' . $start_date_week . ')';
$created_at = $entry_data['created_at'];
// $status = $entry_data['status'];

$left_seat = $reserve_data['count'];
$entry = getEntry($new_reservation_id);
foreach ($entry as $val) {
    if ($val['status'] != 2) {
        $left_seat -= $val['count'];
    }
}



if ($left_seat < $entry_data['count']) {
    header('Location: http://localhost:8888/management/reserve/reschedule/?id=' . $entry_id . '&res=' . 1);
}



// $account = getAccount($entry_data['account_id']);
// $email = $account[0]['email'];

// $company_name = $account[0]['company_name'];
// $sales_office = $account[0]['sales_office'];
// $phone = $account[0]['phone'];
// $memo = $account[0]['memo'];




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
                        <a href="/management/entry/detail/?id=<?php echo $entry_id; ?>"><button　type="button" class="btn btn-primary">申し込み詳細へ</button></a>
                    </div>
                </div>


                <div class="col-md-8 order-md-1">
                    <form class="needs-validation" action="update.php" method="post" id="form">
                        <input type="hidden" name="id" id="id" value="<?php echo $entry_id; ?>">
                        <input type="hidden" name="reservation_id" id="reservation_id" value="<?php echo $reservation_id; ?>">
                        <input type="hidden" name="new_reservation_id" id="new_reservation_id" value="<?php echo $new_reservation_id; ?>">
                        <input type="hidden" name="count" id="count" value="<?php echo $count; ?>">

                        <div class="row">
                            <div class="col-md-12">
                                <label for="firstName">予約講座名: <?php echo $reservation_name; ?></label>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="lastName">予約開始日: <?php echo $start_date; ?></label>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">この日程で変更する</button>
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
                if (window.confirm('予約日時を変更してもいいですか？')) {
                    return true;
                } else {
                    return false;
                }
            });
        });
    </script>

    <script>
        $(function() {
            var res = <?php echo $res; ?>;
            if (res == 1) {
                swal('ステータスを変更しました。');
            }
            if (res == 0) {
                swal('ステータスの変更に失敗しました。');
            }
        });
    </script>
</body>

</html>