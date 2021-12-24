<?php

ini_set('display_errors', "On");
require_once "../../db/reservation_settings.php";
require_once "../../db/reservation.php";
require_once "../../db/entries.php";

if (!empty($_GET['res'])) {
    $res = $_GET['res'];
}

$place = 11;

// $reservation_data = getSelectAll($place);
$reservation_data = getReservationFromPlace($place);
$reserve_data = getReservatinData($place);

$data = array();

if (!empty($reservation_data)) {
    foreach ($reservation_data as $k => $val) {
        $tmp = array();

        $tmp['id'] = $val['id'];

        $start_date = new DateTime($val['start_date']);
        $tmp['start_date'] = $start_date->format('Y年m月d日');

        $week = array("日", "月", "火", "水", "木", "金", "土");
        $tmp['start_week'] = $week[$start_date->format("w")];

        $tmp['start_date'] = $tmp['start_date'] . '(' . $tmp['start_week'] . ')';

        // $progress = (int) $reserve_data['progress'] - 1;
        // $end_date = $start_date->modify('+' .$progress . 'days');
        // $tmp['end_date'] = $end_date->format('m月d日');
        // $tmp['end_week'] = $week[$end_date->format("w")];

        // $tmp['end_date'] = $tmp['end_date'] . '(' . $tmp['end_week'] . ')';

        // $tmp['start_date'] =  $tmp['start_date'] . '〜' . $tmp['end_date'];

        $tmp['progress'] = $reserve_data['progress'];
        $tmp['count'] = $reserve_data['count'];
        $tmp['left_seat'] = $reserve_data['count'];
        $tmp['use_seat'] = 0;

        $entry_data = getEntry($val['id']);
        foreach ($entry_data as $entry) {
            if ($entry['status'] != 2) {
                $tmp['use_seat'] += $entry['count'];
            }
        }
        $tmp['left_seat'] -= $tmp['use_seat'];

        $data[$k] = $tmp;
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
                    <h1 class="h2">【三重県トラック協会】予約一覧</h1>
                    <div class="text-right">
                        <a href="/management/reserve/mie/calendar.php"><button type="button" class="btn btn-secondary">カレンダー表示</button></a>
                        <a href="/management/reserve/mie/create.php"><button type="button" class="btn btn-primary">新規予約束作成</button></a>

                    </div>
                </div>

                <div class="container">
                    <table class="table">
                        <thead>

                            <tr class="success">
                                <th>開始日</th>
                                <th>講座日数</th>
                                <th>予約枠</th>
                                <th>予約人数</th>
                                <th>残り枠数</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($data)) : ?>
                                <?php foreach ($data as $k => $val) : ?>
                                    <tr>
                                        <td><?php echo $val['start_date']; ?></td>
                                        <td><?php echo $val['progress'] . '日間'; ?></td>
                                        <td><?php echo $val['count']; ?></td>
                                        <td><?php echo $val['use_seat']; ?></td>
                                        <td><?php echo $val['left_seat']; ?></td>
                                        <td><a href="/management/reserve/list/?id=<?php echo $val['id']; ?>"><button type="button" class="btn btn-primary">詳細</button></a></td>
                                        <?php if ($val['left_seat'] == 0) : ?>
                                            <td><button type="button" class="btn btn-secondary">予約不可</button></td>
                                        <?php else : ?>
                                            <td><a href="/management/reserve/form.php/?id=<?php echo $val['id']; ?>"><button type="button" class="btn btn-success">新規予約</button></a></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
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
            var res = <?php echo $res; ?>;
            if (res == 1) {
                swal('予約を作成しました。');
            }
            if (res == 0) {
                swal('予約を作成に失敗しました。');
            }

            if (res == 3) {
                swal('予約を削除しました。');
            }


        });
    </script>
</body>

</html>