<?php
ini_set('display_errors', "On");
require "../../../db/reservation_settings.php";
require "../../../db/entries.php";
require "../../../db/accounts.php";
require "../../../db/mail.php";
require "../../../db/information.php";

if (isset($_GET['id'])) {
  $id = (int) $_GET['id'];
}

if (!empty($_GET['res'])) {
  $res = $_GET['res'];
}

$information_data = selectInformation($id);


?>


<html lang="ja">

<head>
  <title>グットラーニング管理画面</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  <link href="dashboard.css" rel="stylesheet">
  <link href="../example.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


</head>

<body>

  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="/management">
                <span data-feather="home"></span>
                <!-- Dashboard <span class="sr-only">(current)</span> -->
                ホーム <span class="sr-only">(現在位置)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/management/reserve">
                <span data-feather="file"></span>
                <!-- Orders -->
                予約講座
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/management/account">
                <span data-feather="users"></span>
                <!-- Products -->
                顧客
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/management/mail">
                <span data-feather="mail"></span>
                <!-- Customers -->
                メール配信
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/management/information">
                <span data-feather="bar-chart-2"></span>
                <!-- Reports -->
                インフォメーション
              </a>
            </li>
            <li>
              <a class="nav-link" href="/management/adopt">
                <span data-feather="layers"></span>
                <!-- Reports -->
                実績
              </a>
            </li>
            <li>
              <a class="nav-link" href="/management/introducer/">
                <span data-feather="user"></span>
                <!-- Reports -->
                紹介者
              </a>
            </li>
          </ul>


      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <!-- <h1 class="h2">Dashboard</h1> -->
          <h1 class="h2">インフォメーション詳細変更画面</h1>
          <a href="/management/information/bus/"><button　type="button" class="btn btn-primary">インフォメーション一覧へ</button></a>

        </div>


        <div class="container">

          <form method="POST" action="change.php" id="form">

            <table class="table">
              <input type="hidden" name="id" value="<?php echo $information_data[0]['id']; ?>">

              <tr>
                <td style="width: 20%">掲載日</td>
                <td><input type="date" class="form-control" id="publish_date" name="publish_date" value="<?php echo $information_data[0]['publish_date']; ?>" required>
                </td>
              </tr>

              <tr>
                <td style="width: 20%">タイトル</td>
                <td>
                  <input type="text" class="form-control" id="title" name="title" value="<?php echo $information_data[0]['title']; ?>" required>

                </td>
              </tr>

              <tr>
                <td style="width: 20%">リンク部分</td>
                <td>
                  <input type="text" class="form-control" id="link_part" name="link_part" value="<?php echo $information_data[0]['link_part']; ?>">

                </td>
              </tr>

              <tr>
                <td style="width: 20%">リンクURL</td>
                <td> <input type="text" class="form-control" id="link" name="link" value="<?php echo $information_data[0]['link']; ?>">
                </td>
              </tr>

              <tr>
                <td style="width: 20%">表示フラグ</td>
                <td>
                  <select name="display_flg" id="display_flg" class="form-control">
                    <option value="0" <?php if ($information_data[0]['display_flg'] == 0) {
                                        echo 'selected';
                                      } ?>>非表示</option>
                    <option value="1" <?php if ($information_data[0]['display_flg'] == 1) {
                                        echo 'selected';
                                      } ?>>表示</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td style="width: 20%">優先度</td>
                <td>
                  <select name="priority" id="priority" class="form-control">
                    <option value="0" <?php if ($information_data[0]['priority'] == 0) {
                                        echo 'selected';
                                      } ?>>通常</option>
                    <option value="1" <?php if ($information_data[0]['priority'] == 1) {
                                        echo 'selected';
                                      } ?>>優先</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td style="width: 20%">外部へのリンク</td>
                <td>
                  <select name="blank_flg" id="blank_flg" class="form-control">
                    <option value="0" <?php if ($information_data[0]['blank_flg'] == 0) {
                                        echo 'selected';
                                      } ?>>使用しない</option>
                    <option value="1" <?php if ($information_data[0]['blank_flg'] == 1) {
                                        echo 'selected';
                                      } ?>>使用</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>更新時間</td>
                <td>
                  <label><?php echo $information_data[0]['updated_at']; ?></label>
                </td>
              </tr>

              <tr>
                <td></td>
                <td> <button type="submit" class="btn btn-primary">変更</button></td>
              </tr>

              <tr>
                <td></td>
                <td> <button type="button" id="del" class="btn btn-danger">削除</button></td>
              </tr>

          </form>
          </table>







      </main>
    </div>
  </div>


  <!-- Icons -->
  <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
  <script>
    feather.replace()
  </script>

  <!-- Graphs -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script>
    window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery-slim.min.js"><\/script>')
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
  <script src="/docs/4.4/assets/js/vendor/anchor.min.js"></script>
  <script src="/docs/4.4/assets/js/vendor/clipboard.min.js"></script>
  <script src="/docs/4.4/assets/js/vendor/bs-custom-file-input.min.js"></script>
  <script src="/docs/4.4/assets/js/src/application.js"></script>
  <script src="/docs/4.4/assets/js/src/search.js"></script>
  <script src="/docs/4.4/assets/js/src/ie-emulation-modes-warning.js"></script>
  <script>
    $(function() {
      $("#form").submit(function() {
        if (window.confirm('この内容で変更しますか')) {
          return true;
        } else {
          return false;
        }
      });
    });
  </script>
  <script>
    $(function() {
      var res = <?php echo $res; ?>;
      if (res == 1) {
        swal('インフォメーションを変更しました');
      }
      if (res == 2) {
        swal('インフォメーションの変更に失敗しました');
      }
    });
  </script>
    <script>
    $("#del").click(function() {
      const id = <?php echo $information_data[0]['id'];?>;

      if (confirm('こちらのインフォメーションを削除してもよろしいでしょうか？')) {
        window.location.href = 'https://promote.good-learning.jp/management/information/bus/delete.php?id=' + id;
      } else {

      }

    });
  </script>
</body>

</html>


<!-- 
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理画面</title>
</head>

<body>
    <div class="container">
        <br>
        <a href="/management/reservation/">予約管理画面</a><br>
        <a href="/management/information/">インフォメーション管理画面</a><br>
        <a href="/management/user/">ユーザー管理画面</a><br>
        <a href="/management/mail/">メール管理画面</a><br>
    </div>
</body>

</html> -->