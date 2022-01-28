<?php
$mail = $_POST["mail_address"];

// 2通のメールの共通部分
$inquiry_content = "-----------------\n";
$inquiry_content .= "お問い合わせ内容\n";
$inquiry_content .= $_POST["checkBox"] . "\n\n";
$inquiry_content .= "会社名\n";
$inquiry_content .= $_POST["company"] . "\n\n";
$inquiry_content .= "ご担当者名\n";
$inquiry_content .= $_POST["inquirer"] . "\n\n";
$inquiry_content .= "メールアドレス\n";
$inquiry_content .= $mail . "\n\n";
$inquiry_content .= "お電話番号\n";
$inquiry_content .= $_POST["tel"] . "\n\n";
$inquiry_content .= "ご住所\n";
$inquiry_content .= $_POST["pref_address"] . "\n\n";
$inquiry_content .= "受講開始の時期\n";
$inquiry_content .= $_POST["date"] . "\n\n";
$inquiry_content .= "受講者の人数\n";
$inquiry_content .= $_POST["human"] . "\n\n";
$inquiry_content .= "その他(質問・ご相談)\n";
$inquiry_content .= $_POST["question"] . "\n";
$inquiry_content .= "-----------------";

//2通のメールのそれぞれの本文
$mail_body_1 = "「グッドラーニング！」(トラック)メールフォームからお問い合わせがありました。\n\n\n";
$mail_body_1 .= $inquiry_content;

$mail_body_2 = "「グッドラーニング！」メールフォームから\n";
$mail_body_2 .= "お問い合わせ頂き、ありがとうございます。\n";
$mail_body_2 .= "下記内容で受付いたしました。\n\n";
$mail_body_2 .= "折り返し、担当者よりご連絡いたしますので、\n";
$mail_body_2 .= "恐れ入りますが、しばらくお待ちください。\n\n";
$mail_body_2 .= $inquiry_content;

//メールの作成
$mail_to_1	= "yosuke-saito@cab-station.com";
$mail_subject_1	= "【グッドラーニング】お問い合わせ";
$mail_header_1	= "from:" . $mail;

$mail_to_2	= $mail;
$mail_subject_2	= "【グッドラーニング】お問い合わせを受け付けました";
$mail_header_2	= "from:yosuke-saito@cab-station.com";

//メール送信処理
mb_language("Japanese");
mb_internal_encoding("UTF-8");

$mailsousin_1 = mb_send_mail($mail_to_1, $mail_subject_1, $mail_body_1, $mail_header_1);
$mailsousin_2 = mb_send_mail($mail_to_2, $mail_subject_2, $mail_body_2, $mail_header_2);
?><!DOCTYPE html>
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
      content="https://promote.good-learning.jp/truck/contact/"
    />
    <meta
      property="og:image"
      content="https://promote.good-learning.jp/truck/common/img/shared/og_image.jpg"
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
      href="https://promote.good-learning.jp/truck/contact/"
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
    <link href="../common/css/default.css" rel="stylesheet" type="text/css" />
    <link href="../common/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="../common/css/content.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
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
        <div id="pageTit">
          <h1>お問い合わせ・受講体験</h1>
          <div id="breadCrumbs">
            <ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
              <li
                itemprop="itemListElement"
                itemscope=""
                itemtype="https://schema.org/ListItem"
              >
                <a href="/truck/" itemprop="item"
                  ><span itemprop="name">HOME</span></a
                ><meta itemprop="position" content="1" />
              </li>
              <li>お問い合わせ・受講体験</li>
            </ol>
          </div>
        </div>
        <div class="inner">
          <?php if ($mailsousin_1 == true && $mailsousin_2 == true) : ?>
          <div id="contact" class="thanks">
            <h2>お問い合わせ・受講体験を承りました。</h2>
            <p class="thanksTxt">
              お問い合わせいただきありがとうございました。<br />お問い合わせを受け付けました。<br />
              <br />
              折り返し、担当者よりご連絡いたしますので、恐れ入りますが、しばらくお待ちください。<br />
              <br />
              なお、ご入力いただいたメールアドレス宛に受付完了メールを配信しております。<br />
              完了メールが届かない場合、処理が正常に行われていない可能性があります。<br />
              大変お手数ですが、再度お問い合わせの手続きをお願い致します。
            </p>
          </div>
          <?php else : ?>
          <div id="contact" class="thanks">
            <h2>メール送信時にエラーが発生しました。</h2>
            <p class="thanksTxt">
              恐れ入りますが、再度ご送信いただけますでしょうか。
            </p>
          </div>
          <?php endif; ?>
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
    <?php @include($_SERVER['DOCUMENT_ROOT']."/truck/common/inc/js_after.inc")?>
  </body>
</html>
