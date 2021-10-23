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
	// データベースから陣地色とボーナスポイントを読み込んで計算
	$query = "SELECT * FROM `area` WHERE `id` = '$stage_id' LIMIT 1";
	$result = mysqli_query($mysqlconn, $query);
	$row = mysqli_fetch_assoc($result);
	$current_area = $row['flag'];
	$ore = intval(substr($row['mark'], 4) );
	$ore_point = $ore * (pow(2, $ore) / 2) * 2;
	if($current_area == 3){
		$team = "bonus_b";
		$point = $row['bonus_b'] + $ore_point;
	} elseif($current_area == 4){
		$team = "bonus_a";
		$point = $row['bonus_a'] + $ore_point;
	} else {
		$error_flag = 1;
	}
	if(!$error_flag){
		// データベースに書き込む（相手ボーナス点と自陣総合点の更新）
		$query = "UPDATE `area` SET $team = '$point' WHERE `id` = '$stage_id'";
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