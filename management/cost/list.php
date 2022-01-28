<?php
ini_set('display_errors', "On");
require_once "../db/reservation_settings.php";
require_once "../db/reservation.php";
require_once "../db/entries.php";
require_once "../db/accounts.php";


$place = '';

if (!empty($_GET['place']) && $_GET['place'] != 0) {
    $place = $_GET['place'];
    $reservation_data = getReservationAllDataFromPlace($place);
} else {
    $reservation_data = getReservationAllData();
}
$i = 0;
$data = array();
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

            $reserve_data = getReservatinData($reservation['place']);
            $price = $reserve_data['price'];
            $tmp['price'] = $price * $entry['count'];

            $account = getAccount($entry['account_id']);

            $tmp['company_name'] = $account[0]['company_name'];
            $tmp['payment'] = $entry['payment'];

            $reservation_name = $reserve_data['name'];
            $tmp['reservation_name'] = mb_substr($reservation_name, 0, 12);

            $start_date = new DateTime($reservation['start_date']);
            $tmp['start_date'] = $start_date->format('Y年n月j日');

            $start_date_week = $week[$start_date->format("w")];

            $tmp['start_date'] .= '(' . $start_date_week . ')';

            if($tmp['price'] == $tmp['payment']){
                $total_member +=  $tmp['count'];
                $total_price += $price * $entry['count'];
                $total_payment_price += $tmp['payment'];
                $total_count++;
    
                $data[$i] = $tmp;
                $i++;
            }

           
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
                    <a href="/management/cost/"><button type="button" class="btn btn-secondary">月別集計に戻る</button></a>
                </div>

                <div class="container">

                    <form action="/management/cost/list.php" method="get">
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
                            全日程集計
                        </div>
                    </div>


                    <table class="table">
                        <thead>
                            <tr class="thead-light">
                                <th>講座開始日</th>
                                <th>講座名</th>
                                <th>会社名</th>
                                <th>人数</th>
                                <th>請求金額</th>
                                <th>入金金額</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($data as $k => $val) : ?>
                                <tr>
                                    <td><?php echo $val['start_date']; ?></td>
                                    <td><?php echo $val['reservation_name']; ?></td>
                                    <td><?php echo $val['company_name']; ?></td>
                                    <td><?php echo $val['count']; ?></td>
                                    <td><?php echo number_format($val['price']); ?>円</td>
                                    <td><?php echo number_format($val['payment']); ?>円</td>
                                    <td></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

    
                    </table>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>集計</th>
                            </tr>
                            <tr class="thead-light">
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>件数</th>
                                <th>人数</th>
                                <th>請求金額</th>
                                <th>入金金額</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?php echo $total_count; ?>件</td>
                                <td><?php echo $total_member; ?>人</td>
                                <td><?php echo number_format($total_price); ?>円</td>
                                <td><?php echo number_format($total_payment_price); ?>円</td>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'ja',
                height: 'auto',
                firstDay: 1,
                headerToolbar: {
                    left: "dayGridMonth",
                    center: "title",
                    right: "today prev,next"
                },
                buttonText: {
                    today: '今月',
                    month: '月',
                    // list: 'リスト'
                },
                noEventsContent: 'スケジュールはありません',

                events: "setEvents.php",

            });
            calendar.render();
        });
    </script>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace()
    </script>

    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                datasets: [{
                    data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
                    lineTension: 0,
                    backgroundColor: 'transparent',
                    borderColor: '#007bff',
                    borderWidth: 4,
                    pointBackgroundColor: '#007bff'
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: false
                        }
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });
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
        $(function() {
            var res = <?php echo $res; ?>;
            if (res == 1) {
                swal('予約を作成しました。');
            }
            if (res == 2) {
                swal('予約を作成に失敗しました。');
            }


        });
    </script>
</body>

</html>