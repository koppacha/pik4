<?php
	$team1_win = 0;		// 左チームの勝利数
	$team2_win = 0;		// 右チームの勝利数
	$compare_score = 0;	// スコア差
	$area_team_flag = 0;	// チーム対抗戦の場合はON
	${'team'.$team_a.'_score'} = 0;	// 左チームの合計スコア
	${'team'.$team_b.'_score'} = 0;	// 右チームの合計スコア

	if($stage_id == 200723 or $stage_id == 200918 or $stage_id == 211105) $area_team_flag = 1;
	
	// スコアテーブル本体
	$table_row_num = 1;
	${'rps'.$team_a} = 0;
	${'rps'.$team_b} = 0;
	$array_count = count(${'limited'.$stage_id});
	if($page_type == 10 or $area_team_flag == 1){
		foreach(${'limited'.$stage_id} as $get_limstage){
			$get_stage_title = $array_stage_title[$get_limstage];
			$get_stage_title2= str_replace('#',' <br>', $get_stage_title);
			$get_stage_title3= str_replace('（',' <br>（', $get_stage_title2);
			$stage_title     = str_replace('[',' <br>[', $get_stage_title3);
			$i = $team_a;
			while($i <= $team_b){
				// 未定義回避	
				$sql = "SELECT * FROM `ranking` WHERE `stage_id` = $get_limstage AND `log` = 0 AND `team` = '$i' ORDER BY `score` DESC";
				$result = mysqli_query($mysqlconn, $sql);
				if (!$result) {
					die('<br>Error '.__LINE__.'：クエリの取得に失敗.'.mysql_error());
				}
				// 各ステージのチーム別レコードをWhileして合計スコアを加算していく（ピク1は10倍）
				while(${'total_row'.$i} = mysqli_fetch_assoc($result)){
					${'rps'.$i} += ${'total_row'.$i}["rps2"];
					if(array_search(${'total_row'.$i}["stage_id"], $limited_pik1)){
						${'team'.$i.'_score'} += ${'total_row'.$i}["score"] * 10;
					} else {
						${'team'.$i.'_score'} += ${'total_row'.$i}["score"];
					}
				}
				// トップスコアのみを抽出
				$result = mysqli_query($mysqlconn, $sql);
				${'row'.$i} = mysqli_fetch_assoc($result);
				if (!$result) {
					die('<br>Error '.__LINE__.'：クエリの取得に失敗.'.mysql_error());
				}
				// 未定義回避
				if(!isset(${'row'.$i}["user_name"])) ${'row'.$i}["user_name"] = "";
				if(!isset(${'row'.$i}["unique_id"])) ${'row'.$i}["unique_id"] = "";
				if(!isset(${'row'.$i}["post_comment"])) ${'row'.$i}["post_comment"] = "";
				if(!isset(${'row'.$i}["post_date"])) ${'row'.$i}["post_date"] = "";
								
				// スコア表示を加工
				if(isset(${'row'.$i}["score"]) and ${'row'.$i}["score"] > 0){
					${'score_lim'.$i} = number_format(${'row'.$i}["score"]).'<font class="score_tale"> pts.</font>';
					if(${'row'.$i}["stage_id"] >= $blind_start and ${'row'.$i}["stage_id"] <= $blind_end){
						${'score_lim'.$i} = '??,??? pts.';
					}
				} else {
					${'score_lim'.$i} = '';
				}
				// 通常ランキングテーブルを流用ここから
				// 日付表記を分割する
				if ($page_type == 2 ){
					$date_hook = ${'row'.$i}["lastupdate"];
				} elseif(isset(${'row'.$i}["post_date"])){
					$date_hook = ${'row'.$i}["post_date"];
				}
				${'get_post_date'.$i} = substr( $date_hook , 0 , 10);
				${'get_post_time'.$i} = substr( $date_hook , 11, 8 );

				// 使用コントローラーの判別
				if (isset(${'row'.$i}["console"])){
					$get_console = ${'row'.$i}["console"];
					${'console_type'.$i} = '['.$array_console[$get_console].'] ';
				} else {
					${'console_type'.$i} = '';
				}
				// 証拠写真有無の判別
				if(!isset(${'row'.$i}["pic_file"]) or (${'row'.$i}["stage_id"] >= $blind_start and ${'row'.$i}["stage_id"] <= $blind_end) ){
					${'pic_file_url'.$i} = "";
				} else {
					${'pic_file_url'.$i} = '<A href="../_img/pik4/uploads/'.${'row'.$i}["pic_file"].'" data-lity="data-lity"><i class="fa fa-camera"></i></A>';
					if(${'row'.$i}["pic_file2"] ) ${'pic_file_url'.$i} .= '<A href="../_img/pik4/uploads/'.${'row'.$i}["pic_file2"].'" data-lity="data-lity"><i class="fa fa-camera"></i></A>';
				}

				// 証拠動画有無の判別
				if(!isset(${'row'.$i}["video_url"])){
					${'video_link'.$i} = "";
				} elseif( strpos(${'row'.$i}["video_url"], "youtu")) {
					${'video_link'.$i} = '<A href="'.${'row'.$i}["video_url"].'" data-lity="data-lity"><i class="fab fa-youtube"></i></A>';
				} else {
					${'video_link'.$i} = '<A href="'.${'row'.$i}["video_url"].'" target="_brank"><i class="fab fa-youtube"></i></A>';
				}

				// 投稿IDの付与
				if(${'row'.$i}["unique_id"] > 0){
					${'tag_link'.$i} = '<i class="fa fa-tag tooltip" title="POST ID: '.${'row'.$i}["unique_id"].'"></i>';
				} else {
					${'tag_link'.$i} = '';
				}
				// 通常ランキングテーブルを流用ここまで
			$i++;
			}
			// 勝者判定結果を集計＆中央セルのスタイル指定に反映＆スコア差を計算（トップスコア比較）
			if(isset(${'row'.$team_a}["score"]) or isset(${'row'.$team_b}["score"])){
				if(${'row'.$team_a}["score"] > ${'row'.$team_b}["score"]){
					$compare_score = ${'row'.$team_a}["score"] - ${'row'.$team_b}["score"];
					$compare_style = $team_a;
					$team_center_style = 'width:20%;background-color:#555555;text-align:center;border-left:solid 10px #'.$teamc[$team_a].';border-right:solid 10px #444444;';
				} elseif(${'row'.$team_a}["score"] < ${'row'.$team_b}["score"]){
					$compare_style = $team_b;
					$team_center_style = 'width:20%;background-color:#555555;text-align:center;border-right:solid 10px #'.$teamc[$team_b].';border-left:solid 10px #444444;';
					$compare_score = ${'row'.$team_b}["score"] - ${'row'.$team_a}["score"];
				} else {
					$team_center_style = 'width:20%;background-color:#555555;text-align:center;border-right:solid 10px #444444;border-left:solid 10px #444444;';
				}
			} else {
				$team_center_style = 'width:20%;background-color:#555555;text-align:center;border-right:solid 10px #444444;border-left:solid 10px #444444;';
			}
			// ステージ毎の合計RPSを表示
			$str_sql = "SELECT * FROM `ranking` WHERE `stage_id` = $get_limstage AND `log` = 0 AND `team` IN('$team_a','$team_b') ORDER BY `score` DESC";
			$str_result = mysqli_query($mysqlconn, $str_sql);
			$stage_rps[$team_a] = 0;	// ステージ別チームポイント
			$stage_rps[$team_b] = 0;	// ステージ別チームポイント
			while($str_row = mysqli_fetch_assoc($str_result) ){
				if($str_row["rps2"]){
					$add_point = $str_row["rps2"];
				} else {
					$add_point = 0;
				}
					if($str_row["team"] == $team_a) $stage_rps[$team_a] += $add_point;
					if($str_row["team"] == $team_b) $stage_rps[$team_b] += $add_point;
			}
			// スコア差の二次処理
			if(isset(${'row'.$team_a}["score"]) and isset(${'row'.$team_b}["score"])){
				if(${'row'.$team_a}["score"] < 1 or ${'row'.$team_b}["score"] < 1) $compare_score = 0;
				if($compare_score > 0){
					if($stage_id > 170429) $compare = '<span style="color:#'.$teamc[$team_a].'">'.$stage_rps[$team_a].'</span> - <span style="color:#'.$teamc[$team_b].'">'.$stage_rps[$team_b]."</span>";
					if($stage_id < 170429) $compare = '<span style="color:#'.$teamc[$compare_style].'">[+'.$compare_score.']</span>';
				} else {
					if($stage_id > 170429) $compare = '<span style="color:#'.$teamc[$team_a].'">'.$stage_rps[$team_a].'</span> - <span style="color:#'.$teamc[$team_b].'">'.$stage_rps[$team_b]."</span>";
					if($stage_id < 170429) $compare = '';
				}
			}
			// 参加条件を明記する
			$stage_sql = "SELECT * FROM `stage_title` WHERE `stage_id` = $get_limstage";
			$stage_result = mysqli_query($mysqlconn, $stage_sql);
			$stage_row = mysqli_fetch_assoc($stage_result);
			$terms = explode("_", $stage_row["terms"]);
			if($terms[0] == "LU"){
				$imp_str = '<span glot-model="main_limited_classa">◆Aクラス限定◆</span> <br>';
			} elseif($terms[0] == "LD"){
				$imp_str = '<span glot-model="main_limited_classb">◆Bクラス限定◆</span> <br>';
			} elseif($terms[0] == "MD"){
				$imp_str = '<span glot-model="main_limited_eachteam">◆各チーム</span>'.$terms[1].'<span glot-model="main_limited_eachteam_tail">人まで◆</span> <br>';
			} else {
				$imp_str = "";
			}
			if(${'row'.$team_a}["unique_id"] > 0 or ${'row'.$team_b}["unique_id"] > 0){
				$row_output[$table_row_num] = '<tr><td style="width:40%;text-align:right;border-bottom-left-radius:4px;"><span class="rtd2_player">'.${'row'.$team_a}["user_name"].'</span> <br>';
				$row_output[$table_row_num].= '<span class="rtd2_score">'.${'score_lim'.$team_a}.'</span> <br><span id="id-'.${'row'.$team_a}["unique_id"].'" class="rtd_other">'.${'get_post_date'.$team_a}.' <span class="mobile-hidden" style="color:#cccccc;">'.${'get_post_time'.$team_a}.'</span> '.${'console_type'.$team_a}.${'pic_file_url'.$team_a}.${'video_link'.$team_a}.${'tag_link'.$team_a}.'</span> <br>';
				$row_output[$table_row_num].= '<span class="rtd_other">'.${'row'.$team_a}["post_comment"].'</span></td>';
				$row_output[$table_row_num].= '<td style="'.$team_center_style.'"><span style="font-size:1.0em;font-weight:bold;">'.$imp_str.'<A style="display:block;" href="./'.$get_limstage.'">#'.$stage_title.' <br>'.$compare.'</A></span></td>';
				$row_output[$table_row_num].= '<td style="width:40%;border-bottom-right-radius:4px;"><span class="rtd2_player">'.${'row'.$team_b}["user_name"].'</span> <br>';
				$row_output[$table_row_num].= '<span class="rtd2_score">'.${'score_lim'.$team_b}.'</span> <br><span id="id-'.${'row'.$team_b}["unique_id"].'" class="rtd_other">'.${'tag_link'.$team_b}.${'video_link'.$team_b}.${'pic_file_url'.$team_b}.${'console_type'.$team_b}.${'get_post_date'.$team_b}.' <span class="mobile-hidden" style="color:#cccccc;">'.${'get_post_time'.$team_b}.'</span></span> <br>';
				$row_output[$table_row_num].= '<span class="rtd_other">'.${'row'.$team_b}["post_comment"].'</span></td>';
			}
			$table_row_num++;
		}
	}
	// 少数チームへのハンディキャップを処理
	if($area_team_flag == 1){
		// 第15回は処理しない

	} elseif($stage_id == 170101){
		$leftside_count = 4;
		$rightside_count = 5;
	} else {
		$sql = "SELECT * FROM `ranking` WHERE `team` = '$team_a' AND `log` = 0";
		$result = mysqli_query($mysqlconn, $sql);
		$rightside_count = mysqli_num_rows($result);
		$sql = "SELECT * FROM `ranking` WHERE `team` = '$team_b' AND `log` = 0";
		$result = mysqli_query($mysqlconn, $sql);
		$leftside_count = mysqli_num_rows($result);
		$player_total = $rows_count;
	}
	// ハンディキャップ点数を計算	[第7回：１ステージ分のボーナス＝整数1から参加者数Nまでの和の平均に等しい数 ]
	// 				[第8回：全ステージ分のボーナス＝各チーム投稿数の差分の絶対値×参加者数の半数切り上げ]
	if($area_team_flag == 1){
		// エリア踏破戦チーム対抗制の場合は処理しない
		
	} elseif($stage_id == 170101){
		$player_total = $rightside_count + $leftside_count;
		$stage_count = count(${'limited'.$stage_id});
		$minority_bonus = (($player_total+1)/2)*$stage_count;
		if($leftside_count > $rightside_count){
			$is_minority = 2;
			${'rps'.$team_b} += $minority_bonus;
		}
		if($leftside_count < $rightside_count){
			$is_minority = 1;
			${'rps'.$team_a} += $minority_bonus;
		}
	} else {
		$post_diff = abs($rightside_count - $leftside_count);
		$minority_bonus = $post_diff * ceil($player_total / 2);
		if($_SESSION['debug_mode']) var_dump($post_diff, $minority_bonus, $player_total,$rightside_count, $leftside_count);
		list($leftside_count, $rightside_count) = array($rightside_count, $leftside_count); // ハンデ付与判定のために便宜的に変数の値を入れ替える
		if($leftside_count > $rightside_count){
			$is_minority = 2;
			${'rps'.$team_b} += $minority_bonus;
		}
		if($leftside_count < $rightside_count){
			$is_minority = 1;
			${'rps'.$team_a} += $minority_bonus;
		} else {
			$is_minority = 0;
		}
	}
	// チームポイント表示PHP版（第17回以降は非表示）
	if($stage_id != 211105){
		// テーブルを出力する
		if($stage_id == 999999){
			$top_float = "position:relative;top:-120px;";
		} else {
			$top_float = "";
		}
		// 左チーム概要
		if($stage_id == 171013){
			$background_color = 'background-color:#151515;"';
		} else  {
			$background_color = '';
		}
		// エリア踏破制の場合は陣地の数を計算する
		$areacount = 0;
		$flag = '';
		$limcount = array_search($stage_id, $limited_stage_list);
		$sql = "SELECT * FROM `area` WHERE `lim` = '$limcount' AND `flag` = 3";
		$result = mysqli_query($mysqlconn, $sql);
		$areacount = mysqli_num_rows($result);
		echo '<table class="team_info_tab"><tr>';
		echo '<td style="width:20%;text-align:center;vertical-align:top;'.$background_color.'">';
		if($areacount > 0){
			echo '<span style="color:#'.$teamc[$team_a].';" class="team_point">'.$areacount.'</span><hr style="height:3px;border:none;background-color:#'.$teamc[$team_a].';">';
		}
		echo '<span style="color:#'.$teamc[$team_a].';" class="team_point">'.${'rps'.$team_a}.'</span>';
		echo '<br>';
		if(!$blind) echo '<span style="color:#'.$teamc[$team_a].'" class="team_point_mini">.'.${'team'.$team_a.'_score'}.'</span></td>';
		if( $blind) echo '<span style="color:#'.$teamc[$team_a].'" class="team_point_mini">.?????</span></td>';

		echo '<td style="'.$top_float.'width:30%;text-align:center;vertical-align:top;'.$background_color.'" class="mobile-hidden">';
		echo '<b style="color:#'.$teamc[$team_a].'">◆'.$team[$team_a].'◆</b> <br>';
		if(isset($player_total) and isset($leftside_count)) $last_postcount = ($player_total * 2) - $leftside_count;
		if($stage_id == 170429 or $stage_id == 180101) echo '<span><span glot-model="menu_cnt_total">総投稿数</span>：'.$leftside_count.' / <span glot-model="main_limited_last">残り</span>：'.$last_postcount.' <br>';
		if($stage_id != 171013) echo '<table class="team_user_tab">';
		if($stage_id == 171013) echo '<table class="team_user_tab2">';
		$userentry1_array = array(); // 投稿済みの記録リスト
		$userlist1_array  = array(); // 参加ユーザーリスト
		$sql = "SELECT * FROM `ranking` WHERE `log` = 0 AND `team` = $team_a";
		$result = mysqli_query($mysqlconn, $sql);
		$i = 0;
		while($row = mysqli_fetch_assoc($result)){
			$ulist[$i] = $row["user_name"];
			$i++;
		}
		// スコアを登録しているか否かにかかわらず参加しているユーザーを検出する
		$sql = "SELECT * FROM `user` WHERE `current_team` = $team_a";
		if($stage_id <= 200723){ // 最新でない期間限定ランキング総合ページを開いている場合の処理
			$sql = "SELECT * FROM `ranking` WHERE `team` = $team_a AND `log` = 0";
		}
		$result = mysqli_query($mysqlconn, $sql);
		while($row = mysqli_fetch_assoc($result)){
			$ulist_unique[] = $row["user_name"];
		}
		$ulist_unique = array_unique($ulist_unique);
		$i = 0;
		$team_rank = array();
		if($result){
			foreach($ulist_unique as $userlist1){
				$your_mark= "";
				$your_tps = 0;
				$your_pts = 0;
				$your_rate= 0;
				$userlist1_array[$i] = $userlist1;
				$imp_limstage = implode(",", ${'limited'.$stage_id});
				$utpssql = "SELECT * FROM `ranking` WHERE `user_name` = '$userlist1_array[$i]' AND `log` = 0 AND `stage_id` IN($imp_limstage)";
				$utpsresult = mysqli_query($mysqlconn, $utpssql);
				if (!$utpsresult) {
					die('<br>Error '.__LINE__.'：クエリの取得に失敗.'.mysql_error());
				}
				while($user_tps = mysqli_fetch_assoc($utpsresult)){
					if($user_tps["rate"] > 499){
						$your_rate = '<span class="att">(#'.$user_tps["rate"].')</span>';
					}
					// 代表選抜制において確定地位を投稿済みステージから算出
					if($user_tps["stage_id"] == 1038 and $user_tps["score"] > 0){
						$your_mark = '<span style="font-size:0.8em;color:#777777;" glot-model="main_limited_turn1">先鋒</span> <img class="chess_icon_w" src="https://chr.mn/_img/pik4/icons/w006.png"/> <br>';
						$hidden_flag = 1;
					}
					if($user_tps["stage_id"] == 1039 and $user_tps["score"] > 0){
						$your_mark = '<span style="font-size:0.8em;color:#777777;" glot-model="main_limited_turn2">次鋒</span> <img class="chess_icon_w" src="https://chr.mn/_img/pik4/icons/w005.png"/> <br>';
						$hidden_flag = 1;
					}
					if($user_tps["stage_id"] == 1040 and $user_tps["score"] > 0){
						$your_mark = '<span style="font-size:0.8em;color:#777777;" glot-model="main_limited_turn3">副将</span> <img class="chess_icon_w" src="https://chr.mn/_img/pik4/icons/w003.png"/> <br>';
						$hidden_flag = 1;
					}
					if($user_tps["stage_id"] == 1041 and $user_tps["score"] > 0){
						$your_mark = '<span style="font-size:0.8em;color:#777777;" glot-model="main_limited_turn4">大将</span> <img class="chess_icon_w" src="https://chr.mn/_img/pik4/icons/w002.png"/> <br>';
						$hidden_flag = 1;
					}
					if($user_tps["stage_id"] == 1042 and $user_tps["score"] > 0){
						$your_mark = '<span style="font-size:0.8em;color:#777777;" glot-model="main_limited_turn5">ヘイ</span> <img class="chess_icon_w" src="https://chr.mn/_img/pik4/icons/w001.png"/> <br>';
						$hidden_flag = 1;
					}
					$your_tps += $user_tps["rps2"];
					if(array_search($user_tps["stage_id"], $limited_pik1)){ // チーム対抗対象ステージかつピクミン1の場合10倍して加算
						$your_pts += $user_tps["score"] * 10;
					} else {
						$your_pts += $user_tps["score"];
					}
				}
				$team_rank[$i] = array($userlist1_array[$i], $your_tps, $your_pts, $your_rate, $your_mark);
				$i++;
			}
		if(count($userlist1_array) > 1) array_multisort(array_column($team_rank, 1), SORT_DESC, $team_rank);
			foreach($team_rank as $val){
				$utps2sql = "SELECT * FROM `ranking` WHERE `user_name` = '$val[0]' AND `log` = 0 AND `stage_id` IN($imp_limstage)";
				$utps2result = mysqli_query($mysqlconn, $utps2sql);
				$utpscount = mysqli_num_rows($utps2result);
				if(!$blind) $show_score = number_format($val[2])." pts.";
				if( $blind) $show_score = "??,??? pts.";
				if($stage_id != 170429 and $stage_id != 171013 and $stage_id != 180101) echo '<tr style="color:#'.$teamc[$team_a].'"><td><b>'.$val[0].'</b></td><td>'.$val[1].' RPS</td><td>'.number_format($val[2]).' pts.</td></tr>';
				if($stage_id == 170429) echo '<tr style="color:#'.$teamc[$team_a].'"><td><b>'.$val[0].'</b></td><td>'.$val[1].' RPS</td><td>['.$utpscount.'<span style="color:#777777;">/4</span>]</td><td>'.number_format($val[2]).'</td></tr>';
				if($stage_id == 180101) echo '<tr style="color:#'.$teamc[$team_a].'"><td><b>'.$val[0].'</b></td><td>'.$val[1].' RPS</td><td>['.$utpscount.'<span style="color:#777777;">/4</span>]</td><td>'.$show_score.'</td></tr>';
				if($stage_id == 171013) echo '<tr style="color:#'.$teamc[$team_a].'"><td>'.$val[4].'<b>'.$val[0].'</b>'.$val[3].'</td><td>'.$val[1].' <br><span class="att">RPS</span></td><td>'.number_format($val[2]).' <br><span class="att">pts.</span></td></tr>';

			}
			if(isset($is_minority)){
				if($is_minority == 1 and $stage_id == 170429) echo '<tr title="総投稿数が少ないチームに{参加者数÷2}の切り捨てを付与" style="color:#'.$teamc[$team_a].'"><td glot-model="main_limited_bonus">(ボーナス)</td><td>'.$minority_bonus.' RPS</td><td>['.$post_diff.']</td><td>- pts.</td></tr>';
				if($is_minority == 1 and $stage_id != 170429 and $stage_id != 171013) echo '<tr style="color:#'.$teamc[$team_a].'"><td glot-model="main_limited_bonus">(ボーナス)</td><td>'.$minority_bonus.' RPS</td><td>- pts.</td></tr>';
				if($is_minority == 1 and $stage_id == 171013) echo '<tr style="color:#'.$teamc[$team_a].'"><td glot-model="main_limited_bonus">(ボーナス)</td><td>'.$minority_bonus.' <br><span class="att">RPS</span></td><td>- <br><span class="att">pts.</span></td></tr>';
			}
		} else {
			echo '<tr><td colspan="4" glot-model="main_limited_noplayer">(まだ参加者がいません)</td></tr>';
		}
		echo '</table></td>';

		// 右チーム概要
		if($stage_id == 171013){
			$background_color = 'background-color:#e5e5e5;"';
		} else  {
			$background_color = '';
		}
		echo '<td style="'.$top_float.'width:30%;text-align:center;vertical-align:top;'.$background_color.'" class="mobile-hidden">';
		echo '<b style="color:#'.$teamc[$team_b].'">◆'.$team[$team_b].'◆</b> <br>';
		if(isset($player_total) and isset($rightside_count)) $right_postcount = ($player_total * 2) - $rightside_count;
		if($stage_id == 170429 or $stage_id == 180101) echo '<span><span glot-model="menu_cnt_total">総投稿数</span>：'.$rightside_count.' / <span glot-model="main_limited_last">残り</span>：'.$right_postcount.' <br>';
		if($stage_id != 171013) echo '<table class="team_user_tab">';
		if($stage_id == 171013) echo '<table class="team_user_tab2">';
		$userentry2_array = array(); // 投稿済みの記録リスト
		$userlist2_array  = array(); // 参加ユーザーリスト
		$sql = "SELECT * FROM `ranking` WHERE `log` = 0 AND `team` = '$team_b'";
		$result = mysqli_query($mysqlconn, $sql);
		$i = 0;
		while($row = mysqli_fetch_assoc($result)){
			$ulist2[$i] = $row["user_name"];
			$i++;
		}
	//	$ulist_unique2 = array_unique($ulist2);
		// スコアを登録しているか否かにかかわらず参加しているユーザーを検出する
		$sql = "SELECT * FROM `user` WHERE `current_team` = '$team_b'";
		if($stage_id <= 200723){
			$sql = "SELECT * FROM `ranking` WHERE `team` = $team_b AND `log` = 0";
		}
		$result = mysqli_query($mysqlconn, $sql);
		while($row = mysqli_fetch_assoc($result)){
			$ulist_unique2[] = $row["user_name"];
		}
		$ulist_unique2 = array_unique($ulist_unique2);
		$i = 0;
		$team_rank = array();
		if($result){
			foreach($ulist_unique2 as $userlist2){
				$your_mark= "";
				$your_tps = 0;
				$your_pts = 0;
				$your_rate= 0;
				$userlist2_array[$i] = $userlist2;
				$imp_limstage = implode(",", ${'limited'.$stage_id});
				$utpssql = "SELECT * FROM `ranking` WHERE `user_name` = '$userlist2_array[$i]' AND `log` = 0 AND `stage_id` IN($imp_limstage)";
				$utpsresult = mysqli_query($mysqlconn, $utpssql);
				$utpscount = mysqli_num_rows($utpsresult);
				if (!$utpsresult) {
					die('<br>Error '.__LINE__.'：クエリの取得に失敗.'.mysql_error());
				}
				while($user_tps = mysqli_fetch_assoc($utpsresult)){
					$your_rate = $user_tps["rate"];
					if($user_tps["rate"] > 499){
						$your_rate = '<span style="font-size:0.8em;">(#'.$user_tps["rate"].')</span>';
					}
					if($user_tps["stage_id"] == 1038 and $user_tps["score"] > 0) $your_mark = '<span style="font-size:0.8em;color:#777777;" glot-model="main_limited_turn1">先鋒</span> <img class="chess_icon_b" src="https://chr.mn/_img/pik4/icons/b006.png"/> <br>';
					if($user_tps["stage_id"] == 1039 and $user_tps["score"] > 0) $your_mark = '<span style="font-size:0.8em;color:#777777;" glot-model="main_limited_turn2">次鋒</span> <img class="chess_icon_b" src="https://chr.mn/_img/pik4/icons/b004.png"/> <br>';
					if($user_tps["stage_id"] == 1040 and $user_tps["score"] > 0) $your_mark = '<span style="font-size:0.8em;color:#777777;" glot-model="main_limited_turn3">副将</span> <img class="chess_icon_b" src="https://chr.mn/_img/pik4/icons/b003.png"/> <br>';
					if($user_tps["stage_id"] == 1041 and $user_tps["score"] > 0) $your_mark = '<span style="font-size:0.8em;color:#777777;" glot-model="main_limited_turn4">大将</span> <img class="chess_icon_b" src="https://chr.mn/_img/pik4/icons/b002.png"/> <br>';
					if($user_tps["stage_id"] == 1042 and $user_tps["score"] > 0) $your_mark = '<span style="font-size:0.8em;color:#777777;" glot-model="main_limited_turn5">ヘイ</span> <img class="chess_icon_b" src="https://chr.mn/_img/pik4/icons/b001.png"/> <br>';
					$your_tps += $user_tps["rps2"];
					if(array_search($user_tps["stage_id"], $limited_pik1)){ // チーム対抗対象ステージかつピクミン1の場合10倍して加算
						$your_pts += $user_tps["score"] * 10;
					} else {
						$your_pts += $user_tps["score"];
					}
				}
				$team_rank[$i] = array($userlist2_array[$i], $your_tps, $your_pts, $your_rate, $your_mark);
				$i++;
			}
			if(count($userlist2_array) > 1) array_multisort(array_column($team_rank, 1), SORT_DESC, $team_rank);
			foreach($team_rank as $val){
				$utps2sql = "SELECT * FROM `ranking` WHERE `user_name` = '$val[0]' AND `log` = 0 AND `stage_id` IN($imp_limstage)";
				$utps2result = mysqli_query($mysqlconn, $utps2sql);
				$utpscount = mysqli_num_rows($utps2result);
				if(!$blind) $show_score = number_format($val[2])." pts.";
				if( $blind) $show_score = "??,??? pts.";
				if($stage_id != 170429 and $stage_id != 171013 and $stage_id != 180101) echo '<tr style="color:#'.$teamc[$team_b].'"><td><b>'.$val[0].'</b></td><td>'.$val[1].' RPS</td><td>'.number_format($val[2]).' pts.</td></tr>';
				if($stage_id == 170429) echo '<tr style="color:#'.$teamc[$team_b].'"><td><b>'.$val[0].'</b></td><td>'.$val[1].' RPS</td><td>['.$utpscount.'<span style="color:#777777;">/4</span>]</td><td>'.number_format($val[2]).' pts.</td></tr>';
				if($stage_id == 180101) echo '<tr style="color:#'.$teamc[$team_b].'"><td><b>'.$val[0].'</b></td><td>'.$val[1].' RPS</td><td>['.$utpscount.'<span style="color:#777777;">/4</span>]</td><td>'.$show_score.'</td></tr>';
				if($stage_id == 171013) echo '<tr style="color:#'.$teamc[$team_b].'"><td>'.$val[4].'<b>'.$val[0].'</b>'.$val[3].'</td><td>'.$val[1].' <br><span class="att">RPS</span></td><td>'.number_format($val[2]).' <br><span class="att">pts.</span></td></tr>';
			}
			if(isset($is_minority)){
				if($is_minority == 2 and $stage_id == 170429) echo '<tr title="総投稿数が少ないチームに{参加者数÷2}の切り捨てを付与" style="color:#'.$teamc[$team_b].'"><td glot-model="main_limited_bonus">(ボーナス)</td><td>'.$minority_bonus.' RPS</td><td>['.$post_diff.']</td><td>- pts.</td></tr>';
				if($is_minority == 2 and $stage_id != 170429 and $stage_id != 171013) echo '<tr style="color:#'.$teamc[$team_b].'"><td glot-model="main_limited_bonus">(ボーナス)</td><td>'.$minority_bonus.' RPS</td><td>- pts.</td></tr>';
				if($is_minority == 2 and $stage_id == 171013) echo '<tr style="color:#'.$teamc[$team_b].'"><td glot-model="main_limited_bonus">(ボーナス)</td><td>'.$minority_bonus.' <br><span class="att">RPS</span></td><td>- <br><span class="att">pts.</span></td></tr>';
			}
		} else {
			echo '<tr><td colspan="4" glot-model="main_limited_noplayer">(まだ参加者がいません)</td></tr>';
		}
		echo '</table>';
		echo '<td style="width:20%;text-align:center;vertical-align:top;'.$background_color.'">';

		// エリア踏破制の場合は陣地の数を計算する
		$areacount = 0;
		$flag = '';
		$limcount = array_search($stage_id, $limited_stage_list);
		$sql = "SELECT * FROM `area` WHERE `lim` = '$limcount' AND `flag` = 4";
		$result = mysqli_query($mysqlconn, $sql);
		$areacount = mysqli_num_rows($result);
		if($areacount > 0){
			echo '<span style="color:#'.$teamc[$team_b].';" class="team_point">'.$areacount.'</span><hr style="height:3px;border:none;background-color:#'.$teamc[$team_b].';">';
		}
		echo '<span style="color:#'.$teamc[$team_b].'" class="team_point">'.${'rps'.$team_b}.'</span>';
		echo '<br>';
		if(!$blind) echo '<span style="color:#'.$teamc[$team_b].'" class="team_point_mini">.'.${'team'.$team_b.'_score'}.'</span></td>';
		if( $blind) echo '<span style="color:#'.$teamc[$team_b].'" class="team_point_mini">.?????</span></td>';

		echo '</td></tr></table>';
		// チーム対抗戦ここまで
	}
	// 総合ヘッダーここまで
	echo '<table id="team_tab" class="pik4_teamtab" style="margin-top:0.5em;">'."\n";
	if($stage_id < 211105) foreach($row_output as $output)	echo $output."\n";
	echo '</table></div></div>';
	echo '<div class="pc-hidden" style="width:100%;height:80px;"> </div>';
	if($area_team_flag == 1) echo '</div>';

	$show_scoretable = 0;
