<?php
ini_set('display_errors', "On");
require "../../db/reservation_settings.php"; 
require "../../db/entries.php"; 
require "../../db/accounts.php"; 
require "../../db/mail.php"; 

if(isset($_GET['id'])) {
    $reservation_id = (int) $_GET['id'];
}

$data = [];

$reservation_date = getReservation($reservation_id);
$data['id'] = $reservation_date['id'];
$data['place_id'] = $reservation_date['place'];
$data['count'] = $reservation_date['count'];
$data['start_date'] = $reservation_date['start_date'];
$data['progress'] = $reservation_date['progress'];
$data['display_flg'] = $reservation_date['display_flg'];
$data['created_at'] = $reservation_date['created_at'];
$data['updated_at'] = $reservation_date['updated_at'];

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
    <link href="../common/css/default.css" rel="stylesheet" type="text/css" />
    <link href="../common/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="../common/css/content.css" rel="stylesheet" type="text/css" />
    <link href="../common/css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <?php @include($_SERVER['DOCUMENT_ROOT']."/truck/common/inc/head_before.inc")?>
  </head>

<body>

<a href="/management/reservation/"><button>管理画面一覧へ戻る</button></a>

    <div class="container">

        <form method="POST" action="change.php">

            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
       
            <h2>予約詳細変更画面</h2><br>

    
            <div class="form-group">
                <label>予約名</label>
                <select name="place" id="place" class="form-control">
                    <?php if($data['place_id'] == 1):?>
                        <option value="1">初任者講習</option>
                    <?php elseif($data['place_id'] == 11):?>
                      <option value="11">三重県会場</option>
                    <?php else:?>
                      <option value="21">京都会場</option>
                    <?php endif;?>
                </select>
            </div>
            <div class="form-group">
                <label>開始日</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $data['start_date'];?>">
            </div>

            <div class="form-group">
                <label>所用日数</label>
                <input type="number" class="form-control" id="progress" name="progress" value="<?php echo $data['progress'];?>">
            </div>
            <div class="form-group">
                <label>席数</label>
                <input type="number" class="form-control" id="count" name="count" value="<?php echo $data['count'];?>">
            </div>
            <div class="form-group">
                <label>表示フラグ</label>
                <select name="display_flg" id="display_flg" class="form-control">
                    <option value="0" <?php if ($data['display_flg'] == 0) {echo 'selected';} ?>>非表示</option>
                    <option value="1" <?php if ($data['display_flg'] == 1) {echo 'selected';} ?>>表示</option>
                </select>
            </div>
            <div class="form-group">
                <label>作成時間</label><br>
                <label><?php echo $data['created_at'];?></label><br>
            </div>
            <div class="form-group">
                <label>更新時間</label><br>
                <label><?php echo $data['updated_at'];?></label><br>
            </div>
            <button type="submit" class="btn btn-primary">変更</button>
        </form>
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
