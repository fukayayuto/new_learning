<?php
// defineの値は環境によって変えてください。
define('HOSTNAME', 'localhost');
define('DATABASE', 'e_learning');
define('USERNAME', 'root');
define('PASSWORD', 'root');

$id = 2;

try {
  /// DB接続を試みる
  $pdo  = new PDO('mysql:host=' . HOSTNAME . ';dbname=' . DATABASE, USERNAME, PASSWORD);
  $msg = "MySQL への接続確認が取れました。";
} catch (PDOException $e) {
  $isConnect = false;
  $msg       = "MySQL への接続に失敗しました。<br>(" . $e->getMessage() . ")";
}

// (3) SQL作成
$stmt = $pdo->prepare("SELECT * FROM reservation_settings WHERE id = :id");

// (4) 登録するデータをセット
$stmt->bindParam( ':id', $id, PDO::PARAM_INT);

// (5) SQL実行
$res = $stmt->execute();

if( $res ) {
	$data = $stmt->fetch();
}


?>
