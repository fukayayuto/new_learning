<?php

ini_set('display_errors', "On");
require_once "../db/mail.php";
require_once "../db/accounts.php";
require_once "../db/mail_template.php";
require_once "../db/entries.php";
require_once "../db/accounts.php";
require_once "../db/reservation_settings.php";
require_once "../db/reservation.php";

$mail_title = '';
$mail_text = '';
$confirm_flg = 0;
$mail_template = '';
$entry_id = 0;

if (!empty($_POST)) {
  $check_list = $_POST['check'];

  $account_list = '';
  $data = array();
  foreach ($check_list as $k => $val) {
    $tmp = array();
    $tmp['account_id'] = $val;
    $accountData = getAccount($val);

    $account_list .= ', ' . $accountData[0]['company_name'];
    $data[$k] = $tmp;
  }
  $account_list = mb_substr($account_list, 1);
  $account_id = $data[0]['account_id'];
}

if (!empty($_GET['id'])) {
  $id = $_GET['id'];
  $account_list = '';
  $data = array();
  $tmp = array();
  $tmp['account_id'] = $id;

  $account = getAccount($id);

  $account_list .= ', ' . $account[0]['company_name'];
  $data[0] = $tmp;
  $account_list = mb_substr($account_list, 1);
  $account_id = $id;
}

if (!empty($_GET['confirm'])) {
  $entry_id = $_GET['confirm'];

  $entry_data = selectEntry($entry_id);
  $reservation_data = getReservation($entry_data['reservation_id']);
  $reverve_data = getReservatinData($reservation_data['place']);

  $account_data = getAccount($entry_data['account_id']);

  $company_name = $account_data[0]['company_name'];
  $reservation_name = $reverve_data['name'];
  $tmp_start_date = new DateTime($reservation_data['start_date']);
  $start_date = $tmp_start_date->format('Y年n月j日');

  $week = array("日", "月", "火", "水", "木", "金", "土");
  $start_week = $week[$tmp_start_date->format("w")];

  $progress = (int) $reverve_data['progress'] - 1;
  $tmp_end_date = $tmp_start_date->modify('+' . $progress . 'days');
  $end_date = $tmp_end_date->format('n月j日');
  $end_week = $week[$tmp_end_date->format("w")];

  $count = $entry_data['count'];
  $detail = $reverve_data['detail'];

  //確定メールテンプレート
  $mailTemplateData = getMailTemplate(4);

  $mail_template = $mailTemplateData['text'];
  $mail_title = $mailTemplateData['title'];

  $search = array('{{会社名}}', '{{予約名}}', '{{開始日}}', '{{開始曜日}}', '{{終了日}}', '{{終了曜日}}', '{{人数}}', '{{講座詳細}}');
  $replace = array($company_name, $reservation_name, $start_date, $start_week, $end_date, $end_week, $count, $detail);
  $mail_template = str_replace($search, $replace, $mail_template);

  $data[0]['account_id'] = $account_data[0]['id'];
  $account_list = $account_data[0]['company_name'];
  $account_id = $account_data[0]['id'];
  $confirm_flg = 1;
}

$input_template = getMailTemplateInput();




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
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
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
          <h1 class="h2">メール作成画面</h1>

          <div class="text-right">
            <form action="post">
              <select name="template" id="template" class="form-control">
                <option value="0"></option>
                <?php if (!empty($input_template)) : ?>
                  <?php foreach ($input_template as $val) : ?>
                    <option value="<?php echo $val['id'];?>"><?php echo $val['method'];?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
              <button type="button" id="template_btn" class="btn-secondary">埋め込み</button>
            </form>
          </div>
        </div>


        <div class="container" class="mb-20">

          <form action="confirm.php" method="post" enctype="multipart/form-data">
            <input type="hidden" id="confirm_flg" name="confirm_flg" value="<?php echo $confirm_flg; ?>">
            <input type="hidden" id="entry_id" name="entry_id" value="<?php echo $entry_id; ?>">

            <?php foreach ($data as $val) : ?>
              <input type="hidden" name="account_id[]" id="account_id[]" value="<?php echo $val['account_id']; ?> ">
            <?php endforeach; ?>

            <div class="form-group">
              <label>宛先</label><br>
              <label><?php echo $account_list; ?></label>
            </div>

            <div class="form-group">
              <label>タイトル</label><br>
              <input type="text" name="title" id="title" class="form-control" required value="<?php echo $mail_title; ?>">
            </div>

            <div class="form-group">
              <label>メール本文</label><br>
              <textarea name="mail_text" id="mail_text" rows="22" class="form-control" required><?php echo $mail_template; ?></textarea>
            </div>

             

            <button type="submit" class="btn btn-primary">確認画面へ</button>

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

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
  <script src="/docs/4.4/assets/js/vendor/anchor.min.js"></script>
  <script src="/docs/4.4/assets/js/vendor/clipboard.min.js"></script>
  <script src="/docs/4.4/assets/js/vendor/bs-custom-file-input.min.js"></script>
  <script src="/docs/4.4/assets/js/src/application.js"></script>
  <script src="/docs/4.4/assets/js/src/search.js"></script>
  <script src="/docs/4.4/assets/js/src/ie-emulation-modes-warning.js"></script>


  <script>
    $(function() {
      $('#template_btn').click(function() {

        const select = $('#template').val();
        const account_id = <?php echo $account_id;?>;

        $.ajax({
          url: 'set.php',
          type: 'POST',
          data: {
            'select': select,
            'account_id': account_id
          }
        }).done(data => {
          const title = data['title'];
          const text = data['text'];

          $("#title").val(title);
          $('#mail_text').append(text);

        }).fail(data => {
          console.error(data);
        }).always(data => {

        });
      });
    });
  </script>
</body>

</html>