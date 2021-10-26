<?php
if(@$_POST['formtype'] == 1){
	// Cookieをセットする
	setcookie('user_name', $_POST['user_name'], time()+60*60*24*30*120);
	$_COOKIE['user_name'] = $_POST['user_name'];
	setcookie('user_name_2p', $_POST['user_name_2p'], time()+60*60*24*30*120);
	$_COOKIE['user_name_2p'] = $_POST['user_name_2p'];		// クッキーに保存するパスワードを暗号化
	$set_cookiepass	= $_POST['password'];
	$randpass	= COOKIE_CRYPT; //乱数種を設定
	$iv		= openssl_random_pseudo_bytes( 8 );	//ランダムバイトを設定
	$raw_output	= false;				//Base64で出力
	$method		='aes-256-ecb';				//AES256bitで暗号化

	if ($_POST['password'] != ""){
		$cookiepass = openssl_encrypt($set_cookiepass, $method, $randpass);
	}

	setcookie('password', $cookiepass, time()+60*60*24*30*120);
	$_COOKIE['password'] = $cookiepass;
	setcookie('console', $_POST['console'], time()+60*60*24*30*120);
	$_COOKIE['console'] = $_POST['console'];
	setcookie('console_2p', $_POST['console_2p'], time()+60*60*24*30*120);
	$_COOKIE['console_2p'] = $_POST['console_2p'];
	if(isset($_POST['post_twitter'])){
		setcookie('post_twitter', $_POST['post_twitter'], time()+60*60*24*30*120);
		$_COOKIE['post_twitter'] = $_POST['post_twitter'];
	}
}

// クッキー（COOKIE）からログイン中のユーザー名を取得
if (isset($_COOKIE['user_name'])) {
	$cookie_name = $_COOKIE["user_name"];
	$cookie_sql = "SELECT * FROM `user` WHERE `user_name` = '$cookie_name' LIMIT 1";
	$cookie_result = mysqli_query($mysqlconn, $cookie_sql);
	if($cookie_result) $cookie_row = mysqli_fetch_assoc($cookie_result);
} else {
	$cookie_name = '';
}
// クッキー（COOKIE）からログイン中のユーザー名を取得
if (isset($_COOKIE['user_name_2p'])) {
	$cookie_name_2p = $_COOKIE["user_name_2p"];
	$cookie_sql = "SELECT * FROM `user` WHERE `user_name` = '$cookie_name_2p' LIMIT 1";
	$cookie_result = mysqli_query($mysqlconn, $cookie_sql);
	if($cookie_result) $cookie_row2 = mysqli_fetch_assoc($cookie_result);
} else {
	$cookie_name_2p = '';
}
// クッキーに保存されているパスワードを復号
if (isset($_COOKIE['password'])) {
	$set_cookiepass	= $_COOKIE['password'];
	$randpass	= COOKIE_CRYPT; //乱数種を設定
	$iv		= openssl_random_pseudo_bytes( 8 );	//ランダムバイトを設定
	$raw_output	= false;				//Base64で出力
	$method		='aes-256-ecb';				//AES256bitで暗号化

	$cookie_pass = openssl_decrypt($set_cookiepass, $method, $randpass);
} else {
	$cookie_pass = '';
}

// スコア比較機能用COOKIE
if (isset($_POST['compare_check'])) {
	setcookie('compare_data', $_POST['compare_data'], time()+60*60*24*30*120);
	$_COOKIE['compare_data'] = $_POST['compare_data'];
}

// クッキーを各種変数に格納する（空の場合は0をセット）
$array_cookie = array(
		'formlock',
		'navlock',
		'watchmode',
		'console',
		'console_2p',
		'user_name_2p',
		'compare_data',
		'filtering_data',
		'filtering_sub_data',
		'season_data',
		'log_data',
		'notice_twitter',
		'movie_link',
		'diary_challenge',
		'latest_record',
		'nav_table',
		'retry_counter',
		'total_ranking',
		'starter_info',
		'sort_data',
		'pin_data',
		'history_id',
		'user_id'
		);
foreach($array_cookie as $val){
	if(isset($_COOKIE[$val])){
		${$val} = $_COOKIE[$val];
	} else {
		${$val} = 0;
	}
}
// Cookieを削除する
if (isset($_POST['del_id'])) {
	$array_cookie[] = "user_name";
	$array_cookie[] = "password";
	$array_cookie[] = "compare_data";
	$array_cookie[] = "post_twitter";

	foreach($array_cookie as $val){
		setcookie($val, '', time()+60*60*24*30*120);
		$_COOKIE[$val] = '';
	}
}