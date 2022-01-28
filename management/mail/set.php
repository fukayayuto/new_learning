<?PHP
header('Content-type: application/json; charset=utf-8'); // ヘッダ（データ形式、文字コードなど指定）
require_once "../db/mail_template.php";
require_once "../db/accounts.php";
ini_set('display_errors', "On");

$id = $_POST['select'];
$account_id = $_POST['account_id'];


$template_data = getMailTemplate($id);

$account = getAccount($account_id);

$title = $template_data['title'];
$text = $template_data['text'];

$data = array();
$data['title'] = $title;
$data['text'] = $text;

$company_name = $account[0]['company_name'];

$search = array('{{会社名}}');
$replace = array($company_name);
$data['text'] = str_replace($search, $replace, $data['text']);


echo json_encode($data); //　echoするとデータを返せる（JSON形式に変換して返す）