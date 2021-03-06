<?php
require "../db/reservation_settings.php";
require "../db/reservation.php";
require "../db/entries.php";

if (!empty($_GET['id'])) {
  $introducer_id = $_GET['id'];
}

$data = array();
$num = 0;

$reservation_data = getDataDef();
if (!empty($reservation_data)) {
  foreach ($reservation_data as $k => $val) {
    $tmp = array();
    $tmp['id'] = $val['id'];

    $reserve_data = getReservatinData($val['place']);

    // $weekday = ['日', '月', '火', '水', '木', '金', '土'];
    $progress = (int) $reserve_data['progress'] - 1;
    // $start_date = new Carbon($val);
    $start_date = new DateTime($val['start_date']);

    $tmp['start_date'] = $start_date->format('n月j日');

    $week = array("日", "月", "火", "水", "木", "金", "土");
    $tmp['start_week'] = $week[$start_date->format("w")];

    $end_date = $start_date->modify('+' . $progress . 'days');
    $tmp['end_date'] = $end_date->format('n月j日');
    $tmp['end_week'] = $week[$end_date->format("w")];

    $tmp_reservation_data = getDataNomember($val['start_date']);
    if (!empty($tmp_reservation_data)) {

      $entry = getEntry($tmp_reservation_data['id']);

      $count = 0;

      if (!empty($entry)) {
        foreach ($entry as $item) {
          if ($item['status'] != 2) {
            $count = $count + $item['count'];
          }
        }
      }
      $tmp['id_nomember'] = $tmp_reservation_data['id'];
      $tmp['left_seat_nomember'] = $reserve_data['count'] - $count;
    }


    $entry = getEntry($val['id']);
    $count = 0;

    if (!empty($entry)) {
      foreach ($entry as $item) {
        if ($item['status'] != 2) {
          $count = $count + $item['count'];
        }
      }
    }
    $tmp['id'] = $val['id'];
    $tmp['left_seat'] = $reserve_data['count'] - $count;
    $tmp['display'] = 0;

    if ($num >= 4) {
      $tmp['display'] = 1;
    }
    if ($val['display_flg'] == 1) {
      $num++;
    }

    $tmp['display_flg'] = $val['display_flg'];

    $data[$k] = $tmp;
  }
}





?>

