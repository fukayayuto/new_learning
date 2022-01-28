<?php

ini_set('display_errors', "On");
require_once "../db/accounts.php";

$account_id_list = $_POST['account_id'];
$confirm_flg = $_POST['confirm_flg'];
$entry_id = $_POST['entry_id'];


$account_list = '';
$data = array();

foreach ($account_id_list as $k => $val) {
    $tmp = array();
    $tmp['account_id'] = $val;
    $account_data = getAccount($val);
    $account_list .= ',' . $account_data[0]['company_name'];
    $data[$k] = $tmp;
}
$account_list = mb_substr($account_list, 1);
$title = $_POST['title'];
$mail_text_list = $_POST['mail_text'];
$mail_text = $_POST['mail_text'];

$mail_text_list = explode("\n", $mail_text_list);


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

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <!-- <h1 class="h2">Dashboard</h1> -->
                    <h1 class="h2">メール送信内容確認画面</h1>
                </div>

                <div class="container">

                    <form action="store.php" method="post" id="form" enctype="multipart/form-data">
                        <input type="hidden" id="confirm_flg" name="confirm_flg" value="<?php echo $confirm_flg; ?>">
                        <input type="hidden" id="entry_id" name="entry_id" value="<?php echo $entry_id; ?>">

                        <?php foreach ($data as $val) : ?>
                            <input type="hidden" name="account_id[]" id="account_id[]" value="<?php echo $val['account_id']; ?> ">
                        <?php endforeach; ?>

                        <input type="hidden" name="title" id="title" value="<?php echo $title; ?> ">
                        <input type="hidden" name="mail_text" id="mail_text" value="<?php echo $mail_text; ?> ">


                        <div class="form-group">
                            <label class="border-bottom">宛先 : <?php echo $account_list; ?></label>
                        </div>

                        <div class="form-group">
                            <label class="border-bottom">件名 : <?php echo $title; ?></label>
                        </div>

                        <div class="form-group">
                            <label>本文</label>
                            <p label class="border-bottom">
                                <?php foreach ($mail_text_list as $text) : ?>
                                    <?php echo $text; ?><br>
                                <?php endforeach; ?>

                            </p>
                        </div>

                        <div class="form-group">
                            <label>添付ファイル</label><br>
                            <input type="file" name="file_1[]" id="file_1[]" class="form-control">
                        </div>
                        <div id="file_add">

                        </div>

                        <button class="btn btn-secondary" type="button" id="add">さらに作成する</button>

                        <br>
                        <br>
                        <!-- <p　style="white-space: pre-wrap;"><?php echo $mail_text; ?></p><br> -->

                        <button type="submit" class="btn btn-primary">送信する</button>

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
                if (window.confirm('この内容でメールを送信しますか?')) {
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

                $("#file_add").append('<input type="file" style=" margin-top: 1em;" class="form-control" name="file_1[]" value="">')

            });
        });
    </script>
</body>

</html>