<?php

require_once "db/information.php";

$place = 0;
$information_priority_data = getPriorityiInformation($place);
$limit = 6 - count($information_priority_data);

$information_nomal_data = getNormalInformation($limit, $place);

$priority_data = array();

foreach ($information_priority_data as $k => $val) {
  $tmp = array();

  $publish_date = new DateTime($val['publish_date']);
  $tmp['publish_date'] = $publish_date->format('Y.m.d');

  $title = $val['title'];
  $link_part = $val['link_part'];
  $tmp['link'] = $val['link'];
  $tmp['link_part'] = $link_part;
  $tmp['title'] = $title;

  if (!is_null($link_part)) {
    $part_first = strstr($title, $link_part, true);
    $left_part = strstr($title, $link_part);
    $word_count = mb_strlen($link_part);
    $part_final = mb_substr($left_part, $word_count);
    $tmp['part_first'] = $part_first;
    $tmp['part_final'] = $part_final;
    $tmp['blank_flg'] = $value['blank_flg'];
  }

  $priority_data[$k] = $tmp;
}



$normal_data = array();
foreach ($information_nomal_data as $key => $value) {
  $tmp = array();

  $publish_date = new DateTime($value['publish_date']);
  $tmp['publish_date'] = $publish_date->format('Y.m.d');

  $title = $value['title'];
  $link_part = $value['link_part'];
  $tmp['link_part'] = $link_part;
  $tmp['link'] = $value['link'];
  $tmp['blank_flg'] = $value['blank_flg'];

  $tmp['title'] = $title;

  if (!is_null($link_part)) {
    $part_first = strstr($title, $link_part, true);
    $left_part = strstr($title, $link_part);
    $word_count = mb_strlen($link_part);
    $part_final = mb_substr($left_part, $word_count);
    $tmp['part_first'] = $part_first;
    $tmp['part_final'] = $part_final;
  }

  $normal_data[$key] = $tmp;
}




?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>
    乗務員教育のクラウド型eラーニング【グッドラーニング!】
  </title>
  <meta name="title" content="乗務員教育のクラウド型eラーニング【グッドラーニング!】" />
  <meta name="description" content="グッドラーニング！は、国交省の「一般的な指導および監督の指針」に対応した、運転者の指導教育に特化したeラーニングシステムです。時間と場所を選ばずに、すべての乗務員に対して効率よく指導教育を実施することができます。" />
  <meta name="keywords" content="乗務員,教育,研修,Eラーニング,指導,国交省,バス,運送業,グッドラーニング" />
  <meta property="og:title" content="乗務員教育のクラウド型eラーニング【グッドラーニング!】" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="http://localhost:8888/" />
  <meta property="og:image" content="http://localhost:8888/common/img/shared/og_image.jpg" />
  <meta property="og:site_name" content="乗務員教育のクラウド型eラーニング【グッドラーニング!】" />
  <meta property="og:description" content="グッドラーニング！は、国交省の「一般的な指導および監督の指針」に対応した、運転者の指導教育に特化したeラーニングシステムです。時間と場所を選ばずに、すべての乗務員に対して効率よく指導教育を実施することができます。" />
  <link rel="canonical" href="http://localhost:8888/" />
  <link rel="stylesheet" href="https://use.typekit.net/hcg7pyj.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700" rel="stylesheet" media="print" onload="this.media=’all'" />
  <link href="common/css/default.css" rel="stylesheet" type="text/css" />
  <link href="common/css/layout.css" rel="stylesheet" type="text/css" />
  <link href="common/css/top.css" rel="stylesheet" type="text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <?php @include($_SERVER['DOCUMENT_ROOT'] . "/common/inc/head_before.inc") ?>
</head>