<!DOCTYPE html>
<html lang="ja">
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WHJMK5S');</script>
<!-- End Google Tag Manager -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>初任運転者研修はグッドラーニングならいつでもどこでも受講可能！</title>
<meta name="title" content="初任運転者研修はグッドラーニングならいつでもどこでも受講可能！" />
<meta name="description" content="グッドラーニング！の初任運転者研修はいつでもどこでも好きな時間に受講が可能です！国土交通省が定めている「初任運転者に対する特別な指導」のうち12時間分の座学講座をeラーニングで受講できます。" />
<meta name="keywords" content="初任運転者研修,乗務員,教育,研修,Eラーニング,指導,国交省,トラック" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
<link href="common/css/default.css" rel="stylesheet" type="text/css" />
<link href="common/css/layout.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WHJMK5S"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="wrapper"> 
  <main>
    <div id="mainImg">
		<div id="mainTxt">
		<h1><img src="common/img/main_tit.svg" alt="いつでもどこでも受講可能 グッドラーニングの初任運転者研修" width="465" height="203"></h1>
		  <p>グッドラーニングの初任運転者講習はパソコン・スマートフォン・タブレットに対応しており、いつでもどこでもお好きな時間に受講することが出来ます。</p>
			<div id="corpLogo">
				<ul>
				<li><img src="common/img/logo_kyoto.png" width="294" height="56" alt="一般社団法人 京都府トラック協会"/><span>12項目も導入</span></li>
				<li><img src="common/img/logo_mie.png" width="264" height="44" alt="一般社団法人 三重県トラック協会"/><span>全国で初採用</span></li>
				</ul>
			</div>
		</div>
	  <div id="mainPh"><img src="common/img/mainimg.webp" alt="トラック運転者" width="682" height="768"></div>
    </div>
	  
	 <div id="about">
	  <h2><img src="common/img/tit01.svg" width="556" height="93" alt="グッドラーニング！の初任運転者研修はオンライン型学習システム"></h2>
		 <ul>
		 <li>
		   <div class="ph"><img src="common/img/illust01.webp" alt="オンライン学習" width="230" height="230"></div>
			 <h3>座学講座をeラーニングで受講</h3>
			 <p>国土交通省が定めている「初任運転者に対する特別な指導」の法定義務は15時間。そのうち12時間分の座学講座をeラーニングで受講できます。
			 </p></li>
		 <li>
		   <div class="ph"><img src="common/img/illust02.webp" alt="オンライン学習" width="230" height="230"></div>
			 <h3>いつでもどこでも好きな時間に！</h3>
			 <p>受講開始から7日間以内であれば、お好きな時間、お好きな場所で受講可能です。業務が忙しくて研修の時間が取れない！という方にもおすすめです。
			 </p></li></ul>
	  </div>
	  
	  <div id="info">
	  <h2><span><img src="common/img/tit02.svg" alt="初任運転者研修" width="302" height="30"></span></h2>
		  <div class="tableBox"><table>
			  <tr>
			  <th>対象</th>
			  <td>初任運転者</td>
			  <th>開催日</th>
			  <td>毎日</td>
			  <th>受講場所</th>
			  <td>パソコン/スマートフォン/タブレット</td></tr></table></div>
		  <div class="tableBox"><table>
			  <tr>
			  <th>所要時間</th>
			  <td>受講開始日より最長7日間、任意の時間に12時間分をeラーニングで受講していただきます。</td></tr></table></div>
		  <div class="tableBox"><table>
			  <tr>
			  <th>講座内容</th>
			  <td><ul>
				  <li>トラックを運転する場合の心構え</li>
<li>トラックの運行の安全を確保するために遵守すべき基本的事項</li>
<li>トラックの構造上の特性</li>
<li>貨物の正しい積載方法</li>
<li>過積載の危険性</li>
<li>危険物を運搬する場合に留意すべき事項</li>
<li>適切な運行の経路及び当該経路における道路及び交通の状況</li>
<li>危険の予測及び回避並びに緊急時における対応方法</li>
<li>運転者の運転適性に応じた安全運転</li>
<li>交通事故に関わる運転者の生理的及び心理的要因及びこれらへの対処方法</li>
<li>健康管理の重要性</li>
<li>安全性の向上を図る為の装置を備える事業用自動車の適切な運転方法</li></ul>
				  <p>※国土交通省の定める必要学習時間15時間のうちの12時間に相当します。<br>
※実際の車両を用いて行う指導項目は含まれていません。<br>
◆講座は全部で15講座あります。（12項目＋ドラレコを使用した危険予測講座2＋実力テスト1）</p></td></tr></table></div>
		  <div class="tableBox"><table>
			  <tr>
			  <th>受講料金</th>
			  <td>一般：1名<span>11,000円</span>（税込）<br>
グッドラーニング！会員：1名<span>7,700円</span>（税込）<br>
【振込口座】三井住友銀行　渋谷支店　普通9492637　株式会社キャブステーション</td></tr></table></div>
		  
	  </div>
	  <div id="application">
	  <h2 class="mt40 mb20"><span><img src="common/img/tit07.svg" alt="お申込み" height="30"></span></h2>
	  <div class="priceBox">
	  <h3>受講料金</h3>
			  <ul class="price">
			  <li><h5>非会員</h5>
				  <p>1名<span>11,000円</span>(税込)</p></li>
			  <li><h5>グッドラーニング！会員</h5>
				  <p>1名<span>7,700円</span>(税込)</p></li></ul>
	  </div>
		  <p class="info">受講期間は7日間のうち、ご都合が良いときに受講ください。<br>
