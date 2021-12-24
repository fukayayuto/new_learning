<?php
ini_set('display_errors', "On");
require_once "db/reservation_settings.php";
require_once "db/reservation.php";
require_once "db/entries.php";
require_once "db/accounts.php";
require_once "db/name_lists.php";

$entry_data = getEntryAll();

if (!empty($_GET['res'])) {
  $res = $_GET['res'];
}

$data = array();
$place = '';

foreach ($entry_data as $k => $entry) {

  if ($entry['status'] != 0) {
    continue;
  }

  $reservation_data = getReservation($entry['reservation_id']);

  //検索なし
  $tmp = array();
  $tmp['id'] = $entry['id'];

  $created_at = new DateTime($entry['created_at']);
  $tmp['created_at'] = $created_at->format('Y年n月j日');

  $week = array("日", "月", "火", "水", "木", "金", "土");
  $created_at_week = $week[$created_at->format("w")];

  $tmp['created_at'] .= '(' . $created_at_week . ')';



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
          </ul>


      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <!-- <h1 class="h2">Dashboard</h1> -->
          <h1 class="h2">ホーム画面</h1>
          <a href="/management/entry/index.php"><button type="button" class="btn btn-primary">申し込み一覧</button></a>
        </div>

        <div class="container">

          <table class="table">
            <thead>
              <h1 class="h4">新規予約リスト</h1>

              <?php if (!empty($data)) : ?>
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
              <?php else : ?>
                <tr class="success">
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th>現在新規予約はありません</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              <?php endif; ?>
            </thead>

            <tbody>
              <?php if (!empty($data)) : ?>
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
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mt-3 border-bottom">
          <!-- <h1 class="h2">Dashboard</h1> -->
          <h1 class="h4">予約一覧カレンダー</h1>（空席数／設定座席数）


        </div>

        <div id="app">
          <div class="m-auto">
            <div id='calendar'></div>
          </div>
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


<!-- 
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理画面</title>
</head>

<body>
    <div class="container">
        <br>
        <a href="/management/reservation/">予約管理画面</a><br>
        <a href="/management/information/">インフォメーション管理画面</a><br>
        <a href="/management/user/">ユーザー管理画面</a><br>
        <a href="/management/mail/">メール管理画面</a><br>
    </div>
</body>

</html> -->