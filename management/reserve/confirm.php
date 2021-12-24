<?php

ini_set('display_errors', "On");
require_once "../db/reservation_settings.php";
require_once "../db/reservation.php";
require_once "../db/entries.php";
require_once "../db/accounts.php";

$reservation_id = $_GET['id'];
$account_id = $_GET['account'];

$account = getAccount($account_id);
$reservation = getReservation($reservation_id);
$reserve_data = getReservatinData($reservation['place']);

// $account_name = $account[0]['name'];
$company_name = $account[0]['company_name'];
$reservation_name = $reserve_data['name'];

$tmp_start_date = new DateTime($reservation['start_date']);
$start_date = $tmp_start_date->format('Y年n月j日');

$week = array("日", "月", "火", "水", "木", "金", "土");
$start_date_week = $week[$tmp_start_date->format("w")];

$start_date .= '(' . $start_date_week . ')';

$entry = getEntry($reservation_id);
$left_seat = $reserve_data['count'];

if (!empty($entry)) {
    foreach ($entry as $item) {
        if ($item['status'] != 2) {
            $left_seat = $left_seat - $item['count'];
        }
    }
}

?>



<html lang="ja">

<head>
    <title>グットラーニング管理画面</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">
    <link href="../example.css" rel="stylesheet">
    <link href='http://localhost:8888/management/fullcalendar-5.10.1/lib/main.css' type="text/css" rel='stylesheet' />
    <link href='http://localhost:8888/management/fullcalendar-5.10.1/lib/main.min.css' type="text/css" rel='stylesheet' />

    <script src="http://localhost:8888/management/fullcalendar-5.10.1/lib/main.js"></script>
    <script src="http://localhost:8888/management/fullcalendar-5.10.1/lib/main.min.js"></script>

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
                    <h1 class="h3">予約内容</h1>
                </div>


                <div class="col-md-8 order-md-1">
                    <form class="needs-validation" action="/management/reserve/entry.php" method="post">
                        <input type="hidden" name="reservation_id" id="reservation_id" value="<?php echo $reservation_id; ?>">
                        <input type="hidden" name="account_id" id="account_id" value="<?php echo $account_id; ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="firstName">予約講座名 :</label>
                                <label for=""><?php echo $reservation_name; ?></label>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="lastName">予約開始日 : <?php echo $start_date; ?></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="lastName">予約人数 : </label>
                                <select name="count" id="count" class="form-control">
                                    <?php
                                    switch ($left_seat):
                                        case 1:
                                    ?>
                                            <option value="1">1人</option>
                                            <?php break; ?>
                                        <?php
                                        case 2: ?>
                                            <option value="1">1人</option>
                                            <option value="2">2人</option>
                                            <?php break; ?>
                                        <?php
                                        case 3: ?>
                                            <option value="1">1人</option>
                                            <option value="2">2人</option>
                                            <option value="3">3人</option>
                                            <?php break; ?>
                                        <?php
                                        case 4: ?>
                                            <option value="1">1人</option>
                                            <option value="2">2人</option>
                                            <option value="3">3人</option>
                                            <option value="4">4人</option>
                                            <?php break; ?>
                                        <?php
                                        case 5: ?>
                                            <option value="1">1人</option>
                                            <option value="2">2人</option>
                                            <option value="3">3人</option>
                                            <option value="4">4人</option>
                                            <option value="5">5人</option>
                                            <?php break; ?>
                                    <?php endswitch; ?>

                                </select>
                            </div>
                        </div><br>
                        <div class="row">
                            <label for="lastName">氏名:</label>
                            <div class="col-md-12" id="textbox">
                                <input type="text" name="name_1" id="name_1" value="" class="form-control" placeholder="氏名(一人目)">
                            </div>
                        </div>
                        <br>




                        <div class="row">
                            <div class="col-md-12">
                                <label for="lastName">会社名 : <?php echo $company_name; ?></label>
                            </div>
                        </div>


                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">登録する</button>
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

            //セレクトボックスが切り替わったら発動
            $('select').change(function() {
                var val = $(this).val();

                $('#textbox').empty();


                if (val >= 1) {
                    $('#textbox').append('<input type="text"  class="form-control input-lg validate[required]" id="name_1" name="name_1" placeholder="氏名(一人目)"/>');
                }
                if (val >= 2) {
                    $('#textbox').append('<input style=" margin-top: 1em;" type="text" class="form-control input-lg validate[required]" id="name_2" name="name_2" placeholder="氏名(二人目)"/>');
                }
                if (val >= 3) {
                    $('#textbox').append('<input style=" margin-top: 1em;"  type="text" class="form-control input-lg validate[required]" id="name_3" name="name_3" placeholder="氏名(三人目)"/>');
                }
                if (val >= 4) {
                    $('#textbox').append('<input style=" margin-top: 1em;"  type="text" class="form-control input-lg validate[required]" id="name_4" name="name_4" placeholder="氏名(四人目)"/>');
                }
                if (val >= 5) {
                    $('#textbox').append('<input style=" margin-top: 1em;"  type="text" class="form-control input-lg validate[required]" id="name_5" name="name_5" placeholder="氏名(五人目)"/>');
                }


            });
        });
    </script>
</body>

</html>