<?php
session_start();

// アプリケーション設定
define('CONSUMER_KEY', '37320831151-qmejbqa1lv9t3bescsof9b7s96r5crnk.apps.googleusercontent.com');
define('CONSUMER_SECRET', 'YbNjsEgj7JiZuZDiALcmGQGp');
define('CALLBACK_URL', 'http://localhost/test/oauth.php');

// URL
define('TOKEN_URL', 'https://accounts.google.com/o/oauth2/token');
define('INFO_URL', 'https://www.googleapis.com/oauth2/v1/userinfo');

$params = array(
	'code' => $_GET['code'],
	'grant_type' => 'authorization_code',
	'redirect_uri' => CALLBACK_URL,
	'client_id' => CONSUMER_KEY,
	'client_secret' => CONSUMER_SECRET,
);

$header = array(
    "Content-Type: application/x-www-form-urlencoded"
    );

// POST送信
$options = array('http' => array(
    'method' => 'POST',
    'header' => implode($header),
	'content' => http_build_query($params)
));



// アクセストークンの取得
$res = file_get_contents(TOKEN_URL, false, stream_context_create($options));

// レスポンス取得
$token = json_decode($res, true);
if(isset($token['error'])){
	echo 'エラー発生';
	exit;
}else{
	//ログインセッション
	$_SESSION['login'] = true;
}



$access_token = $token['access_token'];

$params = array('access_token' => $access_token);

// ユーザー情報取得
$res = file_get_contents(INFO_URL . '?' . http_build_query($params));

$result = json_decode($res, true);
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="style.css">
	<title>プロフィール取得</title>
</head>
<body>
	ログイン成功！
	<h2>ユーザー情報</h2>
	<table>
		<tr><td>ID</td><td><?php echo $result['id']; ?></td></tr>
		<tr><td>ユーザー名</td><td><?php echo $result['name']; ?></td></tr>
		<tr><td>苗字</td><td><?php echo $result['family_name']; ?></td></tr>
		<tr><td>名前</td><td><?php echo $result['given_name']; ?></td></tr>
		<tr><td>場所</td><td><?php echo $result['locale']; ?></td></tr>
		<tr><td>メールアドレス</td><td><?php echo $result['email']; ?></td></tr>
		<tr><td>ログイン状態</td><td><?php echo $_SESSION['login']; ?></td></tr>
	</table>
	<h2>プロフィール画像</h2>
	<img src="<?php echo $result['picture']; ?>" width="100">
</body>
</html>