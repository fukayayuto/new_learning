<html lang="ja">

<head>
    <title>グットラーニング管理画面</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">
    <link href="../example.css" rel="stylesheet">
    <link href='http://localhost:8888/management/fullcalendar-5.10.1/lib/main.css' type="text/css" rel='stylesheet' />
    <link href='http://localhost:8888/management/fullcalendar-5.10.1/lib/main.min.css' type="text/css" rel='stylesheet' />

    <script src="http://localhost:8888/management/fullcalendar-5.10.1/lib/main.js"></script>
    <script src="http://localhost:8888/management/fullcalendar-5.10.1/lib/main.min.js"></script>

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
                    <h1 class="h2">インフォメーション作成</h1>
                </div>

                <div>
                    <form class="needs-validation" action="store.php" method="post" id="form">

                        <table class="table">

                            <tr>
                                <td style="width: 20%">掲載日</td>
                                <td><input type="date" class="form-control" id="publish_date" name="publish_date" required>
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 20%">タイトル</td>
                                <td>
                                    <input type="text" class="form-control" id="title" name="title" required>

                                </td>
                            </tr>

                            <tr>
                                <td style="width: 20%">リンク部分</td>
                                <td>
                                    <input type="text" class="form-control" id="link_part" name="link_part">
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 20%">リンクURL</td>
                                <td> <input type="text" class="form-control" id="link" name="link">
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 20%">表示フラグ</td>
                                <td>
                                    <select name="display_flg" id="display_flg" class="form-control">
                                        <option value="0">非表示</option>
                                        <option value="1" selected>表示</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 20%">優先度</td>
                                <td>
                                    <select name="priority" id="priority" class="form-control">
                                        <option value="0">通常</option>
                                        <option value="1">優先</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 20%">外部へのリンク</td>
                                <td>
                                    <select name="blank_flg" id="blank_flg" class="form-control">
                                        <option value="0">使用しない</option>
                                        <option value="1">使用</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td> <button type="submit" class="btn btn-success">登録する</button></td>
                            </tr>


                        </table>


                    </form>
                </div>



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
                
                const url = $("#link").val();
                const link_part = $("#link_part").val();

   
                if(link_part == '' && url != ''){
                    alert('リンク部分とURL両方に記載してください');
                    return false;
                }

                if(link_part != '' && url == ''){
                    alert('リンク部分とURL両方に記載してください');
                    return false;
                }
           
               
                if (window.confirm('この内容で登録しますか?')) {
                    return true;
                } else {
                    return false;
                }
            });
        });
    </script>

  
</body>

</html>