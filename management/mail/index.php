<?php
ini_set('display_errors', "On");
require_once "../db/mail.php";
require_once "../db/accounts.php";


if (!empty($_GET['res'])) {
    $res = $_GET['res'];
}

if (!empty($_GET['company_name'])) {
    $company_name = $_GET['company_name'];
    $account = getSearchFromCompanyname($company_name);
    $account_id_list = array();
    foreach ($account as $k => $item) {
        $account_id_list[$k] = $item['id'];
    }
    $adress_id_list = array();
    $num = 0;
    $adress_id_list_data = getAdressListFromAccount($account_id_list);
    foreach ($adress_id_list_data as $tmp_data_list) {
        foreach ($tmp_data_list as $k => $foo) {
            $adress_id_list[$num] = $foo['adress_id'];
            $num++;
        }
    }

    $email_content_id_list = array();
    $num = 0;
    foreach ($adress_id_list as $adress_id) {
        $email_content_id_list[$num] = getEmailContentFromAdressID($adress_id);
        $num++;
    }

    $emailData = array();
    foreach ($email_content_id_list as $k => $email_content_id) {
        $tmp = array();
        $tmp = getEmailFromContentID($email_content_id);
        $emailData[$k] = $tmp;
    }
} else {
    $emailData = getEmailAll();
}

$max = 30;

$email_num = count($emailData); // トータルデータ件数

$max_page = ceil($email_num / $max); // トータルページ数※ceilは小数点を切り捨てる関数

if (!isset($_GET['page'])) { // $_GET['page_id'] はURLに渡された現在のページ数
    $now = 1; // 設定されてない場合は1ページ目にする
} else {
    $now = $_GET['page'];
}

$start_no = ($now - 1) * $max; // 配列の何番目から取得すればよいか

// array_sliceは、配列の何番目($start_no)から何番目(MAX)まで切り取る関数
$disp_data = array_slice($emailData, $start_no, $max, true);

$previous = $now - 1;
$next = $now + 1;

$data = array();
foreach ($disp_data as $k => $val) {

    $tmp = array();

    $tmp['id'] = $val['id'];


    $tmp_created_at = new DateTime($val['created_at']);
    $tmp['created_at'] = $tmp_created_at->format('Y年n月j日');

    $week = array("日", "月", "火", "水", "木", "金", "土");
    $created_at_week = $week[$tmp_created_at->format("w")];
    $tmp['created_at'] .= '(' . $created_at_week . ') ';

    $email_content_id = $val['email_content_id'];
    $emailContentData = getEmailContent($email_content_id);
    $tmp['content_id'] = $emailContentData[0]['id'];
    $tmp['title'] =  mb_substr($emailContentData[0]['title'], 0, 30);
    $tmp['mail_text'] = mb_substr($emailContentData[0]['mail_text'], 0, 100);


    $adress_id = $emailContentData[0]['adress_id'];
    $account_list = getAccountList($adress_id);
    $tmp['adress_id'] = $adress_id;

    $tmp['account_list'] = '';
    foreach ($account_list as $key => $item) {
        $account_data = getAccount($item['account_id']);
        if (!empty($account_data)) {
            $tmp['account_list'] .= ',' . $account_data[0]['company_name'];
        }
    }
    $tmp['account_list'] = mb_substr($tmp['account_list'], 1);
    $length = mb_strlen($tmp['account_list']);
    if ($length >= 15) {
        $tmp['account_list'] = mb_substr($tmp['account_list'], 0, 15);
        $tmp['account_list'] .= ' 等..';
    }




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
                    <h1 class="h2">メール履歴一覧</h1>
                    <a href="/management/mail/template/"><button type="button" class="btn btn-primary">メールテンプレート編集</button></a>
                </div>

                <div class="container">

                    <form action="/management/mail" method="get">
                        <input type="text" name="company_name" id="company_name" placeholder="会社名" value="">
                        <button type="submit" class="btn btn-secondary">検索</button>
                    </form>

                    <table class="table">
                        <thead>
                            <tr class="success">
                                <td>ID</td>
                                <td>種類</td>
                                <td>日付</td>
                                <td>宛先</td>
                                <td>本文</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($data as $k => $val) : ?>
                                <tr>
                                    <td><?php echo $val['id']; ?></td>
                                    <td>メール</td>
                                    <td><?php echo $val['created_at']; ?></td>
                                    <td><a href="/management/mail/adress.php?id=<?php echo $val['adress_id']; ?>"><?php echo $val['account_list']; ?></a></td>
                                    <td><a href="/management/mail/detail/?id=<?php echo $val['content_id']; ?>"><?php echo $val['title']; ?></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>


                <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($previous == 0) : ?>
                            <?php else : ?>
                                <li class="page-item"><a class="page-link" href="/management/mail/?page=<?php echo $previous; ?>">Previous</a></li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $max_page; $i++) : ?>
                                <?php if ($i != $now) : ?>
                                    <li class="page-item"><a class="page-link" href="/management/mail/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php else : ?>
                                    <li class="page-item"><a class="page-link"><?php echo $now; ?></a></li>

                                <?php endif; ?>
                            <?php endfor; ?>
                            <?php if ($next > $max_page) : ?>
                            <?php else : ?>
                                <li class="page-item"><a class="page-link" href="/management/mail/?page=<?php echo $next; ?>">Next</a></li>

                            <?php endif; ?>
                        </ul>
                    </nav>


            </main>

            <footer class="footer mt-auto py-3">
                    <div class="container">
                        <span class="text-muted"><br></span>
                    </div>
            </footer>
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
            if (res == 5) {
                swal('メールを送信しました。');
            }
            if (res == 1) {
                swal('メールの送信に失敗しました');
            }

            if (res == 2) {
                swal('アドレスリストの登録に失敗しました');
            }
            if (res == 3) {
                swal('メールコンテンツの登録に失敗しました');
            }
            if (res == 4) {
                swal('メール履歴の登録に失敗しました');
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