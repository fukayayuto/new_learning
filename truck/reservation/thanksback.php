<?php
session_start();
require "../db/reservation.php"; 
require "../db/reservation_settings.php"; 
require "../db/entries.php"; 
require "../db/accounts.php"; 
require "../db/mail.php"; 
require "../db/mail_template.php"; 





if(empty($_POST)){
    header('Location: http://localhost:8888/truck/price');
}


if(empty($_SESSION["flg"])){

  $name = $_POST['name'];
  $email = $_POST['email'];
  $company_name = $_POST['company_name'];
  $phone = $_POST['phone'];
  $sales_office = $_POST['sales_office'];

  $account_id = accountStore($name,$email,$company_name,$phone,$sales_office);

  $reservation_id = $_POST['id'];
  $reserve_data = getReservation($reservation_id);
  $reserve_data = getReservatinData($reserve_data['place']);
  $price = $reserve_data["price"];

  $count = $_POST['count'];

  $res = entryStore($account_id,$reservation_id,$count);

  if(!$res){
    die('アカウント登録に失敗しました');
  }
  
  

  $mail = $_POST["email"];


  $mailTemplateData = getMailTemplate(1);

  $mail_template = $mailTemplateData['text'];
  $title = $mailTemplateData['title'];

  $name = $_POST['name'];
  $reservation_name = $_POST['reservation_name'];
  $start_date = $_POST['start_date'];
  $start_week = $_POST['start_week'];
  $count = $_POST['count'];

  $search = array('{{氏名}}', '{{予約名}}','{{開始日}}', '{{開始曜日}}','{{予約人数}}');
  $replace = array($name, $reservation_name,$start_date,$start_week,$count);
  $mail_template = str_replace($search, $replace, $mail_template);

  $mail_body_1 = $mail_template;
  $mail_subject_1 = $title;


  // $mail_body_1 = $_POST['name'] . "様\n\n";
  // $mail_body_1 .= "下記の通り、サービスの予約申請を受付しました。\n";
  // $mail_body_1 .= "本メールの時点では、まだ予約は確定されていません。\n";
  // $mail_body_1 .= "予約が「確定」もしくは「キャンセル」となった場合に、再度メールが送付されますのでご確認ください。\n\n";
  // $mail_body_1 .= "◆ご予約内容:\n";
  // $mail_body_1 .= $_POST['reservation_name'] . "\n";
  // $mail_body_1 .= "◆提供者:\n";
  // $mail_body_1 .= "グッドラーニング！\n";
  // $mail_body_1 .= "◆予約日時:\n";
  // $mail_body_1 .= $_POST['start_date'] . "(" . $_POST['start_week'] . ") 08:00 ~ 20:00 (予約人数:" . $_POST['count'] . ")\n";
  // $mail_body_1 .= "◆金額:\n";
  // $mail_body_1 .= $price . "円\n";
  // $mail_body_1 .= "◆「グッドラーニング！初任運転者講習（受講開始日で予約、最長７日間まで受講可能）」について:\n";
  // $mail_body_1 .= "受講開始日より最長７日間、任意の時間に受講することができます。\n";
  // $mail_body_1 .= "～～～～～講座内容～～～～～\n";
  // $mail_body_1 .= "◆講座内容は国交省の「初任運転者に対する特別な指導」により規定されている１２項目です。\n";
  // $mail_body_1 .= "◆実際の車両を用いて行う指導項目は含まれていません。\n";
  // $mail_body_1 .= "◆国土交通省の定める必要学習時間１５時間のうちの１２時間に相当します。\n";
  // $mail_body_1 .= "◆講座は全部で１５講座あります。\n";
  // $mail_body_1 .= "～～～～～受講開始までの流れ～～～～～\n";
  // $mail_body_1 .= "◆予約「確定」のメールのあとに、グッドラーニング！運営事務局より受講案内メールが届きます。\n";
  // $mail_body_1 .= "◆受講開始日になりましたら、受講案内にしたがって受講を開始してください。\n";
  // $mail_body_1 .= "◆受講期間は７日間です。７日以内にすべての講座を受講して下さい。\n";
  // $mail_body_1 .= "◆◆◆グッドラーニング！運営事務局◆◆◆\n";
  // $mail_body_1 .= "株式会社キャブステーション　ICTソリューション事業部\n";
  // $mail_body_1 .= "TEL：03-6880-1072　FAX：03-6880-1075\n";
  // $mail_body_1 .= "Mail：icts01@cab-station.com\n";


   $inquiry_content = "申し込み情報\n";
   $inquiry_content .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
   $inquiry_content .= "予約内容\n";
   $inquiry_content .= "【" . $_POST["reservation_name"] . "】\n";
   $inquiry_content .= "講座期間:" . $_POST["start_date"] .'〜'. $_POST["end_date"] . "\n";
   $inquiry_content .= "予約人数:" . $_POST["count"] .'人'. "\n\n";

   $inquiry_content .= "お客様情報\n";
   $inquiry_content .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
   $inquiry_content .= "氏名:" . $_POST["name"] . "様\n";
   $inquiry_content .= "メールアドレス:". $_POST["email"] . "\n";
   $inquiry_content .= "会社名:". $_POST["company_name"] . "\n";
   $inquiry_content .= "営業所:" . $_POST["sales_office"] . "\n";
   $inquiry_content .= "電話番号:". $_POST["phone"] . "\n";


  // //2通のメールのそれぞれの本文
  $mail_body_2 = "齋藤様\n\n";
  $mail_body_2 .= "このメールはシステムから自動送信しています。\n";
  $mail_body_2 .= "「グッドラーニング！」から予約が入りました。\n\n\n";
  $mail_body_2 .= $inquiry_content;


  //メールの作成
  $mail_to_2	= "yuto.fukaya@cab-station.com";
  $mail_subject_2	= "【グッドラーニング】予約確認メール";
  $mail_header_2	= "from:" . $mail ;

  $mail_to_1	= $mail;
  // $mail_subject_1	= "[予約完了メール] グッドラーニング";
  $mail_header_1	= "from:icts01@cab-station.com";



  //メールの作成
  $mail_to	= "yuto.fukaya@cab-station.com";
  $mail_subject	= "【グッドラーニング】予約確認メール";
  $mail_header	= "from:" . $mail ;


  //メール送信処理
  mb_language("Japanese");
  mb_internal_encoding("UTF-8");

  $mailsousin_1 = mb_send_mail($mail_to_1, $mail_subject_1, $mail_body_1, $mail_header_1);
  $mailsousin_2 = mb_send_mail($mail_to_2, $mail_subject_2, $mail_body_2, $mail_header_2);



  $adress_id = getAdressId();
  $adress_id++;

  $res = adressListStore($adress_id, $account_id);

  if(!$res){
    die('1');
  }

  $title = $mail_subject_1;
  $mail_text = $mail_body_1;

  $email_content_id = emailContentStore($title, $mail_text,$adress_id);

  if(empty($email_content_id)){
    die('2');
  }

  $res = emailStore($email_content_id);

  if(!$res){
    die('3');
  }

}

