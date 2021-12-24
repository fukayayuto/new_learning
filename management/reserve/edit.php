<?php

ini_set('display_errors', "On");
require_once "../db/reservation_settings.php";
require_once "../db/reservation.php";
require_once "../db/entries.php";
require_once "../db/accounts.php";

if (empty($_GET['id'])) {
    header('Location: http://localhost:8888/management/reserve');
}
$del = 0;
if (!empty($_GET['del'])) {
    $del = $_GET['del'];
}
$reservation_id = $_GET['id'];
$reservation_data = getReservation($reservation_id);

$reserve_data = getReservatinData($reservation_data['place']);

$reservation_name = $reserve_data['name'];
$place = $reserve_data['id'];
$start_date = $reservation_data['start_date'];
$created_at = $reservation_data['created_at'];



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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                </div>

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <!-- <h1 class="h2">Dashboard</h1> -->
                    <h1 class="h3">予約内容詳細</h1>
                    <button class="btn btn-danger" type="button" id="delete">削除する</button>
                </div>


                <div class="col-md-8 order-md-1">
                    <form class="needs-validation" action="update.php" method="post" id="form">
                        <input type="hidden" name="id" id="id" value="<?php echo $reservation_id; ?>">
                        <input type="hidden" name="place" id="place" value="<?php echo $place; ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="firstName">予約講座名: <?php echo $reservation_name; ?></label>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="lastName">予約開始日:</label>
                                <input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo $start_date; ?>">
                            </div>
                        </div>


                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">変更する</button>
                    </form>


                </div>
        </div>
        </main>
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
        var del = <?php echo $del; ?>;
        if (del == 1) {
            swal('予約を削除に失敗しました。\n 申し込みがあります。');
        }
        if (del == 2) {
            swal('予約を削除に失敗しました。\n 非会員用に申し込みがあります。');
        }
    </script>


    <script>
        $('#delete').click(function() {
            if (confirm('予約を消去しますか？')) {
                var id = <?php echo $reservation_id; ?>;
                window.location.href = '/management/reserve/delete.php?id=' + id;
            } else {
                //キャンセルした場合
                //何も起きない
                return false
            }
        });
    </script>

    <script>
        $(function() {
            $("#form").submit(function() {
                if (window.confirm('予約開始日を変更しますか？')) {
                    return true;
                } else {
                    return false;
                }
            });
        });
    </script>


</body>

</html>