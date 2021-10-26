<?php

require_once('_def.php');

$back_data = '';

if(isset($_POST['minites_count']) and isset($_COOKIE['user_name'])){

$get_minites = $_POST['minites_count'];		// タマゴムシの数
$get_egg = $_POST['egg'];			// 割ったタマゴの数
$get_date = $_POST['date'];			// 投稿日時
$get_name = $_COOKIE['user_name'];		// 名前を取得

// データベース接続情報
if($_SERVER['SERVER_NAME'] != 'localhost'){
	// Heteml DataBase Server Connection
	$mysql_host = DATABASE_DOMAIN;
	$mysql_user = DATABASE_USER;
	$mysql_pass = DATABASE_PASS;
	$mysql_db   = DATABASE_USER;
	// XAMPP Local Server Connection
} else {
	$mysql_host = "127.0.0.1";
	$mysql_user = "root";
	$mysql_pass = "";
	$mysql_db   = "pik4";
}
$conn = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);
	if ( $conn == false) {
		die ("p-1：Database Connection Error. ");
	}
	// クッキーに基づいてユーザー情報を取得
	$sql = "SELECT * FROM `user` WHERE `user_name` = '$get_name'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if( !$result){
		die('ポイントの取得に失敗');
	}
	$min_pass = $row['pass'];

	// クッキーに保存されているパスワードを復号
	if (isset($_COOKIE['password'])) {
	$cookie_flag	= 1;
	$set_cookiepass	= $_COOKIE['password'];
	$randpass	= COOKIE_CRYPT;//乱数種を設定
	$iv		= openssl_random_pseudo_bytes( 8 );	//ランダムバイトを設定 
	$raw_output	= false;				//Base64で出力
	$method		='aes-256-ecb';				//AES256bitで暗号化
	$cookie_pass = openssl_decrypt($set_cookiepass, $method, $randpass);
	}

	// データベースのパスワードを複合
	$randpass	= PASS_CRYPT;//乱数種を設定
	$iv		= openssl_random_pseudo_bytes( 8 );	//ランダムバイトを設定 
	$raw_output	= false;				//Base64で出力
	$method		='aes-256-ecb';				//AES256bitで暗号化

	if ($min_pass != ""){
	$decrypt_flag	= 1;
	$decode_pass = openssl_decrypt($min_pass, $method, $randpass);
	}

	if ($cookie_pass === $decode_pass and $cookie_flag == $decrypt_flag){

	// 残TPを取得し、1減らして更新する
	$lest_tp = $row["tp"];

	if($lest_tp > 0){

	$lest_tp = $lest_tp - 1;

	$sql = "UPDATE `user` SET `tp` = '$lest_tp' WHERE `user_name` = '$get_name'";
	$result = mysqli_query($conn, $sql);
	if( !$result){
		die('ポイントの更新に失敗');
	}

	// タマゴムシくじデータベースへ登録
	$sql = "INSERT INTO minites (`minites_count`, `egg`, `date`, `name`) VALUES ('$get_minites', '$get_egg', '$get_date', '$get_name')";
	$result = mysqli_query($conn, $sql);
	if( !$result){
		die('クエリの送信に失敗');
	}

	// 自己ベストを取得
	$sql = "SELECT * FROM `minites` WHERE `name` = '$get_name' ORDER BY `minites_count` DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if( !$result){
		die('ポイントの取得に失敗');
	}
	$my_best_minites = $row["minites_count"];

	// 最高記録を取得
	$sql = "SELECT * FROM `minites` ORDER BY `minites_count` DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if( !$result){
		die('ポイントの取得に失敗');
	}
	$all_best_minites = $row["minites_count"];
	$all_best_player = $row["name"];

	$back_data = "残りTP：".$lest_tp."<br/>あなたの最高記録：".$my_best_minites."<br/>みんなの最高記録：".$all_best_minites." (".$all_best_player.")<br/>";

	} else {

	$back_data = "タマゴムシポイントが足りません！";
	}

	} else {
	$back_data = "パスワード照合エラー";
	}

	mysqli_close($conn);

} else {
$back_data = "ユーザー情報が存在しないため記録の保存に失敗しました... （最低１回以上ランキングに参加し、クッキーを保存する必要があります）";

}

header('Content-Type: application/json; charset=utf-8');

echo json_encode($back_data);
?>