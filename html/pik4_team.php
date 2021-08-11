<?php

$back_data = '';
$user_name = $_POST["user_name"];
$rate      = $_POST["rate"];
$min       = $_POST["min"];
$max	   = $_POST["max"];
// $user_name = '木っ端ちゃっぴー';
// $rate = 1043;
// $min = 13;
// $max = 14;
$error	   = 0;

// index.php からコピーする
$teamname = array('', 'チーム青ピクミン', 'チーム赤ピクミン','チーム白ピクミン','チーム紫ピクミン','チーム羽ピクミン','チーム岩ピクミン','チームデメマダラ','チームヘビガラス','偉そうで偉くないチーム','偉そうで偉いチーム','飴坊主組','飴入道組','チームヒダマリノミ🍓','チームツラノカワ🍊','チームオフランス🍐','チームカワスベール🍌');

// データベース接続情報
if($_SERVER['SERVER_NAME'] != 'localhost'){
	// Heteml DataBase Server Connection
	$mysql_host = "mysql506.heteml.jp";
	$mysql_user = "_pik4";
	$mysql_pass = "a21586hhwxj7egk";
	$mysql_db   = "_pik4";
	$mysql_mode = 1;
} else {
	// XAMPP Local Server Connection
	$mysql_host = "127.0.0.1";
	$mysql_user = "root";
	$mysql_pass = "";
	$mysql_db   = "pik4";
	$mysql_mode = 0;
}
$conn = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);
$result = mysqli_query($conn, 'SET NAMES utf8mb4');

	if ( $conn == false) {
		$error = 1;
		$back_data = 'エラー：データベースの接続に失敗しました。';
	}

	// 簡易不正アクセス対策
	if($_COOKIE['user_name'] != $user_name){
		$error = 1;
		$back_data = 'エラー：不正なアクセスです。';
	} else {
		// 既存チームのレートを取得
		$team_a = array();
		$team_b = array();

		$query = "SELECT `rate` FROM `user` WHERE `current_team` = '$min' ";
		if ($result = mysqli_query($conn, $query) ){
			while ($row = mysqli_fetch_assoc($result)) {
				$team_a[] = $row['rate'];
			}
		}

		$query = "SELECT `rate` FROM `user` WHERE `current_team` = '$max' ";
		if ($result = mysqli_query($conn, $query) ){
			while ($row = mysqli_fetch_assoc($result)) {
				$team_b[] = $row['rate'];
			}
		}
		// 新規メンバーのレートを取得
		$rate = 0;
		$query = "SELECT `rate` FROM `user` WHERE `user_name` = '$user_name' LIMIT 1 ";
		if ($result = mysqli_query($conn, $query) ){
			$row = mysqli_fetch_assoc($result);
			$rate = $row['rate'];
		} else {
			$error = 1;
			$back_data = 'エラー：新規参加者のレート取得に失敗しました。';
		}

		// 全体をマージする
		$team_all = array_merge($team_a, $team_b);

		// 新規参加者を加える
		$team_all[] = $rate;

		// 参加者数を数える
		$player_count = count($team_all);

		// 全体の中で新規参加者が何位なのかを調べる
		rsort($team_all);
		$rate_rank = array_search($rate, $team_all) + 1;

		// 既存チームのレート合計を計算
		$team_a_total = array_sum($team_a);
		$team_b_total = array_sum($team_b);
		
		// ランダムで決める場合の関数
		function randteam(){
			$rand = rand(1, 2);
			if($rand === 1){
				return 'a';
			} else {
				return 'b';
			}
		}

		// チームメンバー数の差が１以上だったらレート関係なく不足している方へ
		if(abs(count($team_a) - count($team_b)) > 0){
			if(count($team_a) > count($team_b)){
				$team = 'b';
			} else {
				$team = 'a';
			}
		} else {
			// 全体の中で上位ならレート合計が少ない方へ
			if($rate_rank <= ($player_count / 2)){
				if($team_a_total > $team_b_total){
					$team = 'b';
				} elseif($team_a_total < $team_b_total){
					$team = 'a';
				} else {
					$team = randteam();
				}
			} elseif($rate_rank >= ($player_count / 2)) {
				if($team_a_total > $team_b_total){
					$team = 'a';
				} elseif($team_a_total < $team_b_total){
					$team = 'b';
				} else {
					$team = randteam();
				}
			} else {
				$team = randteam();
			}
			
		}
		if($team == 'a'){
			$teamnum = $min;
			$query ="UPDATE `user` SET `current_team` = '$min' WHERE `user_name` = '$user_name' ";
		} elseif($team == 'b'){
			$teamnum = $max;
			$query ="UPDATE `user` SET `current_team` = '$max' WHERE `user_name` = '$user_name' ";
		} else {
			$error = 1;
			$back_data = 'エラー：チーム振り分けでエラーが発生しました。';
		}
		if($error != 1){
			$result = mysqli_query($conn, $query );
			if($result){
				$back_data = '抽選の結果あなたは <b>'.$teamname[$teamnum].'</b> になりました。グッドラック！ <A style="#000;" href="./200918">→こちらを押して再読み込みしてください</A>';
			} else {
				$back_data = 'エラー：データベースの登録に失敗しました。';
			}
		}
	}

	mysqli_close($conn);

header('Content-Type: application/json; charset=utf-8');

echo json_encode($back_data);
?>