<?php

ini_set('display_errors', "On");
require_once "../db/reservation_settings.php";
require_once "../db/reservation.php";
require_once "../db/entries.php";
require_once "../db/accounts.php";

if (!empty($_POST['place'])) {
    $place = $_POST['place'];
}
$reserve_data = getReservatinData($place);

$name = $reserve_data['name'];
$start_time = $reserve_data['start_time'];
$end_time = $reserve_data['end_time'];
$progress = $reserve_data['progress'];
$count = $reserve_data['count'];
$detail = $reserve_data['detail'];
$price = $reserve_data['price'];
$image = $reserve_data['image'];

$tmp_updated_at = new DateTime($reserve_data['updated_at']);
$updated_at = $tmp_updated_at->format('Y年n月j日');
$tmp_created_at = new DateTime($reserve_data['created_at']);
$created_at = $tmp_created_at->format('Y年n月j日');


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
          <h4 class="mb-3">顧客編集画面</h4>
        </div>


        <div class="col-md-8 order-md-1">

          <form class="needs-validation" action="update.php" method="post" id="form">
            <input type="hidden" name="place" id="place" value="<?php echo $place; ?>">

            <div class="row">
              <div class="col-md-12">
                <label for="lastName">講座名</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
              </div>
            </div><br>

            <div class="row">
              <div class="col-md-12">
                <label for="lastName">所用日数</label>
                <input type="number" class="form-control" id="progress" name="progress" value="<?php echo $progress; ?>">
              </div>
            </div>
            <br>



            <div class="row">
              <div class="col-md-12">
                開始時間: <input type="time" class="form-control" id="start_time" name="start_time" value="<?php echo $start_time; ?>">
                終了時間: <input type="time" class="form-control" id="end_time" name="end_time" value="<?php echo $end_time; ?>">

              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <label for="lastName">枠数</label>
                <input type="number" class="form-control" id="count" name="count" value="<?php echo $count; ?>">
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <label for="lastName">料金</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $price; ?>">
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <label for="lastName">説明</label>
                <textarea class="form-control" name="detail" id="detail" rows="22" style="white-space:pre-wrap;"><?php echo $detail; ?></textarea>
              </div>
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">変更する</button>
          </form>
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
      $("#form").submit(function() {
        if (window.confirm('この内容で変更しますか')) {
          return true;
        } else {
          return false;
        }
      });
    });
  </script>
</body>

</html>