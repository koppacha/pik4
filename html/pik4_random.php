<?php

require_once('_def.php');

$back_data = '';
$user_name = $_POST["user_name"];
$error	   = 0;

// データベース接続情報
if($_SERVER['SERVER_NAME'] != 'localhost'){
	// Heteml DataBase Server Connection
	$mysql_host = DATABASE_DOMAIN;
	$mysql_user = DATABASE_USER;
	$mysql_pass = DATABASE_PASS;
	$mysql_db   = DATABASE_USER;
	$mysql_mode = 1;
} else {
	// XAMPP Local Server Connection
	$mysql_host = "127.0.0.1";
	$mysql_user = "root";
	$mysql_pass = "";
	$mysql_db   = "pik4";
	$mysql_mode = 0;
}
$conn = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);
$result = mysqli_query($conn, 'SET NAMES utf8mb4');

	if ( $conn == false) {
		$error = 1;
		$back_data = 'エラー：データベースの接続に失敗しました。';
	}

	// 簡易不正アクセス対策
	if($_COOKIE['user_name'] != $user_name){
		$error = 1;
		$back_data = 'エラー：不正なアクセスです。';
	} else {
		// ユーザーが投稿したことのあるシリーズを判定
		$user_touch_stage = array();
		$sql = "SELECT `stage_id` FROM `ranking` WHERE `user_name` = '$user_name' ORDER BY `post_date` DESC LIMIT 100";
		$result = mysqli_query($conn, $sql);
		if(!$result){
			$back_data = 'エラー：一度も投稿していないユーザーはランダムステージチャレンジを利用できません。';
		} else {
			while($row = mysqli_fetch_assoc($result) ){
				$user_touch_stage[] = $row['stage_id'];
			}
			// 各カテゴリごとにフラグを決定する
			$key = array();
			$set = array();

			$set['pik1']	= range(101,  105);
			$set['pik2']	= range(201,  230);
			$set['pik2_mi'] = range(285,  297);
			$set['pik3']	= range(301,  336);
			$set['pik3dx']	= range(337,  338);
			$set['pik2_sp'] = range(5001,5017);

			foreach($user_touch_stage as $val){
				$key[] = array_search($val, $set);
			}
			var_dump($key);
		}
	}

	mysqli_close($conn);

header('Content-Type: application/json; charset=utf-8');

echo json_encode($back_data);
?>