<body>
  <?php @include($_SERVER['DOCUMENT_ROOT'] . "/common/inc/body_after.inc") ?>
  <div id="wrapper">
    <!-- header// -->
    <header id="index">
      <div id="mainImg">
        <div class="txtBox">
          <ul>
            <li>
              <img src="common/img/index/main_point01.webp" alt="指導教育記録簿自動作成" width="205" height="205" loading="lazy" />
            </li>
            <li>
              <img src="common/img/index/main_point02.webp" alt="国交省指定安全教育対応" width="205" height="205" loading="lazy" />
            </li>
            <li>
              <img src="common/img/index/main_point03.webp" alt="どこでも受講！PC・スマホ対応" width="205" height="205" loading="lazy" />
            </li>
            <li>
              <img src="common/img/index/main_point04.webp" alt="リーズナブルな料金体系" width="205" height="205" loading="lazy" />
            </li>
          </ul>
          <div>
            <img src="common/img/index/main_tit_smt.webp" alt="バス・タクシー乗務員教育のクラウド型eラーニング グッドラーニング!" width="717" height="361" class="smt" loading="lazy" /><img src="common/img/index/main_tit.webp" alt="バス・タクシー乗務員教育のクラウド型eラーニング グッドラーニング!" width="786" height="239" class="pc" loading="lazy" />
          </div>
        </div>
      </div>
      <div id="global">
        <div id="navTrigger"><span>&nbsp;</span></div>
        <nav>
          <ul>
            <li><a href="/">HOME</a></li>
            <li><a href="/price/">料金について</a></li>
            <li><a href="/flow/">ご利用の流れ</a></li>
            <li><a href="/adopt/">ご採用実績</a></li>
            <li><a href="/faq/">FAQ</a></li>
            <li><a href="/contact/">お問い合わせ</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <!-- //header -->
    <!-- main// -->
    <main>
      <div id="news">
        <div id="newsIn">
          <p id="newsTit">NEWS &amp; TOPICS</p>
          <ul>

            <?php if (isset($priority_data)) : ?>
              <?php foreach ($priority_data as $val) : ?>
                <li>
                  <span><?php echo $val['publish_date']; ?></span>

                  <?php if (!empty($val['part_first'])) : ?>
                    <?php echo $val['part_first']; ?>
                  <?php endif; ?>

                  <?php if(!empty($val['link_part'])):?>
                    <?php if($val['blank_flg'] == 0):?>
                    <a href="<?php echo $val['link'];?>">
                        <?php echo $val['link_part'];?>
                    </a>
                    <?php else:?>
                      <a href="<?php echo $val['link'];?>" target="_blank" rel="nofollow">
                        <?php echo $val['link_part'];?>
                    </a>
                    <?php endif;?>
                  <?php else:?>
                       <?php echo $val['title'];?>
                  <?php endif;?>

                  <?php if(!empty($val['part_final'])):?>
                    <?php echo $val['part_final'];?>
                  <?php endif;?>       

                </li>
              <?php endforeach; ?>
            <?php endif; ?>

            <?php if (isset($normal_data)) : ?>
              <?php foreach ($normal_data as $value) : ?>
                <li>
                  <span><?php echo $value['publish_date']; ?></span>

                  <?php if (!empty($value['part_first'])) : ?>
                    <?php echo $value['part_first']; ?>
                  <?php endif; ?>

                  <?php if(!empty($value['link_part'])):?>
                    <?php if($value['blank_flg'] == 0):?>
                    <a href="<?php echo $value['link'];?>">
                        <?php echo $value['link_part'];?>
                    </a>
                    <?php else:?>
                      <a href="<?php echo $value['link'];?>" target="_blank" rel="nofollow">
                        <?php echo $value['link_part'];?>
                    </a>
                    <?php endif;?>
                  <?php else:?>
                       <?php echo $value['title'];?>
                  <?php endif;?>

                  <?php if(!empty($value['part_final'])):?>
                    <?php echo $value['part_final'];?>
                  <?php endif;?>     
                </li>
              <?php endforeach; ?>
            <?php endif; ?>

          </ul>
        </div>
      </div>
      <div id="contactBox">
        <div id="contactIn">
          <p>お問い合わせ・受講体験は<br />お電話又はフォームで</p>
          <a href="tel:0368801064" class="tel">03-6880-1064</a>
          <a href="/contact/" class="btn">お問い合わせ・受講体験はこちら</a>
        </div>
      </div>
      <div id="topContent01">
        <h1>
          <span>乗務員教育</span>で<br />お困りではありませんか？
        </h1>
        <p>
          輸送の安全を実現するためには、運転者に対する継続的な指導教育が欠かせません。<br />
          しかし、乗務員を集めて研修会を開催するとなると、教材の事前準備、講師の手配、<br />
          受講記録の作成、稼働率の低下など、手間やコストに大きな負担がかかります。
        </p>
        <ul>
          <li>配車業務が忙しくてドライバー教育まで手が回らない</li>
          <li>研修にかかるコストの負担が大きい</li>
          <li>集合研修を開催する場所も機会もない</li>
          <li>専任の教育担当者を配置したいが要員不足で難しい</li>
        </ul>
      </div>
      <div id="topContent02">
        <div id="topContentInfo">
          <h2>
            <img src="common/img/shared/ico_logo.svg" alt="グッドラーニング" width="390" height="54" loading="lazy" />が<br />全てのお悩みを解決します！
          </h2>
          <div class="movie">
            <iframe src="https://player.vimeo.com/video/534674085?badge=0&amp;autopause=0&amp;pl
