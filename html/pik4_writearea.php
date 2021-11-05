<?php

require_once('_def.php');
require_once('pik4_config.php');

$back_data = array();

if(isset($_POST['stage_id'])){

	$stage_id = intval($_POST['stage_id']);		// ステージIDを取得

	// データベースへアクセス
	$mysqlconn = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);
	if ( $mysqlconn == false) {
		$network_error = 1;
		$return_flag = 0;
	} else {
		$result = mysqli_query($mysqlconn, 'SET NAMES utf8mb4');
		if (!$result) {
			$return_flag = 0;
		}
	}

	require_once('pik4_function.php');
	require_once('pik4_array.php');
	require_once('pik4_name.php');
	require_once('pik4_database.php');
	require_once('pik4_cookie.php');

	$error_flag = 0;
	// クッキーからチーム番号を取得
	$current_team = $users[$cookie_name]["current_team"];

	// チームIDが有効なら処理を続行する
	if($current_team > 16){

		// データベースから陣地色と最終更新日時を読み込んで計算
		$query = "SELECT * FROM `area` WHERE `id` = '$stage_id' LIMIT 1";
		$result = mysqli_query($mysqlconn, $query);
		$row = mysqli_fetch_assoc($result);
		$current_area = $row['flag'];
		$check_time = floor((time() - strtotime($row['check_time'])) / 60);
		$ore = intval(substr($row['mark'], 4) );
		$ore_point = $ore * (pow(2, $ore) / 2) * 2;
		$ore_time  = 15 * (pow(2, ($ore - 1)));

		// 採掘に必要な時間が経過していたら処理続行
		if($check_time >= $ore_time){

			// 最終チェック時間にポイント変換分の秒数を加算
			$add_time = date('Y-m-d H:i:s', strtotime($row['check_time']) + ($check_time - ($check_time % $ore_time)) * 60);
			$add_point = floor($check_time / $ore_time) * $ore_point;
		} else {
			$error_flag = 1;
		}
		if(!$error_flag){

			// 自陣の現在のポイントを取得
			$query = "SELECT * FROM `team_log` WHERE `id` = '$current_team' LIMIT 1";
			$result = mysqli_query($mysqlconn, $query);
			$team_log = mysqli_fetch_assoc($result);

			$add_ore_point = $team_log["ore_point"] + $add_point;

			// データベースに書き込む（自陣総合点と最終チェック時間の更新）
			$query = "UPDATE `area` SET `check_time` = '$add_time' WHERE `id` = '$stage_id'";
			$result = mysqli_query($mysqlconn, $query );
			
			$query = "UPDATE `team_log` SET `ore_point` = '$add_ore_point' WHERE `id` = '$current_team'";
			$result = mysqli_query($mysqlconn, $query );
			$return_flag = 1;
		} else {
			$return_flag = 0;
		}
		mysqli_close($mysqlconn);
	} else {
		$return_flag = 0;
	}
} else {

$return_flag = 0;

}

header('Content-Type: application/json; charset=utf-8');

echo json_encode($return_flag);
?>