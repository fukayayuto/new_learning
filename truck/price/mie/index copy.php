<?php
ini_set('display_errors', "On");
require "../../db/reservation_settings.php"; 
require "../../db/reservation.php"; 
require "../../db/entries.php"; 

session_start();
unset($_SESSION["flg"]);

if(!empty($_GET['res'])){
  $res = $_GET['res'];
}

$data = array();
$num = 0;
$today = new DateTime();
$today = $today->format('y-m-d');
date_default_timezone_set('Asia/Tokyo');
$date = date("Y-m-d H:i:s",strtotime("+3 day"));

$reservation_data = getDataMie($date);

foreach ($reservation_data as $k => $val){
  $tmp = array();
  $tmp['id'] = $val['id'];

  $reserve_data = getReservatinData($val['place']);
  

  // $weekday = ['日', '月', '火', '水', '木', '金', '土'];
  $progress = (int) $reserve_data['progress'] - 1;
  // $start_date = new Carbon($val);
  $start_date = new DateTime($val['start_date']);
  
  $tmp['start_date'] = $start_date->format('n月j日');

  $week = array( "日", "月", "火", "水", "木", "金", "土" );
  $tmp['start_week'] = $week[$start_date->format("w")];

  $end_date = $start_date->modify('+' .$progress . 'days');
  $tmp['end_date'] = $end_date->format('n月j日');
  $tmp['end_week'] = $week[$end_date->format("w")];

  $entry = getEntry($val['id']);
  $count = 0;

  if(!empty($entry)){
      foreach ($entry as $item) {
        if($item['status'] != 2){
          $count = $count + $item['count'];
        }
      }
  }
    $tmp['id'] = $val['id'];
    $tmp['left_seat'] = $reserve_data['count'] - $count;
    $tmp['display'] = 0;

    if($num >= 4){
      $tmp['display'] = 1;
    }

    if($val['display_flg'] == 1){
      $num++;
  }
  $tmp['display_flg'] = $val['display_flg'];
  

  $data[$k] = $tmp;
}



?>



<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>
    三重県トラック協会予約依頼｜トラックドライバー教育のクラウド型eラーニング【グッドラーニング!】
    </title>
    <meta
      name="title"
      content="料金について｜トラックドライバー教育のクラウド型eラーニング【グッドラーニング!】"
    />
    <meta
      name="description"
      content="グッドラーニング！の料金プランは通常プラン・2年割引プラン・2年割ライトプランの3つのプランをご用意しております。"
    />
    <meta
      name="keywords"
      content="乗務員,教育,研修,Eラーニング,指導,国交省,トラック,運送業,グッドラーニング"
    />
    <meta
      property="og:title"
      content="料金について｜トラックドライバー教育のクラウド型eラーニング【グッドラーニング!】"
    />
    <meta property="og:type" content="article" />
    <meta
      property="og:url"
      content="http://localhost:8888/truck/price/"
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
      content="グッドラーニング！の料金プランは通常プラン・2年割引プラン・2年割ライトプランの3つのプランをご用意しております。"
    />
    <link
      rel="canonical"
      href="http://localhost:8888/truck/price/"
    />
    <link rel="stylesheet" href="https://use.typekit.net/hcg7pyj.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700"
      rel="stylesheet"
      media="print"
      onload="this.media=’all'"
    />
    <link href="../../common/css/default.css" rel="stylesheet" type="text/css" />
    <link href="../../common/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="../../common/css/content.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

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
                src="../../common/img/shared/head_logo.svg"
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
              <li class="stay">料金について</li>
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
        <div id="pageTit">
          <h1>三重県トラック協会予約依頼</h1>
          <div id="breadCrumbs">
            <ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
              <li
                itemprop="itemListElement"
                itemscope=""
                itemtype="https://schema.org/ListItem"
              >
                <a href="/truck/price/mie" itemprop="item"
                  ><span itemprop="name">HOME</span></a
                ><meta itemprop="position" content="1" />
              </li>
              <li>三重県トラック協会予約依頼</li>
            </ol>
          </div>
        </div>
       
        

        <div id="optionPlan">
          <div class="inner">
            <h2 class="subTit">
              初任運転者講座
            </h2>
            <p>
              国土交通省が定めている「初任運転者に対する特別な指導」について、座学15時間の教育内容の一部（「初任運転者に対する特別な指導」により規定されている12項目（実際の車両を用いて行う指導は除く）について、12時間分の講座）をグッドラーニング！で受講できるようあらたに「初任運転者講座」をご用意いたしました。
            </p>

            
            
	  <div id="application">
		  <p class="info">受講期間は5日間のうち、ご都合が良いときに受講ください。<br>
