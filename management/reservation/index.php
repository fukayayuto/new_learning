<?php

ini_set('display_errors', "On");
require "../db/reservation_settings.php";
require "../db/reservation.php";
require "../db/entries.php";

$reservation_data = getAllData();
$data = array();

foreach ($reservation_data as $k => $val) {
  $tmp = array();
  $tmp['id'] = $val['id'];
  $tmp['start_date'] = $val['start_date'];
  $tmp['updated_at'] = $val['updated_at'];
  $tmp['display_flg'] = $val['display_flg'];
  $tmp['place'] = $val['place'];

  $reserve_data = getReservatinData($val['place']);
  $tmp['progress'] = $reserve_data['progress'];
  $tmp['count'] = $reserve_data['count'];
  $tmp['name'] = $reserve_data['name'];

  $entry = getEntry($val['id']);

  $count = 0;

  if (!empty($entry)) {
    foreach ($entry as $item) {
      $count = $count + $item['count'];
    }
  }
  $tmp['left_seat'] = $tmp['count'] - $count;

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
          <h1 class="h2">予約状況管理</h1>
        </div>

        <div class="container">
          <form action="store.php" method="post">
            <select name="place" id="place">
              <option value="1">初任者講習</option>
              <option value="11">三重県会場</option>
              <option value="21">京都会場</option>
            </select>
            開始日：<input type="date" name="start_date" id="start_date" required>
            所用日数：<input type="number" name="progress" id="progress" min="1" max="100" required>
            席数：<input type="number" name="count" id="count" min="1" max="100" required>
            <button class="submit">新規登録</button>
          </form>
        </div>

        <div class="container" id="users">
          <table class="table">
            <thead>
              <tr class="success">
                <th>ID</th>
                <th>予約会場</th>
                <th class="sort" data-sort="id">開始日</th>
                <th>所用日数</th>
                <th>定員枠</th>
                <th>残り定員枠</th>
                <th>更新日時</th>
                <th>表示フラグ</th>
                <th></th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($data as $val) : ?>
                <tr>
                  <td><?php echo $val['id']; ?></td>
                  <td><?php echo $val['name']; ?></td>
                  <td><?php echo $val['start_date']; ?></td>
                  <td><?php echo $val['progress']; ?></td>
                  <td><?php echo $val['count']; ?></td>
                  <td><?php echo $val['left_seat']; ?></td>
                  <td><?php echo $val['updated_at']; ?></td>

                  <?php if ($val['display_flg'] == 1) : ?>
                    <td>表示</td>
                  <?php else : ?>
                    <td>非表示</td>
                  <?php endif; ?>

                  <td><a href="/management/reservation/entry?id=<?php echo $val['id']; ?>"><button type="button" class="btn btn-primary">エントリー表示</button></a></td>

                  <?php if ($val['place'] == 2) : ?>
                    <td></td>
                  <?php else : ?>
                    <td><a href="/management/reservation/detail?id=<?php echo $val['id']; ?>"><button type="button" class="btn btn-warning">変更</button></a></td>
                  <?php endif; ?>

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
</body>

</html>