<?php

require_once('_def.php');
require_once('pik4_config.php');

$back_data = array();

if(isset($_POST['lim'])){

	$lim = intval($_POST['lim']);
	$teama = intval($_POST['teama']);
	$teamb = intval($_POST['teamb']);

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

	$tlim = 'total_limited'.sprintf('%03d', $lim);
	$rlim = 'total_rpslim'.sprintf('%03d', $lim);

	// 各チームの名前・RPS・合計点をRPS降順で取得する
        $point = array();
        $sql = "SELECT `user_id`,`user_name`,`current_team`,$tlim ,$rlim FROM `user` WHERE `current_team` BETWEEN '$teama' AND '$teamb' ORDER BY '$rlim' DESC";
        $result = mysqli_query($mysqlconn, $sql);
        if($result){
                while($area_data = mysqli_fetch_assoc($result)){
                        if($area_data["current_team"] == $teama) $point["user"]["teama"][$area_data["user_id"]] = $area_data;
                        if($area_data["current_team"] == $teamb) $point["user"]["teamb"][$area_data["user_id"]] = $area_data;
			$point["test"][$area_data["user_id"]] = $area_data;
                }
        }

	// 各チームの総合点を取得する
	$sql = "SELECT * FROM `team_log` WHERE `lim` = '$lim' ORDER BY `lim` ASC";
	$result = mysqli_query($mysqlconn, $sql);
	if($result){
		while($area_data = mysqli_fetch_assoc($result)){
			if($area_data["id"] == $teama) $point["team"]["teama"] = $area_data;
			if($area_data["id"] == $teamb) $point["team"]["teamb"] = $area_data;
		}
	}
	mysqli_close($conn);
} else {

$back_data = "エラーが発生しています（ステージIDの取得に失敗しました）";

}

header('Content-Type: application/json; charset=utf-8');

echo json_encode($point);
?>