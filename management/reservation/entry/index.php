<?php
ini_set('display_errors', "On");
require "../../db/reservation_settings.php"; 
require "../../db/entries.php"; 
require "../../db/accounts.php"; 
require "../../db/mail.php"; 

if(isset($_GET['id'])) {
    $reservation_id = (int) $_GET['id'];
}

$data = array();

$reservation_date = getReservation($reservation_id);
$data['id'] = $reservation_date['id'];
$data['place_id'] = $reservation_date['place'];
$data['count'] = $reservation_date['count'];
$data['start_date'] = $reservation_date['start_date'];
$data['progress'] = $reservation_date['progress'];

switch ($reservation_date['place']) {
    case 1:
        $data['place'] = '初任者講習(会員)';
        break;
    case 2:
        $data['place'] = '初任者講習(非会員)';
        break;
    case 11:
        $data['place'] = '三重会場';
        break;
    case 21:
        $data['place'] = '京都会場';
        break;
    default:
        break;
}

$entry_data = array();
$entry = getEntry($reservation_date['id']);
$count = 0;

if(!empty($entry)){
    foreach ($entry as $item) {

        $entry_data['id'] = $item['id'];
        $entry_data['count'] = $item['count'];

        $account_data = getAccount($item['account_id']);

        $entry_data['account_id'] = $item['account_id'];
        $entry_data['account_name'] = $account_data[0]['name'];
        $entry_data['account_email'] = $account_data[0]['email'];
        $entry_data['account_company_name'] = $account_data[0]['company_name'];

        $count = $count + $item['count'];
    }
}
$data['left_seat'] = $reservation_date['count'] - $count;






?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>
      お問い合わせ・受講体験｜トラックドライバー教育のクラウド型eラーニング【グッドラーニング!】
    </title>
    <meta
      name="title"
      content="お問い合わせ・受講体験｜トラックドライバー教育のクラウド型eラーニング【グッドラーニング!】"
    />
    <meta
      name="description"
      content="グッドラーニング！についてのお問い合わせ・受講体験はこちらから受け付けております。お気軽にお問合せください。"
    />
    <meta
      name="keywords"
      content="乗務員,教育,研修,Eラーニング,指導,国交省,トラック,運送業,グッドラーニング"
    />
    <meta
      property="og:title"
      content="お問い合わせ・受講体験｜トラックドライバー教育のクラウド型eラーニング【グッドラーニング!】"
    />
    <meta property="og:type" content="article" />
    <meta
      property="og:url"
      content="http://localhost:8888/truck/contact/"
    />
    <meta
      property="og:image"
      content="http://localhost:8888/truck/common/img/shared/og_image.jpg"
    />
    <meta
      property="og:site_name"
      content="トラックドライバー教育のクラウド型eラーニング【グッドラーニング!】"
    />
    <meta
      property="og:description"
      content="グッドラーニング！についてのお問い合わせ・受講体験はこちらから受け付けております。お気軽にお問合せください。"
    />
    <link
      rel="canonical"
      href="http://localhost:8888/truck/contact/"
    />
    <link rel="stylesheet" href="https://use.typekit.net/hcg7pyj.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <link
      href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700"
      rel="stylesheet"
      media="print"
      onload="this.media='all'"
    />
  
    <link href="../common/css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <?php @include($_SERVER['DOCUMENT_ROOT']."/truck/common/inc/head_before.inc")?>
  </head>

<body>

<a href="/management/reservation/"><button>管理画面一覧へ戻る</button></a>
<a href="/management/reservation/calendar"><button>カレンダー表示</button></a>

    <div class="container">

        <table class="table">
            <thead>
                <tr class="success">
                    <th>ID</th>
                    <th>予約会場</th>
                    <th class="sort">開始日</th>
                    <th>所用日数</th>
                    <th>定員枠</th>
                    <th>残り定員枠</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td><?php echo $data['id'];?></td>
                    <td><?php echo $data['place'];?></td>
                    <td><?php echo $data['start_date'];?></td>
                    <td><?php echo $data['progress'];?></td>
                    <td><?php echo $data['count'];?></td>
                    <td><?php echo $data['left_seat'];?></td>
                    
                </tr>
            </tbody>          
        </table>

        <table class="table">
            <thead>
                <tr class="success">
                    <th>エントリーID</th>
                    <th>予約人数</th>
                    <th>ユーザーID</th>
                    <th>ユーザー名</th>
                    <th>メールアドレス</th>
                    <th>会社名</th>
                </tr>
            </thead>

            <tbody>
                <?php if(!empty($entry_data)):?>
                <tr>
                    <td><?php echo $entry_data['id'];?></td>
                    <td><?php echo $entry_data['count'];?></td>
                    <td><?php echo $entry_data['account_id'];?></td>
                    <td><?php echo $entry_data['account_name'];?></td>
                    <td><?php echo $entry_data['account_email'];?></td>
                    <td><?php echo $entry_data['account_company_name'];?></td>
                </tr>
                <?php endif;?>
            </tbody>          
        </table>
    </div>
        


    </div>

    <script>
      jQuery(function () {
        jQuery("#form_1").validationEngine({validateNonVisibleFields: true,promptPosition:'inline'});
        var headerHeight = $("header").outerHeight();
        var urlHash = location.hash;
        if (urlHash) {
          $("body,html").stop().scrollTop(0);
          setTimeout(function () {
            var target = $(urlHash);
            var position = target.offset().top - headerHeight;
            $("body,html").stop().animate({ scrollTop: position }, 500);
          }, 100);
        }
        $('a[href^="#"]').click(function () {
          var href = $(this).attr("href");
          var target = $(href);
          var position = target.offset().top - headerHeight;
          $("body,html").stop().animate({ scrollTop: position }, 500);
        });
      });
    </script>
    <script src="../common/js/common.js"></script>
    <script src="../common/js/jquery.validationEngine.js"></script>
    <script src="../common/js/jquery.validationEngine-ja.js"></script>
</body>

</html>
