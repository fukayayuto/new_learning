<?php
ini_set('display_errors', "On");
require "../db/reservation_settings.php"; 
require "../db/entries.php";
if(isset($_GET['id'])) {
     $reservation_id = (int) $_GET['id'];
}
$data = [];
$reservation_data = getReservation($reservation_id);
if(empty($reservation_data)){
    header('Location: http://localhost:8888/truck/price');
}
$data['id'] = $reservation_data['id'];

switch ($reservation_data['place']) {
    case 1:
        $data['name'] = '【ユーザー限定】グッドラーニング！初任運転者講習（受講開始日で予約、最長７日間まで受講可能）';
        break;
    case 2:
        $data['name'] = '予約受付中グッドラーニング！初任運転者講習（受講開始日で予約、最長７日間まで受講可能）';
        break;
    case 11:
        $data['name'] = '【三重県トラック協会】グッドラーニング！初任運転者講習（受講開始日で予約、最長５日間まで受講可能）';
        break;
    case 21:
        $data['name'] = '【京都府トラック協会】グッドラーニング！初任運転者講習（受講開始日で予約、最長５日間まで受講可能）';
        break;
    default:
        break;
}
$start_date = new DateTime($reservation_data['start_date']);
  
$data['start_date'] = $start_date->format('m月d日');
$week = array( "日", "月", "火", "水", "木", "金", "土" );
$data['start_week'] = $week[$start_date->format("w")];

$progress = $reservation_data['progress'];

$start_date = new DateTime($reservation_data['start_date']);

$end_date = $start_date->modify('+' .$progress . 'days');
$data['end_date'] = $end_date->format('m月d日');
$data['end_week'] = $week[$end_date->format("w")];

$reservation_total_seat = $reservation_data['count'];
$used_seat = 0;

