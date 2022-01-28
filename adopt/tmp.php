<?php
require "../db/adopt.php";
$place = 0;
$data = getAdopt($place);
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>
      ご採用実績｜バス・タクシー乗務員教育のクラウド型eラーニング【グッドラーニング!】
    </title>
    <meta
      name="title"
      content="ご採用実績｜バス・タクシー乗務員教育のクラウド型eラーニング【グッドラーニング!】"
    />
    <meta
      name="description"
      content="グッドラーニング！をご採用頂いたお客様をご紹介いたします。"
    />
    <meta
      name="keywords"
      content="乗務員,教育,研修,Eラーニング,指導,国交省,バス,タクシー,観光業,グッドラーニング"
    />
    <meta
      property="og:title"
      content="ご採用実績｜バス・タクシー乗務員教育のクラウド型eラーニング【グッドラーニング!】"
    />
    <meta property="og:type" content="article" />
    <meta
      property="og:url"
      content="http://localhost:8888/faq/"
    />
    <meta
      property="og:image"
      content="http://localhost:8888/common/img/shared/og_image.jpg"
    />
    <meta
      property="og:site_name"
      content="バス・タクシー乗務員教育のクラウド型eラーニング【グッドラーニング!】"
    />
    <meta
      property="og:description"
      content="グッドラーニング！をご採用頂いたお客様をご紹介いたします。"
    />
    <link rel="canonical" href="http://localhost:8888/faq/" />
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
    <?php @include($_SERVER['DOCUMENT_ROOT']."/common/inc/head_before.inc")?>
  </head>

  <body>
    <?php @include($_SERVER['DOCUMENT_ROOT']."/common/inc/body_after.inc")?>
    <div id="wrapper">
      <!-- header// -->
      <header>
        <div id="header">
          <p id="headLogo">
            <a href="/"
              ><img
                src="../common/img/shared/head_logo.svg"
                alt="グッドラーニング"
                width="262"
                height="50"
                loading="lazy"
            /></a>
          </p>
          <p id="headTxt">
            <span>バス・タクシー乗務員教育</span>のクラウド型eラーニング
          </p>
        </div>
        <div id="global">
          <div id="navTrigger"><span>&nbsp;</span></div>
          <nav>
            <ul>
              <li><a href="/">HOME</a></li>
              <li><a href="/price/">料金について</a></li>
              <li><a href="/flow/">ご利用の流れ</a></li>
              <li class="stay"><span>ご採用実績</span></li>
              <li><a href="/faq/">FAQ</a></li>
              <li><a href="/contact/">お問い合わせ</a></li>
            </ul>
          </nav>
        </div>
      </header>
      <!-- //header -->
      <!-- main// -->
      <main>
        <div id="pageTit">
          <h1>ご採用実績</h1>
          <div id="breadCrumbs">
            <ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
              <li
                itemprop="itemListElement"
                itemscope=""
                itemtype="https://schema.org/ListItem"
              >
                <a href="/" itemprop="item"
                  ><span itemprop="name">HOME</span></a
                ><meta itemprop="position" content="1" />
              </li>
              <li>ご採用実績</li>
            </ol>
          </div>
        </div>
        <p id="pageTxt">
          グッドラーニング！をご採用いただいた企業様をご紹介いたします。北は北海道から南は九州・沖縄まで、多くの企業様・ドライバー様にお使いいただき、安心・安全の一助となっております。
        </p>
        <div class="inner">
          <div id="adopt">
            <ul>
            <?php if (!empty($data)) : ?>
              <?php foreach ($data as $val) : ?>
                <?php if ($val['display_flg'] == 1) : ?>
                  <li><?php echo $val['company_name']; ?></li>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>
            </ul>
          </div>
        </div>
        <div id="contactBox">
          <div id="contactIn">
            <p>お問い合わせ・受講体験は<br />お電話又はフォームで</p>
            <a href="tel:0368801064" class="tel">03-6880-1064</a>
            <a href="/contact/" class="btn"
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
              src="../common/img/shared/foot_logo.svg"
              alt="グッドラーニング"
              width=""
              height=""
              loading="lazy"
            />
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
    <script>
      (function (d) {
        var config = {
            kitId: "bli4hjx",
            scriptTimeout: 3000,
            async: true,
          },
          h = d.documentElement,
          t = setTimeout(function () {
            h.className =
              h.className.replace(/\bwf-loading\b/g, "") + " wf-inactive";
          }, config.scriptTimeout),
          tk = d.createElement("script"),
          f = false,
          s = d.getElementsByTagName("script")[0],
          a;
        h.className += " wf-loading";
        tk.src = "https://use.typekit.net/" + config.kitId + ".js";
        tk.async = true;
        tk.onload = tk.onreadystatechange = function () {
          a = this.readyState;
          if (f || (a && a != "complete" && a != "loaded")) return;
          f = true;
          clearTimeout(t);
          try {
            Typekit.load(config);
          } catch (e) {}
        };
        s.parentNode.insertBefore(tk, s);
      })(document);
    </script>
    <script src="../common/js/common.js"></script>
    <?php @include($_SERVER['DOCUMENT_ROOT']."/common/inc/js_after.inc")?>
  </body>
</html>