定員がございますので、お早めにお申し込みください。また、受付締め切りは、お申込みの2日前までとなっております。<br>
WEBからのご予約は下記受講開始日の<span>席数ボタン</span>からご予約いただけます。</p>
		  <div id="calendar">
		  <table>
			  <thead>
			  <tr>
				  <th>受講開始日～終了日</th>
				  <th>非会員</th>
				  <th>グッドラーニング！会員</th>
				  </tr></thead>

				  <tbody>
                  <?php foreach ($data as $val) : ?>
                    <?php if ($val['display'] == 0) : ?>
                      <?php if ($val['display_flg'] == 1) : ?>
                        <tr>
                          <td><?php echo $val['start_date'] ?><span>(<?php echo $val['start_week'] ?>)</span>～<?php echo $val['end_date'] ?><span>(<?php echo $val['end_week'] ?>)</span></td>
                          <?php if ($val['left_seat_nomember'] > 0) : ?>
                            <?php if (empty($introducer_id)) : ?>
                              <td><a href="/truck/reservation/?id=<?php echo $val['id_nomember'] ?>"><button class="normal">残り<span><?php echo $val['left_seat_nomember']; ?></span>席</button></a></td>
                            <?php else : ?>
                              <td><a href="/truck/reservation/?id=<?php echo $val['id_nomember'] ?>&recom=<?php echo $introducer_id; ?>"><button class="normal">残り<span><?php echo $val['left_seat_nomember']; ?></span>席</button></a></td>
                            <?php endif; ?>
                          <?php else : ?>
                            <td><button class="normal" disabled>残り<span><?php echo $val['left_seat_nomember']; ?></span>席</button></td>
                          <?php endif; ?>

                          <?php if ($val['left_seat'] > 0) : ?>
                            <?php if (empty($introducer_id)) : ?>
                              <td><a href="/truck/reservation/?id=<?php echo $val['id'] ?>"><button class="member">残り<span><?php echo $val['left_seat']; ?></span>席</button></a></td>
                            <?php else : ?>
                              <td><a href="/truck/reservation/?id=<?php echo $val['id'] ?>&recom=<?php echo $introducer_id; ?>"><button class="member">残り<span><?php echo $val['left_seat']; ?></span>席</button></a></td>
                            <?php endif; ?>
                          <?php else : ?>
                            <td><button class="member" disabled>残り<span><?php echo $val['left_seat']; ?></span>席</button></td>
                          <?php endif; ?>
                        </tr>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </tbody>

				<tbody id="display" style="display: none;">
                  <?php foreach ($data as $val) : ?>
                    <?php if ($val['display'] == 1) : ?>
                      <?php if ($val['display_flg'] == 1) : ?>
                        <tr>
                          <td><?php echo $val['start_date'] ?><span>(<?php echo $val['start_week'] ?>)</span>～<?php echo $val['end_date'] ?><span>(<?php echo $val['end_week'] ?>)</span></td>
                          <?php if ($val['left_seat_nomember'] > 0) : ?>
                            <?php if (empty($introducer_id)) : ?>
                              <td><a href="/truck/reservation/?id=<?php echo $val['id_nomember'] ?>"><button class="normal">残り<span><?php echo $val['left_seat_nomember']; ?></span>席</button></a></td>
                            <?php else : ?>
                              <td><a href="/truck/reservation/?id=<?php echo $val['id_nomember'] ?>&recom=<?php echo $introducer_id; ?>"><button class="normal">残り<span><?php echo $val['left_seat_nomember']; ?></span>席</button></a></td>
                            <?php endif; ?>
                          <?php else : ?>
                            <td><button class="normal" disabled>残り<span><?php echo $val['left_seat_nomember']; ?></span>席</button></td>
                          <?php endif; ?>

                          <?php if ($val['left_seat'] > 0) : ?>
                            <?php if (empty($introducer_id)) : ?>
                              <td><a href="/truck/reservation/?id=<?php echo $val['id'] ?>"><button class="member">残り<span><?php echo $val['left_seat']; ?></span>席</button></a></td>
                            <?php else : ?>
                              <td><a href="/truck/reservation/?id=<?php echo $val['id'] ?>&recom=<?php echo $introducer_id; ?>"><button class="member">残り<span><?php echo $val['left_seat']; ?></span>席</button></a></td>
                            <?php endif; ?>

                          <?php else : ?>
                            <td><button class="member" disabled>残り<span><?php echo $val['left_seat']; ?></span>席</button></td>
                          <?php endif; ?>
                        </tr>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </tbody>
			
			
			</table>
			  <div class="moreLoad">
			  <p id="more">さらに表示する</p>
			  </div>
		  </div>
			  <div class="contactTel">
			  <h3>お電話でのご予約はこちらから</h3>
				  <p class="tel">
				  <a href="tel:0368801064">03-6880-1064</a>
					  <span>平日9:00~17:00<br>
