<?php

require_once('_def.php');

$back_data = '';
$mysql_mode= 1 ;

if(isset($_POST['stage']) and isset($_COOKIE['user_name'])){

$now_time = time()+(0*24*60*60)+(0*60*60);	// 現在時刻
$one_day_ago = strtotime("-1day");		// 24時間前
$get_date  = 0;
$get_stage = 0;
$get_flag  = 0;
$get_date  = "2017-08-13 00:00:00";			// 投稿日時（デバッグ用）
$get_name  = $_COOKIE['user_name'];		// 名前を取得
$get_stage = $_POST['stage'];			// タマゴムシの数
$get_flag  = $_POST['flag'];			// フラグ
$get_count = $_POST['count'];			// カウント数
$last_update = 0;
// $get_date = $_POST['date'];			// 投稿日時
// $get_stage= 205;			// タマゴムシの数（デバッグ用）
// $get_flag = 9;			// フラグ（デバッグ用）

// データベース接続情報
if ($mysql_mode == 1){
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
	$mysql_db   = "pik4_ranking";
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
	$randpass	= COOKIE_CRYPT; //乱数種を設定
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
	if (($cookie_pass === $decode_pass and $cookie_flag == $decrypt_flag) or $get_flag == 9){

	if($get_flag != 9){
		$new_count = $get_count;
		$sql = "INSERT INTO `counter` (`user_name`, `stage_id`, `date`, `count`, `flag`) VALUES ('$get_name', '$get_stage', '$get_date', '$new_count', '$get_flag')";
		$result = mysqli_query($conn, $sql);
	}

	$today_count = 0;
	$total_count = 0;
	$clear_count = 0;
	$update_after_count = 0;
	$your_clear_count = 0;
	$stage_count = 0;

	// 今日のプレイ回数を算出
	$days = date('Y-m-d H:i:s', $one_day_ago);
	$sql = "SELECT * FROM `counter` WHERE `user_name` = '$get_name' AND `stage_id` = '$get_stage' AND `date` >= '$days'";
	$result = mysqli_query($conn, $sql);
	if($result){
		while($row = mysqli_fetch_assoc($result)){
			$today_count += $row["count"];
		}
	}

	// 累計プレイ回数を算出
	$sql = "SELECT * FROM `counter` WHERE `user_name` = '$get_name' AND `stage_id` = '$get_stage'";
	$result = mysqli_query($conn, $sql);
	if($result){
		while($row = mysqli_fetch_assoc($result)){
			$total_count += $row["count"];
		}
	}
	// このステージで最後に自己ベを出したIDを抽出
	$sql = "SELECT * FROM `counter` WHERE `user_name` = '$get_name' AND `stage_id` = '$get_stage' AND `flag` = 0";
	$result = mysqli_query($conn, $sql);
	if($result){
		while($row = mysqli_fetch_assoc($result)){
			$last_update = $row["id"];
		}
	} else {
		$last_update = 0;
	}

	// このステージで最後に自己ベを出したIDを抽出
	$update_after_count = 0;
	$sql = "SELECT * FROM `counter` WHERE `user_name` = '$get_name' AND `stage_id` = '$get_stage' AND `id` > '$last_update'";
	$result = mysqli_query($conn, $sql);
	if($result){
		while($row = mysqli_fetch_assoc($result)){
			$update_after_count += $row["count"];
		}
	}

	// このステージの合計プレイ回数を算出
	$sql = "SELECT * FROM `counter` WHERE `stage_id` = '$get_stage'";
	$result = mysqli_query($conn, $sql);
	if($result){
		while($row = mysqli_fetch_assoc($result)){
			$stage_count += $row["count"];
		}
	}

	// このステージのプレイヤーの自己ベ更新回数を算出
	$sql = "SELECT * FROM `counter` WHERE `user_name` = '$get_name' AND `stage_id` = '$get_stage' AND `flag` = '0'";
	$result = mysqli_query($conn, $sql);
	if($result){
		$your_clear_count = mysqli_num_rows($result);
	}
	
	if($total_count > 0){
		$your_clear_rate = round(($your_clear_count / $total_count)*100, 2);
	} else {
		$your_clear_rate = 0;
	}
	// このステージの自己ベ更新回数を算出
	$sql = "SELECT * FROM `counter` WHERE `stage_id` = '$get_stage' AND `flag` = '0'";
	$result = mysqli_query($conn, $sql);
	if($result){
		while($row = mysqli_fetch_assoc($result)){
			$clear_count = mysqli_num_rows($result);
		}
	}
	if($stage_count > 0){
		$clear_rate = round(($clear_count / $stage_count)*100, 2);
	} else {
		$clear_rate = 0;
	}
	$back_data = '<table style="width:100%;"><tr><td>前回更新以降のリトライ</td><td>'.$update_after_count."</tr><tr><td>あなたの本日のリトライ</td><td>".$today_count."</td></tr><tr><td>あなたの合計リトライ</td><td>".$total_count."</td></tr><tr><td>みんなの合計リトライ</td><td>".$stage_count."</td></tr><tr><td>あなたの自己ベ更新率</td><td>".$your_clear_rate." %</td></tr><tr><td>みんなの自己ベ更新率</td><td>".$clear_rate." %</td></tr></table>";

	} else {
	$back_data = "パスワード照合エラー";
	}

	mysqli_close($conn);

} else {
$back_data = "ユーザー情報が存在しません";

}

header('Content-Type: application/json; charset=utf-8');

echo json_encode($back_data);
?>