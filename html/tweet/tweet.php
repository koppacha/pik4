<?php
session_start();

// 各種設定
require "../twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;


date_default_timezone_set('Asia/Tokyo');			// 標準時

// エラー非表示
ini_set('display_errors', 0);

$mysql_host = DATABASE_DOMAIN;
$mysql_user = DATABASE_USER;
$mysql_pass = DATABASE_PASS;
$mysql_db   = DATABASE_USER;
$mysqlconn = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);
if ( $mysqlconn == false) {
	die ("<br/>エラー715：Database Connection Error. ");
}
$result = mysqli_query($mysqlconn, 'SET NAMES utf8');
if (!$result) {
	exit('<br/>エラー719：文字コードを指定できませんでした。');

// Twitter APIで取得した情報をHTML変換 参考：http://qiita.com/yokoh9/items/760e432ebd39040d5a0f
function disp_tweet($value, $text){
    $icon_url = $value->user->profile_image_url;
    $screen_name = $value->user->screen_name;
    $updated = date('Y/m/d H:i', strtotime($value->created_at));
    $tweet_id = $value->id_str;
    $url = 'https://twitter.com/' . $screen_name . '/status/' . $tweet_id;

    echo '<div class="tweetbox">' . PHP_EOL;
    echo '<div class="thumb">' . '<img alt="" src="' . $icon_url . '">' . '</div>' . PHP_EOL;
    echo '<div class="meta"><a target="_blank" href="' . $url . '">' . $updated . '</a>' . '<br>@' . $screen_name .'</div>' . PHP_EOL;
    echo '<div class="tweet">' . $text . '</div>' . PHP_EOL;
    echo '</div>' . PHP_EOL;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja">
<head>
	<title><?php echo $header_stage_title; ?>SandBox - pik4.chr.mn</title>
	<Meta Name="description" Content="" />
	<Meta Name="keywords"    Content="" />
	<Meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<Meta http-equiv="Content-script-Type" content="text/javascript" />
</head>
<body>
<?php
if(isset($_POST['send'])){
		$pik4_api_key = TWITTER_API_KEY;
		$pik4_api_skey= TWITTER_API_SKEY;
		$pik4_access_token = $_SESSION['access_token']['oauth_token'];
		$pik4_access_stoken = $_SESSION['access_token']['oauth_token_secret'];

		if($_SESSION['access_token']['oauth_token']){
		if($old_entry == 1) $update_flag = '自己ベスト更新！';
		if($old_entry == 0) $update_flag = 'ニューレコード！';
		if($old_entry == 0) $old_score = 0;
		
		// ステージ名・URL・カテゴリを取得
		$tweet_post_url = 'http://pik4.chr.mn/'.$stage_id;
		$tweet_post_stage = $array_stage_title[$stage_id];
		$needle = strpos ($array_stage_title[$stage_id] , '#');
		if($needle > 0 ) $needle = $needle + 1;
		$fixed_stage_title = mb_substr ( $array_stage_title[$stage_id] , $needle );
		$tweet_post_cat = '';
		if($stage_id > 100 and $stage_id < 106 ) $tweet_post_cat = '[ピクミン1]';
		if($stage_id > 200 and $stage_id < 231 ) $tweet_post_cat = '[ピクミン2]';
		if($stage_id > 230 and $stage_id < 245 ) $tweet_post_cat = '[本編地下]';
		if($stage_id > 244 and $stage_id < 275 ) $tweet_post_cat = '[日替わり]';
		if($stage_id > 300 and $stage_id < 337 ) $tweet_post_cat = '[ピクミン3]';
		if($stage_id >1000 and $stage_id <10000) $tweet_post_cat = '[期間限定]';
		if($stage_id >10000and $stage_id <99999) $tweet_post_cat = '[本編]';

//		$tweet = '#ピクチャレ大会 '.$update_flag.' '.$tweet_post_cat.$fixed_stage_title.' ('.number_format($old_score).' → '.number_format($score).'pts) '.htmlspecialchars($post_comment, ENT_QUOTES).' '.$tweet_post_url;
		$tweet = 'サンドボックスから送信テスト！';
		$twObj = new TwitterOAuth($pik4_api_key, $pik4_api_skey , $pik4_access_token, $pik4_access_stoken);
		$result = $twObj->post("statuses/update", array("status" => $tweet));
		if($result['errors']['code'] == 89){
			echo '<br/>エラーTw89：Twitter連携トークンの期限切れです。';
		} else {
			echo '<br/> Twitterへの投稿に成功しました。';
		}
		} else {
		echo '<br/> Twitterへの投稿エラーが発生しています。';
		}
}

	if(!isset($_SESSION['access_token'])){
		echo '<i class="fa fa-twitter" aria-hidden="true"></i><a href="pik4_login.php">Twitterでログイン</a>';
	}else{
		//callback.phpからセッションを受け継ぐ
//		echo "<p>Twitterでログイン中：(". $_SESSION['id'] . ")</p>";
//		echo "<p>Twitterでログイン中：(". $_SESSION['name'] . ")</p>";
		echo '<span style="font-size:0.8em;">Twitterでログイン中：(@'. $_SESSION['screen_name'] . ")</span><br/>";
//		echo "<p>最新ツイート：" .$_SESSION['text']. "</p>";
//		echo "<p><img src=".$_SESSION['profile_image_url_https']."></p>";
//		echo "<p>access_token：". $_SESSION['access_token']['oauth_token'] . "</p>";
		echo '<i class="fa fa-twitter" aria-hidden="true"></i><a href="pik4_logout.php">ログアウト</A>';
	}
	$pik4_api_key = TWITTER_API_KEY;
	$pik4_api_skey= TWITTER_API_SKEY;
	$pik4_access_token = $_SESSION['access_token']['oauth_token'];
	$pik4_access_stoken = $_SESSION['access_token']['oauth_token_secret'];
	$twObj = new TwitterOAuth($pik4_api_key, $pik4_api_skey , $pik4_access_token, $pik4_access_stoken);
	$tweet = $twObj->get("search/tweets", array("q" => "a", 'count' => 10));
	foreach ($tweet as $value) {
	    $text = htmlspecialchars($value->text, ENT_QUOTES, 'UTF-8', false);
	    echo $text;
	    // 検索キーワードをマーキング
	    $keywords = preg_split('/,|\sOR\s/', $tweets_params['q']); //配列化
	foreach ($keywords as $key) {
		$text = str_ireplace($key, '<span class="keyword">'.$key.'</span>', $text);
	}
	// ツイート表示のHTML生成
		disp_tweet($value, $text);
	}
	$test = 56+44;
	echo $test;
	$mysqlconn = mysqli_close($mysqlconn);
?>
<form action="#" method="post"><input type="submit" name="send" value="Enter"></form>
</body>
</html>
