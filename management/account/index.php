<?php
require_once "../db/accounts.php";
require_once "../db/name_lists.php";
require_once "../db/reservation_settings.php";
require_once "../db/entries.php";

$count = 0;
$data = array();

$email = '';
$company_name = '';
$place = '';


if (!empty($_GET['email'])) {

    $count++;
    $email = $_GET['email'];

    $account_data = getSearchFromEmail($email);
}
if (!empty($_GET['company_name'])) {
    $count++;
    $company_name = $_GET['company_name'];
    $account_data = getSearchFromCompanyname($company_name);
}

if(!empty($_GET['place'])){
    $count++;
    $place = $_GET['place'];
    $account_id_list = array();
    $i = 0;
    $reservation_data_list = getSelectAll($place);
    foreach ($reservation_data_list as $k => $val) {
        $reservation_id = $val['id'];
        $entry = getEntry($reservation_id);
        foreach ($entry as $key => $value) {
            $account_id_list[$i] = $value['account_id'];
            $i++;
        }
    }
    $account_id_list = array_unique($account_id_list);
   
    $account_data = array();
    if(!empty($account_id_list)){
        $account_data = getSearchFromPlace($account_id_list);
    }

}

if (!empty($_GET['res'])) {
    $res = $_GET['res'];
}




if($count == 0){
    $max = 30;
    $account_data = getAccountAll();

    $account_num = count($account_data);
    
    $max_page = ceil($account_num / $max); // トータルページ数※ceilは小数点を切り捨てる関数
    if (!isset($_GET['page'])) { // $_GET['page_id'] はURLに渡された現在のページ数
        $now = 1; // 設定されてない場合は1ページ目にする
    } else {
        $now = $_GET['page'];
    }
    
    $start_no = ($now - 1) * $max; // 配列の何番目から取得すればよいか
    
    $disp_data = array_slice($account_data, $start_no, $max, true);
    
    $previous = $now - 1;
    $next = $now + 1;
    
    foreach ($disp_data as $k => $val) {
        if ($val['del_flg'] == 1) {
            continue;
        }
        $account_num++;
        $tmp = array();
        $tmp['id'] = $val['id'];
    
        $tmp['email'] = $val['email'];
        $tmp['company_name'] = $val['company_name'];
        $tmp['sales_office'] = '';
        if (!empty($val['sales_office'])) {
            $tmp['sales_office'] = $val['sales_office'];
        }
        $tmp['phone'] = $val['phone'];
        $tmp['updated_at'] = $val['updated_at'];
    
        $tmp_updated_at = new DateTime($val['updated_at']);
        $tmp['updated_at'] = $tmp_updated_at->format('Y年n月j日');
    
        $data[$k] = $tmp;
    }

}else{
    foreach ($account_data as $k => $val) {
        if ($val['del_flg'] == 1) {
            continue;
        }
        $account_num++;
        $tmp = array();
        $tmp['id'] = $val['id'];
    
        $tmp['email'] = $val['email'];
        $tmp['company_name'] = $val['company_name'];
        $tmp['sales_office'] = '';
        if (!empty($val['sales_office'])) {
            $tmp['sales_office'] = $val['sales_office'];
        }
        $tmp['phone'] = $val['phone'];
        $tmp['updated_at'] = $val['updated_at'];
    
        $tmp_updated_at = new DateTime($val['updated_at']);
        $tmp['updated_at'] = $tmp_updated_at->format('Y年n月j日');
    
        $data[$k] = $tmp;
    }
}






