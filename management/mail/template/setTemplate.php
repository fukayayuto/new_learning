<?PHP
header('Content-type: application/json; charset=utf-8'); // ヘッダ（データ形式、文字コードなど指定）
 
echo json_encode($param); //　echoするとデータを返せる（JSON形式に変換して返す）