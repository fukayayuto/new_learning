<?php

ini_set('display_errors', "On");
require_once "../db/reservation_settings.php";
require_once "../db/reservation.php";
require_once "../db/entries.php";
require_once "../db/accounts.php";
require_once "../db/name_lists.php";

$entry_data = getEntryAll();
$data = array();
$place = '';
$search_start_date = '';

foreach ($entry_data as $k => $entry) {

    $reservation_data = getReservation($entry['reservation_id']);

    //検索した場合
    if (!empty($_GET['place']) && !empty($_GET['search_start_date'])) {
        $place = $_GET['place'];
        $search_start_date = $_GET['search_start_date'];

        if ($reservation_data['place'] == $place && $reservation_data['start_date'] == $search_start_date) {

            $tmp = array();
            $tmp['id'] = $entry['id'];

            $created_at = new DateTime($entry['created_at']);
            $tmp['created_at'] = $created_at->format('Y年n月j日');

            $week = array("日", "月", "火", "水", "木", "金", "土");
            $tmp['created_at_week'] = $week[$created_at->format("w")];

            $tmp['created_at'] .= '(' . $tmp['created_at_week'] . ')';

            $tmp['status'] = $entry['status'];
            $tmp['count'] = $entry['count'];

            $reserve_data = getReservatinData($reservation_data['place']);

            $account = getAccount($entry['account_id']);
            $tmp['company_name'] = $account[0]['company_name'];

            $reservation_name = $reserve_data['name'];
            $tmp['reservation_name'] = mb_substr($reservation_name, 0, 12);

            $start_date = new DateTime($reservation_data['start_date']);
            $tmp['start_date'] = $start_date->format('Y年n月j日');

            $start_date_week = $week[$start_date->format("w")];
            $tmp['start_date'] .= '(' . $start_date_week . ')';

            $data[$k] = $tmp;
        }
    } elseif (!empty($_GET['place'])) {
        $place = $_GET['place'];

        if ($reservation_data['place'] == $_GET['place']) {

            $tmp = array();
            $tmp['id'] = $entry['id'];

            $created_at = new DateTime($entry['created_at']);
            $tmp['created_at'] = $created_at->format('Y年n月j日');

            $week = array("日", "月", "火", "水", "木", "金", "土");
            $tmp['created_at_week'] = $week[$created_at->format("w")];

            $tmp['created_at'] .= '(' . $tmp['created_at_week'] . ')';

            $tmp['status'] = $entry['status'];
            $tmp['count'] = $entry['count'];

            $reserve_data = getReservatinData($reservation_data['place']);

            $account = getAccount($entry['account_id']);
            $tmp['company_name'] = $account[0]['company_name'];

            $reservation_name = $reserve_data['name'];
            $tmp['reservation_name'] = mb_substr($reservation_name, 0, 12);

            $start_date = new DateTime($reservation_data['start_date']);
            $tmp['start_date'] = $start_date->format('Y年n月j日');

            $start_date_week = $week[$start_date->format("w")];
            $tmp['start_date'] .= '(' . $start_date_week . ')';

            $data[$k] = $tmp;
        }
    } elseif (!empty($_GET['search_start_date'])) {

        $search_start_date = $_GET['search_start_date'];

        if ($reservation_data['start_date'] == $search_start_date) {

            $tmp = array();
            $tmp['id'] = $entry['id'];

            $created_at = new DateTime($entry['created_at']);
            $tmp['created_at'] = $created_at->format('Y年n月j日');

            $week = array("日", "月", "火", "水", "木", "金", "土");
            $tmp['created_at_week'] = $week[$created_at->format("w")];

            $tmp['created_at'] .= '(' . $tmp['created_at_week'] . ')';

            $tmp['status'] = $entry['status'];
            $tmp['count'] = $entry['count'];

            $reserve_data = getReservatinData($reservation_data['place']);

            $account = getAccount($entry['account_id']);
            $tmp['company_name'] = $account[0]['company_name'];

            $reservation_name = $reserve_data['name'];
            $tmp['reservation_name'] = mb_substr($reservation_name, 0, 12);

            $start_date = new DateTime($reservation_data['start_date']);
            $tmp['start_date'] = $start_date->format('Y年n月j日');

            $start_date_week = $week[$start_date->format("w")];
            $tmp['start_date'] .= '(' . $start_date_week . ')';

            $data[$k] = $tmp;
        }
    } else {
        //検索なし
        $tmp = array();
        $tmp['id'] = $entry['id'];

        $created_at = new DateTime($entry['created_at']);
        $tmp['created_at'] = $created_at->format('Y年n月j日');
        $tmp['status'] = $entry['status'];
        $tmp['count'] = $entry['count'];

        $week = array("日", "月", "火", "水", "木", "金", "土");
        $tmp['created_at_week'] = $week[$created_at->format("w")];

        $tmp['created_at'] .= '(' . $tmp['created_at_week'] . ')';


        $reserve_data = getReservatinData($reservation_data['place']);

        $account = getAccount($entry['account_id']);

        // $tmp['account_name'] = $account[0]['name'];
        $tmp['company_name'] = $account[0]['company_name'];

        $reservation_name = $reserve_data['name'];
        $tmp['reservation_name'] = mb_substr($reservation_name, 0, 12);

        $start_date = new DateTime($reservation_data['start_date']);
        $tmp['start_date'] = $start_date->format('Y年n月j日');

        $start_date_week = $week[$start_date->format("w")];
        $tmp['start_date'] .= '(' . $start_date_week . ')';

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
                    <h1 class="h2">申し込み一覧</h1>
                    <a href="/management/"><button type="button" class="btn btn-primary">ホームに戻る</button></a>
                </div>

                <div class="container">

                    <form action="/management/entry/index.php" method="get">
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
                        <input type="date" name="search_start_date" id="search_start_date" value="<?php echo $search_start_date; ?>" class="form-control">
                        <button type="submit" class="btn btn-secondary">検索</button>
                    </form>
                    <table class="table">
                        <thead>
                            <tr class="success">
                                <th></th>
                                <th>申し込み日時</th>
                                <th>希望予約</th>
                                <th>希望予約日時</th>
                                <th>予約会社名</th>
                                <th>人数</th>
                                <th>ステータス</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($data as $k => $val) : ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $val['created_at']; ?></td>
                                    <td><?php echo $val['reservation_name']; ?></td>
                                    <td><?php echo $val['start_date']; ?></td>
                                    <td><?php echo $val['company_name']; ?></td>
                                    <td><?php echo $val['count']; ?></td>
                                    <?php if (($val['status']) == 0) : ?>
                                        <td><button type="button" class="btn btn-warning">未確定</button></td>
                                    <?php elseif (($val['status']) == 1) : ?>
                                        <td><button type="button" class="btn btn-success">確定</button></td>
                                    <?php elseif (($val['status']) == 2) : ?>
                                        <td><button type="button" class="btn btn-danger">キャンセル</button></td>
                                    <?php endif; ?>
                                    <td><a href="/management/entry/detail/?id=<?php echo $val['id']; ?>"><button type="button" class="btn btn-primary">詳細</button></a></td>
                                </tr>
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
</body>

</html>