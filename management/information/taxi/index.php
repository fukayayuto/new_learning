<?php

ini_set('display_errors', "On");
require_once "../../db/information.php";

$place = 2;
$information_data = getInformation($place);

if (!empty($_GET['res'])) {
  $res = $_GET['res'];
}

$data = array();
foreach ($information_data as $k => $val) {
  $tmp = array();
  $tmp['id'] = $val['id'];
  $tmp['link'] = $val['link'];
  $tmp['title'] = $val['title'];
  $tmp['link_part'] = $val['link_part'];
  $tmp['display_flg'] = $val['display_flg'];
  $tmp['priority'] = $val['priority'];
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
          <h1 class="h2">インフォメーション一覧(タクシー用)</h1>
          <a href="/management/information/taxi/form.php"><button type="button" class="btn btn-success">新規インフォメーション作成</button></a>

        </div>

        <div class="container">
          <table class="table">
            <thead>
              <tr class="success">
                <th>ID</th>
                <th>URL</th>
                <th>タイトル</th>
                <th>URL部分</th>
                <th>表示フラグ</th>
                <th>優先度</th>
                <th>更新日時</th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($data as $k => $val) : ?>
                <tr>
                  <td><?php echo $val['id']; ?></td>
                  <td width="50"><a href="<?php echo $val['link']; ?>"><?php echo $val['link']; ?></a></td>
                  <td><?php echo $val['title']; ?></td>
                  <td><?php echo $val['link_part']; ?></td>
                  <?php if ($val['display_flg'] == 1) : ?>
                    <td>表示</td>
                  <?php else : ?>
                    <td>非表示</td>
                  <?php endif; ?>
                  <?php if ($val['priority'] == 0) : ?>
                    <td>通常</td>
                  <?php elseif ($val['priority'] == 1) : ?>
                    <td>優先</td>
                  <?php endif; ?>
                  <td><?php echo $val['updated_at']; ?></td>
                  <td><a href="/management/information/taxi/detail?id=<?php echo $val['id']; ?>"><button type="button" class="btn btn-primary">変更</button></a></td>
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
  <script>
    $(function() {
      var res = <?php echo $res; ?>;
      if (res == 1) {
        swal('インフォメーションを作成しました');
      }
      if (res == 2) {
        swal('インフォメーションの作成に失敗しました');
      }
    });
  </script>
</body>

</html>