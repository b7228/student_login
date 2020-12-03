<?php
// アプリケーション設定
define('CONSUMER_KEY', '37320831151-qmejbqa1lv9t3bescsof9b7s96r5crnk.apps.googleusercontent.com');
define('CALLBACK_URL', 'http://localhost/test/oauth.php');

// URL
define('AUTH_URL', 'https://accounts.google.com/o/oauth2/auth');


$params = array(
	'client_id' => CONSUMER_KEY,
	'redirect_uri' => CALLBACK_URL,
	'scope' => 'https://www.googleapis.com/auth/userinfo.profile email',
	'response_type' => 'code',
);


// 認証ページにリダイレクト
header("Location: " . AUTH_URL . '?' . http_build_query($params));
?>