<?php

ini_set('display_errors', "On");
require_once "../db/introduce.php";
require_once "../db/entries.php";
require_once "../db/reservation_settings.php";
require_once "../db/reservation.php";

if (!empty($_GET['res'])) {
    $res = $_GET['res'];
}

$channel_data = getChanelAll();

$data = array();
foreach ($channel_data as $k => $val) {
    $tmp = array();
    $tmp['id'] = $val['id'];
    $introducer_id = $val['introducer_id'];
    $tmp['introducer_id'] = $introducer_id;

    $introducer = selectIntroducer($introducer_id);
    $tmp['name'] = $introducer['name'];

    $entry_id = $val['entry_id'];
    $entry_data = selectEntry($entry_id);
    $tmp['entry_id'] = $entry_data['id'];
    $tmp['status'] = $entry_data['status'];
    $tmp['payment'] = $entry_data['payment'];
    $tmp['count'] = $entry_data['count'];
    $reservation_id = $entry_data['reservation_id'];

    $reservation_data = getReservation($reservation_id);
    $place = $reservation_data['place'];

    $tmp_date = new DateTime($entry_data['created_at']);
    $tmp['created_at'] = $tmp_date->format('Y年m月d日');

    $reserve_data = getReservatinData($place);
    $price = $reserve_data['price'];
    $tmp['price'] = $price * $tmp['count'];

    $tmp['reservation_name'] = $reserve_data['name'];

    $tmp['reservation_name'] = mb_substr($tmp['reservation_name'], 0, 15);

    $tmp_date = new DateTime($reservation_data['start_date']);
    $tmp['start_date_format'] = $tmp_date->format('n月d日');


    $tmp_date = new DateTime($val['updated_at']);
    $tmp['updated_at'] = $tmp_date->format('Y年m月d日 G:i');
    $data[$k] = $tmp;
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
                    <h1 class="h2">紹介経路一覧</h1>
                    <a href="/management/introducer/list.php"><button type="button" class="btn btn-primary">紹介者一覧</button></a>

                </div>

                <div class="container">
                    <table class="table">
                        <thead>
                            <tr class="success">
                                <th>講座開始日</th>
                                <th>紹介者名</th>
                                <th>予約名</th>
                                <th>予約人数</th>
                                <th>ステータス</th>
                                <th>申し込み日時</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($data as $k => $val) : ?>
                                <?php if ($val['status'] != 2) : ?>
                                    <tr>
                                        <td><?php echo $val['start_date_format'];?></td>
                                        <td><a href="/management/introducer/detail?id=<?php echo $val['introducer_id']; ?>"><?php echo $val['name']; ?></a></td>
                                        <td><a href="/management/entry/detail/?id=<?php echo $val['entry_id']; ?>"><?php echo $val['reservation_name']; ?></a></td>
                                        <td><?php echo $val['count']; ?></td>

                                        <?php if ($val['payment'] == $val['price']) : ?>
                                            <td><button type="button" class="btn btn-success">正常処理</button></td>
                                        <?php elseif($val['payment'] > $val['price']) : ?>
                                            <td><button type="button" class="btn btn-warning">過払いあり</button></td>
                                        <?php else:?>
                                            <td><button type="button" class="btn btn-warning">未払い</button></td>
                                        <?php endif; ?>
                                        <td><?php echo $val['created_at']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </main>
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
                swal('実績を作成しました');
            }
            if (res == 2) {
                swal('実績の作成に失敗しました');
            }
            if (res == 3) {
                swal('実績内容を変更しました');
            }
            if (res == 4) {
                swal('実績内容の変更に失敗しました');
            }
        });
    </script>
</body>

</html>