定員がございますので、お早めにお申し込みください。また、受付締め切りは、お申込みの2日前までとなっております。<br>
WEBからのご予約は下記受講開始日の<span>席数ボタン</span>からご予約いただけます。</p>
		  <div id="calendar">
		  <table>
			  <thead>
			  <tr>
				  <th>受講開始日～終了日</th>
				  <th></th>
				  <th></th>
				  </tr></thead>
          <tbody>
          <?php foreach($data as $val) :?>
            <?php if($val['display'] == 0):?>
              <?php if($val['display_flg'] == 1):?>
                <tr>
                  <td><?php echo $val['start_date'] ?><span>(<?php echo $val['start_week'] ?>)</span>～<?php echo $val['end_date']?><span>(<?php echo $val['end_week'] ?>)</span></td>
                  <td></td>
                  <?php if($val['left_seat'] > 0):?>
                      <td><a href="/truck/reservation/mie/?id=<?php echo $val['id'] ?>"><button class="member">残り<span><?php echo $val['left_seat'];?></span>席</button></a></td>
                  <?php else:?>
                      <td><button class="member" disabled>残り<span><?php echo $val['left_seat'];?></span>席</button></td>
                  <?php endif;?>
                </tr>
                <?php endif;?>
            <?php endif;?>
          <?php endforeach; ?>
			  </tbody>

        <tbody id="display" style="display: none;">
        <?php foreach($data as $val) :?>
            <?php if($val['display'] == 1):?>
              <?php if($val['display_flg'] == 1):?>
                <tr>
                  <td><?php echo $val['start_date'] ?><span>(<?php echo $val['start_week'] ?>)</span>～<?php echo $val['end_date']?><span>(<?php echo $val['end_week'] ?>)</span></td>
                  <td></td>
                  <?php if($val['left_seat'] > 0):?>
                      <td><a href="/truck/reservation/mie/?id=<?php echo $val['id'] ?>"><button class="member">残り<span><?php echo $val['left_seat'];?></span>席</button></a></td>
                  <?php else:?>
                      <td><button class="member" disabled>残り<span><?php echo $val['left_seat'];?></span>席</button></td>
                  <?php endif;?>
                </tr>
                <?php endif;?>
            <?php endif;?>
          <?php endforeach; ?>
			  </tbody>

      
      </table>
			  <div class="moreLoad">
			  <p id="more">さらに表示する</p>
			  </div>
		  </div>
		  </div>
          </div>
        </div>
        <div id="contactBox">
          <div id="contactIn">
            <p>お問い合わせ・受講体験は<br />お電話又はフォームで</p>
            <a href="tel:0368801064" class="tel">03-6880-1064</a>
            <a href="/truck/contact/" class="btn"
              >お問い合わせ・受講体験はこちら</a
            >
          </div>
        </div>
      </main>
      <!-- //main -->
      <!-- footer// -->
      <footer>
        <div class="inner">
          <div class="footLogo">
            <img
              src="../../common/img/shared/foot_logo.svg"
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
            <p>© 2021 Cab Station Co., Ltd.</p>
          </div>
        </div>
      </footer>
      <!-- //footer -->
		<div id="float">
		<p><span>お問い合わせ・受講体験はお電話で</span></p>
		<a href="tel:0368801064">03-6880-1064<span>今すぐ電話する</span></a>
		</div>
    </div>
    <!-- js -->
    <script src="../../common/js/common.js"></script>
    <script>
        $('#more').on('click', function() {
            $('#display').show();
            $("#more").hide();
        });
    </script>
     <script>
        $(function() {
            var res = <?php echo $res; ?>;
            if (res == 1) {
                swal('正常に申し込みが処理ができませんでした。\nお手数おかけしますが、もう一度申し込みお願い致します。');
            }
        });
    </script>
    <?php @include($_SERVER['DOCUMENT_ROOT']."/truck/common/inc/js_after.inc")?>
  </body>
</html>
