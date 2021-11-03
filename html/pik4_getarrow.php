<?php

require_once('_def.php');
require_once('pik4_config.php');

if(isset($_POST['stage_id'])){

	$stage_id = $_POST['stage_id'];	 // ステージIDを取得

	// データベースへアクセス
	$mysqlconn = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);
	if ( $mysqlconn == false) {
		$network_error = 1;
		echo " <br>Error ".__LINE__."：データベースに接続できませんでした。エラー番号：".mysqli_connect_errno();
		exit;
	} else {
		$result = mysqli_query($mysqlconn, 'SET NAMES utf8mb4');
		if (!$result) {
			echo " <br>Error ".__LINE__."：データベースの文字セット指定に失敗しました。";
		}
	}

	require_once('pik4_function.php');
	require_once('pik4_array.php');
	require_once('pik4_name.php');

	$min = min(${'limited'.$limited_stage_list[$limited_num]});
	$max = max(${'limited'.$limited_stage_list[$limited_num]});
	
	$arrow_count = array(
		"teama" => range($min, $max),
		"teamb" => range($min, $max),
	);
	// 期間限定ランキングの最新100件を取得
	$sql = "SELECT `stage_id`,`team` FROM `ranking` WHERE `stage_id` BETWEEN '$min' AND '$max' AND `log` < 2 ORDER BY `post_date` DESC LIMIT 110";
	$result = mysqli_query($mysqlconn, $sql);
	if($result){
		while($arrow_data = mysqli_fetch_assoc($result)){
			$arrowdata[$arrow_data["team"]][] = $arrow_data["stage_id"];
		}
		$arrow_count["teama"] = array_count_values($arrowdata[$team_a]);
		$arrow_count["teamb"] = array_count_values($arrowdata[$team_b]);
	}
	mysqli_close($mysqlconn);
} else {

$back_data = "エラーが発生しています（ステージIDの取得に失敗しました）";

}

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arrow_count);
?>