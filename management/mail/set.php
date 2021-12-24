<?PHP
header('Content-type: application/json; charset=utf-8'); // ヘッダ（データ形式、文字コードなど指定）
require_once "../db/mail_template.php";

$id = $_POST['select'];

$template_data = getMailTemplate($id);

$title = $template_data['title'];
$text = $template_data['text'];

$data = array();
$data['title'] = $title;
$data['text'] = $text;

echo json_encode($data); //　echoするとデータを返せる（JSON形式に変換して返す）