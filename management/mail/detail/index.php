<?php

ini_set('display_errors', "On");
require_once "../../db/mail.php";
require_once "../../db/accounts.php";

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

if (isset($_GET['mail'])) {
    $mail_id = (int) $_GET['mail'];
}

$data = array();
$email_content_data = getEmailContent($id);
$data['title'] = $email_content_data[0]['title'];
$data['mail_text'] = $email_content_data[0]['mail_text'];

if (!empty($email_content_data[0]['file_id'])) {
    $file_id = $email_content_data[0]['file_id'];
    $file_data_list = getFileNameFromId($file_id);
    $file_name_list = array();
    foreach ($file_data_list as $k => $val) {
        $file_name_list[$k]['file_name'] = $val['file_name'];
        $file_name_list[$k]['name'] = $val['name'];
    }
}

$tmp_start_date = new DateTime($email_content_data[0]['created_at']);
$data['created_at'] = $tmp_start_date->format('Y年n月j日 G:i');

$account_list = getAccountList($email_content_data[0]['adress_id']);

$data['account_list'] = '';
foreach ($account_list as $key => $item) {
    $account_data = getAccount($item['account_id']);
    $data['account_list'] .=  ',' . $account_data[0]['company_name'];
}
$data['account_list'] = mb_substr($data['account_list'], 1);

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
                    <h1 class="h2">メール送信内容</h1>
                    <a href="/management/mail"><button type="button" class="btn btn-primary">メール一覧に戻る</button></a>


                </div>


                <div class="container">
                    <div class="form-group">
                        <label class="border-bottom">宛先 : <?php echo $data['account_list']; ?></label>
                    </div>

                    <div class="form-group">
                        <label class="border-bottom">件名 : <?php echo $data['title']; ?></label>
                    </div>

                    <div class="form-group">
                        <label>本文</label><br>
                        <label class="border-bottom" style="white-space:pre-wrap;"><?php echo $data['mail_text']; ?></label>
                    </div>
                    <?php if (!empty($file_data_list)) : ?>
                        <div class="form-group">
                            <label>添付ファイル</label><br>
                            <?php foreach ($file_name_list as $val) : ?>
                                <a href="/management/common/file/<?php echo $val['file_name']; ?>" target=”_blank”>
                                    <label class="border-bottom"><?php echo $val['name']; ?></label>
                                </a>
                                <br>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>


                    <div class="form-group">
                        <label>送信日時 : <?php echo $data['created_at']; ?></label><br>
                    </div>


                    <div class="form-group">
                        <label><button type="button" id="del" class="btn-danger">削除する</button></label><br>
                    </div>

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
        $("#del").click(function() {
            const id = <?php echo $mail_id; ?>;

            if (confirm('こちらのインフォメーションを削除してもよろしいでしょうか？')) {
                window.location.href = 'https://promote.good-learning.jp/management/mail/detail/delete.php?id=' + id;
            } else {

            }

        });
    </script>
</body>

</html>