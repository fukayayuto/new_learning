<?php

ini_set('display_errors', "On");
require_once "../../db/accounts.php";
require_once "../../db/mail_template.php";

$template_data = getMailTemplateAll();

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
                    <h1 class="h2">メールテンプレート一覧画面</h1>
                    <div class="text-right">
                    <a href="/management/mail/"><button type="button" class="btn btn-primary">メール履歴一覧へ</button></a>
                    <a href="/management/mail/template/form.php"><button type="button" class="btn btn-primary">新規メールテンプレート作成</button></a>
                    </div>
                </div>

                <div class="container">

                    <table class="table">
                        <thead>
                            <tr class="success">
                                <th>ID</th>
                                <th>使用箇所</th>
                                <th>件名</th>
                                <th>メール本文</th>
                                <th>更新日時</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($template_data as $k => $val) : ?>
                                <tr>
                                    <td><?php echo $val['id']; ?></td>
                                    <td><a href="/management/mail/template/detail/?id=<?php echo $val['id']; ?>"><?php echo $val['method']; ?></a></td>
                                    <td><?php echo $val['title']; ?></td>
                                    <td style="white-space:pre-wrap;"><?php echo $val['text']; ?></td>
                                    <td><?php echo $val['updated_at']; ?></td>
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

</body>

</html>