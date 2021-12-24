<?php

ini_set('display_errors', "On");
require "../db/reservation_settings.php";
require "../db/reservation.php";

$reserve_data = getReserveAll();

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

            <!-- 編集部分 -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <!-- <h1 class="h2">Dashboard</h1> -->
                    <h1 class="h2">予約状況管理</h1>
                    <a href="/management/course/form.php"><button type="button" class="btn btn-primary">新規講座を作成する</button></a>
                </div>




                <div class="card-deck mb-3 text-center">
                    <?php foreach ($reserve_data as $val) : ?>
                        <?php
                        $place = $val['id'];
                        if ($place == 1) {
                            $place = 'member';
                        } elseif ($place == 2) {
                            $place = 'nomember';
                        } elseif ($place == 11) {
                            $place = 'mie';
                        }
                        ?>

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="card flex-md-row mb-4 shadow-sm h-md-250">
                                    <a href="/management/reserve/<?php echo $place; ?>"><img class="card-img-right flex-auto d-none d-lg-block" data-src="holder.js/200x250?theme=thumb" alt="Card image cap" src="../common/img/management/<?php echo $val['image']; ?>" width="250px" height="250px"></a>

                                    <div class="card-body align-items-start">
                                        <strong class="d-inline-block mb-2 text-primary"> <a class="text-dark" href="/management/reserve/<?php echo $place; ?>"><?php echo $val['name']; ?></a></strong>
                                        <h3 class="mb-0">

                                        </h3>
                                        <a class="text-dark" href="/management/reserve/<?php echo $place; ?>">
                                            <p class="card-text mb-auto"><?php echo mb_substr($val['detail'], 0, 180); ?></p>
                                        </a>
                                        <div class="text-left mt-6">
                                            <a href="/management/course/?id=<?php echo $val['id']; ?>">講座内容詳細</a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>





                    <?php endforeach; ?>
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
    <script>
        $(function() {
            var res = <?php echo $res; ?>;
            if (res == 1) {
                swal('新規講座を作成しました。');
            } else if (res == 2) {
                swal('新規講座を作成に失敗しました');
            }

        });
    </script>
</body>

</html>