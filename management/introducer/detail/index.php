<?php

ini_set('display_errors', "On");
require_once "../../db/introduce.php";
require_once "../../db/entries.php";
require_once "../../db/reservation.php";
require_once "../../db/reservation_settings.php";
require_once "../../db/accounts.php";

if (!empty($_GET['id'])) {
    $introducer_id = $_GET['id'];
}

if (!empty($_GET['res'])) {
    $res = $_GET['res'];
}

$introducer_data = selectIntroducer($introducer_id);
$name = $introducer_data['name'];
$email = $introducer_data['email'];
$number = $introducer_data['number'];
$created_at = $introducer_data['created_at'];

$tmp_created_at = new DateTime($introducer_data['created_at']);
$created_at = $tmp_created_at->format('Y年n月j日');

$tmp_updated_at = new DateTime($introducer_data['updated_at']);
$updated_at = $tmp_updated_at->format('Y年n月j日');
$today = date('Y-m-d');

$data = array();
$total_price = 0;
$total_reserve_count = 0;
$total_user_count = 0;
$total_complete_count = 0;
$total_stay_count = 0;
$total_ok_count = 0;


$channel_data = getChannelFromIntroducerId($introducer_id);
foreach ($channel_data as $k => $val) {
    $tmp = array();

    $entry_id = $val['entry_id'];
    $entry_data = selectEntry($entry_id);
    $tmp['id'] = $entry_data['id'];

    $tmp['status'] = $entry_data['status'];

    if($tmp['status'] != 1){
        continue;
    }

    $tmp['count'] = $entry_data['count'];
    $reservation_id = $entry_data['reservation_id'];

    $tmp['payment'] = $entry_data['payment'];
    $payment = $entry_data['payment'];

    $tmp_date = new DateTime($entry_data['created_at']);
    $tmp['created_at'] = $tmp_date->format('Y年m月d日');

    $account_id = $entry_data['account_id'];
    $account = getAccount($account_id);
    $tmp['company_name'] = $account[0]['company_name'];


    $reservation_data = getReservation($reservation_id);
    $place = $reservation_data['place'];
    $tmp['start_date'] = $reservation_data['start_date'];

    $tmp_date = new DateTime($reservation_data['start_date']);
    $tmp['start_date_format'] = $tmp_date->format('Y年m月d日');

    $tmp['entry_id'] = $entry_data['id'];


    $reserve_data = getReservatinData($place);

    $tmp['reservation_name'] = $reserve_data['name'];
    $tmp['reservation_name'] = mb_substr($tmp['reservation_name'], 0, 16);

    $price = $reserve_data['price'];
    $price = $price * $tmp['count'];
    $tmp['price'] = $price;


    $total_reserve_count++;
    $total_user_count +=  $entry_data['count'];
    
    if($tmp['start_date'] < $today){
        $total_complete_count++;
        if($price == $tmp['payment']){
            $total_ok_count++;
            $total_price += $price;
        }
    }else{
        $total_stay_count++;
    }
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
                    <h1 class="h2">紹介者詳細</h1>
                    <div class="text-right">
                        <a href="/management/introducer/detail/edit.php?id=<?php echo $introducer_id; ?>"><button type="button" class="btn btn-primary">紹介者を編集する</button></a>
                        <a href="/management/introducer/list.php"><button type="button" class="btn btn-primary">紹介者一覧に戻る</button></a>
                    </div>
                </div>

                <div class="container">
                    <table class="table">
                        <thead>

                        </thead>

                        <tbody>
                            <tr>
                                <th>紹介者名</th>
                                <th><?php echo $name; ?></th>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <th><?php echo $email; ?></th>
                            </tr>
                            <tr>
                                <th>紹介者No.</th>
                                <th><?php echo $number; ?></th>
                            </tr>
                            <tr>
                                <th>作成日時</th>
                                <th><?php echo $created_at; ?></th>
                            </tr>
                            <tr>
                                <th>更新日時</th>
                                <th><?php echo $updated_at; ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="container">
                    <table class="table">

                        <thead>
                            <tr>
                                <th>実施済み</th>
                            </tr>
                            <tr>
                                <th>講座開始日</th>
                                <th>講座名</th>
                                <th>予約会社名</th>
                                <th>予約人数</th>
                                <th>ステータス</th>
                                <th>申し込み日時</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($data)) : ?>
                                <?php foreach ($data as $val) : ?>
                                    <?php if ($val['start_date'] < $today) : ?>
                                        <?php if ($val['status'] == 1) : ?>
                                            <tr>
                                                <td><?php echo $val['start_date_format']; ?></td>
                                                <td><a href="/management/entry/detail/?id=<?php echo $val['entry_id']; ?>"><?php echo $val['reservation_name']; ?></a></td>
                                                <td><?php echo $val['company_name']; ?></td>
                                                <td><?php echo $val['count']; ?></td>

                                                <?php if ($val['payment'] == $val['price']) : ?>
                                                    <td><button type="button" class="btn btn-success">正常処理</button></td>
                                                <?php elseif ($val['payment'] > $val['price']) : ?>
                                                    <td><button type="button" class="btn btn-warning">過払いあり</button></td>
                                                <?php else : ?>
                                                    <td><button type="button" class="btn btn-warning">未払い</button></td>
                                                <?php endif; ?>

                                                <td><?php echo $val['created_at']; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>

                        <thead>
                            <tr>
                                <th>未実施</th>
                            </tr>
                            <tr>
                                <th>講座開始日</th>
                                <th>講座名</th>
                                <th>予約会社名</th>
                                <th>予約人数</th>
                                <th>ステータス</th>
                                <th>申し込み日時</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($data)) : ?>
                                <?php foreach ($data as $val) : ?>
                                    <?php if ($val['start_date'] > $today) : ?>
                                        <?php if ($val['status'] == 1) : ?>
                                            <tr>
                                                <td><?php echo $val['start_date_format']; ?></td>
                                                <td><a href="/management/entry/detail/?id=<?php echo $val['entry_id']; ?>"><?php echo $val['reservation_name']; ?></a></td>
                                                <td><?php echo $val['company_name']; ?></td>
                                                <td><?php echo $val['count']; ?></td>


                                                <?php if ($val['payment'] == $val['price']) : ?>
                                                    <td><button type="button" class="btn btn-success">正常処理</button></td>
                                                <?php elseif ($val['payment'] > $val['price']) : ?>
                                                    <td><button type="button" class="btn btn-warning">過払いあり</button></td>
                                                <?php else : ?>
                                                    <td><button type="button" class="btn btn-warning">未払い</button></td>
                                                <?php endif; ?>

                                                <td><?php echo $val['created_at']; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>

                        <?php if (empty($data)) : ?>
                            <tbody>
                                紹介実績なし
                            </tbody>
                        <?php endif; ?>

                        <thead>
                            <tr>
                                <th>集計</th>
                            </tr>
                            <tr>
                                <th>講座数</th>
                                <th>申し込み人数</th>
                                <th>実施済み</th>
                                <th>未実施</th>
                                <th>正常処理分</th>
                                <th>合計金額</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $total_reserve_count; ?>件</td>
                                <td><?php echo $total_user_count; ?>人</td>
                                <td><?php echo $total_complete_count; ?>件</td>
                                <td><?php echo $total_stay_count; ?>件</td>
                                <td><?php echo $total_ok_count; ?>件</td>
                                <td><?php echo number_format($total_price); ?>円</td>
                            </tr>
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
                swal('紹介者の詳細変更しました。');
            } else if (res == 0) {
                swal('紹介者の詳細変更に失敗しました');
            }

        });
    </script>
</body>

</html>