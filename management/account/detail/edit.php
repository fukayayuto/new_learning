<?php

ini_set('display_errors', "On");
require_once "../../db/accounts.php";
require_once "../../db/name_lists.php";

if (empty($_POST['id'])) {
  header('Location: http://localhost:8888/management/account');
}
$id = $_POST['id'];

$account = getAccount($id);

// $name_list_id = $account[0]['name_list_id'];
// $name_list = getNameListId($name_list_id);

// $name = array();

// $account_name_1 = $account[0]['name_1'];

// if (!empty($account[0]['name_2'])) {
//   $account_name_2 = $account[0]['name_2'];
// }
// if (!empty($account[0]['name_3'])) {
//   $account_name_3 = $account[0]['name_3'];
// }
// if (!empty($account[0]['name_4'])) {
//   $account_name_4 = $account[0]['name_4'];
// }
// if (!empty($account[0]['name_5'])) {
//   $account_name_5 = $account[0]['name_5'];
// }


$email = $account[0]['email'];
$company_name = $account[0]['company_name'];
$sales_office = $account[0]['sales_office'];
$phone = $account[0]['phone'];
$memo = $account[0]['memo'];
$created_at = $account[0]['created_at'];
$updated_at = $account[0]['updated_at'];


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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


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
          <button class="btn btn-danger" type="submit" id="delete">削除する</button>

        </div>


        <div class="col-md-8 order-md-1">

          <form class="needs-validation" action="update.php" method="post">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

            <div class="row">
              <div class="col-md-12">
                <label for="lastName">会社名</label>
                <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $company_name; ?>" required>
              </div>
            </div><br>

            <div class="row">
              <div class="col-md-12">
                <label for="lastName">メールアドレス</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
              </div>
            </div>
            <br>



            <div class="row">
              <div class="col-md-12">
                <label for="lastName">営業所</label>
                <input type="text" class="form-control" id="sales_office" name="sales_office" value="<?php echo $sales_office; ?>" required>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <label for="lastName">電話番号</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" required>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <label for="lastName">顧客メモ</label>
                <textarea class="form-control" name="memo" id="memo"><?php echo $memo; ?></textarea>
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
      $('#delete').click(function() {
        if (confirm('顧客を消去しますか？')) {
          var id = <?php echo $id; ?>;
          window.location.href = '/management/account/detail/delete.php?id=' + id;
        } else {
          //キャンセルした場合
          //何も起きない
          return false
        }
      });
    });
  </script>

</body>

</html>