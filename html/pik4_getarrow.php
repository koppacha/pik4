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

	// 指定されたステージIDの最新10件を取得
        $sql = "SELECT `team`,`post_rank` FROM `ranking` WHERE `stage_id` = '$stage_id' AND `team` > 16 ORDER BY `post_date` DESC LIMIT 10";
        $result = mysqli_query($mysqlconn, $sql);
        if($result){
                while($area_data = mysqli_fetch_assoc($result)){
                        $area[] = $area_data;
                }
        }
	mysqli_close($mysqlconn);
} else {

$back_data = "エラーが発生しています（ステージIDの取得に失敗しました）";

}

header('Content-Type: application/json; charset=utf-8');

echo json_encode($area);
?>