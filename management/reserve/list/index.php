<?php

ini_set('display_errors', "On");
require "../../db/reservation_settings.php";
require "../../db/reservation.php";
require "../../db/entries.php";
require "../../db/accounts.php";
require_once "../../db/name_lists.php";


$id = $_GET['id'];
$place = '';
$today = new DateTime();
$today = $today->format('Y年n月j日');

if (!empty($_GET['res'])) {
  $res = $_GET['res'];
}

$data = array();

$reservation_data = getReservation($id);
$reserve_data = getReservatinData($reservation_data['place']);
$reservation_id = $reservation_data['id'];
$reservation_name = $reserve_data['name'];
$place = $reserve_data['id'];
$place_name = '';
$account_list = '';
$confirm_num = 0;

switch ($place) {
  case 1:
    $place_name = 'member';
    break;
  case 2:
    $place_name = 'nomember';
    break;
  case 11:
    $place_name = 'mie';
    break;
  default:
    break;
}

$reservation_name = mb_substr($reservation_name, 0, 23);
$progress = $reserve_data['progress'];
$count = $reserve_data['count'];

$start_date = new DateTime($reservation_data['start_date']);
$start_date = $start_date->format('Y年n月j日');

$week = array("日", "月", "火", "水", "木", "金", "土");
$start_date_2 = new DateTime($reservation_data['start_date']);
$start_week = $week[$start_date_2->format("w")];

$start_date .= '(' . $start_week . ')';

$entry = getEntry($id);
$left_seat = $count;

$entry_data = array();

if (!empty($entry)) {
  foreach ($entry as $k => $item) {
    $tmp = array();
    $account_data = getAccount($item['account_id']);
    $tmp['id'] = $item['id'];
    $tmp['account_id'] = $account_data[0]['id'];
    $tmp['company_name'] = $account_data[0]['company_name'];

    $tmp['status'] = $item['status'];
    $tmp['count'] = $item['count'];
    $tmp['created_at'] = $item['created_at'];
    $created_at = new DateTime($item['created_at']);
    $tmp['created_at'] = $created_at->format('Y年n月j日');

    $week = array("日", "月", "火", "水", "木", "金", "土");
    $tmp['created_at_week'] = $week[$created_at->format("w")];

    $tmp['created_at'] .= '(' . $tmp['created_at_week'] . ')';


    if ($item['status'] != 2) {
      $left_seat = $left_seat - $item['count'];
    }

    if ($item['status'] == 1) {
      $account_list .= $item['account_id'] . '¥';
      $confirm_num++;
    }

    $entry_data[$k] = $tmp;
  }
  $num = mb_strlen($account_list);
  $cut_num = $num - 1;
  $account_list = mb_substr($account_list, 0, $cut_num);
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

      <!-- 編集部分 -->
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <!-- <h1 class="h2">Dashboard</h1> -->
          <h1 class="h2">予約状況</h1>
          <div class="text-right">
            <?php if ($left_seat > 0) : ?>
              <a href="/management/reserve/form.php/?id=<?php echo $reservation_id; ?>"><button type="button" class="btn btn-success">新規予約する</button></a>
            <?php else : ?>
              <button type="button" class="btn btn-secondary">予約不可</button>
            <?php endif; ?>
            <a href="/management/reserve/<?php echo $place_name; ?>"><button type="button" class="btn btn-primary">予約管理に戻る</button></a>

          </div>
        </div>

        <div class="container">

          <table class="table">
            <thead>
              <tr class="success">
                <th>講座名</th>
                <th>開始日</th>
                <th>所用日数</th>
                <th>定員枠</th>
                <th>残り定員枠</th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td><?php echo $reservation_name; ?></td>
                <td><?php echo $start_date; ?></td>
                <td><?php echo $progress; ?>日</td>
                <td><?php echo $count; ?>人</td>
                <td><?php echo $left_seat; ?>人</td>
                <?php if ($place != 2) : ?>
                  <td><a href="/management/reserve/edit.php?id=<?php echo $reservation_id; ?>"><button type="button" class="btn btn-primary">予約内容を変更する</button></a></td>
                <?php else : ?>
                  <td></td>
                <?php endif; ?>
              </tr>
            </tbody>
          </table>


          <?php if ($confirm_num > 0) : ?>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <a href="/management/mail/check.php?account=<?php echo $account_list; ?>"><button type="button" class="btn btn-info">受講者にメール送信する</button></a>
            </div>
          <?php endif; ?>

          <table class="table">
            <thead>
              <tr class="success">
                <th>申し込み日時</th>
                <th>予約人数</th>
                <th>予約会社名</th>
                <th>ステータス</th>
                <!-- <?php if ($start_date > $today) : ?>
                  <th></th>
                <?php endif; ?> -->
                <th></th>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($entry_data as $val) : ?>
                <tr>
                  <td><?php echo $val['created_at']; ?></td>
                  <td><?php echo $val['count']; ?></td>
                  <td><a href="/management/account/detail/?id=<?php echo $val['account_id']; ?>"><?php echo $val['company_name']; ?></a></td>


                  <?php if (($val['status']) == 0) : ?>
                    <td><button type="button" class="btn btn-warning">未確定</button></td>
                  <?php elseif (($val['status']) == 1) : ?>
                    <td><button type="button" class="btn btn-success">確定</button></td>
                  <?php elseif (($val['status']) == 2) : ?>
                    <td><button type="button" class="btn btn-danger">キャンセル</button></td>
                  <?php endif; ?>

                  <!-- <?php if ($start_date < $today) : ?>
                    <?php if (($val['status']) == 1) : ?>
                      <td><a href="/management/mail/form.php?entry=<?php echo $val['id']; ?>"><span data-feather="file-text"></span>受講証明書を送る</a></td>
                    <?php else : ?>
                      <td></td>
                    <?php endif; ?>

                  <?php endif; ?> -->

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
        swal('予約日を変更しました');
      }
      if (res == 0) {
        swal('予約日を変更に失敗しました。');
      }
      if (res == 3) {
        swal('新規予約作成しました');
      }
      if (res == 4) {
        swal('予新規予約作成に失敗しました。');
      }

    });
  </script>
</body>

</html>