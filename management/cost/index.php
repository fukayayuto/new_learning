<?php
ini_set('display_errors', "On");
require_once "../db/reservation_settings.php";
require_once "../db/reservation.php";
require_once "../db/entries.php";
require_once "../db/accounts.php";

$month = date('Y-m');

$year_format = date('Y');
$month_format = date('m');

$month_str = date('Y年n月');
$pre_month = date('Y-m', strtotime('-1 month'));
$next_month = date('Y-m', strtotime('+1 month'));
$place = 0;

if (!empty($_GET['month'])) {
    $month = $_GET['month'];
    $tmp_month = $month . '-01';
    $year_format = date('Y', strtotime($tmp_month));
    $month_format = date('m', strtotime($tmp_month));
    $month_str = date('Y年n月', strtotime($month));
    $pre_month = date('Y-m', strtotime($tmp_month . '-1 month'));
    $next_month = date('Y-m', strtotime($tmp_month . '+1 month'));
    // $pre_month = date('Y-m', strtotime('-1 month'));
    // $next_month = date('Y-m', strtotime('+1 month'));
}


if (!empty($_GET['place']) && $_GET['place'] != 0) {
    $place = $_GET['place'];
    $reservation_data = getReservationFromMonthPlace($month, $place);
} else {
    $reservation_data = getReservationFromMonth($month);
}

$i = 0;
$data = array();
$stay_data = array();
$over_data = array();
$total_ok_count = 0;
$total_over_count = 0;
$total_stay_count = 0;
$total_price = 0;
$total_count = 0;
$total_member = 0;
$total_payment_price = 0;

if (!empty($reservation_data)) {
    foreach ($reservation_data as $val) {
        $reservation_id = $val['id'];
        $entry_data = getEntryFromConfirmStatus($reservation_id);

        foreach ($entry_data as $entry) {
            $tmp = array();

            $reservation = getReservation($entry['reservation_id']);

            //検索なし
            $tmp = array();
            $tmp['id'] = $entry['id'];

            $created_at = new DateTime($entry['created_at']);
            $tmp['created_at'] = $created_at->format('Y年n月j日');

            $week = array("日", "月", "火", "水", "木", "金", "土");

            $tmp['count'] = $entry['count'];
            $tmp['payment'] = $entry['payment'];

            if (!empty($entry['payment_date'])) {
                $payment_date = new DateTime($entry['payment_date']);
                $tmp['payment_date'] = $payment_date->format('n月j日');
            } else {
                $tmp['payment_date'] = '入金実績なし';
            }


            $reserve_data = getReservatinData($reservation['place']);
            $price = $reserve_data['price'];
            $tmp['price'] = $price * $entry['count'];

            $tmp['difference'] =  $tmp['payment'] - $tmp['price'];

            // if((int) $tmp['difference'] > 0){
            //     $tmp['difference'] = '+' . $tmp['difference'];
            // }

            $account = getAccount($entry['account_id']);

            $tmp['company_name'] = $account[0]['company_name'];

            $reservation_name = $reserve_data['name'];
            $tmp['reservation_name'] = mb_substr($reservation_name, 0, 12);

            $start_date = new DateTime($reservation['start_date']);
            $tmp['start_date'] = $start_date->format('j日');

            $start_date_week = $week[$start_date->format("w")];

            $tmp['start_date'] .= '(' . $start_date_week . ')';

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


            if ($tmp['price'] == $tmp['payment']) {
                $data[$i] = $tmp;
            } elseif ($tmp['price'] > $tmp['payment']) {
                $stay_data[$i] = $tmp;
            } else {
                $over_data[$i] = $tmp;
            }
            $i++;
        }
    }
}

$total_payment_difference =  $total_payment_price -  $total_price;

if ($total_payment_difference > 0) {
    $dif_color = 'red';
} elseif ($total_payment_difference < 0) {
    $dif_color = 'blue';
}