$entry = getEntry($reservation_data['id']);
foreach ($entry as $val) {
    $used_seat = $used_seat + $val['count'];
}
$left_seat = $reservation_total_seat - $used_seat;




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
    <link
      href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700"
      rel="stylesheet"
      media="print"
      onload="this.media='all'"
    />
    <link href="../common/css/default.css" rel="stylesheet" type="text/css" />
    <link href="../common/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="../common/css/content.css" rel="stylesheet" type="text/css" />
    <link href="../common/css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <?php @include($_SERVER['DOCUMENT_ROOT']."/truck/common/inc/head_before.inc")?>
  </head>

  <body>
    <?php @include($_SERVER['DOCUMENT_ROOT']."/truck/common/inc/body_after.inc")?>
    <div id="wrapper">
      <!-- header// -->
      <header>
        <div id="header">
          <p id="headLogo">
            <a href="/truck/"
              ><img
                src="../common/img/shared/head_logo.svg"
                alt="グッドラーニング"
                width="262"
                height="50"
                loading="lazy"
            /></a>
          </p>
          <p id="headTxt">
            <span>トラックドライバー教育</span>のクラウド型eラーニング
          </p>
        </div>
        <div id="global">
          <div id="navTrigger"><span>&nbsp;</span></div>
          <nav>
            <ul>
              <li><a href="/truck/">HOME</a></li>
              <li><a href="/truck/price/">料金について</a></li>
              <li><a href="/truck/flow/">ご利用の流れ</a></li>
              <li><a href="/truck/adopt/">ご採用実績</a></li>
              <li><a href="/truck/faq/">FAQ</a></li>
              <li><a href="/truck/contact/">お問い合わせ</a></li>
            </ul>
          </nav>
        </div>
      </header>
      <!-- //header -->
      <!-- main// -->
      <main>
      <div class="container">

        <form method="POST" action="/truck/reservation/check.php" id="form_1">

            <input type="hidden" name="reservation_id" value="<?php echo $data['id'];?>">
            <input type="hidden" name="reservation_name" value="<?php echo $data['name'];?>">
            <input type="hidden" name="start_date" value="<?php echo $data['start_date'];?>">
            <input type="hidden" name="end_date" value="<?php echo $data['end_date'];?>">

            <h2>受講予約画面</h2><br>

            <label>受講名:</label>：
            <?php echo $data['name'];?><br>
            <label>受講期間:</label>
            <?php echo $data['start_date'] . '(' . $data['start_week'] .')' .'〜' . $data['end_date'] . '(' . $data['end_week'] .')' ; ?><br>

            <div class="form-group">
                <label>人数選択</label>
                <select class="form-control" name="count" id="count">
                    <?php
                        switch ( $left_seat ):
                            case 1:
                    ?>
                        <option value="1">1人</option>
                    <?php break; ?>
                    <?php case 2: ?>
                        <option value="1">1人</option>
                        <option value="2">2人</option>              
                        <?php break; ?>
                    <?php case 3: ?>
                        <option value="1">1人</option>
                        <option value="2">2人</option>
                        <option value="3">3人</option>
                        <?php break; ?>
                    <?php case 4: ?>
                        <option value="1">1人</option>
                        <option value="2">2人</option>
                        <option value="3">3人</option>
                        <option value="4">4人</option>
                        <?php break; ?>
                    <?php case 5: ?>
                        <option value="1">1人</option>
                        <option value="2">2人</option>
                        <option value="3">3人</option>
                        <option value="4">4人</option>
                        <option value="5">5人</option>
                        <?php break; ?>
                        <?php endswitch; ?>

                </select>
            </div>
            
            <div class="form-group">
                <label>氏名</label>
                <input type="text" class="form-control validate[required]" id="name" placeholder="氏名" name="name">
            </div>
            <div class="form-group">
                <label>メールアドレス</label>
                <input type="email" class="form-control validate[required,custom[email]]" id="email" placeholder="メールアドレス" name="email">
            </div>
            <div class="form-group">
                <label>会社名</label>
                <input type="text" class="form-control" id="company_name" placeholder="会社名" name="company_name">
            </div>
            <div class="form-group">
                <label>営業所</label>
                <input type="text" class="form-control" id="sales_office" placeholder="営業所" name="sales_office">
            </div>
            <div class="form-group">
                <label>電話番号</label>
                <input type="text" class="form-control" id="phone" placeholder="電話番号" name="phone">
                <small id="phoneHelp" class="form-text text-muted">ハイフンなしで入力してください</small>
            </div>
            <button type="submit" class="btn btn-primary">確認画面へ</button>
        </form>
        </div>
      </main>
      <!-- //main -->
      <!-- footer// -->
      <footer>
        <div class="inner">
          <div class="footLogo">
            <img
              src="../common/img/shared/foot_logo.svg"
              alt="グッドラーニング"
              width=""
              height=""
              loading="lazy"
            />
          </div>
          <ul class="footNav">
            <li><a href="/truck/">ホーム</a></li>
            <li><a href="/truck/price/">料金について</a></li>
            <li><a href="/truck/flow/">ご利用の流れ</a></li>
            <li><a href="/truck/adopt/">ご採用実績</a></li>
            <li><a href="/truck/faq/">FAQ</a></li>
            <li><a href="/truck/contact/">お問い合わせ</a></li>
          </ul>
        </div>
        <div id="copy">
          <div class="inner">
            <ul class="footSub">
              <li>
                <a href="https://cab-station.com/privacy.html" target="_blank"
                  >プライバシーポリシー</a
                >
              </li>
              <li>
                <a href="https://cab-station.com/company.html" target="_blank"
                  >会社概要</a
                >
              </li>
            </ul>
            <p>© <?php echo date('Y');?> Cab Station Co., Ltd.</p>
          </div>
        </div>
      </footer>
      <!-- //footer -->
    </div>
    <!-- js -->
    <script src="../common/js/common.js"></script>
    <script src="../common/js/jquery.validationEngine.js"></script>
    <script src="../common/js/jquery.validationEngine-ja.js"></script>
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
    <?php @include($_SERVER['DOCUMENT_ROOT']."/truck/common/inc/js_after.inc")?>
  </body>
</html>
