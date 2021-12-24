<?php
// エスケープ処理
function h($str)
{
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//POST変数受け取り
if (isset($_POST["checkBox"])) {
	$checkBox = h(implode(" / ", $_POST["checkBox"]));
} else {
	$checkBox = "--";
}

$company = h($_POST['company']);
$inquirer = h($_POST['inquirer']);
$mail_address = h($_POST['mail_address']);
$tel = h($_POST['tel']);
$pref_address = h($_POST['pref_name'] . " " . $_POST['address']);
$date = h($_POST['year'] . $_POST['month']);

if ($_POST["human"] != '') {
	$human = h('およそ' . $_POST['human'] . '人');
} else {
	$human = "--";
}

$question = h($_POST['question']);
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
        <p id="pageTxt">入力内容をご確認の上、お問い合わせください。</p>
        <div class="inner">
          <div id="contact">
            <form method="post" action="thanks.php">
              <!-- <div id="error">
						〇〇が入力されていません
					</div> -->
              <dl class="conf">
                <dt>お問い合わせ内容</dt>
                <dd><?php echo $checkBox; ?></dd>
                <dt>貴社名</dt>
                <dd><?php echo $company; ?></dd>
                <dt>ご担当者名</dt>
                <dd><?php echo $inquirer; ?></dd>
                <dt>メールアドレス</dt>
                <dd><?php echo $mail_address; ?></dd>
                <dt>お電話番号</dt>
                <dd><?php echo $tel; ?></dd>
                <dt>ご住所</dt>
                <dd><?php echo $pref_address; ?></dd>
                <dt>受講開始の時期</dt>
                <dd><?php echo $date; ?></dd>
                <dt>受講者の人数</dt>
                <dd><?php echo $human; ?></dd>
                <dt>その他(質問・ご相談)</dt>
                <dd><?php echo $question; ?></dd>
              </dl>
              <ul class="formBtn">
                <li>
                  <input
                    type="submit"
                    class="baseSubmit"
                    value="この内容で送信する"
                  />
                </li>
                <li>
                  <input
                    type="button"
                    onclick="history.back()"
                    class="backBtn"
                    value="修正する"
                  />
                </li>
              </ul>
              <!-- thanks.php に値を渡す用 -->
              <input type="hidden" name="checkBox" value="<?php echo $checkBox; ?>">
              <input type="hidden" name="company" value="<?php echo $company; ?>" />
              <input type="hidden" name="inquirer" value="<?php echo $inquirer; ?>" />
              <input type="hidden" name="mail_address" value="<?php echo $mail_address; ?>" />
              <input type="hidden" name="tel" value="<?php echo $tel; ?>" />
              <input type="hidden" name="pref_address" value="<?php echo $pref_address; ?>" />
              <input type="hidden" name="date" value="<?php echo $date; ?>" />
              <input type="hidden" name="human" value="<?php echo $human; ?>" />
              <input type="hidden" name="question" value="<?php echo $question; ?>" />
              <!-- 値を渡す用　ここまで -->
            </form>
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