// if((int) $total_payment_difference > 0){
//     $total_payment_difference = '+' . $total_payment_difference;
// }



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
                        <li>
                            <a class="nav-link" href="/management/cost/">
                                <span data-feather="file"></span>
                                <!-- Reports -->
                                請求
                            </a>
                        </li>
                    </ul>


            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <!-- <h1 class="h2">Dashboard</h1> -->
                    <h1 class="h2">請求管理画面</h1>
                    <a href="/management/cost/list.php"><button type="button" class="btn btn-secondary">全日程</button></a>
                </div>

                <div class="container">

                    <form action="/management/cost/index.php" method="get">
                        <select name="place" id="place" class="form-control">
                            <option value="0" <?php if ($place == '') {
                                                    echo 'selected';
                                                } ?>>未選択</option>
                            <option value="1" <?php if ($place == 1) {
                                                    echo 'selected';
                                                } ?>>【ユーザー限定】グッドラーニング！初任運転者講習（受講開始日で予約、最長７日間まで受講可能）</option>
                            <option value="2" <?php if ($place == 2) {
                                                    echo 'selected';
                                                } ?>>グッドラーニング！初任運転者講習（受講開始日で予約、最長７日間まで受講可能）</option>
                            <option value="11" <?php if ($place == 11) {
                                                    echo 'selected';
                                                } ?>>【三重県トラック協会】グッドラーニング！初任運転者講習（受講開始日で予約、最長５日間まで受講可能）</option>
                        </select>
                        <button type="submit" class="btn btn-secondary">検索</button>
                    </form>




                    <div class="text-center">
                        <div class="h2">
                            <?php echo $month_str; ?>分
                        </div>
                    </div>

                    <div class="text-left">
                        <div class="h5"><a href="/management/cost/?month=<?php echo $pre_month; ?>">◀︎前月へ</a></div>
                    </div>
                    <div class="text-right">
                        <div class="h5"><a href="/management/cost/?month=<?php echo $next_month; ?>">次月へ▶︎</a></div>
                    </div>

                    <?php if (!empty($data)) : ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>正常処理</th>
                                </tr>


                                <tr class="thead-light">
                                    <th>講座開始日</th>
                                    <th>会社名</th>
                                    <th>講座名</th>
                                    <th>人数</th>
                                    <th>請求金額</th>
                                    <th>入金金額</th>
                                    <th>差額</th>
                                    <th>入金確定日</th>
                                    <th></th>
                                </tr>

                            </thead>

                            <tbody>
                                <?php foreach ($data as $k => $val) : ?>
                                    <?php if ($val['price'] == $val['payment']) : ?>
                                        <tr>
                                            <td><?php echo $val['start_date']; ?></td>
                                            <td><?php echo $val['company_name']; ?></td>
                                            <td><a style="text-decoration: none;" href="/management/entry/detail/?id=<?php echo $val['id']; ?>"><?php echo $val['reservation_name']; ?></a></td>
                                            <td><?php echo $val['count']; ?></td>
                                            <td><?php echo number_format($val['price']); ?>円</td>
                                            <td><?php echo number_format($val['payment']); ?>円</td>
                                            <td><?php echo number_format($val['difference']); ?>円</td>
                                            <td><?php echo $val['payment_date']; ?></td>
                                            <td></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    <?php endif; ?>

                    <?php if (!empty($stay_data)) : ?>
                        <table class="table mt-10">
                            <thead>
                                <tr>
                                    <th>未入金</th>
                                </tr>

                                <tr class="thead-light">
                                    <th>講座開始日</th>
                                    <th>会社名</th>
                                    <th>講座名</th>
                                    <th>人数</th>
                                    <th>請求金額</th>
                                    <th>入金金額</th>
                                    <th>差額</th>
                                    <th>入金確定日</th>
                                    <th></th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php foreach ($stay_data as $k => $val) : ?>
                                    <tr>
                                        <td><?php echo $val['start_date']; ?></td>
                                        <td><?php echo $val['company_name']; ?></td>
                                        <td><a href="/management/entry/detail/?id=<?php echo $val['id']; ?>"><?php echo $val['reservation_name']; ?></a></td>
                                        <td><?php echo $val['count']; ?></td>
                                        <td><?php echo number_format($val['price']); ?>円</td>
                                        <td><?php echo number_format($val['payment']); ?>円</td>
                                        <td style="color: blue;"><?php echo number_format($val['difference']); ?>円</td>
                                        <td><?php echo $val['payment_date']; ?></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    <?php endif; ?>

                    <?php if (!empty($over_data)) : ?>
                        <table class="table mt-10">
                            <thead>
                                <tr>
                                    <th>過払い金あり</th>
                                </tr>

                                <tr class="thead-light">
                                    <th>講座開始日</th>
                                    <th>会社名</th>
                                    <th>講座名</th>
                                    <th>人数</th>
                                    <th>請求金額</th>
                                    <th>入金金額</th>
                                    <th>差額</th>
                                    <th>入金確定日</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($over_data as $k => $val) : ?>
                                    <tr>
                                        <td><?php echo $val['start_date']; ?></td>
                                        <td><?php echo $val['company_name']; ?></td>
                                        <td><a href="/management/entry/detail/?id=<?php echo $val['id']; ?>"><?php echo $val['reservation_name']; ?></a></td>
                                        <td><?php echo $val['count']; ?></td>
                                        <td><?php echo number_format($val['price']); ?>円</td>
                                        <td><?php echo number_format($val['payment']); ?>円</td>
                                        <td style="color: red;"><?php echo number_format($val['difference']); ?>円</td>
                                        <td><?php echo $val['payment_date']; ?></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    <?php endif; ?>



                    <table class="table mt-20">
                        <thead>
                            <tr>
                                <th>集計</th>
                                <th><button class="btn-secondary ml-10" type="button" id="csv_btn">csv出力</button></th>
                            </tr>
                            <tr class="thead-light">
                                <th>件数</th>
                                <th>正常処理件数</th>
                                <th>未払い件数</th>
                                <th>過払い金件数</th>
                                <th>人数</th>
                                <th>請求金額</th>
                                <th>入金金額</th>
                                <th>差額</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td><?php echo $total_count; ?>件</td>
                                <td><?php echo $total_ok_count; ?>件</td>
                                <td><?php echo $total_stay_count; ?>件</td>
                                <td><?php echo $total_over_count; ?>件</td>
                                <td><?php echo $total_member; ?>人</td>
                                <td><?php echo number_format($total_price); ?>円</td>
                                <td><?php echo number_format($total_payment_price); ?>円</td>
                                <td style="color: <?php echo $dif_color; ?>;"><?php echo number_format($total_payment_difference); ?>円</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </main>

            <footer class="footer mt-auto py-3">
                <div class="container">
                    <span class="text-muted"><br></span>
                </div>
            </footer>
        </div>
    </div>



    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace()
    </script>


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
        var year_format = <?php echo $year_format; ?>;
        var month_format = <?php echo $month_format; ?>;
        var month_format = year_format + '-' + month_format + '-01';
        var place = <?php echo $place; ?>;

        // 入金登録ボタンをクリックするとイベント発動
        $('#csv_btn').click(function() {

            // もしキャンセルをクリックしたら
            if (!confirm('csv出力をしますか？')) {

                // submitボタンの効果をキャンセルし、クリックしても何も起きない
                return false;

                // 「OK」をクリックした際の処理を記述
            } else {
                window.location.href = '/management/cost/csv.php?month=' + month_format + '&place=' + place;

            }
        });
    </script>
</body>

</html>