土曜8:30~16:00</span>
					  <span>定休日<br>
日曜・祝日</span>
				  </p>
			  </div>
		  </div>
	  
	  
	  <div id="flow">
	  <h2><span><img src="common/img/tit03.svg" width="439" height="35" alt="グッドラーニング！受講の流れ"></span></h2>
		  <ol>
		  <li><a href="#" class="js-modal-open" data-target="mdReserve">お申込みフォーム</a>より、ご予約ください。</li>
		  <li>受講料のお支払いに関するご案内メールが届きます。<span class="red">受講料は事前払い</span>となります。</li>
		  <li>予約日から<span class="red">1週間以内に受講</span>を完了してください。</li>
		  <li>すべての講座を受講完了した受講者には、<span class="green">指導記録簿および修了証明書を発行</span>いたします。</li>
		  <li>受講完了後、受講の資料をデータにてお渡しいたします。
<span class="cap">※国土交通省の定めにより当該教材を3年間、お手元で保管してください。</span></li></ol>
	  </div>
	  <div id="reason">
	  <h2><span><img src="common/img/tit04.svg" width="439" height="35" alt="グッドラーニング！が選ばれる理由"></span></h2>
	  <div class="reasonBox">
		  <div class="driver">
		  <h3><img src="common/img/subtit01.svg" alt="ドライバーのメリット"></h3>
			  <div class="box">
			  <div class="ph"><img src="common/img/ph01.webp" alt="オンライン学習" width="310" height="175"></div>
				  <h4>いつでもどこでも受講可能</h4>
				  <p>受講期間は7日間です。<br>
7日間の受講期間内であれば都合の良い時間にパソコンや、スマホ、タブレットから受講することができます。</p>
			  </div>
		  </div>
		  <div class="manager">
		  <h3><img src="common/img/subtit02.svg" alt="事業者・管理者のメリット"></h3>
			  <div class="box">
			  <div class="ph"><img src="common/img/ph02.webp" alt="修了証" width="310" height="175"></div>
				  <h4>指導記録簿・修了証付き</h4>
				  <p>国土交通省の定めにより当該教材と指導記録簿を3年間、保管する必要があります。</p>
			  </div>
			  <div class="box">
			  <div class="ph"><img src="common/img/ph03.webp" alt="ドライブレコーダー" width="310" height="175"></div>
				  <h4>充実した教育内容</h4>
				  <p>基本講座のほか、ドラレコ使った危険予測講座と実力テストもついています。初任運転者講習＋αで学ぶことができます。</p>
			  </div>
		  </div>
		  </div>
	  </div>
	  <div class="reserveBox">
			  <div class="lBox">
		  <h4>ご予約はWEBまたはお電話で！</h4>
			  <ul class="price">
			  <li><h5>非会員</h5>
				  <p>1名<span>11,000円</span>(税込)</p></li>
			  <li><h5>グッドラーニング！会員</h5>
				  <p>1名<span>7,700円</span>(税込)</p></li></ul>
			  <p>※受付締切：2日前まで<br>
※定員がございますので、お早めにご予約ください。</p></div>
			  <div class="rBox">
				  <p class="btn">
			  <a href="#calendar">WEBからのご予約はこちらから</a></p>
				  <p class="tel">
				  <a href="tel:0368801064">03-6880-1064</a>
					  <span>平日9:00~17:00<br>
