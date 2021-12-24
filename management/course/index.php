<?php

ini_set('display_errors', "On");
require_once "../db/reservation_settings.php";
require_once "../db/reservation.php";
require_once "../db/entries.php";
require_once "../db/accounts.php";

if (!empty($_GET['id'])) {
    $place = $_GET['id'];
}
if(!empty($_GET['res'])){
    $res = $_GET['res'];
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
                    <h1 class="h2">予約講座詳細</h1>
                    <a href="/management/reserve"><button type="button" class="btn btn-primary">一覧に戻る</button></a>
                </div>

                <div class="container">

                    <form class="needs-validation" action="edit.php" method="post">

                        <input type="hidden" name="place" id="place" value="<?php echo $place; ?>">

                        <div class="row">
                            <table class="table">

                                <tbody>
                                    <tr>
                                        <td>講座名</td>
                                        <td><?php echo $name; ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>所用日数</td>
                                        <td><?php echo $progress; ?>日間</td>
                                        <td></td>
                                    </tr>
                                      <tr>
                                        <td>利用時間</td>
                                        <td><?php echo $start_time . 'ー' . $end_time; ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>枠数</td>
                                        <td><?php echo $count; ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>料金</td>
                                        <td><?php echo $price; ?> 円</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>説明</td>
                                        <td style="white-space:pre-wrap;"><?php echo $detail; ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>イメージアイコン<br></td>
                                        <td><img src="../common/img/management/<?php echo $image;?>" alt="" width="250px" height="250px"><br><a href="/management/course/img_edit.php?id=<?php echo $place;?>"><button class="btn btn-light" type="button">アイコンを変更する</button></a></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>登録日時</td>
                                        <td><?php echo $created_at; ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>更新日時</td>
                                        <td><?php echo $updated_at; ?></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">講座内容を変更する</button>
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
        var res = <?php echo $res; ?>;
        if (res == 1) {
          swal('講座内容の詳細を変更しました。');
        }
        if (res == 0) {
          swal('講座内容の詳細の変更に失敗しました');
        }
        if (res == 3) {
          swal('イメージアイコンを変更しました');
        }
        if (res == 4) {
          swal('イメージアイコンを変更に失敗しました');
        }

      });
    </script>
</body>

</html>