$_SESSION['flg'] = 1;


?>





<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>
      初任運転者講習受講予約｜トラックドライバー教育のクラウド型eラーニング【グッドラーニング!】
    </title>
    <meta
      name="title"
      content="初任運転者講習受講予約｜トラックドライバー教育のクラウド型eラーニング【グッドラーニング!】"
    />
    <meta
      name="description"
      content="グッドラーニング！についての初任運転者講習受講予約はこちらから受け付けております。お気軽にお問合せください。"
    />
    <meta
      name="keywords"
      content="乗務員,教育,講習,Eラーニング,指導,国交省,トラック,運送業,グッドラーニング"
    />
    <meta
      property="og:title"
      content="初任運転者講習受講予約｜トラックドライバー教育のクラウド型eラーニング【グッドラーニング!】"
    />
    <meta property="og:type" content="article" />
    <meta
      property="og:url"
      content="http://localhost:8888/truck/reserve/"
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
      content="初任運転者講習受講予約はこちらから受け付けております。お気軽にお問合せください。"
    />
    <link
      rel="canonical"
      href="http://localhost:8888/truck/reserve/"
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
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WHJMK5S');</script>
<!-- End Google Tag Manager -->
  </head>

  <body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WHJMK5S"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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
      </header>
      <!-- //header -->
      <!-- main// -->
      <main>
        <div id="pageTit">
          <h1>初任運転者講習受講予約</h1>
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
              <li>初任運転者講習受講予約</li>
            </ol>
          </div>
        </div>
        
        <div class="inner">
          <div id="contact" class="thanks">
            <h2>初任運転者講習のご予約、承りました。</h2>
            <p class="thanksTxt">
            この度は「初任運転者講座」をお申し込みいただき、誠にありがとうございます。<br />
              <br />
              <b>折り返し、弊社担当より連絡申し上げます。今しばらくお待ちくださいませ。</b><br />
              <br />
              なお、入力いただいたメールアドレス宛に受付完了メールを配信致しました。<br />
              しばらくの時間が経過しても受付完了メールが届かない場合、処理が正常に行われていない可能性、メールアドレスの相違などが考えられます。<br /><br />大変お手数ではございますが、弊社まで連絡を頂戴できれば幸いです。<br />電話：03-6880-1064（平日 9:30〜17:30）
            </p>
          </div>
        </div>
      </main>
      <!-- //main -->
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
    
  </body>
</html>