土曜8:30~16:00</span>
					  <span>定休日<br>
日曜・祝日</span>
				  </p>
			  </div>
		  </div>
	  <div id="achieve">
	  <h2><span><img src="common/img/tit05.svg" width="439" height="35" alt="グッドラーニング！ご採用実績"></span></h2>
		  <div class="inner">
		  
	  <p>グッドラーニング！の初任運転者講習をご採用いただいた企業様をご紹介いたします。<br>
北は北海道から南は九州・沖縄まで多くの企業様・ドライバー様にお使いいただき、安心・安全の一助となっております。</p>
			  <ul>
			  <li>（一社）京都府トラック協会様</li>
			  <li>（一社）三重県トラック協会様</li>
			  <li>水間急配株式会社様</li>
			  <li>東陸ロジテック株式会社様</li>
			  <li>株式会社いわれ様</li>
			  <li>大津中央運送株式会社様</li>
			  <li>有限会社荒川運送様</li>
			  <li>関西低温株式会社様</li>
			  </ul>
		  </div>
	  </div>
	  <div id="faq">
	  <h2><span><img src="common/img/tit06.svg" width="439" height="35" alt="FAQ"></span></h2>
	  <dl>
		  <dt>初任運転者研修の手段としてeラーニングは認められていますか？</dt>
		  <dd>認められています。<br>
グッドラーニング！は、国土交通省が定めている「初任運転者に対する特別な指導」に準拠しております。<br>
（実際の車両を用いて行う指導は除く）</dd>
		  
		  <dt>希望日の何日前までに申し込めば間に合いますか？</dt>
		  <dd><span>受講開始日の2日前</span>までにお申し込みください。</dd>
		  
		  <dt>日程の変更はできますか？</dt>
		  <dd>予約システム内の予約変更機能よりお手続きいただけます。ご希望日に残席がある場合、変更が可能です。<br>
また、開始日以降のご変更はできかねますのでご了承ください。</dd>
		  
		  <dt>受講期間の延長はできますか？</dt>
		  <dd>できかねます。7日間のうちに12項目を受講できる時間を確保してからのお申し込みをお願いいたします。</dd>
		  
		  <dt>キャンセル料はかかりますか？</dt>
		  <dd>ありません。しかし、前日と当日のキャンセルはできませんのでご注意ください。</dd>
		  
		  <dt>領収書は発行できますか？</dt>
		  <dd>お問い合わせいただければ、領収書を発行しデータでお送りさせていただきます。</dd>
		  
		  <dt>テキストだけ受け取ることは可能ですか？</dt>
		  <dd>テキストのみのお渡しは出来かねます。</dd>
		  
		  <dt>テキストの内容は毎年更新されますか？</dt>
		  <dd>法令改正があった場合のみ更新されますので、年度更新ではありません。</dd></dl>
	  </div>
  </main>
	<footer>
		<div id="footIn">
			<ul>
			<li><a href="https://cab-station.com/contact.html" target="_blank">お問い合わせ</a></li>
			<li><a href="https://cab-station.com/privacy.html" target="_blank">プライバシーポリシー</a></li></ul>
		<p>© 2021 Cab Station Co,Ltd.</p>
		</div>
	</footer>
</div>
<div id="mdReserve" class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
	  <ul>
	  <li><h2>非会員の方</h2>
		  <p>1名<span>11,000</span>円(税込)</p>
		  <a href="https://coubic.com/good-learning/644391/express" target="_blank">ご予約はこちらから</a></li>
	  <li><h2>グッドラーニング！会員の方</h2>
		  <p>1名<span>7,700</span>円(税込)</p>
		  <a href="https://coubic.com/good-learning/908288/express" target="_blank">ご予約はこちらから</a></li></ul>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="common/js/common.js"></script> 
<script>
    $('#more').on('click', function() {
      $('#display').show();
      $("#more").hide();
    });
  </script>
</body>
</html>