$check_id = array();
if (!empty($data)) {
    foreach ($data as $t => $item) {
        $check_id['id'][$t] = $item['id'];
    }
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
                    <h1 class="h2">顧客一覧</h1>
                    <a href="/management/account/form.php"><button type="button" class="btn btn-success">新規顧客を作成する</button></a>
                </div>

                <div class="container">

                    <form action="/management/account" method="get">
                        <input type="text" name="company_name" id="company_name" placeholder="会社名" value="<?php echo $company_name; ?>">
                        <input type="text" name="email" id="email" placeholder="メールアドレス" value="<?php echo $email; ?>">
                        <select name="place" id="place">
                            <option value="">会場を選択してください</option>
                            <option value="1" <?php if ($place == 1) {
                                                    echo 'selected';
                                                } ?>>[ユーザー限定]初任者講習</option>
                            <option value="2" <?php if ($place == 2) {
                                                    echo 'selected';
                                                } ?>>初任者講習</option>
                            <option value="11" <?php if ($place == 11) {
                                                    echo 'selected';
                                                } ?>>三重県協会</option>
                        </select>
                        <button type="submit" class="btn btn-secondary">検索</button>
                    </form>

                    <div class='btn-toolbar' role="toolbar">
                        <form action="/management/mail/check.php" method="post">
                            <?php if (!empty($data)) : ?>
                                <?php foreach ($check_id['id'] as $id) : ?>
                                    <td><input type="hidden" id="check" class="chk" name="check[][id]" value="<?php echo $id; ?>"></td>
                                <?php endforeach; ?>
                                <button type="submit" class="btn btn-warning"> 全員に一斉メールを送信する</button>
                            <?php endif; ?>
                        </form>

                        <form action="/management/mail/check.php" method="post">

                            <!-- <a href="/management/mail/check.php"><button type="button" class="btn btn-warning"> 全員に一斉メールを送信する</button></a> -->
                            <button type="submit" class="btn btn-primary" id="submit"> 選択したユーザーにメールを送信する</button>

                    </div>

                    <table class="table">
                        <thead>
                            <tr class="success">
                                <th></th>
                                <th>会社名</th>
                                <th>メールアドレス</th>
                                <th>営業所</th>
                                <th>電話番号</th>
                                <th>更新日時</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($data as $k => $val) : ?>
                                <tr>
                                    <td><input type="checkbox" id="check" class="chk" name="check[][id]" value="<?php echo $val['id']; ?>"></td>
                                    <td><a href="/management/account/detail/?id=<?php echo $val['id']; ?>"><?php echo $val['company_name']; ?></a></td>
                                    <td><a href="/management/mail/form.php?id=<?php echo $val['id']; ?>"><?php echo $val['email']; ?></a></td>
                                    <td><?php echo $val['sales_office']; ?></td>
                                    <td><?php echo $val['phone']; ?></td>
                                    <td><?php echo $val['updated_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>


                    <?php if ($count <= 0) : ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <?php if ($previous == 0) : ?>
                                <?php else : ?>
                                    <li class="page-item"><a class="page-link" href="/management/account/?page=<?php echo $previous; ?>">Previous</a></li>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $max_page; $i++) : ?>
                                    <?php if ($i != $now) : ?>
                                        <li class="page-item"><a class="page-link" href="/management/account/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                    <?php else : ?>
                                        <li class="page-item"><a class="page-link"><?php echo $now; ?></a></li>

                                    <?php endif; ?>
                                <?php endfor; ?>
                                <?php if ($next > $max_page) : ?>
                                <?php else : ?>
                                    <li class="page-item"><a class="page-link" href="/management/account/?page=<?php echo $next; ?>">Next</a></li>

                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>

                    </form>

                </div>
                <footer class="footer mt-auto py-3">
                    <div class="container">
                        <span class="text-muted">©️good-learning</span>
                    </div>
                </footer>

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
            // 初期状態のボタンは無効
            $("#submit").prop("disabled", true);
            // チェックボックスの状態が変わったら（クリックされたら）
            $("input[type='checkbox']").on('change', function() {
                // チェックされているチェックボックスの数
                if ($(".chk:checked").length > 0) {
                    // ボタン有効
                    $("#submit").prop("disabled", false);
                } else {
                    // ボタン無効
                    $("#submit").prop("disabled", true);
                }
            });
        });
    </script>
    <script>
        var res = <?php echo $res; ?>;
        if (res == 2) {
            swal('顧客を削除に失敗しました');
        }
        if (res == 1) {
            swal('顧客を削除しました。');
        }
        if (res == 4) {
            swal('顧客の作成に失敗しました');
        }
        if (res == 3) {
            swal('顧客作成しました。');
        }
    </script>
</body>

</html>