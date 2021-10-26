<?php
// データベースから汎用配列を取得
// ユーザー名一覧（★下と差し替える）
$user = array();
$sql = "SELECT * FROM `user`";
$result = mysqli_query($mysqlconn, $sql);
if($result){
	while($user_data = mysqli_fetch_assoc($result)){
		$user[] = $user_data["user_name"];
	}
}
// ユーザーデータ一覧
$users = array();
$sql = "SELECT * FROM `user`";
$result = mysqli_query($mysqlconn, $sql);
if($result){
	while($user_data = mysqli_fetch_assoc($result)){
		$users[$user_data["user_name"]] = $user_data;
	}
}
// ユーザーデータの順位一覧
$array_select_rank  = array("total_pik1cha", "total_pik2cha", "total_pik2egg", "total_pik2noegg", "total_pik3cha", "total_pik3ct", "total_pik3be", "total_pik3db","total_pik3ss","total_limited000", "total_pik2cave", "total_story", "total_mix", "total_diary", "total_pik2_2p", "total_pik3_2p", "total_new", "total_new2", "total_battle2", "total_battle3");
	foreach($array_select_rank as $val){
	$sql = "SELECT `user_name`,(SELECT COUNT(*) + 1 FROM `user` AS a WHERE a.$val > user.$val) AS `{$val}_rank` FROM `user` WHERE $val > 0 ORDER BY $val DESC";
	$result = mysqli_query($mysqlconn, $sql);
	if($result){
		while($user_ranking_data = mysqli_fetch_assoc($result)){
			$users[$user_ranking_data["user_name"]]["{$val}_rank"] = $user_ranking_data["{$val}_rank"];
		}
	}
}
// ステージ一覧
$stage = array();
$sql = "SELECT * FROM `stage_title`";
$result = mysqli_query($mysqlconn, $sql);
if($result){
	while($stage_data = mysqli_fetch_assoc($result)){
		$stage[$stage_data["stage_id"]] = $stage_data;
	}
}
// トップ記録一覧
$topscorelist = array();
$sql = "SELECT stage_id, user_name, score, post_date, rps FROM `ranking` WHERE `log` = 0 AND `post_rank` = 1 ORDER BY  `stage_id` ASC, `post_date` DESC";
$result = mysqli_query($mysqlconn, $sql);
if($result){
	while($topscore_data = mysqli_fetch_assoc($result)){
		$topscorelist[$topscore_data["stage_id"]] = $topscore_data;
	}
}
// 表示中のユーザーデータ
if(isset($user_name)){
	$user_sql = "SELECT * FROM `user` WHERE `user_name` = '$user_name' LIMIT 1";
	$user_result = mysqli_query($mysqlconn, $user_sql);
	if($user_result) $user_row = mysqli_fetch_assoc($user_result);
} else {
	$user_row = array();
}
// エリア踏破戦データベースを一括取得して配列に入れる
$area = array(0 => null);
$sql = "SELECT * FROM `area`";
$result = mysqli_query($mysqlconn, $sql);
if($result){
	while($area_data = mysqli_fetch_assoc($result)){
		$area[$area_data["id"]] = $area_data;
	}
}
