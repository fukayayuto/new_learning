<?php

ini_set('display_errors', "On");
require_once "../db/adopt.php"; 

$adopt_data = getAdopt();

$data = array();
foreach ($adopt_data as $k => $val){
    $tmp = array();
    $tmp['id'] = $val['id'];
    $tmp['company_name'] = $val['company_name'];
    $tmp_date = new DateTime($val['updated_at']);
    $tmp['updated_at'] = $tmp_date->format('Y年m月d日 G:i');
    $data[$k] = $tmp;
}



?>

    <html lang="ja" >
  <head>
    <title>グットラーニング管理画面</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">
    <link href="../example.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  </head>
  <body >

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
                        <a class="nav-link" href="/management/adopt">
                                <span data-feather="layers"></span>
                                <!-- Reports -->
                                実績
                            </a>
                        </li>
                    </ul>

       
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <!-- <h1 class="h2">Dashboard</h1> -->
        <h1 class="h2">実績一覧</h1>
        <a href="/management/adopt/form.php"><button　type="button" class="btn btn-primary">新規実績作成</button></a>

      </div>

      <div class="container">
        <table class="table">
            <thead>
                <tr class="success"> 
                   <th>ID</th>
                   <th>会社名</th>
                   <th>更新日時</th>
                   <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($data as $k => $val) :?>
                    <tr>
                        <td><?php echo $val['id'];?></td>
                        <td><?php echo $val['company_name'];?></td>
                        <td><?php echo $val['updated_at'];?></td>
                    </tr>
                <?php endforeach;?>
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
</script><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script><script src="/docs/4.4/assets/js/vendor/anchor.min.js"></script>
<script src="/docs/4.4/assets/js/vendor/clipboard.min.js"></script>
<script src="/docs/4.4/assets/js/vendor/bs-custom-file-input.min.js"></script>
<script src="/docs/4.4/assets/js/src/application.js"></script>
<script src="/docs/4.4/assets/js/src/search.js"></script>
<script src="/docs/4.4/assets/js/src/ie-emulation-modes-warning.js"></script>
<script>
    $(function() {
      var res = <?php echo $res;?>;
      if(res == 1){
        swal('インフォメーションを作成しました');
      }  
      if(res == 2){
        swal('インフォメーションの作成に失敗しました');
      }  
    });
  </script>
  </body>
</html>

