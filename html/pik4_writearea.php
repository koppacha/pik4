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

	$error_flag = 0;
	// クッキーからチーム番号を取得★作業中

	// データベースから陣地色と最終更新日時を読み込んで計算
	$query = "SELECT * FROM `area` WHERE `id` = '$stage_id' LIMIT 1";
	$result = mysqli_query($mysqlconn, $query);
	$row = mysqli_fetch_assoc($result);
	$current_area = $row['flag'];
	$check_time = floor((time() - strtotime($row['check_time'])) / 60);
	$ore = intval(substr($row['mark'], 4) );
	$ore_point = $ore * (pow(2, $ore) / 2) * 2;
	$ore_time  = 30 * (pow(2, ($ore - 1)));
	if($check_time >= $ore_time){
		$add_point = floor($check_time / $ore_time) * $ore_point;
		// 最終チェック時間にポイント変換分の秒数を加算
		$add_time = strtotime($row['check_time']) + floor($check_time / $ore_time) * 60;
	} else {
		$add_time = strtotime($row['check_time']);
		$add_point = 0;
	}
	if(!$error_flag){
		// データベースに書き込む（自陣総合点と最終チェック時間の更新）
		$query = "UPDATE `area` SET `check_time` = '$add_time' WHERE `id` = '$stage_id'";
		$result = mysqli_query($mysqlconn, $query );

		$query = "UPDATE `team_log` SET `ore_point` = '$add_point' WHERE `id` = '$current_team'";
		$result = mysqli_query($mysqlconn, $query );
		$return_flag = 1;
	} else {
		$return_flag = 0;
	}
	mysqli_close($conn);

} else {

$return_flag = 0;

}

header('Content-Type: application/json; charset=utf-8');

echo json_encode($return_flag);
?>