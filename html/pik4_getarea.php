<?php
ini_set('display_errors', 1);

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

	// エリア踏破戦データベースを一括取得して配列に入れる
        $area = array(0 => null);
        $sql = "SELECT `id`, `lim`, `flag`, `stage_id`, `mark`, `title`, `top_score`, `user_name`, `count`, `team_a`, `team_b`,
	CASE  
		WHEN update_time IS NULL THEN 0 
		WHEN update_time = '0000-00-00 00:00:00' THEN 0
		ELSE (UNIX_TIMESTAMP('2021-11-07 22:00:00') - UNIX_TIMESTAMP(update_time))
	END  AS update_time,
	CASE  
		WHEN check_time IS NULL THEN 0 
		WHEN check_time = '0000-00-00 00:00:00' THEN 0
		ELSE (UNIX_TIMESTAMP('2021-11-07 22:00:00') - UNIX_TIMESTAMP(check_time))
	END  AS check_time
	FROM `area`";

        $result = mysqli_query($mysqlconn, $sql);
        if($result){
                while($area_data = mysqli_fetch_assoc($result)){
                        $area[$area_data["id"]] = $area_data;
                }
        }
	// ヘッドラインアローを表示するためのデータを取得
	$min = min(${'limited'.$limited_stage_list[17]});
	$max = max(${'limited'.$limited_stage_list[17]});
	
	// 期間限定ランキングの最新100件を取得
	$sql = "SELECT `stage_id`,`team` FROM `ranking` WHERE `stage_id` BETWEEN '$min' AND '$max' AND `log` < 2 ORDER BY `post_date` DESC LIMIT 110";
	$result = mysqli_query($mysqlconn, $sql);
	if($result){
		while($arrow_data = mysqli_fetch_assoc($result)){
			$arrowdata[$arrow_data["team"]][] = $arrow_data["stage_id"];
		}
		$area_count_value["teama"] = array_count_values($arrowdata[$team_a]);
		$area_count_value["teamb"] = array_count_values($arrowdata[$team_b]);
	
		for($i = $min; $i <= $max; $i++){
			if(isset($area_count_value["teama"][$i])){
				$area["arrow"]["teama"][$i] = $area_count_value["teama"][$i];
			} else {
				$area["arrow"]["teama"][$i] = 0;
			}
			if(isset($area_count_value["teamb"][$i])){
				$area["arrow"]["teamb"][$i] = $area_count_value["teamb"][$i];
			} else {
				$area["arrow"]["teamb"][$i] = 0;
			}
		}
	}
	mysqli_close($conn);
} else {

$back_data = "エラーが発生しています（ステージIDの取得に失敗しました）";

}

header('Content-Type: application/json; Access-Control-Allow-Origin: <origin> | *; Access-Control-Allow-Headers: *; charset=utf-8');

echo json_encode($area);
?>