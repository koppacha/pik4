<?php

require_once('_def.php');

$back_data = '';
$db	   = $_POST["db"];
$stage_id  = $_POST["stage_id"];
$type	   = $_POST["type"];

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
	$mysql_host = "pik4_db";
	$mysql_user = "root";
	$mysql_pass = "root";
	$mysql_db   = "pik4";
	$mysql_mode = 0;
}
$conn = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);
	if ( $conn == false) {
		die ("p-1：Database Connection Error. ");
	}

	// 証拠写真必要スコア
	if($db == "ranking_evidence"){
		// 投稿しようとしているステージの投稿数 (4人以下の場合免除)
		$sql2 = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0";
		$result2 = mysqli_query($conn, $sql2 );
		if(mysqli_num_rows($result2) < 5){
			if(mysqli_num_rows($result2) < 1){
				$back_data = "?";
			} else {
				$back_data = "(証拠写真不要のステージです。)";
			}
		} else {
			$i = 0;
			$sql[0] = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 AND `post_rank` < 11 ORDER BY `score` ASC LIMIT 1";
			$sql[1] = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 AND `post_rank` = 1 ORDER BY `score` ASC LIMIT 1";
			foreach($sql as $sqla){
				$result = mysqli_query($conn, $sqla);
				$row = mysqli_fetch_assoc($result);
				if( !$result){
					die('データベースの取得に失敗');
				}
				$evpa[$i] = $row[$type];
				if(!$evpa[$i]) $evpa[$i] = 999999;
				$i++;
			}
			$back_data = min($evpa);
			if($back_data == 999999) $back_data = "?";
			
			// ボスバトルの場合の表記変換
			if( $stage_id > 310 AND $stage_id < 317) {
				if( $stage_id == 311) $decode_score = 420 - $row["score"]; // ヨロヒイモムカデ
				if( $stage_id == 312) $decode_score = 900 - $row["score"]; // オオバケカガミ
				if( $stage_id == 313) $decode_score = 780 - $row["score"]; // オオスナフラシ
				if( $stage_id == 314) $decode_score = 600 - $row["score"]; // タテゴトハチスズメ
				if( $stage_id == 315) $decode_score = 900 - $row["score"]; // ヌマアラシ
				if( $stage_id == 316) $decode_score = 720 - $row["score"]; // アメニュウドウ
				$score_sec = sprintf('%02d', fmod ( $decode_score , 60) );
				$score_min = floor( $decode_score / 60);
				$back_data = $score_min.":".$score_sec ;
			}
		}
		// 期間限定・本編地下・本編・日替わりは必須
		if( ($stage_id > 1000 AND $stage_id < 10205) or ($stage_id > 230 and $stage_id < 275) or ($stage_id > 10299 and $stage_id < 10400)){
			$back_data = "(証拠写真必須のステージです。)";
		}
		
	// 指定されたステージの各種情報を取得
	} else {
		$sql = "SELECT * FROM $db WHERE `stage_id` = '$stage_id'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if( !$result){
			die('データベースの取得に失敗');
		}
	$back_data = $row[$type];
	}

	if(!$back_data){
		if($db == "ranking_evidence"){
			$back_data = "?";
		} else {
		$back_data = "?";
		}
	}
	mysqli_close($conn);

header('Content-Type: application/json; charset=utf-8');

echo json_encode($back_data);
?>