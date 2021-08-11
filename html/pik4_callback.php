<?php
ini_set('display_errors', 0);
ini_set( 'session.gc_maxlifetime', 7776000 );
session_save_path('/home/users/0/chronon/web/chr.mn/_session');
session_start();

define("Consumer_Key", "g8DNcIpCm9LOJMN2x6PKekTPz");
define("Consumer_Secret", "LF2waTjwrFG9dubT8FqJnumzUF11mX1EMb8AkTpa3OkTmqKws8");

//ライブラリを読み込む
require "twitteroauth/autoload.php";
require "ca-bundle-master/src/CaBundle.php";
use Abraham\TwitterOAuth\TwitterOAuth;

// データベースに接続
$mysql_host = "mysql506.heteml.jp";
$mysql_user = "_pik4";
$mysql_pass = "a21586hhwxj7egk";
$mysql_db   = "_pik4";

$mysqlconn = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);
if ( $mysqlconn == false) {
	die ("<br/>エラー715：Database Connection Error. ");
}
$result = mysqli_query($mysqlconn, 'SET NAMES utf8');
if (!$result) {
	exit('<br/>エラー719：文字コードを指定できませんでした。');
}

//oauth_tokenとoauth_verifierを取得
if($_SESSION['oauth_token'] == $_GET['oauth_token'] and $_GET['oauth_verifier']){
	
	//Twitterからアクセストークンを取得する
	$connection = new TwitterOAuth(Consumer_Key, Consumer_Secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	$access_token = $connection->oauth('oauth/access_token', array('oauth_verifier' => $_GET['oauth_verifier'], 'oauth_token'=> $_GET['oauth_token']));

	//取得したアクセストークンでユーザ情報を取得
	$user_connection = new TwitterOAuth(Consumer_Key, Consumer_Secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$user_info = $user_connection->get('account/verify_credentials');
	
	//適当にユーザ情報を取得
	$id = $user_info->id;
	$name = $user_info->name;
	$screen_name = $user_info->screen_name;
	$profile_image_url_https = $user_info->profile_image_url_https;
	$text = $user_info->status->text;
	
	//各値をセッションに入れる
	$_SESSION['access_token'] = $access_token;
	$_SESSION['id'] = $id;
	$_SESSION['name'] = $name;
	$_SESSION['screen_name'] = $screen_name;
	$_SESSION['text'] = $text;
	$_SESSION['profile_image_url_https'] = $profile_image_url_https;

	// DBに登録
//	$tat = $access_token['oauth_token'];
//	$tats= $access_token['oauth_token_secret'];
//	$up_query ="UPDATE `user` SET `twitter_access_key` = '$tat', `twitter_access_skey` = '$tata' WHERE `user_name` = '★★★★★' ";
//	$up_result = mysqli_query($mysqlconn, $up_query );


	$mysqlconn = mysqli_close($mysqlconn);

	header('Location: https://chr.mn/pik4/'.$_SESSION['now_stage_id']);
	exit();
}else{
	header('Location: https://chr.mn/pik4/'.$_SESSION['now_stage_id']);
	exit();
}