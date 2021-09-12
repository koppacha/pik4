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
	require_once('pik4_database.php');

	$stage_array = array();

	if($stage_id > 100000){
		if($limited_type[$stage_id] !== 'u') $stage_array = ${'limited'.$stage_id};
		if($limited_type[$stage_id] === 'u') $stage_array = ${'uplan'.$stage_id};
	}

	foreach($stage_array as $val){
		$back_data[$val]['name'] = $topscorelist[$val]['user_name'];
		$back_data[$val]['score'] = $topscorelist[$val]['score'];
	}
	mysqli_close($conn);
} else {

$back_data = "エラーが発生しています（ステージIDの取得に失敗しました）";

}

header('Content-Type: application/json; charset=utf-8');

echo json_encode($back_data);
?>