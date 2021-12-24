<?php

ini_set('display_errors', "On");
require "../db/reservation_settings.php"; 
require "../db/entries.php"; 

$reservation_data = getAllData();
$data = array();

foreach ($reservation_data as $k => $val) {
    $tmp = array();
    $tmp['id'] = $val['id'];
    $tmp['start_date'] = $val['start_date'];
    $tmp['progress'] = $val['progress'];
    $tmp['count'] = $val['count'];
    $tmp['updated_at'] = $val['updated_at'];
    $tmp['display_flg'] = $val['display_flg'];
    $tmp['place_id'] = $val['place'];
    $tmp['place'] = '';

    switch ($val['place']) {
        case 1:
            $tmp['place'] = '初任者講習(会員)';
            break;
        case 2:
            $tmp['place'] = '初任者講習(非会員)';
            break;
        case 11:
            $tmp['place'] = '三重会場';
            break;
        case 21:
            $tmp['place'] = '京都会場';
            break;
        default:
            break;
    }



    $entry = getEntry($val['id']);
    $count = 0;
  
    if(!empty($entry)){
        foreach ($entry as $item) {
            $count = $count + $item['count'];
        }
    }
    $tmp['left_seat'] = $val['count'] - $count;

    $data[$k] = $tmp;
    
}



?>


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

    <a href="/management/"><button>管理画面一覧へ戻る</button></a><br>
    <a href="/management/reservation/calendar/"><button>カレンダー表示</button></a>

    <div class="container">
        <form action="store.php" method="post">
            <select name="place" id="place">
                <option value="1">初任者講習</option>
                <option value="11">三重県会場</option>
                <option value="21">京都会場</option>
            </select>
            開始日：<input type="date" name="start_date" id="start_date" required>
            所用日数：<input type="number" name="progress" id="progress" min="1" max="100" required>
            席数：<input type="number" name="count" id="count" min="1" max="100" required>
            <button class="submit">新規登録</button>
        </form>
    </div>


    <div class="container" id="users">
        <table class="table">
            <thead>
                <tr class="success">
                    <th>ID</th>
                    <th>予約会場</th>
                    <th class="sort" data-sort="id">開始日</th>
                    <th>所用日数</th>
                    <th>定員枠</th>
                    <th>残り定員枠</th>
                    <th>更新日時</th>
                    <th>表示フラグ</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($data as $val):?>
                <tr>
                    <td><?php echo $val['id'];?></td>
                    <td><?php echo $val['place'];?></td>
                    <td><?php echo $val['start_date'];?></td>
                    <td><?php echo $val['progress'];?></td>
                    <td><?php echo $val['count'];?></td>
                    <td><?php echo $val['left_seat'];?></td>
                    <td><?php echo $val['updated_at'];?></td>
                    
                    <?php if($val['display_flg'] == 1) :?>
                        <td>表示</td>
                    <?php else :?>
                        <td>非表示</td>
                    <?php endif;?>

                    <td><a href="/management/reservation/entry?id=<?php echo $val['id'];?>"><button>エントリー表示</button></a></td>

                    <?php if($val['place_id'] == 2) :?>
                        <td></td>
                    <?php else :?>
                        <td><a href="/management/reservation/detail?id=<?php echo $val['id'];?>"><button>変更</button></a></td>
                    <?php endif;?>

                </tr>
                <?php endforeach;?>
            </tbody>



          
        </table>
    </div>
</body>
<script src="https://www.w3schools.com/lib/w3.js"></script>
    <script>
        var options = {
          valueNames: [ 'id', 'name']
        };
        
        var userList = new List('users', options);
        
        // 初期状態はidで昇順ソートする
        userList.sort( 'id', {order : 'asc' });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/jquery.tablesorter.min.js"> --}}


</html>
