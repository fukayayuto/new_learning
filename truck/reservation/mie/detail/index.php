<?php
ini_set('display_errors', "On");
require_once "../db/adopt.php"; 

if (isset($_GET['id'])) {
  $id = (int) $_GET['id'];
}

$data = selectAdopt($id);

$tmp_date = new DateTime($data[0]['created_at']);
$data[0]['created_at'] = $tmp_date->format('Y年m月d日 G:i');

$tmp_date = new DateTime($data[0]['updated_at']);
$data[0]['updated_at'] = $tmp_date->format('Y年m月d日 G:i');


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
                予約状況
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
          </ul>


      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <!-- <h1 class="h2">Dashboard</h1> -->
          <h1 class="h2">インフォメーション詳細変更画面</h1>
          <a href="/management/information/"><button　type="button" class="btn btn-primary">インフォメーション一覧へ</button></a>

        </div>



        <div class="container">

          <form method="POST" action="change.php" id="form">

            <input type="hidden" name="id" value="<?php echo $data[0]['id']; ?>">

            <div class="form-group">
              <label>タイトル</label>
              <input type="text" class="form-control" id="title" name="title" value="<?php echo $data[0]['company_name']; ?>">
            </div>

            <div class="form-group">
              <label>作成時間</label><br>
              <label><?php echo $data[0]['created_at']; ?></label><br>
            </div>
            <div class="form-group">
              <label>更新時間</label><br>
              <label><?php echo $data[0]['updated_at']; ?></label><br>
            </div>
            <button type="submit" class="btn btn-primary">変更する</button>
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
        $(function(){
        $("#form").submit(function(){
            if(window.confirm('この内容で変更しますか')) {
                return true;
            } else {
                return false;
            }
        });
    });
    </script>
    <script>
    $(function() {
      var res = <?php echo $res;?>;
      if(res == 1){
        swal('インフォメーションを変更しました');
      }  
      if(res == 2){
        swal('インフォメーションの変更に失敗しました');
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