ayer_id=0&amp;app_id=58479" width="1920" height="1080" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen title="グッドラーニング！PRアニメーション"></iframe>
          </div>
          <p>
            グッドラーニング！は、国交省の「一般的な指導および監督の指針」に対応した、運転者の指導教育に特化したeラーニングシステムです。<br />
            時間と場所を選ばずに、すべてのドライバー・乗務員に対して効率よく指導教育を実施することができます。
          </p>
        </div>
        <div class="pointBox">
          <img src="common/img/index/point_ph01.jpg" alt="いつでも受講可能" width="750" height="500" loading="lazy" />
          <div>
            <h3>
              業務の都合に合わせて24時間<br />いつでもどこでも受講可能！
            </h3>
            <p>
              講座の受講時間は約30分。待機時間や休憩時間を活用して受講することもできるので、配車や勤務割に影響することもありません。また理解度に応じて受講者が繰り返し受講することも可能です。
            </p>
          </div>
        </div>
        <div class="pointBox">
          <img src="common/img/index/point_ph02.jpg" alt="PC・スマートフォン・タブレット端末に対応" width="750" height="500" loading="lazy" />
          <div>
            <h3>
              PCだけでなくタブレットやスマートフォンにも対応！
            </h3>
            <p>
              講座は社内に設置されたパソコンだけでなく、タブレット端末やスマートフォンでも受講することができます。社外にいても社内と同じ受講環境を用意することができます。
            </p>
          </div>
        </div>
        <div class="pointBox">
          <img src="common/img/index/point_ph03.jpg" alt="主体的に取り組めて、一方通行にならない教育" width="750" height="500" loading="lazy" />
          <div>
            <h3>準備や資料作成の手間がかからない<br />対話型・体験型の効果的な研修</h3>
            <p>
              直近の指導・監督指針の改正（※）に対応した最新版の講座が自動的に配信されるので、研修資料の作成に時間を取られる心配はありません。また受講後に効果測定テストが用意されており、ただ受講するだけの一方通行の研修ではなく、対話型で効果的な研修を実施できます。<br />
              ※国土交通省告示「旅客・貨物自動車運送事業者が事業用自動車の運転者に対して行う指導及び監督の指針」（２０１８年６月改正）
            </p>
          </div>
        </div>
        <div class="pointBox">
          <img src="common/img/index/point_ph04.jpg" alt="動画を使った危険予測トレーニング" width="750" height="500" loading="lazy" />
          <div>
            <h3>
              動画でわかりやすく安全講座や特別講座が受講可能
            </h3>
            <p>
              コンピューターグラフィックの危険予測シーンやナレーション付きの動画教材など、映像と音声による学習効果の高い、わかりやすい講座を受講できます。
            </p>
            <ul>
              <li>
                <a href="https://vimeo.com/364937431" target="_blank" class="icoPlay">安全講座「危険の予測と回避」サンプル動画</a>
              </li>
              <li>
                <a href="https://vimeo.com/364929237" target="_blank" class="icoPlay">特別講座「過労運転防止のため、改善基準告示を正しく理解しよう」サンプル動画</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="pointBox">
          <img src="common/img/index/point_ph05.jpg" alt="自社のドラレコ映像を使用したオリジナル教材の配信" width="750" height="500" loading="lazy" />
          <div>
            <h3>オリジナル教材作成機能</h3>
            <p>
              自社専用のオリジナル教材を自由に作成できるようになります。他社への公開を前提に、バス会社様に代わって教材作成作業を代行させていただきます。ドラレコ映像ファイルをアップロード（※）して教材として配信できます。<br />
              ※１件あたり２０ＭＢ以内、合計で１ＧＢ以内
            </p>
          </div>
        </div>
        <div class="pointBox">
          <img src="common/img/index/point_ph06.jpg" alt="年間教育計画表・ 指導教育記録簿の出力" width="750" height="500" loading="lazy" />
          <div>
            <h3>年間教育計画表・指導教育記録簿の印刷出力対応！</h3>
            <p>
              受講者の受講履歴やテスト結果は自動的に集計され、必要な時に指導教育記録簿として出力することができます。また管理用サイトを使って受講者ごとの受講状況やテスト結果をリアルタイムで把握できるので、受講漏れや理解不足を見逃すことなく管理することができます。
            </p>
            <ul>
              <li>
                <a href="http://localhost:8888/truck/common/img/sample_pdf.pdf" target="_blank" class="icoPdf">出力サンプルはこちらから</a>
              </li>
            </ul>
          </div>
        </div>

        <div id="contactBanar">
          <p>お問い合わせ・受講体験はお電話又はフォームで</p>
          <div class="telNo">
            <a href="tel:0368801064">03-6880-1064</a>
            <p>平日9:30~17:00<span>土日祝日休業</span></p>
          </div>
          <ul>
            <li><a href="/price/">利用料金</a></li>
            <li>
              <a href="/contact/">お問い合わせ・受講体験はこちら</a>
            </li>
          </ul>
        </div>
      </div>
      <!--
    <div id="topAdopt">
	  <h2>ご採用実績<span>conference member</span></h2>
		  <p><a href="/adopt/">ご採用実績会社一覧</a></p>
		  <ul>
		  <li>aa</li></ul>
	  </div>
-->
    </main>
    <!-- //main -->
    <!-- footer// -->
    <footer>
      <div class="inner">
        <div class="footLogo">
          <img src="common/img/shared/foot_logo.svg" alt="グッドラーニング" width="" height="" loading="lazy" />
        </div>
        <ul class="footNav">
          <li><a href="/">ホーム</a></li>
          <li><a href="/price/">料金について</a></li>
          <li><a href="/flow/">ご利用の流れ</a></li>
          <li><a href="/adopt/">ご採用実績</a></li>
          <li><a href="/faq/">FAQ</a></li>
          <li><a href="/contact/">お問い合わせ</a></li>
        </ul>
      </div>
      <div id="copy">
        <div class="inner">
          <ul class="footSub">
            <li>
              <a href="https://cab-station.com/privacy.html" target="_blank">プライバシーポリシー</a>
            </li>
            <li>
              <a href="https://cab-station.com/company.html" target="_blank">会社概要</a>
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
  <script src="common/js/common.js"></script>
  <?php @include($_SERVER['DOCUMENT_ROOT'] . "/common/inc/js_after.inc") ?>
</body>

</html>