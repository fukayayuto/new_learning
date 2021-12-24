<?php

ini_set('display_errors', "On");
require_once "../../db/reservation.php";

$reverve_data = getReservatinData(11);

$reservation_name = $reverve_data['name'];
$progress = $reverve_data['progress'];
$count = $reverve_data['count'];



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
          <h1 class="h2">予約講座作成</h1>
        </div>

        <div class="col-md-8 order-md-1">
          <form class="needs-validation" action="store.php" method="post" id="form">
            <div class="row">
              <div class="col-md-12">
                <label for="firstName">講座名: <?php echo $reservation_name; ?></label>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <label for="lastName">所用日数: <?php echo $progress; ?>日間</label><br>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <label for="lastName">講座枠数: <?php echo $count; ?></label><br>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <label for="lastName">開始日:</label>
                  <input type="date" class="form-control" id="start_date" name="start_date[]" value="" required>
                   <div id="start_form"> 

                   </div>
              </div>
            </div>
            <button class="btn btn-secondary" type="button" id="add">さらに作成する</button>



            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">作成</button>
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
        if (window.confirm('予約を作成しますか?')) {
          return true;
        } else {
          return false;
        }
      });
    });
  </script>
   <script>
    $(function() {
      $("#add").click(function() {

        $("#start_form").append('<input type="date" style=" margin-top: 1em;" class="form-control" name="start_date[]" value="">')
       
      });
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