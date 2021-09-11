<?php
// シーズントップスコア概要表示
$season_sql = "SELECT * FROM `ranking` WHERE `season` = '$season' AND `stage_id` = '$stage_id' AND `log` < 2 ORDER BY `score` DESC,`post_date` ASC LIMIT 1";
$season_result = mysqli_query($mysqlconn, $season_sql);
$season_top = mysqli_fetch_assoc($season_result);
if($season_top){
	// シーズンボタン
	if($page_type == 3 or $page_type == 5 or $page_type == 7 or $page_type == 8 or $page_type == 11){
		if($season_data == 2) $season_batton = '<span><A style="color:#38ff23;background-color:#3a3a3a;" href="javascript:void(0);" onclick="SeasonToggle(\'season_data\');">→<span glot-model="main_season_toggleall">全期間モード</span></span></A></span>';
		if($season_data != 2) $season_batton = '<span><A style="color:#38ff23;background-color:#3a3a3a;" href="javascript:void(0);" onclick="SeasonToggle(\'season_data\');">→<span glot-model="main_season_toggleseason">シーズンモード</span></span></A></span>';
	}
	echo '<div class="mobile-hidden" style="padding: 4px; margin: 10px 10px 10px 81px;border-radius: 10px 0px 0px 10px;background-color: #cccccc;">';
	echo '<div style="text-align:center;color:#000000;font-weight:bold;">'.'<span glot-model="menu_limited_dai">第</span>'.$season.'<span glot-model="menu_ki">期</span><span glot-model="main_topscore">トップスコア</span> '.$season_batton.'</div>';
	echo '<table style="border-collapse: collapse;table-layout: fixed;width: 100%; background-color: #555555;border-radius: 10px 0px 0px 10px;">';
	echo '<tr><td style="padding-left:0.5em;width:253.7px" glot-model="main_score_player">プレイヤー</td><td style="padding-left:0.25em;width:253.7px" glot-model="main_score_score">スコア</td><td style="padding-left:0.0em;" glot-model="main_score_date">投稿日時</td><tr>';
	echo '<td class="rtd_player">'.$season_top['user_name'].'</td>';
	if(($stage_id >= 311 and $stage_id <= 316) or ($stage_id >= 2311 and $stage_id <= 2316) or $stage_id == 356 or $stage_id == 359 or $stage_id == 361 or $stage_id == 2356 or $stage_id == 2359 or $stage_id == 2361){
		$decode_score = bossscore_enc($stage_id, $season_top['score']);
		$score_sec = sprintf('%02d', fmod ( $decode_score , 60) );
		$score_min = floor( $decode_score / 60);
		$season_score_echo = $score_min.":".$score_sec;
	} else {
		$season_score_echo = number_format($season_top['score']).'<span class="score_tale"> pts.</span>';
	}
	echo '<td class="rtd_score">'.$season_score_echo.'</td>';
	echo '<td>'.date('Y/m/d H:i:s', strtotime($season_top['post_date'])).'</td></tr>';
	echo '</table>';
	echo '</div>';
	echo '<div class="pc-hidden" style="padding: 4px; margin: 10px;border-radius: 10px 0px 0px 10px;background-color: #cccccc;">';
	echo '<div style="text-align:center;color:#000000;font-weight:bold;">'.'<span glot-model="menu_limited_dai">第</span>'.$season.'<span glot-model="menu_ki">期</span><span glot-model="menu_topscore">トップスコア</span> '.$season_batton.'</div>';
	echo '<table style="border-collapse: collapse;table-layout: fixed;width: 100%; background-color: #555555;border-radius: 10px 0px 0px 10px;">';
	echo '<tr><td style="padding-left:0.5em;" glot-model="main_score_player">プレイヤー</td><td style="padding-left:0.25em;" glot-model="main_score_score">スコア</td><td style="padding-left:0.0em;" glot-model="main_score_date">投稿日時</td><tr>';
	echo '<td class="rtd_player">'.$season_top['user_name'].'</td>';
	echo '<td style="text-align:left" class="rtd_score">'.number_format($season_top['score']).'<span class="score_tale"> pts.</span></td>';
	echo '<td>'.date('Y/m/d H:i:s', strtotime($season_top['post_date'])).'</td></tr>';
	echo '</table>';
	echo '</div>';
}
// 携帯版投稿ボタン
// if($page_type == 0 or $page_type == 1 or $page_type == 2 or $page_type == 5 or $page_type == 6 or $page_type == 9 or $page_type == 10 or $page_type == 13 or $page_type == 15 or $page_type == 17 or $page_type == 18 or $page_type == 20 or $page_type == 21 or $page_type > 97){
// } else {
// 	echo '<A href="#form" style="display:block;">
// 	<div class="form_button pc-hidden">
// 		<div class="holder">
// 			<div class="first"></div>
// 			<div class="second"></div>
// 			<div class="third"></div>
// 			<div class="txt" style="text-align:center;margin:8px;width:96%;height:86px;background-color:#fff;border-radius:5px;">
// 				<div style="margin-top:24px;">
// 					<span style="border-bottom:solid 1px #777;color:#000;"><i class="faa-float animated fa fa-paper-plane" style="color:#000;" aria-hidden="true"></i>
// 					<span glot-model="menu_submit">このステージに投稿する</span></span> <br>　<span style="color:#555;font-size:0.9em;"><span glot-model="menu_submit_sub">　Submit Record</span></span>
// 				</div>
// 			</div>
// 		</div>
// 	</div></A>';
// }
// 各種変数をリセットする
$i = 0;			// 現在の順位 (総合ランキング)
$p = -1;		// ひとつ前の順位 (総合ランキング)
$score_array = array();	// 統計用配列
$rank_array = array();	// 統計用配列
$compare_score = 0;	// 比較対象スコア
$compare_win = 0;	// 比較対象に勝っている数
$compare_lose = 0;	// 比較対象に負けている数
$compare_even = 0;	// 比較対象と分けている数
$compare_blank = 0;	// 比較対象が空白である数
$compare_wr1 = 0;	// WR-60
$compare_wr2 = 0;	// WR-120
$compare_wr3 = 0;	// WR-180
$rp_level = 0;		//
$now_rows = 0;		// 処理済みの行数
$header_count = 1;	// ヘッダーを表示する回数
$user_ranking_loop = 0;	//
$top_ranker = array();	// トップランカー一覧
$team1_rpss = 0;	// チーム別集計ポイント
$team2_rpss = 0;	// チーム別集計ポイント
$team3_rpss = 0;	// チーム別集計ポイント
$team4_rpss = 0;	// チーム別集計ポイント
$console_type = '';	// 操作方法・体験版の識別
$pin_flag_used = 0;	// ピン表示フラグを初期化
$days_column = '';	// 本編情報
$sum_rps = array();	// 合計ランクポイント
$sum_score = array();	// 合計スコア
$sum_rank = array();	// 順位の配列
$sum_lest_score = array();// 比較値の合計
$fixed_lest_score = array();// 修正比較値（合計点差産出用）
$prev_score_hook = array();
$overlap_name = array();
$overrap_score = array();
$hidden_flag = 0;
$get_user_name = '';
$prev_score_db = 0;

// 全ステージ一覧はヘッダーを出力しない
if($stage_id == 5) $header_count = 0;

// 結果行数を取得
$rows_count = mysqli_num_rows($result);

// ランキングポイント計算を行数分だけWHILEで回す
while ($row = mysqli_fetch_assoc($result) ){

	// 証拠動画の正規性判定を設定

	if(isset($row["stage_id"])){
		if($row["stage_id"] > 200 and $row["stage_id"] < 231){
			if($row["video_url"] !== "" or strpos($row["pic_file"], 'mp4') > 0){
				$video_match = 1;
			} else {
				$video_match = 0;
			}
		} else {
			$video_match = 1;
		}
	} else {
		$video_match = 1;
	}
	// バトルモードの場合はレートをスコアとする
	if($page_type == 16){
		$row["score"] = $row["rate"];
	}

	// 名前が重複していた場合ループをスキップする（シーズンスコア表示のみ）
	if($stage_id == 99 or (($season_data == 2 or $separation_mode == 2) and ($page_type == 3 or $page_type == 7 or $page_type == 8 or $page_type == 11))){
		if($stage_id == 99) $name_hook = $row["name"];
		if($stage_id != 99) $name_hook = $row["user_name"];
		$overlap_jag = array_search($name_hook, $overlap_name);
		if($overlap_jag === false){
			$overlap_name[] = $name_hook;
			$hidden_flag = 0;
		} else {
			continue;
		}
	}
	// ステージが重複していた場合ループをスキップする（ユーザー別シーズンスコア表示のみ→シーズンベスト以外を切り捨てる）
	if(($season_data == 2 or $separation_mode == 2) and $page_type == 5){
		$now_stage_id = $row["stage_id"];
		$now_user_name = $row["user_name"];
		$spsql = "SELECT * FROM `ranking` WHERE `season` = '$season' AND `user_name` = '$now_user_name' AND `log` < 2 AND `stage_id` = '$now_stage_id' ORDER BY `score` DESC LIMIT 1";
		$spresult = mysqli_query($mysqlconn, $spsql);
		$sprow = mysqli_fetch_assoc($spresult);
		if($sprow["score"] > $row["score"]){
			continue;
		}
	}
	// 残り行数を取得
	$lest_rows = $rows_count - $now_rows;

	// シーズンモード表示中のユーザー別ページ表示時、シーズン別順位を計算する
	if(($season_data == 2 or $separation_mode == 2) and ($page_type == 5 or $page_type == 1)){
		$key = $row["score"];
		$now_stage_id = $row["stage_id"];
		$jad_score_list = array();
		$jad2_score_list= array();
		$rank = 0;
		$sssql = "SELECT * FROM `ranking` WHERE `season` = '$season' AND `log` < 2 AND `stage_id` = '$now_stage_id' ORDER BY `score` ASC";
		$ssresult = mysqli_query($mysqlconn, $sssql);
		while ($ssrow = mysqli_fetch_assoc($ssresult) ){
			$jad_score_list[$ssrow["user_name"]] = $ssrow["score"];
		}
		rsort($jad_score_list);
		$jad2_score_list = array_count_values($jad_score_list);
		$rank = array_search($key, $jad_score_list);
		if($jad2_score_list[$key] > 1){
			$i = $rank + 1;
		} else {
			$i = $rank + 1;
		}
		if($i < 1) $i = 1;
	}

	// 順位の重複判定（シーズンモード）
	if( ($filtering_sub_data > 1 or $season_data == 2 or $separation_mode == 2) and $page_type != 5 and $page_type != 1){
		$key = $row["score"];
		$counter_overrap_score = array_count_values($overrap_score);
		if(isset($counter_overrap_score[$key])){
			$i = $now_rows + 1 - $counter_overrap_score[$key];
		} else {
			$i = $now_rows + 1;
		}
		$overrap_score[] = $row["score"];
	}

	// 順位の重複判定 (総合ランキング)
	if($season_data != 2){
	$score_hook = 0;
		if ( $stage_id == 7) $score_hook = $row["total_all"] ;
		if ( $stage_id == 8) $score_hook = $row["total_sp"] ;
		if ( $stage_id == 9 ) $score_hook = $row["total_rps"] ;
		if ( $stage_id == 10) $score_hook = $row["total_pik1cha"] ;
		if ( $stage_id == 20 ) $score_hook = $row["total_pik2cha"] ;
		if ( $stage_id == 21 ) $score_hook = $row["total_pik2egg"] ;
		if ( $stage_id == 22 ) $score_hook = $row["total_pik2noegg"] ;
		if ( $stage_id == 23 ) $score_hook = $row["total_pik2cave"] ;
		if ( $stage_id == 24 ) $score_hook = $row["total_pik2_2p"] ;
		if ( $stage_id == 25 ) $score_hook = $row["total_battle2"] ;
		if ( $stage_id == 26 ) $score_hook = $row["total_new"] ;
		if ( $stage_id == 27 ) $score_hook = $row["season_pik2cha"] ;
		if ( $stage_id == 28 ) $score_hook = $row["total_new2"] ;
		if ( $stage_id == 30 ) $score_hook = $row["total_pik3cha"] ;
		if ( $stage_id == 31 ) $score_hook = $row["total_pik3ct"] ;
		if ( $stage_id == 32 ) $score_hook = $row["total_pik3be"] ;
		if ( $stage_id == 33 ) $score_hook = $row["total_pik3db"] ;
		if ( $stage_id == 34 ) $score_hook = $row["total_pik3_2p"] ;
		if ( $stage_id == 35 ) $score_hook = $row["total_battle3"] ;
		if ( $stage_id == 36 ) $score_hook = $row["total_pik3ss"] ;
		if ( $stage_id == 81 ) $score_hook = $row["total_unlimit"] ;
		if ( $stage_id == 82 ) $score_hook = $row["total_tas"] ;
		if ( $stage_id == 91 ) $score_hook = $row["total_limited000"] ;
		if ( $stage_id == 92 ) $score_hook = $row["total_diary"] ;
		if ( $stage_id == 93 ) $score_hook = $row["total_story"] ;
		if ( $stage_id == 94 ) $score_hook = $row["total_mix"] ;
		if ( $stage_id == 95 ) $score_hook = $row["battle_rate"] ;
		if ( $stage_id == 98 ) $score_hook = $row["post_count"] ;
		if ( $stage_id == 99 ) $score_hook = $row["minites_count"] ;
		if ( $stage_id == 190209 ) $score_hook = $row["total_uplan001rps"] ;
		if ( $stage_id == 190321 ) $score_hook = $row["total_uplan002rps"] ;
		if ( $stage_id == 210829 ) $score_hook = $row["total_uplan003rps"] ;
		if ( $page_type == 6 or $page_type == 13) {
			$target_db_num = sprintf('%03d', array_search($stage_id, $limited_stage_list) );
			$target_db = 'total_limited'.$target_db_num;
			$score_hook = $row[$target_db] ;
		}
		$prev_score_hook[$now_rows] = $score_hook;		// 前に取り出したスコアを参照する
		if($p < 0){
			$prev_score_hook_check = 9999999;
		} else {
			$prev_score_hook_check = $prev_score_hook[$p];
		}
		if ( $prev_score_hook_check != $score_hook){	// 前のスコアと同じでないなら現在順位を結果行数に直す
			$i = $now_rows + 1;
			$p = $now_rows;
		}
	}
	// ステージ名出力
	if(isset($row["stage_id"])){
		$get_stage_id = $row["stage_id"];
			if(($get_stage_id > 100 and $get_stage_id < 231) or ($get_stage_id > 300 and $get_stage_id < 363) or ($get_stage_id > 2300 and $get_stage_id < 2362)){
				// 通常ランキングの場合、ステージ名をカテゴリ接頭辞に変換
				if($get_stage_id >= 101 and $get_stage_id <= 230) $stage_name =   "".sprintf('%02d',$get_stage_id - 0  );
				if($get_stage_id >= 301 and $get_stage_id <= 305) $stage_name = "CT".sprintf('%02d',$get_stage_id - 300);
				if($get_stage_id >= 306 and $get_stage_id <= 310) $stage_name = "BE".sprintf('%02d',$get_stage_id - 305);
				if($get_stage_id >= 311 and $get_stage_id <= 316) $stage_name = "DB".sprintf('%02d',$get_stage_id - 310);
				if($get_stage_id >= 317 and $get_stage_id <= 321) $stage_name = "CT".sprintf('%02d',$get_stage_id - 316);
				if($get_stage_id >= 322 and $get_stage_id <= 326) $stage_name = "BE".sprintf('%02d',$get_stage_id - 316);
				if($get_stage_id >= 327 and $get_stage_id <= 331) $stage_name = "CT".sprintf('%02d',$get_stage_id - 316);
				if($get_stage_id >= 332 and $get_stage_id <= 336) $stage_name = "BE".sprintf('%02d',$get_stage_id - 321);
				if($get_stage_id >= 349 and $get_stage_id <= 362) $stage_name = "SS".sprintf('%02d',$get_stage_id - 348);
				if($get_stage_id >=2301 and $get_stage_id <=2305) $stage_name = "CT".sprintf('%02d',$get_stage_id -2300);
				if($get_stage_id >=2306 and $get_stage_id <=2310) $stage_name = "BE".sprintf('%02d',$get_stage_id -2305);
				if($get_stage_id >=2311 and $get_stage_id <=2316) $stage_name = "DB".sprintf('%02d',$get_stage_id -2310);
				if($get_stage_id >=2317 and $get_stage_id <=2321) $stage_name = "CT".sprintf('%02d',$get_stage_id -2316);
				if($get_stage_id >=2322 and $get_stage_id <=2326) $stage_name = "BE".sprintf('%02d',$get_stage_id -2316);
				if($get_stage_id >=2327 and $get_stage_id <=2331) $stage_name = "CT".sprintf('%02d',$get_stage_id -2316);
				if($get_stage_id >=2332 and $get_stage_id <=2336) $stage_name = "BE".sprintf('%02d',$get_stage_id -2321);
				if($get_stage_id >=2349 and $get_stage_id <=2362) $stage_name = "SS".sprintf('%02d',$get_stage_id -2348);
				$needle = strpos ($array_stage_title[$get_stage_id] , '#');
				if($needle > 0 ) $needle = $needle + 1;
				$fixed_stage_title = mb_substr ( $array_stage_title[$get_stage_id] , $needle );
				$stage_name .= "#".$fixed_stage_title;
			} else {
				$stage_name = '<span style="color: #b8dcbc;"'.$array_stage_title[$get_stage_id]."</span>";
			}
	} else {
		$get_stage_id = 0;
		$stage_name = "";
	}

	// 接尾辞 (ステージ番号311～316の場合は表示しない)
	if( $stage_id == 25 OR $stage_id == 35 OR $stage_id == 95 OR ($get_stage_id > 274 AND $get_stage_id < 285) OR ($get_stage_id > 336 AND $get_stage_id < 349) OR ($get_stage_id > 310 AND $get_stage_id < 317) OR ($get_stage_id > 2310 AND $get_stage_id < 2317) OR ($get_stage_id > 10000 AND $get_stage_id < 20000) or $get_stage_id == 356 or $get_stage_id == 359 or $get_stage_id == 361 or $get_stage_id == 2356 or $get_stage_id == 2359 or $get_stage_id == 2361) {
		$score_tale = "";
		$score_tale2 = "";
	} elseif($stage_id == 98) {
		$score_tale = '<font class="score_tale"> count</font>';
		$score_tale2 = "";
	} else {
		$score_tale = '<font class="score_tale"> pts.</font>';
		$score_tale2= ' pts.';
	}
	// ランクポイントを表示
	if(isset($row["rps"])){
		if(isset($limited_type[$stage_hook])){
			if($limited_type[$stage_hook] == "t"){
				$show_rps = '<span class="rtd_rps">['.$row["rps2"].'p]</span>';
			} else {
				$show_rps = '<span class="rtd_rps">['.$row["rps"].'p]</span>';
			}
		} else {
			$show_rps = '<span class="rtd_rps">['.$row["rps"].'p]</span>';
		}
	}
	// コメントを処理 (タマゴムシくじはユーザーDBから自動的にコメントを取得)
	if(isset($row["user_name"])){
		$egg_user_name   = $row["user_name"];
	} else {
		$egg_user_name = '';
	}
	if(isset($row["post_comment"])){
		if ( $row["post_rank"] == 1 and $video_match != 1){
			$get_post_comment= '<span glot-model="main_score_notvideo">この記録は１位ですが証拠動画がありません。</span>';
		} else {
			$get_post_comment= $row["post_comment"];
		}
	} else {
		$get_post_comment= "";
	}
	if ($get_stage_id == 299 ){
		$egg_sql = "SELECT * FROM `user` WHERE `user_name` = '$egg_user_name' ORDER BY `user_name` DESC";
		$egg_result = mysqli_query($mysqlconn, $egg_sql);
		if (!$egg_result) {
			die('<br>Error '.__LINE__.'：クエリの取得に失敗.'.mysql_error());
		}
		while ($egg_row = mysqli_fetch_assoc($egg_result) ){
			$get_egg = $egg_row["egg"];
			$get_post_comment = '<span glot-model="main_score_egg">割ったタマゴの総数</span>：'.$get_egg ;
		}
	}

	// スコア比較ここから
	if(isset($row["stage_id"])){

	// 対象ステージの比較対象スコアを抽出
	$sub_stage_id = $row["stage_id"];
	$compare_score = 0;		// 比較スコアをリセットする
	$compare_special = 0;		// 特殊比較フラグ
	$row_score = $row["score"];	// 表示するスコア
	if (!is_numeric($compare_data) ){
			if ($compare_data == "_TIME"){
				$sub_sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$sub_stage_id'";
				$compare_special = 1;
			} elseif ($compare_data == "_WR"){
				$sub_sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$sub_stage_id'";
				$compare_special = 2;
			} elseif ($compare_data == "_WRDX"){
				$sub_sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$sub_stage_id'";
				$compare_special = 10;
			} elseif ($compare_data == "_SD"){
				$sub_sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$sub_stage_id'";
				$compare_special = 3;
			} elseif ($compare_data == "_AVE"){
				$sub_sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$sub_stage_id'";
				$compare_special = 4;
			} elseif ($compare_data == "_700K"){
				$sub_sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$sub_stage_id'";
				$compare_special = 5;
			} elseif ($compare_data == "_701K"){
				$sub_sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$sub_stage_id'";
				$compare_special = 6;
			} elseif ($compare_data == "_DEF"){
				$sub_sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$sub_stage_id'";
				$compare_special = 7;
			} elseif ($compare_data == "_UX"){
				$sub_sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$sub_stage_id'";
				$compare_special = 8;
			} elseif ($compare_data == "_NEXT"){
				$sub_sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$sub_stage_id' AND `log` = 0 AND `score` > '$row_score' ORDER BY `score` ASC LIMIT 1";
				$compare_special = 9;
			} else {
				$sub_sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$sub_stage_id' AND `log` = 0 AND `user_name` = '$compare_data' ORDER BY `stage_id` DESC";
			}
	} else {
		$sub_sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$sub_stage_id' AND `log` = 0 AND `post_rank` <= '$compare_data' ORDER BY `post_rank` DESC LIMIT 1";
	}
	$sub_result = mysqli_query($mysqlconn, $sub_sql);
	if (!$sub_result) {
		die('<br>Error '.__LINE__.'：クエリの取得に失敗.'.mysql_error());
	}
	$sub_row = mysqli_fetch_assoc($sub_result);
	if ($compare_special == 1){
	// ピクミン2チャレンジモードの全回収時タイムボーナスを計算
		if ($sub_stage_id > 200 and $sub_stage_id < 298){
			$compare_score = ($sub_row["Max_Treture"]*10) + ($sub_row["Total_Pikmin"]*10);
		// ピクミン3デフォルトステージのタイムボーナスを計算 (
		} elseif ($sub_stage_id > 300 and $sub_stage_id < 366){
			$compare_score = $sub_row["Max_Treture"];
		} else {
			$compare_score = 0;
		}
	} else {
		if(isset($sub_row["score"])){
			$compare_score = $sub_row["score"];
		}
	}

	// 固定値を比較値に代入
	if($compare_special == 2) $compare_score = $sub_row["wr"];
	if($compare_special == 4) $compare_score = round($sub_row["score_ave"]);
	if($compare_special == 5) $compare_score = $sub_row["border_line"];
	if($compare_special == 6) $compare_score = $sub_row["border_line_701k"];
	if($compare_special == 8) $compare_score = $sub_row["unexpected"];
	if($compare_special == 9) $compare_score = $sub_row["score"];
	if($compare_special ==10) $compare_score = $sub_row["wrdx"];

	// ピクミン3のWRを変換
	if((($sub_stage_id > 310 and $sub_stage_id < 317) or ($sub_stage_id > 2310 and $sub_stage_id < 2317) or $sub_stage_id == 356 or $sub_stage_id == 359 or $sub_stage_id == 361 or $sub_stage_id == 2356 or $sub_stage_id == 2359 or $sub_stage_id == 2361) and ($compare_special == 2 or $compare_special == 8 or $compare_special == 10)){
		if($compare_score > 0){
			$compare_score = bossscore_enc($sub_stage_id, $compare_score);
		}
	}

	// 選択されている比較値を計算
	if($sub_stage_id < 10000){
		$lest_score = $row_score - $compare_score ;
		$fixed_lest_score = $row_score - $compare_score ;
		if($compare_score < 1) $fixed_lest_score = 0 ; // 比較点差産出用（ライバルが投稿していないステージは計算しない）
	}
	if ($sub_stage_id > 10000 and $sub_stage_id < 20000){
		$lest_score = $compare_score - $row_score;
		$fixed_lest_score = $compare_score - $row_score;
		if($compare_score < 1) $fixed_lest_score = 0 ;
	}

	// ピクミン3タイムボーナス比較の場合、対象ステージから残時間を再計算
	if ($compare_special != 0){
		$ss_normal_stage = array(349, 350, 351, 352, 353, 354, 355, 357, 358, 360, 362);
		if ($sub_stage_id > 300 and $sub_stage_id < 311) $lest_score = $lest_score/30; // デフォルトステージ
		if ($sub_stage_id > 316 and $sub_stage_id < 322) $lest_score = $lest_score/30; // DLC第一弾
		if ($sub_stage_id > 321 and $sub_stage_id < 327) $lest_score = $lest_score/10; // DLC第二弾
		if ($sub_stage_id > 326 and $sub_stage_id < 332) $lest_score = $lest_score/30; // DLC第三弾・お宝をあつめろ！
		if ($sub_stage_id > 331 and $sub_stage_id < 337) $lest_score = $lest_score/10; // DLC第三弾・原生生物をたおせ！
		if (array_search($sub_stage_id, $ss_normal_stage) !== false) $lest_score = $lest_score/30; // サイドストーリーモード
		if ($sub_stage_id > 2300 and $sub_stage_id < 2311) $lest_score = $lest_score/30; // デフォルトステージ
		if ($sub_stage_id > 2316 and $sub_stage_id < 2322) $lest_score = $lest_score/30; // DLC第一弾
		if ($sub_stage_id > 2321 and $sub_stage_id < 2327) $lest_score = $lest_score/10; // DLC第二弾
		if ($sub_stage_id > 2326 and $sub_stage_id < 2332) $lest_score = $lest_score/30; // DLC第三弾・お宝をあつめろ！
		if ($sub_stage_id > 2331 and $sub_stage_id < 2337) $lest_score = $lest_score/10; // DLC第三弾・原生生物をたおせ！
		if ($sub_stage_id > 2348 and $sub_stage_id < 2363) $lest_score = $lest_score/30; // サイドストーリーモード
	}

	// スコアごとの比較値を表示
	if ( $compare_score < 1){
		$get_lest_score = '';
		$compare_blank++;

	// タイムボーナスの場合、ピクミン3の場合はM:SS表記で、ピクミン2の場合はSSS表記で表示
	} elseif ( $lest_score > 0 and $compare_special == 1){
		if(($sub_stage_id > 300 and $sub_stage_id < 400) or ($sub_stage_id > 2300 and $sub_stage_id < 2400)){
			$get_lest_score = ' <font class="rtd_score_win">(+'.time_enc(round($lest_score)).")</font>";
		} else {
			$get_lest_score = ' <font class="rtd_score_win">(+'.round($lest_score).")</font>";
		}
		$compare_win++;
	} elseif ( $lest_score > 0 and $compare_special != 2 and $compare_special != 10){
		$get_lest_score = ' <font class="rtd_score_win">(+'.round($lest_score).")</font>";
		$compare_win++;
	} elseif ( $lest_score < 0 and ($compare_special == 0 or $compare_special == 4 or $compare_special == 5 or $compare_special == 6 or $compare_special == 8 or  $compare_special == 9)){

		// タイムボーナス表示中、比較値がマイナスの場合はスコアを表示しない
			$get_lest_score = ' <font class="rtd_score_lose">('.round($lest_score).")</font>";
			$compare_lose++;

	// ピクミン3世界記録比較の別途計算
	} elseif ($compare_special == 2 or $compare_special == 10){
		if($lest_score >= 0){
			// 世界記録表示中、現WRと一致または超えていたら★を付ける
			$get_lest_score = ' <font class="rtd_score_wr0">(★WR+'.number_format($lest_score).')</font>';
			$compare_even++;
		} elseif ( $lest_score < 0    and $lest_score > -61 ) {
			$get_lest_score = ' <font class="rtd_score_wr1">('.round($lest_score).")</font>";
			$compare_wr1++;
		} elseif ( $lest_score < -60  and $lest_score > -121) {
			$get_lest_score = ' <font class="rtd_score_wr2">('.round($lest_score).")</font>";
			$compare_wr2++;
		} elseif ( $lest_score < -120 and $lest_score > -181) {
			$get_lest_score = ' <font class="rtd_score_wr3">('.round($lest_score).")</font>";
			$compare_wr3++;
		} else {
			$get_lest_score = ' <font class="rtd_score_wr4">('.round($lest_score).")</font>";
			$compare_lose++;
		}
	} else {
			$get_lest_score = '';
			$compare_even++;
	}
	// 偏差値を計算
	if ($compare_special == 3){
		$score_sdss = ($row_score - $sub_row["score_ave"]) / sqrt($sub_row["score_sd"]) * 10 + 50;
		if($score_sdss > 99){
			$get_lest_score = ' <font class="rtd_score_ssds">[99+]</font>';
		} elseif($score_sdss < 0){
			$get_lest_score = ' <font class="rtd_score_ssds">[<0]</font>';
		} else {
			$get_lest_score = ' <font class="rtd_score_ssds">['.round($score_sdss).']</font>';
		}
	}
	// 2回目以降の投稿の場合前回スコアとの比較値を計算
	if (isset($row["prev_score"])){
		if($row["prev_score"] > 0){
			$get_prev_score	= $row["prev_score"];
			$date_hook = $row["firstpost_date"];
			$get_post_count = $row["post_count"];
			$get_prev_post_date = substr( $date_hook , 0 , 10);
			$get_prev_post_time = substr( $date_hook , 11, 8 );
			$diff_score = $row["score"] - $row["prev_score"] ;
			$show_diff = abs( $diff_score );

			// 更新の場合のみツールチップを表示する (本編ランキングでは負の数になるため絶対値で表示)
			if ( $diff_score != 0){
				$get_diff_score = '<i class="fa fa-hourglass tooltip f-white" title="前回のスコア（Prev Score）：'.$get_prev_score.$score_tale2." (+ ".$show_diff.") [".$get_prev_post_date.']"></i>';
			} else {
				$get_diff_score = '';
			}
		} else {
			$get_diff_score = "";
		}
	}

	// 順位変動マークを付与
	if(isset($row["prev_rank"])){
		if ( $row["prev_rank"] > 0 and $compare_special == 7){
			$get_prev_rank	= $row["prev_rank"];
			$get_now_rank	= $row["post_rank"];
			$diff_rank = $get_prev_rank - $get_now_rank;
			$diff_mark = '';

			if ( $get_prev_rank == 0 ){
				$diff_mark = '';
			} elseif ( $diff_rank > 0 ){
				$diff_mark = ' <font class="rtd_diffscores">(<font style="color:#fbff00;">↑</font>'.$diff_rank.")</font>";
				$compare_win++;
			} elseif ($diff_rank < 0){
				$diff_mark = ' <font class="rtd_diffscores">(<font style="color:#0300ff;">↓</font>'.$diff_rank.")</font>";
				$compare_lose++;
			} else {
				$diff_mark = ' <font class="rtd_diffscores">(<font style="color:#777777;">→</font>'.$diff_rank.")</font>";
				$compare_even++;
			}
		} else {
			$diff_mark = "";
		}
	}
	// スコア比較ここまで
	}

	// ボスバトルの場合にスコアを時間表記にデコードする
	if( ($get_stage_id > 310 AND $get_stage_id < 317) OR ($get_stage_id > 2310 AND $get_stage_id < 2317) or $get_stage_id == 356 or $get_stage_id == 359 or $get_stage_id == 361 or $get_stage_id == 2356 or $get_stage_id == 2359 or $get_stage_id == 2361) {
		$decode_score = bossscore_enc($get_stage_id, $row["score"]);
		$score_sec = sprintf('%02d', fmod ( $decode_score , 60) );
		$score_min = floor( $decode_score / 60);
		$show_score= $score_min.":".$score_sec;

	// 本編ランキングの場合、RTAタイムをスコアに変換
	} elseif($get_stage_id > 10000 AND $get_stage_id < 20000) {
		$show_score = time_enc($row["score"]);
	} else {

	// 通常ランキングの場合、ピン値比較用に前のスコアを保持しておく
		if(isset($row["score"])){
			$show_score= number_format( $row["score"] );
			$score_pin_array[$now_rows] = $row["score"];
		} else {
			$show_score= 0;
			$score_pin_array = array();
		}
	}
	// バトルモードの場合、レートをスコアとして扱う
	if( $page_type == 16){
		$score_float = round($row["rate"], 3);
		$score_int   = floor($row["rate"]);
		$score_deci  = sprintf('%03d', round(($score_float - $score_int) * 1000, 0));
		$show_score= $score_int.'<span class="score_tale">.'.$score_deci.'</span>';
	}
	// ブラインド制ランキングの場合、スコア表示を隠す
	if($blind and $row["stage_id"] >= $blind_start and $row["stage_id"] <= $blind_end){
		$show_score= "??,???";
		$get_diff_score = "前回のスコア（Prev Score）：??,??? pts.[".$get_prev_post_date."]";
		$get_lest_score = "";
	}
	// 携帯表示の場合、比較スコア表示の前に改行を挿入
	if(isset($get_lest_score)){
		$get_lest_score = '<br class="pc-hidden"/>'.$get_lest_score;
	}
	// チーム対抗の場合、ステージ別RPSを集計
	if($get_stage_id > 1014 and $get_stage_id < 1023){
		for($tc = 1; $tc <= $team_b2; $tc++){
			if($row["team"] == $tc) ${'team'.$tc.'_rpss'} += $row["rps2"];
		}
	}
	// 体験版の判別
	if($get_stage_id == 301 or $get_stage_id == 2301){
		$get_trial = $row["post_memo"];
		if($get_trial == "Trial"){
			$post_memo_paste = '<span style="color:#6eddd0;" glot-model="main_score_trial">[体験版]</span>';
		} else {
			$post_memo_paste = "";
		}
	} else {
		$post_memo_paste = "";
	}
	// 使用コントローラーの判別
	if ($get_stage_id != 299 and $get_stage_id > 100){
		$get_console = $row["console"];
		$get_console2= '';
		if(isset($row["console_2p"])) $get_console2= $row["console_2p"];
			if($get_console2){
				$console_type = '[1P:'.$array_console[$get_console].' 2P:'.$array_console[$get_console2].'] ';
			} else {
				$console_type = '['.$array_console[$get_console].'] ';
			}
	}
	// 証拠写真有無の判別
	if(!isset($row["pic_file"])){
		$pic_file_url = "";
	} elseif(!$row["pic_file"] or ($get_stage_id >= $blind_start and $get_stage_id <= $blind_end)){
		$pic_file_url = "";
	} else {
		if(strpos($row["pic_file"], 'mp4')){
			$pic_file_url = '<A href="./'.$row["unique_id"].'"><i class="fa fa-external-link"></i></A>';
		} else {
			$pic_file_url = '<A href="../_img/pik4/uploads/'.$row["pic_file"].'" data-lity="data-lity"><i class="fa fa-camera"></i></A>';
		}
		if(isset($row["pic_file2"])){
			if($row["pic_file2"]){
				$pic_file_url .= '<A href="../_img/pik4/uploads/'.$row["pic_file2"].'" data-lity="data-lity"><i class="fa fa-camera"></i></A>';
			}
		}
	}
	// 証拠動画有無の判別
	$video_link = "";
	if(!isset($row["video_url"])){
		$video_link = "";
	} elseif( !$row["video_url"]){
		$video_link = "";
	} elseif( strpos($row["video_url"], "youtu")) {
		$video_link = '<A href="'.$row["video_url"].'" data-lity="data-lity"><i class="fab fa-youtube"></i></A>';
	} elseif( strpos($row["video_url"], "twitter")) {
		$video_link = '<A href="'.twitter_videourl($row["video_url"]).'" data-lity="data-lity"><i class="fab fa-twitter"></i></A>';
	} else {
		// Twitch、ニコニコ動画はポップアップ非対応
		$video_link = '<A href="'.$row["video_url"].'"><i class="fas fa-video"></i></A>';
	}
	// 投稿IDの付与
	$tag_link = "";
	if(!isset($row["unique_id"])){
		$tag_link = "";
	} else {
//			$tag_link = '<A href="javascript:void(0)" onclick="id_tooltip('.$row["unique_id"].')"><i class="fa fa-tag rtd_tooltip"></i></A>';
		$tag_link = '<i class="fa fa-tag tooltip f-white" title="POST ID: '.$row["unique_id"].'"></i>';
	}
	// バトルモード総合の場合に総勝敗数を計算
	$battle_total_count = "";
	if($stage_id == 25 or $stage_id == 35 or $stage_id == 95){
		$row_user_name = $row["user_name"];
		$wins = 0;
		$lose = 0;
		$draw = 0;
		$cnt  = 0;
		if($stage_id == 25) $where = "AND `stage_id` BETWEEN 275 AND 284";
		if($stage_id == 35) $where = "AND `stage_id` BETWEEN 337 AND 348";
		if($stage_id == 95) $where = "AND `stage_id` IN(275,276,277,278,279,280,281,282,283,284,337,338,339,340,341,342,343,344,345,346,347,348)";
		$battle_sql = "SELECT * FROM `battle` WHERE `log` = 0 $where AND `user_name` = '$row_user_name'";
		$battle_result = mysqli_query($mysqlconn, $battle_sql);
		while($battle_row = mysqli_fetch_assoc($battle_result)){
			$wins += $battle_row["win"];
			$lose += $battle_row["lose"];
			$draw += $battle_row["draw"];
			$cnt = $wins + $lose + $draw;
		}
		$battle_total_count = ' ['.$cnt.'<span glot-model="main_battle_total">戦</span>'.$wins.'<span glot-model="main_battle_win">勝</span>'.$lose.'<span glot-model="main_battle_lose">敗</span>'.$draw.'<span glot-model="main_battle_draw">分</span>]';
	}

	// 本編地下の付属情報付与
	if($get_stage_id > 230 and $get_stage_id < 245){
		$cleartime_timer = time_enc($row["rta_time"]);
		$qr = 0;
		$caveinfo_array = array();
		if($row["red_pikmin"] > 0) $caveinfo_array[$qr] = '<span class="red">'.$row["red_pikmin"].'</span>'; $qr ++;
		if($row["yellow_pikmin"] > 0) $caveinfo_array[$qr] = '<span class="yellow">'.$row["yellow_pikmin"].'</span>'; $qr ++;
		if($row["blue_pikmin"] > 0) $caveinfo_array[$qr] = '<span class="blue">'.$row["blue_pikmin"].'</span>'; $qr ++;
		if($row["purple_pikmin"] > 0) $caveinfo_array[$qr] = '<span class="purple">'.$row["purple_pikmin"].'</span>'; $qr ++;
		if($row["white_pikmin"] > 0) $caveinfo_array[$qr] = '<span class="white">'.$row["white_pikmin"].'</span>'; $qr ++;
		if($row["bulbmin"] > 0) $caveinfo_array[$qr] = '<span class="bulbmin">'.$row["bulbmin"].'</span>'; $qr ++;
		if($row["queen_candypop_bud"] > 0) $caveinfo_array[$qr] = '<span class="queen">'.$row["queen_candypop_bud"].'</span>';
		$qr = 0;

		$caveinfo = '<span glot-model="main_score_tresure">お宝</span>:'.$row["correct"].'poko / <span class="rtd_popup" title="残(実)時間（remaining time）：'.$cleartime_timer.'"><span glot-model="main_score_time">タイムボーナス</span>:'.$cleartime.'</span> / <span glot-model="pik">ピクミン</span>:'.$row["pikmin"].'='.implode('+ ', $caveinfo_array).' (-<span glot-model="main_score_deaths">犠牲</span>: '.$row["death"].") <br>\n";
	} else {
		$caveinfo ='';
	}
	// スコアヒストリー機能リンク
	$history_link = "";
	if(isset($sub_stage_id)){
		$row_user_name = $row["user_name"];
		$history_sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$sub_stage_id' AND `log` != 2 AND `user_name` = '$row_user_name'";
		$history_result = mysqli_query($mysqlconn, $history_sql);
		$history_count = mysqli_num_rows($history_result);
		if($history_count > 1){
			$history_link = '<A href="#" onclick="ScoreHistory('.$get_stage_id.', \''.$row["user_name"].'\');"><i class="fa fa-history" aria-hidden="true"></i></A><span class="color:#333333;">('.$history_count.') </span>';
		}
	} else {
		$history_link = "";
	}
	// チャレンジ複合の通過タイムを整形
	if($get_stage_id > 10204 and $get_stage_id < 10215){
		$show_sum = '';
		$array_split_time  = array();
		$array_split_score = array();
		$split_table = '<table class="split_table">';
		if(isset($row["lim"])){
			$array_split = explode("_", $row["lim"]);
			if($get_stage_id < 10208) $offset = 0;
			if($get_stage_id < 10207) $length = 30;
			if($get_stage_id > 10206) $length = 5;
			if($get_stage_id ==10208) $offset = 5;
			if($get_stage_id ==10209) $offset = 10;
			if($get_stage_id ==10210) $offset = 15;
			if($get_stage_id ==10211) $offset = 20;
			if($get_stage_id ==10212) $offset = 25;
			if($get_stage_id ==10213) $length = 30;
			if($get_stage_id ==10213) $offset = 0;
			if($get_stage_id ==10214) $length = 30;
			if($get_stage_id ==10214) $offset = 0;
			$score_offset = $offset + 30;
			$array_split_time = array_slice($array_split, $offset, $length);
			$array_split_score = array_slice($array_split, $score_offset, $length);
			$sum_split_score = array_sum($array_split_score);
			if($sum_split_score > 0){
				$show_sum = ' <br><span style="font-size:0.9em;color:#bbbbbb;">'.number_format($sum_split_score)." pts.</span>";
			}
		}
		if($array_split_time[0] != ""){
			$i = 0;
			foreach($array_split_time as $val){
				$time2 = '';
				$time1 = '';
				$ssscore = '';
				if($i % 10 == 0) $split_table .= "<tr>";
				$ti = explode(":", $val);
				$st = $i + $offset + 201;
				$stage_title = mb_substr($array_stage_title_raw[$st], 4); // ツールチップに不具合あり、英語非対応
				if($ti[0] == "") $ti[0] = 0;
				if($ti[1] == "") $ti[1] = 0;
				if($ti[2] == "") $ti[2] = 0;
				$time2 = sprintf("%02s", $ti[0]).":".sprintf("%02s", $ti[1]);
				$time1 = $time2.":".sprintf("%02s", $ti[2]);
				if($array_split_score[$i] > 0) $ssscore = ' ('.$array_split_score[$i].' pts.)';
				if($val == "::") $split_table .= '<td class="tooltip" title="'.$st.'#'.$stage_title."＝?:??".$ssscore.'"> - </td>';
				if($val != "::" and $get_stage_id > 10206 and $get_stage_id < 10213) $split_table .= '<td class="tooltip" title="'.$st.'#'.$stage_title."＝".$time1.$ssscore.'">'.$time1.'</td>';
				if($val != "::" and ($get_stage_id < 10207 or  $get_stage_id > 10212)) $split_table .= '<td class="tooltip" title="'.$st.'#'.$stage_title."＝".$time1.$ssscore.'">'.$time2.'</td>';
				if($i % 10 == 9) $split_table .= "</tr>";
				$i++;
			}
		}
		$split_table.= '</table>';
	}
	// 本編付属情報の付与
	$rtd_other = '';
	$get_series = 0;
	if($get_stage_id > 10000 and $get_stage_id < 10200) $get_series = 1; //ピクミン1
	if($get_stage_id > 10199 and $get_stage_id < 10205) $get_series = 2; //ピクミン2
	if($get_stage_id > 10299 and $get_stage_id < 10400) $get_series = 3; //ピクミン3
	$get_storytype = ($get_stage_id != 10100 and $get_stage_id != 10200 and $get_stage_id != 10300) ? 0 : 1;
	if($get_series == 1){
		$pikmin_count = '<span glot-model="form_score_totalpikmin">増やした数</span>:'.$row["pikmin"].' <span glot-model="form_score_deaths">犠牲数</span>:'.$row["death"].' <span glot-model="red">赤</span>: '.$row["red_pikmin"].' <span glot-model="yellow">黄</span>: '.$row["yellow_pikmin"].' <span glot-model="blue">青</span>: '.$row["blue_pikmin"];
	} elseif($get_series == 2){
		$pikmin_count = '<span glot-model="form_score_totalpikmin">増やした数</span>:'.$row["pikmin"].' <span glot-model="form_score_deaths">犠牲数</span>:'.$row["death"].' <span glot-model="red">赤</span>: '.$row["red_pikmin"].' <span glot-model="yellow">黄</span>: '.$row["yellow_pikmin"].' <span glot-model="blue">青</span>: '.$row["blue_pikmin"].' <span glot-model="purple">紫</span>: '.$row["purple_pikmin"].' <span glot-model="white">白</span>: '.$row["white_pikmin"];
	} elseif($get_series == 3){
		$pikmin_count = '<span glot-model="form_score_totalpikmin">増やした数</span>:'.$row["pikmin"].' <span glot-model="form_score_deaths">犠牲数</span>:'.$row["death"].' <span glot-model="red">赤</span>: '.$row["red_pikmin"].' <span glot-model="yellow">黄</span>: '.$row["yellow_pikmin"].' <span glot-model="blue">青</span>: '.$row["blue_pikmin"].' <span glot-model="rock">岩</span>: '.$row["rock_pikmin"].' <span glot-model="winged">羽</span>: '.$row["winged_pikmin"];
	} else {
		$pikmin_count = '';
	}

	$rtd_other = $pikmin_count." <br>";
//		if($rtd_other !== '') $get_diff_score .= " ".$rtd_other;

	if($get_storytype == 1){
		$rtd_storypts = ' <br><span class="rtd_storypts">('.$row["story_pts"].' pts.)</span>';
	} else {
		$rtd_storypts = '';
	}
	// ユーザー名の整形
	if($stage_id == 99){
		$get_user_name = '<A href="./'.$row["name"].'">'.$row["name"].'</A>';

	} elseif(isset($row["user_name_2p"])){
		if($row["user_name_2p"] != ""){
			$get_user_name = '<A href="./'.$row["user_name"].'">'.$row["user_name"].'</A> <br>　× <br><A href="./'.$row["user_name_2p"].'">'.$row["user_name_2p"].'</A>';
		// レーティング制の場合はユーザー名の直下にレートを表示する
		} elseif($stage_id > 1035 and $stage_id < 1050){
			$rate = $row["rate"];
				if($rate < 500 or $rate > 1500){
				$show_rate = '<span class="rtd_rate">#？</span>';
			} else {
				$show_rate = '<span class="rtd_rate">#'.$rate."</span>";
			}
			$get_user_name = '<A href="./'.$row["user_name"].'">'.$row["user_name"].'</A> <br>'.$show_rate;
		} else {
			$get_user_name = '<A href="./'.$row["user_name"].'">'.$row["user_name"].'</A>';
		}
	} else {
		$get_user_name = '<A href="./'.$row["user_name"].'">'.$row["user_name"].'</A>';
	}

	// 順位によってTRのBackground-colorを変更する
	$rtd_tr = "rtd_21th"; // デフォルト値

	if (isset($row["post_rank"]) and $season_data != 2 and $log_data < 2 and $filtering_sub_data < 2 ) {
		$rtd = $row["post_rank"];
	} elseif(($filtering_sub_data < 2 or $log_data > 1) and ($page_type == 3 or $page_type == 12)){
		$rtd = $row["at_rank"];
	} else {
		$rtd = $i;
	}
	if ( $rtd == 1 and $video_match == 1) $rtd_tr = "rtd_1st";
	if ( $rtd == 1 and $video_match == 0) $rtd_tr = "rtd_1st_n";
	if ( $rtd == 2) $rtd_tr = "rtd_2nd";
	if ( $rtd == 3) $rtd_tr = "rtd_3rd";
	if ( $rtd >  3 and $rtd < 11) $rtd_tr = "rtd_10th";
	if ( $rtd > 10 and $rtd < 21) $rtd_tr = "rtd_11th";
	if ( $rtd > 20) $rtd_tr = "rtd_21th";

	// ループ内で取得する各種ヘッダー情報 (最終レコードまでの処理が終わったら一度だけ出力)
	if ( $lest_rows == 1){

	if( $page_type > 0 and $page_type < 9 and $page_type != 2 and $page_type != 6){
// チーム対抗RPS表示
		if($stage_id > 1014 and $stage_id < 1019){
			echo '<b glot-model="main_score_teamtotal">◆チーム別ランクポイント</b> <br>'."\n";
			echo '<span class="team1">'.$team[1].'</span><b>：'.$team1_rpss.' RP</b> <br>'."\n";
			echo '<span class="team2">'.$team[2].'</span><b>：'.$team2_rpss.' RP</b> <br>'."\n";
		}
		if($stage_id > 1018 and $stage_id < 1023){
			echo '<b glot-model="main_score_teamtotal">◆チーム別ランクポイント</b> <br>'."\n";
			echo '<span class="team3">'.$team[3].'</span><b>：'.$team3_rpss.' RP</b> <br>'."\n";
			echo '<span class="team4">'.$team[4].'</span><b>：'.$team4_rpss.' RP</b> <br>'."\n";
		}

	}
// ★ピン表示ここから
	}
	// 総合ランキングのコメント変数を処理 ($row["user_name"]からrankingにアクセス)
	if($page_type == 2 or $page_type == 21){
		$r = 1;
		$comm_sel = "201";
		$comment_temp = '<table class="total_comment_tab"><tr>';
		if($stage_id == 8 ) $comm_sel = "";
		if($stage_id == 10) $comm_sel = "BETWEEN 101 AND 105";
		if($stage_id == 20) $comm_sel = "BETWEEN 201 AND 230";
		if($stage_id == 21) $comm_sel = "IN(201,202,205,206,207,212,217,218,220,226,228,229,230)";
		if($stage_id == 22) $comm_sel = "IN(203,204,208,209,210,211,213,214,215,216,219,221,222,223,224,225,227)";
		if($stage_id == 23) $comm_sel = "BETWEEN 231 AND 244";
		if($stage_id == 24) $comm_sel = "BETWEEN 2201 AND 2230";
		if($stage_id == 25) $comm_sel = "BETWEEN 275 AND 284";
		if($stage_id == 26) $comm_sel = "BETWEEN 285 AND 297";
		if($stage_id == 27) $comm_sel = "BETWEEN 201 AND 230";
		if($stage_id == 28) $comm_sel = "BETWEEN 5001 AND 5013";
		if($stage_id == 30) $comm_sel = "IN(301,302,303,304,305,317,318,319,320,321,327,328,329,330,331,306,307,308,309,310,322,323,324,325,326,332,333,334,335,336,311,312,313,314,315,316,349,350,351,352,353,354,355,356,357,358,359,360,361,362)";
		if($stage_id == 31) $comm_sel = "IN(301,302,303,304,305,317,318,319,320,321,327,328,329,330,331)";
		if($stage_id == 32) $comm_sel = "IN(306,307,308,309,310,322,323,324,325,326,332,333,334,335,336)";
		if($stage_id == 33) $comm_sel = "IN(311,312,313,314,315,316)";
		if($stage_id == 34) $comm_sel = "BETWEEN 2301 AND 2336";
		if($stage_id == 35) $comm_sel = "BETWEEN 337 AND 348";
		if($stage_id == 36) $comm_sel = "BETWEEN 349 AND 362";
		if($stage_id == 81) $comm_sel = "BETWEEN 5018 AND 5047";
		if($stage_id == 82) $comm_sel = "BETWEEN 5048 AND 5077";
		if($stage_id == 91) $comm_sel = " = 499"; // 多すぎるので休止中
		if($stage_id == 92) $comm_sel = "BETWEEN 245 AND 274";
		if($stage_id == 93) $comm_sel = "IN(10101,10201,10202,10203,10204,10301,10302)";
		if($stage_id == 94) $comm_sel = "BETWEEN 10205 AND 10214";
		if($stage_id == 95) $comm_sel = "IN(275,276,277,278,279,280,281,282,283,284,337,338,339,340,341,342,343,344,345,346,347,348)";
		if($stage_id == 98) $comm_sel = "IN(100)";
		if($stage_id == 99) $comm_sel = "IN(100)";
		if($stage_id == 190209) $comm_sel = "BETWEEN 4001 AND 4030";
		if($stage_id == 190321) $comm_sel = "BETWEEN 4031 AND 4060";
		if($stage_id == 210829) $comm_sel = "BETWEEN 4061 AND 4073";

		if(isset($row["user_name"])){
			$comm_user_name = $row["user_name"];
		} else {
			$comm_user_name = "";
		}

		if($stage_id > 9){
			$comm_sql = "SELECT * FROM `ranking` WHERE `stage_id` $comm_sel AND `log` = 0 AND `user_name` = '$comm_user_name' ORDER BY `stage_id` ASC";
			if($stage_id == 27) $comm_sql = "SELECT DISTINCT `stage_id` FROM `ranking` WHERE `stage_id` $comm_sel AND `log` < 2 AND `season` = '$season' AND `user_name` = '$comm_user_name' ORDER BY `stage_id` ASC";
			if($stage_id == 25 or $stage_id == 35 or $stage_id == 95) $comm_sql = "SELECT * FROM `battle` WHERE `stage_id` $comm_sel AND `log` = 0 AND `user_name` = '$comm_user_name' ORDER BY `stage_id` ASC";
			$comm_result = mysqli_query($mysqlconn, $comm_sql);
			$comm_lastupdate = array();
			while ($comm_row = mysqli_fetch_assoc($comm_result) ){
				$comm_bg_css = "";
				$comm_lastupdate[] = $comm_row["post_date"];
				if($comm_row["post_rank"] == 1) $comm_rank_css = "r1st";
				if($comm_row["post_rank"] == 2) $comm_rank_css = "r2nd";
				if($comm_row["post_rank"] == 3) $comm_rank_css = "r3rd";
				if($comm_row["post_rank"] < 11 and $comm_row["post_rank"] > 3) $comm_rank_css = "r4th";
				if($comm_row["post_rank"] < 21 and $comm_row["post_rank"] >10) $comm_rank_css = "r5th";
				if($comm_row["post_rank"] > 20) $comm_rank_css = "r9th";
				if($comm_row["stage_id"] > 300 and $comm_row["stage_id"] < 306) $comm_bg_css = ' style="border-color:#c3f285"';
				if($comm_row["stage_id"] > 305 and $comm_row["stage_id"] < 311) $comm_bg_css = ' style="border-color:#85f2c6"';
				if($comm_row["stage_id"] > 310 and $comm_row["stage_id"] < 317) $comm_bg_css = ' style="border-color:#85e0f2"';
				if($comm_row["stage_id"] > 316 and $comm_row["stage_id"] < 322) $comm_bg_css = ' style="border-color:#c3f285"';
				if($comm_row["stage_id"] > 321 and $comm_row["stage_id"] < 327) $comm_bg_css = ' style="border-color:#85f2c6"';
				if($comm_row["stage_id"] > 326 and $comm_row["stage_id"] < 332) $comm_bg_css = ' style="border-color:#c3f285"';
				if($comm_row["stage_id"] > 331 and $comm_row["stage_id"] < 337) $comm_bg_css = ' style="border-color:#85f2c6"';
				$comment_temp .= '<td'.$comm_bg_css.'><span class="'.$comm_rank_css.'">';
				$array_stage_title[$comm_row["stage_id"]] = preg_replace('/<.*?>/', '', $array_stage_title[$comm_row["stage_id"]]);
				if($comm_row["stage_id"] > 316 and $comm_row["stage_id"] < 327){
					$comment_temp .= "続".mb_substr( $array_stage_title[$comm_row["stage_id"]], 6, 1);
				} elseif($comm_row["stage_id"] > 284 and $comm_row["stage_id"] < 298){
					$comment_temp .= mb_substr( $array_stage_title[$comm_row["stage_id"]], 6, 2);
				} elseif($comm_row["stage_id"] > 348 and $comm_row["stage_id"] < 353){
					$comment_temp .= mb_substr( $array_stage_title[$comm_row["stage_id"]], 12, 2);
				} elseif($comm_row["stage_id"] > 5000 and $comm_row["stage_id"] < 5018){
					$comment_temp .= mb_substr( $array_stage_title[$comm_row["stage_id"]], 7, 2);
				} else {
					$comment_temp .= mb_substr( $array_stage_title[$comm_row["stage_id"]], strpos($array_stage_title[$comm_row["stage_id"]],'#')+1, 2);
				}
				$comment_temp .= '<span style="font-weight:bold;">';
				$comment_temp .= sprintf("%'_2s", $comm_row["post_rank"]);
				$comment_temp .= "</span></span></td>";
				if($r % 10 == 0) $comment_temp .= "</tr><tr>";
				$r++;
			}
			rsort($comm_lastupdate);
			$comment_temp .= "</table>";
		} else { // 参加者総合ランキング
			$q = 0;
			$r = 0;
			if($stage_id == 9) $array_select_rank  = array("total_pik1cha", "total_pik2cha", "total_pik2egg", "total_pik2noegg", "total_pik3cha", "total_pik3ct", "total_pik3be", "total_pik3db","total_pik3ss");
			if($stage_id == 9) $array_select_rank_t= array($array_stage_title_veryshort[10], $array_stage_title_veryshort[20], $array_stage_title_veryshort[21], $array_stage_title_veryshort[22], $array_stage_title_veryshort[30], $array_stage_title_veryshort[31], $array_stage_title_veryshort[32], $array_stage_title_veryshort[33]);
			if($stage_id == 8) $array_select_rank  = array("total_limited000", "total_pik2cave", "total_story", "total_mix", "total_diary", "total_pik2_2p", "total_pik3_2p", "total_new", "total_new2", "total_battle2", "total_battle3");
			if($stage_id == 8) $array_select_rank_t= array($array_stage_title_veryshort[91], $array_stage_title_veryshort[24], $array_stage_title_veryshort[93], $array_stage_title_veryshort[94], $array_stage_title_veryshort[92], $array_stage_title_veryshort[24], $array_stage_title_veryshort[34], $array_stage_title_veryshort[26], $array_stage_title_veryshort[28], $array_stage_title_veryshort[25], $array_stage_title_veryshort[35]);
			if($stage_id == 7) $array_select_rank  = array("total_pik1cha", "total_pik2cha", "total_pik2egg", "total_pik2noegg", "total_pik3cha", "total_pik3ct", "total_pik3be", "total_pik3db","total_pik3ss","total_limited000", "total_pik2cave", "total_story", "total_mix", "total_diary", "total_pik2_2p", "total_pik3_2p", "total_new", "total_new2", "total_battle2", "total_battle3");
			if($stage_id == 7) $array_select_rank_t= array($array_stage_title_veryshort[10], $array_stage_title_veryshort[20], $array_stage_title_veryshort[21], $array_stage_title_veryshort[22], $array_stage_title_veryshort[30], $array_stage_title_veryshort[31], $array_stage_title_veryshort[32], $array_stage_title_veryshort[33], $array_stage_title_veryshort[36], $array_stage_title_veryshort[91], $array_stage_title_veryshort[24],
									$array_stage_title_veryshort[93], $array_stage_title_veryshort[94], $array_stage_title_veryshort[92], $array_stage_title_veryshort[24], $array_stage_title_veryshort[34], $array_stage_title_veryshort[26], $array_stage_title_veryshort[28], $array_stage_title_veryshort[25], $array_stage_title_veryshort[35]);
			foreach ( $array_select_rank as $val){
				$comm_rank_css = "";
				// ユーザーごとに都度ランキングを算出する方式は重すぎるので廃止（2021/01/17）
				// $rank_sql = "SELECT *, (SELECT COUNT(*) + 1 FROM `user` b WHERE b.$val > a.$val) AS `ranking` FROM `user` a WHERE `user_name` = '$comm_user_name'";
				// $rank_result = mysqli_query($mysqlconn, $rank_sql);
				// $rank_row = mysqli_fetch_assoc($rank_result);
				// $array_rank[$val] = $rank_row["ranking"];
				if(isset($users[$comm_user_name]["{$val}_rank"])) $comm_rank = $users[$comm_user_name]["{$val}_rank"];
				if($comm_rank == 1) $comm_rank_css = "r1st";
				if($comm_rank == 2) $comm_rank_css = "r2nd";
				if($comm_rank == 3) $comm_rank_css = "r3rd";
				if($comm_rank < 11 and $comm_rank > 3) $comm_rank_css = "r4th";
				if($comm_rank < 21 and $comm_rank >10) $comm_rank_css = "r5th";
				if($comm_rank > 20) $comm_rank_css = "r9th";
				if($comm_rank > 0) {
					$comment_temp .= '<td><span class="'.$comm_rank_css.'">'.$array_select_rank_t[$q]." <br>".$comm_rank."</span></td>";
					$r++;
				}
				if($r == 10) $comment_temp .= '</tr><tr>';
				$q++;
			}
			$comment_temp .= "</tr></table>";
		}
	}
	// 日付表記を分割する
	if($stage_id == 99){
		$date_hook = $row["date"];
	} elseif($page_type == 2 ){
		if(isset($comm_lastupdate[0])){
			$date_hook = $comm_lastupdate[0];
		} else {
			$date_hook = $row["lastupdate"];
		}
	} else {
		if(isset($row["post_date"])){
			$date_hook = $row["post_date"];
		} else {
			$date_hook = "";
		}
	}
	$new_record_flag = "";
	if($now_time < (strtotime($date_hook) + ( 7*24*60*60))) $new_record_flag = " nrc3";
	if($now_time < (strtotime($date_hook) + ( 1*24*60*60))) $new_record_flag = " nrc2";
	if($now_time < (strtotime($date_hook) + ( 1* 6*60*60))) $new_record_flag = " nrc1";
	if($now_time < (strtotime($date_hook) + ( 1* 1*60*60))) $new_record_flag = " nrc0";
	$get_post_date = str_replace("-", "/", substr( $date_hook , 0 , 10) );
	$get_post_time = substr( $date_hook , 11, 8 );

	// モバイル表示用の日付表示
	$mob_post_date = date("m/d", strtotime($date_hook));

	// 総合ランキング系変数をまとめる
		if ($stage_id == 9  ){
		$show_score = number_format( $row["total_rps"] );
//			$comment_temp = '<A href="./10">ピクミン1総合：'.$row["total_pik1cha"].'</A> | <A href="./20">ピクミン2総合：'.$row["total_pik2cha"].'</A> | <A href="./30">ピクミン3総合：'.$row["total_pik3cha"].'</A>';
	} elseif ($stage_id == 8 ){
		$show_score = number_format( $row["total_sp"] );
	} elseif ($stage_id == 7 ){
		$show_score = number_format( $row["total_all"] );
	} elseif ($stage_id == 91 ){
		$show_score = number_format( $row["total_limited000"] );
		if($blind) $show_score = "??,???"; // ブラインド制開催中の場合は隠す
//			$comment_temp = '';
	} elseif ($stage_id == 92 ){
		$show_score = number_format( $row["total_diary"] );
	} elseif ($stage_id == 93 ){
		$show_score = number_format( $row["total_story"] );
	} elseif ($stage_id == 94 ){
		$show_score = number_format( $row["total_mix"] );
//			$comment_temp = '';
	} elseif ($stage_id == 10 ){
		$show_score = number_format( $row["total_pik1cha"] );
//			$comment_temp = '<A href="./10">ピクミン1総合：'.$row["total_pik1cha"].'</A> | <A href="./20">ピクミン2総合：'.$row["total_pik2cha"].'</A> | <A href="./30">ピクミン3総合：'.$row["total_pik3cha"].'</A>';
	} elseif ($stage_id == 20 ){
		$show_score = number_format( $row["total_pik2cha"] );
//			$comment_temp = '<A href="./10">ピクミン1総合：'.$row["total_pik1cha"].'</A> | <A href="./20">ピクミン2総合：'.$row["total_pik2cha"].'</A> | <A href="./30">ピクミン3総合：'.$row["total_pik3cha"].'</A>';
	} elseif ($stage_id == 21 ){
		$show_score = number_format( $row["total_pik2egg"] );
//			$comment_temp = '<A href="./20">ピクミン2総合：'.$row["total_pik2cha"].'</A> | <A href="./21">タマゴあり：'.$row["total_pik2egg"].'</A> | <A href="./22">タマゴなし：'.$row["total_pik2noegg"].'</A>';
	} elseif ($stage_id == 22 ){
		$show_score = number_format( $row["total_pik2noegg"] );
//			$comment_temp = '<A href="./20">ピクミン2総合：'.$row["total_pik2cha"].'</A> | <A href="./21">タマゴあり：'.$row["total_pik2egg"].'</A> | <A href="./22">タマゴなし：'.$row["total_pik2noegg"].'</A>';
	} elseif ($stage_id == 23 ){
		$show_score = number_format( $row["total_pik2cave"] );
	} elseif ($stage_id == 24 ){
		$show_score = number_format( $row["total_pik2_2p"] );
	} elseif ($stage_id == 25 ){
		$score_float = round($row["total_battle2"], 3);
		$score_int   = floor($row["total_battle2"]);
		$score_deci  = sprintf('%03d', round(($score_float - $score_int) * 1000, 0));
		$show_score = $score_int.'<span class="score_tale">.'.$score_deci.'</span>';
	} elseif ($stage_id == 26 ){
		$show_score = number_format( $row["total_new"] );
	} elseif ($stage_id == 27 ){
		$show_score = number_format( $row["season_pik2cha"] );
	} elseif ($stage_id == 28 ){
		$show_score = number_format( $row["total_new2"] );
	} elseif ($stage_id == 30 ){
		$show_score = number_format( $row["total_pik3cha"] );
//			$comment_temp = '<A href="./10">ピクミン1総合：'.$row["total_pik1cha"].'</A> | <A href="./20">ピクミン2総合：'.$row["total_pik2cha"].'</A> | <A href="./30">ピクミン3総合：'.$row["total_pik3cha"].'</A>';
	} elseif ($stage_id == 31 ){
		$show_score = number_format( $row["total_pik3ct"] );
//			$comment_temp = '<A href="./30">ピクミン3総合：'.$row["total_pik3cha"].'</A> | <A href="./31">お宝をあつめろ！：'.$row["total_pik3ct"].'</A> | <A href="./32">原生生物をたおせ！：'.$row["total_pik3be"].'</A> | <A href="./33">巨大生物をたおせ！：'.$row["total_pik3db"].'</A>';
	} elseif ($stage_id == 32 ){
		$show_score = number_format( $row["total_pik3be"] );
//			$comment_temp = '<A href="./30">ピクミン3総合：'.$row["total_pik3cha"].'</A> | <A href="./31">お宝をあつめろ！：'.$row["total_pik3ct"].'</A> | <A href="./32">原生生物をたおせ！：'.$row["total_pik3be"].'</A> | <A href="./33">巨大生物をたおせ！：'.$row["total_pik3db"].'</A>';
	} elseif ($stage_id == 33 ){
		$show_score = number_format( $row["total_pik3db"] );
	} elseif ($stage_id == 34 ){
		$show_score = number_format( $row["total_pik3_2p"] );
	} elseif ($stage_id == 35 ){
		$score_float = round($row["total_battle3"], 3);
		$score_int   = floor($row["total_battle3"]);
		$score_deci  = sprintf('%03d', round(($score_float - $score_int) * 1000, 0));
		$show_score = $score_int.'<span class="score_tale">.'.$score_deci.'</span>';
	} elseif ($stage_id == 36 ){
		$show_score = number_format( $row["total_pik3ss"] );
	} elseif ($stage_id == 81 ){
		$show_score = number_format( $row["total_unlimit"] );
	} elseif ($stage_id == 82 ){
		$show_score = number_format( $row["total_tas"] );
	} elseif ($stage_id == 95 ){
		$score_float = round($row["battle_rate"], 3);
		$score_int   = floor($row["battle_rate"]);
		$score_deci  = sprintf('%03d', round(($score_float - $score_int) * 1000, 0));
		$show_score = $score_int.'<span class="score_tale">.'.$score_deci.'</span>';
	} elseif ($stage_id == 98 ){
		$show_score = number_format( $row["post_count"] );
	} elseif ($stage_id == 99 ){
		$show_score = number_format( $row["minites_count"] );
	} elseif ($page_type == 6 ){
		$limited_rank_comment_num = array_search($stage_id, $limited_stage_list);
		$limited_rank_target = sprintf('%03d', $limited_rank_comment_num);
		$target_db = 'total_limited'.$limited_rank_target;
		$show_score = number_format( $row['$target_db'] );
		$comment_temp = '<A href="./'.$stage_id.'">'.$stage_id.'#<span glot-model="menu_limited_dai">第</span>'.$limited_rank_comment_num.'<span glot-model="menu_limited_kai">回</span><span glot-model="main_limited_wrtotal">WR総合ランキング</span></A>';
	} elseif ($page_type == 21 ){
		$limited_rank_comment_num = array_search($stage_id, $uplan_stage_list);
		$limited_rank_target = sprintf('%03d', $limited_rank_comment_num);
		$target_db = 'total_uplan'.$limited_rank_target;

		if(isset($row['$target_db'])) $show_score = number_format( $row['$target_db'] );
//			$comment_temp = '<A href="./'.$stage_id.'">テスト</A>';
	} else   {
	}

	// ここからテーブル出力
	if ( $header_count == 1){
		$stage_column = '／<span glot-model="form_score_stage">ステージ名</span>';
		if ( $page_type == 3 ) echo '<table id="normal_tab" class="pik4_scoretab">'."\n";
		if ( $page_type == 8 ) echo '<table id="normal_tab" class="pik4_scoretab">'."\n";
		if ( $page_type == 11) echo '<table id="normal_tab" class="pik4_scoretab">'."\n";
		if ( $page_type == 5 ) echo '<table   id="user_tab" class="pik4_scoretab">'."\n";
		if ( $page_type == 7 ) $days_column = '';
		if ( $page_type == 7 ) $stage_column = '';
		if ( $page_type != 3 and $page_type != 5) echo '<table id="special_tab" class="pik4_scoretab">'."\n";
		if ( $page_type != 13) echo '<tr class="mobile-hidden"><td style="border:none;"> </td><td style="padding-left:0.5em;" glot-model="main_score_player">プレイヤー</td><td style="padding-left:0.75em;" glot-model="main_score_score">スコア</td>'.$days_column.'<td style="padding-left:0.5em;"><span glot-model="main_score_date">投稿日時</span>'.$stage_column.'</td></tr>'."\n";
		if ( $page_type == 13) echo '<tr class="mobile-hidden"><td style="border:none;"> </td><td style="padding-left:0.5em;" glot-model="main_score_player">プレイヤー</td><td style="padding-left:0.75em;" glot-model="main_score_score">スコア</td>'.$days_column.'<td style="padding-left:0.5em;" glot-model="main_breakthrough">踏破ポイント</td></tr>'."\n";
		echo '<tr class="pc-hidden"><td> </td><td style="padding-left:0.5em;" glot-model="main_score_player">プレイヤー</td><td style="padding-left:0.75em;" glot-model="main_score_score">スコア</td></tr>'."\n";
		$header_count = 0;
	}

	// ピンの表示内容を定義（平均点を取得）
	if(isset($sub_stage_id)){
	$pin_sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$sub_stage_id'";
	$pin_result = mysqli_query($mysqlconn, $pin_sql);
	if (!$pin_result) {
		die('<br>Error '.__LINE__.'：クエリの取得に失敗.'.mysql_error());
	}
	$pin_row = mysqli_fetch_assoc($pin_result);
	$q = 1;
	while($q < $season +1){
		$season_score_array[$q] = $pin_row['s'.sprintf('%02d',$q).'_top'];
		$q++;
	}
	$time_bonus = 0;
		if ($sub_stage_id > 300 and $sub_stage_id < 311)   $time_bonus = 30; // デフォルトステージ
		if ($sub_stage_id > 311 and $sub_stage_id < 317)   $time_bonus =  1; // 巨大生物をたおせ！
		if ($sub_stage_id > 316 and $sub_stage_id < 322)   $time_bonus = 30; // DLC第一弾
		if ($sub_stage_id > 321 and $sub_stage_id < 327)   $time_bonus = 10; // DLC第二弾
		if ($sub_stage_id > 326 and $sub_stage_id < 332)   $time_bonus = 30; // DLC第三弾・お宝をあつめろ！
		if ($sub_stage_id > 331 and $sub_stage_id < 337)   $time_bonus = 10; // DLC第三弾・原生生物をたおせ！
		if ($sub_stage_id > 2300 and $sub_stage_id < 2311) $time_bonus = 30; // デフォルトステージ
		if ($sub_stage_id > 2311 and $sub_stage_id < 2317) $time_bonus =  1; // 巨大生物をたおせ！
		if ($sub_stage_id > 2316 and $sub_stage_id < 2322) $time_bonus = 30; // DLC第一弾
		if ($sub_stage_id > 2321 and $sub_stage_id < 2327) $time_bonus = 10; // DLC第二弾
		if ($sub_stage_id > 2326 and $sub_stage_id < 2332) $time_bonus = 30; // DLC第三弾・お宝をあつめろ！
		if ($sub_stage_id > 2331 and $sub_stage_id < 2337) $time_bonus = 10; // DLC第三弾・原生生物をたおせ！
	$pin_wr1 = $pin_row["wr"] - ($time_bonus * 60);
	$pin_wr2 = $pin_row["wr"] - ($time_bonus *120);
	$pin_wr3 = $pin_row["wr"] - ($time_bonus *180);
	$pin_score = 0;
	if($pin_data == 2) $pin_score = round($pin_row["score_ave"]);
	if($pin_data == 3) $pin_score = round($pin_row["border_line"]);
	if($pin_data ==15) $pin_score = round($pin_row["border_line_701k"]);
	if($pin_data ==16) $pin_score = round($pin_row["wr"]);
	if($pin_data ==17) $pin_score = round($pin_wr1);
	if($pin_data ==18) $pin_score = round($pin_wr2);
	if($pin_data ==19) $pin_score = round($pin_wr3);
	if($pin_data ==20) $pin_score = round($pin_row["unexpected"]);
	if($pin_data ==23) $pin_score = round($pin_row["s14_top"]);
	if($pin_data ==22) $pin_score = round($pin_row["s13_top"]);
	if($pin_data ==21) $pin_score = round($pin_row["s12_top"]);
	if($pin_data == 4) $pin_score = round($pin_row["s11_top"]); // ↑第11期からは当期トップスコアを自動集計
	if($pin_data == 5) $pin_score = max( array_slice($season_score_array, 0,10) ); // 第10期までは当期までのトップ記録を表示
	if($pin_data == 6) $pin_score = max( array_slice($season_score_array, 0, 9) );
	if($pin_data == 7) $pin_score = max( array_slice($season_score_array, 0, 8) );
	if($pin_data == 8) $pin_score = max( array_slice($season_score_array, 0, 7) );
	if($pin_data == 9) $pin_score = max( array_slice($season_score_array, 0, 6) );
	if($pin_data ==10) $pin_score = max( array_slice($season_score_array, 0, 5) );
	if($pin_data ==11) $pin_score = max( array_slice($season_score_array, 0, 4) );
	if($pin_data ==12) $pin_score = max( array_slice($season_score_array, 0, 3) );
	if($pin_data ==13) $pin_score = max( array_slice($season_score_array, 0, 2) );
	if($pin_data ==14) $pin_score = max( array_slice($season_score_array, 0, 1) );

	if($pin_score == null or $pin_score < 1) $pin_score = 999999;
	// ピンを表示する
		if(isset($score_pin_array[$now_rows])){
			if($pin_data > 1 and $score_pin_array[$now_rows] <= $pin_score and $pin_flag_used == 0){
				// 通常ランキング
				if($page_type == 3){
					if($pin_score == 999999){
						echo '<tr><td colspan="6" style="text-align:center;border-left:none;border-bottom:2px solid #ff18c3;"><span style="color:#ff18c3;"><i class="fa fa-flag" style="color:#ff18c3;" aria-hidden="true"></i> '.$array_pin[$pin_data].'：<span glot-model="main_score_notpindata">比較用データがありません</span></span></td></tr>';
					} else {
						echo '<tr><td colspan="6" style="text-align:center;border-left:none;border-bottom:2px solid #ff18c3;"><span style="color:#ff18c3;"><i class="fa fa-flag" style="color:#ff18c3;" aria-hidden="true"></i> '.$array_pin[$pin_data].'：'.number_format($pin_score).'</span></td></tr>';
					}
				}
				$pin_flag_used = 1;
			}
		}
	}

	// 順位表示をフラグによって分岐する
	$rank = 0;
	if($season_data == 2 or $separation_mode == 2 or $filtering_sub_data > 1 ){
		$rank = '<span class="rtd_ranknum" style="color:#f2fe39;">'.$i.'</span><br class="pc-hidden"/><span class="score_tale" glot-model="rank_tail"> 位</span>';
	} elseif($log_data > 1 and ($page_type == 3 or $page_type == 12)) {
		$rank = '<span class="rtd_ranknum" style="color:#45fe39;">'.$row["at_rank"].'</span><br class="pc-hidden"/><span class="score_tale" glot-model="rank_tail"> 位</span>';
	} else {
		if(!isset($row["post_rank"])){
			$rank = '<span class="rtd_ranknum">?</span>'.'<br class="pc-hidden"/><span class="score_tale" glot-model="rank_tail"> 位</span>';
		} else {
			$rank = '<span class="rtd_ranknum">'.$row["post_rank"].'</span><br class="pc-hidden"/><span class="score_tale" glot-model="rank_tail"> 位</span>';
		}
	}

	// ランキングを表示（期間限定）
	if ( $page_type == 6) {
	$limited_stage_implode = implode(", " ,${'limited'.$stage_id});
	$limited_rank_comment_num = array_search($stage_id, $limited_stage_list);
	$limited_rank_target = sprintf('%03d', $limited_rank_comment_num);
	$target_db = 'total_limited'.$limited_rank_target;
	echo '<tr class="'.$rtd_tr.' mobile-hidden rtd_top">
		<td class="rtd_rank"><p><span class="rtd_ranknum">'.$i.'</span><span class="score_tale" glot-model="rank_tail"> 位</span></p></td>
		<td class="rtd_player"><p>'.$get_user_name.'</p></td>
		<td class="rtd_score"><p>'.$row[$target_db].$score_tale.'</p></td>
		<td class="rtd_info">
			<table class="rtd_comment_tab">
				<tr>
					<td><p><font class="rtd_date">'.$get_post_date.'</font> <font class="rtd_time'.$new_record_flag.'">'.$get_post_time.'</font></p></td>
					<td class="rtd_stage"><p><A href="./'.$stage_id.'"><span glot-model="menu_limited_dai">第</span>'.$limited_rank_comment_num.'<span glot-model="menu_limited_kai">回</span><span glot-model="main_limited_wrtotal">WR総合ランキング</span></A></p></td>
				</tr>
				<tr>
					<td colspan="2" class="rtd_comment_hr"><p class="rtd_comment"><table style="width:100%;height:100%;">';
	$user_name = $row["user_name"];
		// 対象ステージのステージスコアを抽出（PC版）
		$sql = "SELECT * FROM `ranking` WHERE `stage_id` in($limited_stage_implode) AND `log` = 0 AND `user_name` = '$user_name' ORDER BY `stage_id` DESC";
			$pc_comment_result = mysqli_query($mysqlconn, $sql);
			if (!$pc_comment_result) {
				die('<br>Error '.__LINE__.'：クエリの取得に失敗.'.mysql_error());
			}
		while ($pc_comment_row = mysqli_fetch_assoc($pc_comment_result) ){
			echo '<tr><td style="width:70%;border-left:none;padding:0;"><A href="./'.$pc_comment_row["stage_id"].'">'.$array_stage_title[$pc_comment_row["stage_id"]].'</A></td><td style="width:30%;padding:0;">'.$pc_comment_row["score"].$score_tale.'</A></td></tr>'."\n" ;
		}
	echo '</table>';
	echo '</td>
				</tr>
			</table>
		</td>
	</tr>',"\n";

	// ランキングを表示（参加者企画・RPS基準）
	} elseif ( $page_type == 21 and $stage_id != 210829) {
	$uplan_stage_implode = implode(", " ,${'uplan'.$stage_id});
	$uplan_rank_comment_num = array_search($stage_id, $uplan_stage_list);
	$uplan_rank_target = sprintf('%03d', $uplan_rank_comment_num);
	$target_db = 'total_uplan'.$uplan_rank_target;
	$target_rps = 'total_uplan'.$uplan_rank_target.'rps';
	echo '<tr class="'.$rtd_tr.' mobile-hidden rtd_top">
		<td class="rtd_rank"><p><span class="rtd_ranknum">'.$i.'</span><span class="score_tale" glot-model="rank_tail"> 位</span></p></td>
		<td class="rtd_player"><p>'.$get_user_name.'</p></td>
		<td class="rtd_score"><p>'.$row[$target_rps].'<span class="score_tale"> RPS</span><hr/>'.$row[$target_db].$score_tale.'</p></td>
		<td class="rtd_info">'.$comment_temp.'</td></tr>
	</tr>',"\n";

	echo '<tr class="'.$rtd_tr.' pc-hidden"    ><td rowspan="2" class="rtd_rank"><p><span class="rtd_ranknum">'.$i.'</span><span class="score_tale" glot-model="rank_tail"> 位</span></td><td class="rtd_player"><A href="./'.$row["user_name"].'">'.$row["user_name"].'</A></td><td class="rtd_score">'.$row[$target_db].$score_tale.'</td></tr><tr class="'.$rtd_tr.' pc-hidden"><td colspan="2" class="rtd_comment">(<A href="./'.$stage_id.'">'.$stage_id.'#<span glot-model="menu_limited_dai">第</span>'.$limited_rank_comment_num.'<span glot-model="menu_limited_kai">回</span><span glot-model="main_limited_wrtotal">WR総合ランキング</span></A>) <br></td></tr>';

	// ランキングを表示（参加者企画・ゲームポイント基準）
	} elseif ( $page_type == 21) {
	$uplan_stage_implode = implode(", " ,${'uplan'.$stage_id});
	$uplan_rank_comment_num = array_search($stage_id, $uplan_stage_list);
	$uplan_rank_target = sprintf('%03d', $uplan_rank_comment_num);
	$target_db = 'total_uplan'.$uplan_rank_target;
	echo '<tr class="'.$rtd_tr.' mobile-hidden rtd_top">
		<td class="rtd_rank"><p><span class="rtd_ranknum">'.$i.'</span><span class="score_tale" glot-model="rank_tail"> 位</span></p></td>
		<td class="rtd_player"><p>'.$get_user_name.'</p></td>
		<td class="rtd_score"><p>'.$row[$target_db].$score_tale.'</p></td>
		<td class="rtd_info">'.$comment_temp.'</td></tr>
	</tr>',"\n";
	echo '<tr class="'.$rtd_tr.' pc-hidden"    ><td rowspan="2" class="rtd_rank"><p><span class="rtd_ranknum">'.$i.'</span><span class="score_tale" glot-model="rank_tail"> 位</span></td><td class="rtd_player"><A href="./'.$row["user_name"].'">'.$row["user_name"].'</A></td><td class="rtd_score">'.$row[$target_db].$score_tale.'</td></tr><tr class="'.$rtd_tr.' pc-hidden"><td colspan="2" class="rtd_comment">(<A href="./'.$stage_id.'">'.$stage_id.'#<span glot-model="menu_limited_dai">第</span>'.$limited_rank_comment_num.'<span glot-model="menu_limited_kai">回</span><span glot-model="main_limited_wrtotal">WR総合ランキング</span></A>) <br></td></tr>';
	$i++;

	// ランキングを表示（全ステージ一覧）
	} elseif ( $stage_id == 5 ) {
	echo '<table id="sortable_table" class="stagelist_tab tablesorter">';
	echo '<thead><tr><th>ID</th><th glot-model="main_score_cat">カテゴリ</th><th glot-model="form_score_stage">ステージ名</th><th glot-model="menu_cnt_total">総投稿数</th><th glot-model="main_score_topper">トップ保持者</th><th glot-model="main_topscore">ハイスコア</th><th glot-model="main_seasontop">今期トップ</th><th glot-model="main_lastupdate">最終投稿日</th></tr></thead><tbody>';
	$sql = "SELECT * FROM `stage_title` WHERE `stage_id` $whereand AND `stage_id` NOT IN(299,10100,10200,10300) AND `stage_id` BETWEEN 101 AND 10999 ORDER BY `stage_id` ASC";
	$stage_list_result = mysqli_query($mysqlconn, $sql);
	while($row = mysqli_fetch_assoc($stage_list_result) ){
		if($row["stage_id"] == 399 or ($row["stage_id"] >= 3000 and $row["stage_id"] <= 5000)){ // 非表示にしたいステージがある場合はここで指定
			continue;
		}
		$top_ranker = '';
		$top_score  = 0;
		$last_post_date = 0;
		$sql = "SELECT * FROM `ranking` WHERE `stage_id` = $row[stage_id] and `log` != 2 ORDER BY `post_date` DESC";
		$stage_wr_result = mysqli_query($mysqlconn, $sql);
		while($rrow = mysqli_fetch_assoc($stage_wr_result)){
			if($rrow["post_rank"] == 1 and $rrow["log"] == 0) $top_ranker .= $rrow["user_name"]." <br>";
			if($rrow["post_rank"] == 1 and $rrow["log"] == 0) $top_score = $rrow["score"];
			if($rrow["post_date"] > $last_post_date) $last_post_date = $rrow["post_date"];
		}
		if($last_post_date > 0){
			$last_post_date = date('Y/m/d',strtotime($last_post_date));
		} else {
			$last_post_date = "----/--/--";
		}
		if($row["stage_id"] >= $blind_start and $row["stage_id"] <= $blind_end){ // ハイスコアを隠したいステージがある場合はここで指定
			$top_score = "??,???";
			$row["s11_top"] = "??,???";
		}
		$p_count = mysqli_num_rows($stage_wr_result );
		echo "<tr><td>".$row["stage_id"]."</td><td>".$row["stage_sub"].'</td><td><b><A href="./'.$row["stage_id"].'">'.$row["stage_name"]."</A></b></td><td>".$p_count."</td><td>".$top_ranker."</td><td>".$top_score."</td><td>".$row["s".$season."_top"]."</td><td>".$last_post_date."</td></tr>";
	}
	echo '</tbody></table>';
	break;
	// ランキングを表示（総合）
	} elseif ( $page_type == 2 ) {
		// 期間限定総合の場合は投稿ステージ数＝大会参加数とする
		if($stage_id == 91){
			$limited_ranking_range = range(1, $end_of_limited);
			$stage_count = 0;
			foreach($limited_ranking_range as $val){
				if($users[$row["user_name"]]["total_limited".sprintf('%03d', $val)]){
					$stage_count += 1;
				}
			}
		} elseif($stage_id > 9) {
			$stage_count = $r - 1;
		} else {
			// 参加者総合の場合投稿数を独自計算
			if($stage_id == 9) $whereis = "AND (`stage_id` BETWEEN 101 AND 105 OR `stage_id` BETWEEN 201 AND 230 OR `stage_id` BETWEEN 301 AND 336)";
			if($stage_id == 8) $whereis = "AND (`stage_id` BETWEEN 231 AND 297 OR `stage_id` BETWEEN 337 AND 348 OR `stage_id` BETWEEN 1001 AND 3999 OR `stage_id` BETWEEN 10001 AND 10399)";
			if($stage_id == 7) $whereis = "AND (`stage_id` BETWEEN 101 AND 10399)";
			$query_tcount = "SELECT * FROM `ranking` WHERE `user_name` = '$row[user_name]' AND `log` = 0 $whereis";
			$result_tcount = mysqli_query($mysqlconn, $query_tcount);
			$stage_count = mysqli_num_rows($result_tcount);
			// バトルモードの投稿数を加算する
			if($stage_id == 8 or $stage_id == 7){
					$whereis = "AND (`stage_id` BETWEEN 275 AND 348)";
				$query_tcount = "SELECT * FROM `ranking` WHERE `user_name` = '$row[user_name]' AND `log` = 0 $whereis";
				$result_tcount = mysqli_query($mysqlconn, $query_tcount);
				$stage_count += mysqli_num_rows($result_tcount);
			}
			// 2Pモードの投稿数を加算する
			if($stage_id == 8 or $stage_id == 7){
				$query_tcount = "SELECT * FROM `ranking` WHERE (`user_name` = '$row[user_name]' OR `user_name_2p` = '$row[user_name]') AND `log` = 0 AND `stage_id` BETWEEN 2201 AND 2336";
				$result_tcount = mysqli_query($mysqlconn, $query_tcount);
				$stage_array = array();
				while($strow = mysqli_fetch_assoc($result_tcount)){
					$stage_array[] = $strow["stage_id"];
				}
				$stage_count += count( array_unique($stage_array) );
			}

		}
		// 全ステージ投稿したら色を変える
		if($stage_count_array[$stage_id] <= $stage_count){
			$css_class = "score_tale2";
		} else {
			$css_class = "score_tale";
		}
		// ピクミン2総合の場合はレートを表示
		if($stage_id >= 20 and $stage_id <= 22){
			$show_rate = '<span class="rtd_rate">#'.$row["rate"].'</span>';
		} elseif($stage_id == 91) {
			$show_rate = '<span class="rtd_rate">#'.$row["limrate"].'</span>';
		} else {
			$show_rate = '';
		}
		echo '<tr class="'.$rtd_tr.' mobile-hidden rtd_top">
			<td class="rtd_rank"><p><span class="rtd_ranknum">'.$i.'</span><span class="score_tale" glot-model="rank_tail"> 位</span></p></td>
			<td class="rtd_player"><p>'.$get_user_name.'</p></td>
			<td class="rtd_score">'.$show_rate.'<p>'.$show_score.$score_tale.'</p>';
		if($stage_id < 98) echo '<span class="'.$css_class.'">'.$stage_count.'/'.$stage_count_array[$stage_id].$battle_total_count.'</span>';
		echo '</td>
			<td class="rtd_info">
				<table class="rtd_comment_tab">
					<tr>
						<td><p><font class="rtd_date'.$new_record_flag.'">'.$get_post_date.'</font> <font class="rtd_time'.$new_record_flag.'">'.$get_post_time.'</font></p></td>
						<td class="rtd_stage"><!--/ <p><A href="./'.$stage_id.'">'.$stage_id.'#'.$fixed_stage_title.'</A></p> /--></td>
					</tr>
					<tr>
						<td colspan="2" class="rtd_comment_hr"><p class="rtd_comment">'.$comment_temp.'</td>
					</tr>
				</table>
			</td>
		</tr>',"\n";
		echo '<tr class="'.$rtd_tr.' pc-hidden"  	   ><td rowspan="2" class="rtd_rank"><p><span class="rtd_ranknum">'.$i.'</span><span class="score_tale" glot-model="rank_tail"> 位</span></td><td                 class="rtd_player"   >'.$get_user_name.'</td><td                 class="rtd_score">'.$show_score.$score_tale.'</td></tr><tr class="'.$rtd_tr.' pc-hidden"><td colspan="2" class="rtd_comment">(<A href="./'.$stage_id.'">'.$fixed_stage_title.'</A>)</td></tr>';

	// ランキングを表示（エリア踏破戦）
	}  elseif ($page_type == 13) {
	$limited_stage_implode = implode(", " ,${'limited'.$stage_id});
	$limited_rank_comment_num = array_search($stage_id, $limited_stage_list);
	$limited_rank_target = sprintf('%03d', $limited_rank_comment_num);
	$target_db = 'total_limited'.$limited_rank_target;
	$target_db2 = 'total_arealim'.$limited_rank_target;
	$non_link_user_name = $row["user_name"];

	$query_area = "SELECT * FROM `area` WHERE `user_name` = '$non_link_user_name' AND `lim` = '$limited_rank_comment_num' AND `flag` = 5";
	$result_area= mysqli_query($mysqlconn, $query_area);
	$flag5_count = mysqli_num_rows($result_area);

	$query_area = "SELECT * FROM `area` WHERE `user_name` = '$non_link_user_name' AND `lim` = '$limited_rank_comment_num' AND `flag` <= 4";
	$result_area= mysqli_query($mysqlconn, $query_area);
	$flag4_count = mysqli_num_rows($result_area);

	$lands_point = ($flag5_count * 3) + $flag4_count;
	echo '<tr class="'.$rtd_tr.' mobile-hidden rtd_top">
		<td class="rtd_rank"><p><span class="rtd_ranknum">'.$i.'</span><span class="score_tale" glot-model="rank_tail"> 位</span></p></td>
		<td class="rtd_player"><p>'.$get_user_name.'</p></td>
		<td class="rtd_score"><p>'.$row[$target_db].$score_tale.'<hr size="1"/>'.$row[$target_db2].$score_tale.'</p></td>
		<td class="rtd_score"><p>'.$lands_point.$score_tale.'</p></td>
	</tr>';

	// ランキングを表示（総合とユーザー別を除くすべて）
	}  elseif ( $page_type == 3 or $page_type == 4 or $page_type == 8 or $page_type == 11 or $page_type == 12  or $page_type == 19) {
	echo '<tr class="'.$rtd_tr.' team_color'.$row["team"].'  mobile-hidden rtd_top">
		<td class="rtd_rank"><p>'.$rank.' <br>'.$show_rps.'</p></td>
		<td class="rtd_player"><p>'.$get_user_name.'</p></td>
		<td class="rtd_score"><p>'.$show_score.$score_tale.$get_lest_score.$diff_mark.'</p></td>
		<td class="rtd_info">
			<table class="rtd_comment_tab">
				<tr>
					<td><p><font class="rtd_date'.$new_record_flag.'">'.$get_post_date.'</font> <font class="rtd_time'.$new_record_flag.'">'.$get_post_time.'</font></p></td>
					<td class="rtd_stage"> </td>
				</tr>
				<tr>
					<td colspan="2" class="rtd_comment_hr"><p class="rtd_comment" id="id-'.$row["unique_id"].'">'.$caveinfo.$get_diff_score.$tag_link.$pic_file_url.$video_link.$post_memo_paste.$console_type.$get_post_comment.'</p></td>
				</tr>
			</table>
		</td>
	</tr>',"\n";
	echo '<tr class="'.$rtd_tr.' team_color'.$row["team"].'  pc-hidden"><td rowspan="2" class="rtd_rank">'.$rank.' <br>'.$show_rps.'<br><span class="mobile_unique_id">#'.$row["unique_id"].'</span></td><td class="rtd_player">'.$get_user_name.'</td><td class="rtd_score">'.$show_score.$score_tale.$get_lest_score.$diff_mark.'</td></tr><tr class="'.$rtd_tr.' team_color'.$row["team"].' pc-hidden"><td colspan="2" class="rtd_comment">'.$post_memo_paste.$console_type.'(<font class="rtd_date'.$new_record_flag.'">'.$mob_post_date.'</font>) '.$caveinfo.$get_diff_score.$tag_link.$pic_file_url.$video_link.$get_post_comment.'</td></tr>';

	// ランキングを表示（本編）
	}  elseif ( $page_type == 7 ) {
	$days_tale = "days";
	if($row["days"] > 0) $days_tale = "days";
	if($row["days"] < 2) $days_tale = "day";
	echo '<tr class="'.$rtd_tr.' team_color'.$row["team"].'  mobile-hidden rtd_top">
		<td class="rtd_rank"><p>'.$rank.' <br>'.$show_rps.'</p></td>
		<td class="rtd_player"><p>'.$get_user_name.'</p></td>
		<td class="rtd_score"><p>'.$row["days"].' <font class="score_tale">'.$days_tale.'</font> <br>'.$show_score.$score_tale.$get_lest_score.$diff_mark.'</p>'.$rtd_storypts.'</td>
		<td class="rtd_info">
			<table class="rtd_comment_tab">
				<tr>
					<td><p><font class="rtd_date'.$new_record_flag.'">'.$get_post_date.'</font> <font class="rtd_time'.$new_record_flag.'">'.$get_post_time.'</font></p></td>
					<td class="rtd_stage"><p><A href="./'.$row["stage_id"].'">'.$stage_name.'</A></p></td>
				</tr>
				<tr>
					<td colspan="2" class="rtd_comment_hr"><p class="rtd_comment" id="id-'.$row["unique_id"].'">'.$caveinfo.$rtd_other.$get_diff_score.$tag_link.$pic_file_url.$video_link.$post_memo_paste.$console_type.$get_post_comment.'</p></td>
				</tr>
			</table>
		</td>
	</tr>',"\n";
	echo '<tr class="'.$rtd_tr.' pc-hidden		　"><td rowspan="2" class="rtd_rank">'.$row["post_rank"].'<font class="score_tale"> 位</font> <br>'.$show_rps.'</td><td class="rtd_player">'.$get_user_name.'</td><td class="rtd_score">'.$show_score.$score_tale.$get_lest_score.$diff_mark.'</td></tr><tr class="'.$rtd_tr.' pc-hidden"><td colspan="2" class="rtd_comment">'.$post_memo_paste.$console_type.'(<font class="rtd_date'.$new_record_flag.'">'.$mob_post_date.'</font>) '.$get_post_comment.$get_diff_score.$tag_link.$pic_file_url.$video_link.' (<A href="./'.$row["stage_id"].'">'.$stage_name.'</A>)</td></tr>';

	// ランキングを表示（チャレンジ複合）
	}  elseif ( $page_type == 14 ) {
	echo '<tr class="'.$rtd_tr.' team_color'.$row["team"].'  mobile-hidden rtd_top">
		<td class="rtd_rank"><p>'.$rank.' <br>'.$show_rps.'</p></td>
		<td class="rtd_player"><p>'.$get_user_name.'</p></td>
		<td class="rtd_score"><p>'.$show_score.$score_tale.$get_lest_score.$diff_mark.'</p></td>
		<td class="rtd_info">
			<table class="rtd_comment_tab">
				<tr>
					<td><p><font class="rtd_date'.$new_record_flag.'">'.$get_post_date.'</font> <font class="rtd_time'.$new_record_flag.'">'.$get_post_time.'</font></p></td>
					<td class="rtd_stage"><p><A href="./'.$row["stage_id"].'">'.$stage_name.'</A></p></td>
				</tr>
				<tr>
					<td colspan="2" class="rtd_comment_hr">'.$split_table.'</td>
				</tr>
				<tr>
					<td colspan="2" class="rtd_comment_hr"><p class="rtd_comment" id="id-'.$row["unique_id"].'">'.$caveinfo.$get_diff_score.$tag_link.$pic_file_url.$video_link.$post_memo_paste.$console_type.$get_post_comment.'</p></td>
				</tr>
			</table>
		</td>
	</tr>',"\n";
	echo '<tr class="'.$rtd_tr.' pc-hidden		　"><td rowspan="2" class="rtd_rank">'.$row["post_rank"].'<font class="score_tale"> 位</font> <br>'.$show_rps.'</td><td class="rtd_player">'.$get_user_name.'</td><td class="rtd_score">'.$show_score.$score_tale.$get_lest_score.$diff_mark.'</td></tr><tr class="'.$rtd_tr.' pc-hidden"><td colspan="2" class="rtd_comment">'.$post_memo_paste.$console_type.'(<font class="rtd_date'.$new_record_flag.'">'.$mob_post_date.'</font>) '.$get_post_comment.$get_diff_score.$tag_link.$pic_file_url.$video_link.' (<A href="./'.$row["stage_id"].'">'.$stage_name.'</A>)</td></tr>';

	// ランキングを表示（カスタムリストと新着）
	} elseif ( $stage_id == 4 or $stage_id == 1) {
	echo '<tr class="'.$rtd_tr.' team_color'.$row["team"].'  mobile-hidden rtd_top">
		<td class="rtd_rank"><p>'.$rank.' <br>'.$show_rps.'</p></td>
		<td class="rtd_player"><p>'.$get_user_name.'</p></td>
		<td class="rtd_score"><p>'.$show_score.$score_tale.$get_lest_score.$diff_mark.'</p></td>
		<td class="rtd_info">
			<table class="rtd_comment_tab">
				<tr>
					<td><p><font class="rtd_date'.$new_record_flag.'">'.$get_post_date.'</font> <font class="rtd_time'.$new_record_flag.'">'.$get_post_time.'</font></p></td>
					';
					if($row["stage_id"] >= 3096 and $row["stage_id"] <= 3112){
						echo '<td class="rtd_stage"><p><A href="./200918">????#<span glot-model="menu_limited_16">第16回期間限定ランキング</span></A></p></td>';
					} else {
						echo '<td class="rtd_stage"><p><A href="./'.$row["stage_id"].'">'.$stage_name.'</A></p></td>';
					}
				echo '</tr>
				<tr>
					<td colspan="2" class="rtd_comment_hr"><p class="rtd_comment" id="id-'.$row["unique_id"].'">'.$caveinfo.$get_diff_score.$tag_link.$pic_file_url.$video_link.$post_memo_paste.$console_type.$get_post_comment.'</p></td>
				</tr>
			</table>
		</td>
	</tr>',"\n";
	echo '<tr class="'.$rtd_tr.' pc-hidden"><td rowspan="2" class="rtd_rank">'.$rank.' <br>'.$show_rps.'</td><td class="rtd_player">'.$get_user_name.'</td><td class="rtd_score">'.$show_score.$score_tale.$get_lest_score.$diff_mark.'</td></tr><tr class="'.$rtd_tr.' pc-hidden"><td colspan="2" class="rtd_comment">'.$post_memo_paste.$console_type.' (<font class="rtd_date'.$new_record_flag.'">'.$mob_post_date.'</font>) '.$get_post_comment.$get_diff_score.$tag_link.$pic_file_url.$video_link.' (<A href="./'.$row["stage_id"].'">'.$stage_name.'</A>)</td></tr>';

	// ランキングを表示（バトルモードランキング）
	}  elseif ( $page_type == 16 ) {
	echo '<tr class="'.$rtd_tr.' mobile-hidden rtd_top">
		<td class="rtd_rank"><p>'.$rank.' <br>'.$show_rps.'</p></td>
		<td class="rtd_player"><p>'.$get_user_name.'</p></td>
		<td class="rtd_score rtd_tooltip"><p>'.$show_score.$score_tale.$get_lest_score.'</p><span class="score_tale">'.$row["win"].'<span glot-model="main_battle_win">勝</span>'.$row["lose"].'<span glot-model="main_battle_lose">敗</span>'.$row["draw"].'<span glot-model="main_battle_draw">分</span></span></td>
		<td class="rtd_info">
			<table class="rtd_comment_tab">
				<tr>
					<td><p><font class="rtd_date'.$new_record_flag.'">'.$get_post_date.'</font> <font class="rtd_time'.$new_record_flag.'">'.$get_post_time.'</font></p></td>
					<td class="rtd_stage"><p><A href="./'.$row["stage_id"].'">'.$stage_name.'</A></p></td>
				</tr>
				<tr>
					<td colspan="2" class="rtd_comment_hr"><p class="rtd_comment" id="id-'.$row["unique_id"].'">'.$caveinfo.$get_diff_score.$tag_link.$pic_file_url.$video_link.$console_type.$get_post_comment.'</p></td>
				</tr>
			</table>
		</td>
	</tr>',"\n";
	echo '<tr class="'.$rtd_tr.' pc-hidden	　    "><td rowspan="2" class="rtd_rank">   '.$rank.' <br>'.$show_rps.'    </td><td class="rtd_player">'.$get_user_name.'</td><td class="rtd_score">'.$show_score.$score_tale.$get_lest_score.'</td></tr><tr class="'.$rtd_tr.' pc-hidden"><td colspan="2" class="rtd_comment">'.$post_memo_paste.$console_type.'(<font class="rtd_date'.$new_record_flag.'">'.$mob_post_date.'</font>) '.$caveinfo.$get_diff_score.$tag_link.$pic_file_url.$video_link.$get_post_comment.' <br>(<A href="./'.$row["stage_id"].'">'.$stage_name.'</A>)</td></tr>';

	// ランキングを表示（ユーザー別）
	} else {
	$child_parent = $stage[$row["stage_id"]]["parent"];
	if(strstr($child_parent, '#') !== false){
		$parent_split = explode("#", $child_parent);
		$child_parent = $parent_split[1];
	}
	echo '<tr class="'.$rtd_tr.' team_color'.$row["team"].'  mobile-hidden rtd_top">
		<td class="rtd_rank"><p>'.$rank.' <br>'.$show_rps.'</p></td>
		<td class="rtd_player"><p>'.$get_user_name.'</p></td>
		<td class="rtd_score"><p>'.$show_score.$score_tale.$get_lest_score.$diff_mark.'</p></td>
		<td class="rtd_info">
			<table class="rtd_comment_tab">
				<tr>
					<td><p><font class="rtd_date'.$new_record_flag.'">'.$get_post_date.'</font> <font class="rtd_time'.$new_record_flag.'">'.$get_post_time.'</font></p></td>
					<td class="rtd_stage"><p><A href="./'.$row["stage_id"].'">'.$stage_name.'</A></p></td>
				</tr>
				<tr>
					<td colspan="2" class="rtd_comment_hr"><p class="rtd_comment" id="id-'.$row["unique_id"].'">'.$caveinfo.$get_diff_score.$tag_link.$pic_file_url.$video_link.$history_link.$console_type.$get_post_comment.'</p></td>
				</tr>
			</table>
		</td>
	</tr>',"\n";
	echo '<tr class="'.$rtd_tr.' pc-hidden"><td rowspan="2" class="rtd_rank">'.$rank.' <br>'.$show_rps.'</td><td class="rtd_player">'.$get_user_name.'</td><td class="rtd_score">'.$show_score.$score_tale.$get_lest_score.$diff_mark.'</td></tr><tr class="'.$rtd_tr.' pc-hidden"><td colspan="2" class="rtd_comment">'.$post_memo_paste.$console_type.' (<font class="rtd_date'.$new_record_flag.'">'.$mob_post_date.'</font>) '.$get_post_comment.$get_diff_score.$tag_link.$pic_file_url.$video_link.$history_link.' (<A href="./'.$row["stage_id"].'">'.$stage_name.'</A>)</td></tr>';
	}
	// 現在の行数と合計点カウント
	if($page_type != 2 and $page_type != 6 and $page_type != 10 and $page_type != 13){
		if(isset($row["post_rank"]) and $row["post_rank"] > 0 and $season_data != 2) $sum_rank[] = $row["post_rank"];
		if(isset($row["post_rank"]) and $row["post_rank"] > 0 and ($season_data == 2 or $separation_mode == 2)) $sum_rank[] = $i;
		if(isset($row["rps"]) and $row["rps"] > 0) $sum_rps[] = $row["rps"];
		if(isset($row["score"]) and $row["score"] > 0){
			if($row["stage_id"] > 100 and $row["stage_id"] < 106 and $filtering_data == 14){ // 通常総合の場合はピクミン1のスコアを10倍にする
				$sum_score[] = ($row["score"] * 10);
			} else {
				$sum_score[] = $row["score"];
			}
		}
		$sum_lest_score[] = $fixed_lest_score;
	}
	$now_rows++;
}
// Whileここまで

// フッターメニューでスコアが隠れるのを防止（携帯版のみ）
echo '</table><div class="pc-hidden" style="height:60px;"> </div></div>';

// ★動画リンクと比較プルダウンメニューここから
if($season_data == 2 or $separation_mode == 2) $rows_count = $now_rows;
if($page_type != 9 and $page_type !=15 and $page_type !=10 and $page_type != 2 and $page_type != 1 and $page_type != 16){
	echo '<div style="order:2;margin-left:auto;width:100%;margin-top:0.5em;">';

	// 各種統計テーブル
	if($page_type == 5){
	echo '<div class="scroll-wrap"><table class="series_nav"><tr>';
	echo '<td style="background-color:#aaa;color:#111;" glot-model="main_compare_displaytotal">表示中の合計点</td><td style="background-color:#aaa;color:#111;" glot-model="main_compare_toprank">最高位</td><td style="background-color:#aaa;color:#111;" glot-model="main_compare_averank">平均位</td><td style="background-color:#aaa;color:#111;" glot-model="main_compare_lowrank">最低位</td><td style="background-color:#aaa;color:#111;" glot-model="main_compare_totalrps">合計RPS</td>';
	if($compare_special != 3 and $compare_special != 7){
		echo '<td style="background-color:#aaa;color:#111;">比較値との合計点差</td>';
	}
	echo '</tr>';
	if(!$blind) echo '<td><span class="compare_even">'.number_format(array_sum($sum_score))."</span> pts.</td>\n";
	if( $blind) echo '<td><span class="compare_even">??,???</span> pts.</td>'."\n"; // ブラインド制のときは隠す
	$include_sum_array = array(min($sum_rank), round(array_sum($sum_rank)/$rows_count,2), max($sum_rank));
	foreach($include_sum_array as $val){
		if(!$val){
			echo '<td><span class="compare_nocolor r9th">-</span><span glot-model="rank_tail"> 位</span></td>'."\n";
		} else {
			if($val >   0 and $val <= 1.0)	$rank_css = "r1st";
			if($val > 1.0 and $val <= 2.0)	$rank_css = "r2nd";
			if($val > 2.0 and $val <= 3.0)	$rank_css = "r3rd";
			if($val > 3.0 and $val <=10.0)	$rank_css = "r4th";
			if($val >10.0 and $val <=20.0)	$rank_css = "r5th";
			if($val >20.0)			$rank_css = "r9th";
			echo '<td><span class="compare_nocolor '.$rank_css.'">'.$val.'</span><span glot-model="rank_tail"> 位</span></td>'."\n";
		}
	}
	echo '<td><span class="compare_nocolor">'.number_format(array_sum($sum_rps))."</span> pts.</td>\n";
	if($compare_special != 3 and $compare_special != 7){
		if(array_sum($sum_lest_score) > 0) $comp_css = "compare_win";
		if(array_sum($sum_lest_score)== 0) $comp_css = "compare_even";
		if(array_sum($sum_lest_score) < 0) $comp_css = "compare_lose";
		if($limited_num != 11) echo '<td><span class="'.$comp_css.'">'.number_format(array_sum($sum_lest_score))."</span> pts.</td>";
		if($limited_num == 11) echo '<td><span class="compare_even">??,???</span> pts.</td>';
	}
	echo "</tr></table></div>\n";
	}
if($page_type == 3 or $page_type == 4 or $page_type == 5 or $page_type == 7 or $page_type == 8 or $page_type == 11 or $page_type == 12 or $page_type == 14 or $page_type == 19){

// ピックアップ動画
$get_youtube_id = '';
$secret_mode = 1;
if($secret_mode){
	// ブラックリストメンバーは下記SQLに直接記述
//		if($page_type != 5) $vcsql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 AND `video_url` != '' ORDER BY `post_rank` ASC LIMIT 1";
	if($page_type != 5) $vcsql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 AND `video_url` != '' AND `user_name` != 'ライジング-rising-' ORDER BY `post_rank` ASC LIMIT 1";
	if($page_type == 5) $vcsql = "SELECT * FROM `ranking` WHERE `user_name` = '$user_name' AND `log` = 0 AND `video_url` != '' ORDER BY `rps` DESC LIMIT 1";
	$vcresult = mysqli_query($mysqlconn, $vcsql);
		$ct = 0;
		$get_score = 0;
		while($vcrow = mysqli_fetch_assoc($vcresult) ){
			$get_video_url = $vcrow["video_url"];
			$get_score = $vcrow["score"];
			$get_player = $vcrow["user_name"];
			$get_rank = $vcrow["post_rank"];
			$get_stage = $vcrow["stage_id"];
			$ct++;
		}
		if($get_score > 0){
		echo '<div style="text-align:center;">';
		echo '<span style="float:left;">';
		if($page_type == 5) echo '<A href="./'.$get_stage.'">'.$array_stage_title[$get_stage].'</A> ';
		echo '<b>Played by '.$get_player.'</b> ('.$get_score.'pts. / '.$get_rank.'<span glot-model="rank_tail"> 位</span>)</span>';
		// 選出した動画URLを加工 [youtu.be/ID]と[(m.)youtube.com/watch?v=ID]
		$query_stage_title = preg_replace('/<.*?>/', '', $fixed_stage_title );
		if($page_type != 5) echo '<span style="font-size:0.8em;float:right;"><A href="https://www.youtube.com/results?search_query='.$query_stage_title.'" target="_blank"><span glot-model="main_score_videosearch">[ステージ名で動画を検索]</span></A></span>';
		echo '<br>';
		if(strpos($get_video_url, 'youtu') !== false){
			$get_youtube_id = preg_replace('/http(s)?:\/\/(www\.|m\.)?youtu(.be|be.com)\/(watch\?v=)?/', '', $get_video_url);
			echo '<iframe id="pickup_video" width="512" height="288" src="https://www.youtube.com/embed/'.$get_youtube_id.'?rel=0&enablejsapi=1" frameborder="0" allowfullscreen></iframe> <br>';
		}
		if(strpos($get_video_url, 'nico') !== false){
			$get_nico_id = preg_replace('/http(s)?:\/\/(www\.)?nico(video\.jp|\.ms)(\/watch)?\/sm/', '', $get_video_url);
			echo '<script type="application/javascript" src="https://embed.nicovideo.jp/watch/sm'.$get_nico_id.'/script"></script>';
		}
		echo '</div>';
		}
	}
		echo "\n".'<div class="mobile-clear" style="float:right;">'."\n";

		echo '<div class="filtering_position">';
		if($page_type == 3){
			// ピン機能切り替えメニュー
			echo '<form id="form6" name="form6" action="#" method="post" enctype="multipart/form-data" accept-charset="utf-8">'."\n";
			echo '<select type="text" name="pin_data" style="padding:2px;margin-left:4px;border:0;background-color:#333333;color:#ffffff;" onChange="FormSubmit5();">'."\n";
			echo '<option value="0">---</option>'."\n" ;
			echo '<option value="1">★'.$array_pin[1].'</option>'."\n" ;
			echo '<option value="2">★'.$array_pin[2].'</option>'."\n" ;
			if($stage_cat == 20) echo '<option value="3">★'.$array_pin[3].' [2]</option>'."\n" ;
			if($stage_cat == 20) echo '<option value="15">★'.$array_pin[15].' [2]</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="16">★'.$array_pin[16].' [3]</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="17">★'.$array_pin[17].' [3]</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="18">★'.$array_pin[18].' [3]</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="19">★'.$array_pin[19].' [3]</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="20">★'.$array_pin[20].' [3]</option>'."\n" ;
			echo '<option value="23">★'.$array_pin[23].'</option>'."\n" ;
			echo '<option value="22">★'.$array_pin[22].'</option>'."\n" ;
			echo '<option value="21">★'.$array_pin[21].'</option>'."\n" ;
			echo '<option value="4">★'.$array_pin[4].'</option>'."\n" ;
			echo '<option value="5">★'.$array_pin[5].'</option>'."\n" ;
			echo '<option value="6">★'.$array_pin[6].'</option>'."\n" ;
			echo '<option value="7">★'.$array_pin[7].'</option>'."\n" ;
			echo '<option value="8">★'.$array_pin[8].'</option>'."\n" ;
//				echo '<option value="9">★第6期トップ (2012)</option>'."\n" ;
//				echo '<option value="10">★第5期トップ (2011)</option>'."\n" ;
//				echo '<option value="11">★第4期トップ (2010)</option>'."\n" ;
//				echo '<option value="12">★第3期トップ (2009)</option>'."\n" ;
//				echo '<option value="13">★第2期トップ (2008)</option>'."\n" ;
//				echo '<option value="14">★第1期トップ (2007)</option>'."\n" ;
			echo '</select>';
			echo '</form>';
			echo '<span glot-model="main_filter_pin">ピン表示</span> <br><span class="compare_other">'.$array_pin[$pin_data].'</span>'."\n";
		}
		echo '</div>';
		echo '<div class="filtering_position">';
		if($page_type == 5 or $stage_id == 4){
			// ソートプルダウンメニュー (ユーザー別ランキングのみ)
			echo '<form id="form3" name="form3" action="#" method="post" enctype="multipart/form-data" accept-charset="utf-8">'."\n";
			echo '<select type="text" name="sort_data" style="padding:2px;margin-left:4px;border:0;background-color:#333333;color:#ffffff;" onChange="FormSubmit2();">'."\n";
			echo '<option value="0">---</option>'."\n" ;
			echo '<option value="1">▼'.$array_sort[1].'</option>'."\n" ;
			echo '<option value="2">▼'.$array_sort[2].'</option>'."\n" ;
			echo '<option value="3">▼'.$array_sort[3].'</option>'."\n" ;
//				echo '<option value="4">▼名前順</option>'."\n" ;
			echo '<option value="5">▼'.$array_sort[5].'</option>'."\n" ;
			echo '<option value="6">▼'.$array_sort[6].'</option>'."\n" ;
			echo '</select>'."\n";
			echo '</form>'."\n";
			echo '<span glot-model="main_filter_sort">並び順</span> <br><span class="compare_other">'.$array_sort[$sort_data].'</span>'."\n";
		}
		echo '</div>';
		echo '<div class="filtering_position">';
		if($page_type == 3 or $page_type == 5 or $stage_id == 4){
			// サブフィルタープルダウンメニュー
//				echo '<div class="sub_pulldownmenu">';
			echo '<form id="form5" name="form5" action="#" method="post" enctype="multipart/form-data" accept-charset="utf-8">';
			echo '<select type="text" name="filtering_sub_data" style="padding:2px;margin-left:4px;border:0;background-color:#333333;color:#ffffff;" onChange="FormSubmit4();">';
			echo '<option value="0">---</option>'."\n" ;
			echo '<option value="1">■'.$array_subfilter[1].'</option>'."\n" ;
			if($stage_cat != 30) echo '<option value="2">□'.$array_subfilter[2].'</option>'."\n" ;
			echo '<option value="3">□'.$array_subfilter[3].'</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="4">□'.$array_subfilter[4].'</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="5">□'.$array_subfilter[5].'</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="6">□'.$array_subfilter[6].'</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="7">□'.$array_subfilter[7].'</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="8">□'.$array_subfilter[8].'</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="9">□'.$array_subfilter[9].'</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="10">□'.$array_subfilter[10].'</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="11">□'.$array_subfilter[11].'</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="12">□'.$array_subfilter[12].'</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="13">□'.$array_subfilter[13].'</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="14">□'.$array_subfilter[14].'</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="15">□'.$array_subfilter[15].'</option>'."\n" ;
			if($stage_cat == 30) echo '<option value="16">□'.$array_subfilter[16].'</option>'."\n" ;
			echo '</select>';
			echo '</form>';
			echo '<span glot-model="main_filter_subfilter">フィルター1</span> <br><span class="compare_other">'.$array_subfilter[$filtering_sub_data].'</span>';
//				echo '</div>';
		}
		echo '</div>';
		echo '<div class="filtering_position">';
		if($page_type == 5 or $stage_id == 4 or $stage_id == 5){
			// フィルタープルダウンメニュー
			echo '<form id="form4" name="form4" action="#" method="post" enctype="multipart/form-data" accept-charset="utf-8">'."\n";
			echo '<select type="text" name="filtering_data" style="padding:2px;margin-left:4px;border:0;background-color:#333333;color:#ffffff;" onChange="FormSubmit3();">'."\n";
			echo '<option value="0">---</option>'."\n" ;
			echo '<option value="1">◇'.$array_filter[1].'</option>'."\n" ;
			echo '<option value="14">◆'.$array_filter[14].'</option>'."\n" ;
			echo '<option value="2">◇'.$array_filter[2].'</option>'."\n" ;
			echo '<option value="3">◇'.$array_filter[3].'</option>'."\n" ;
			echo '<option value="4">◇'.$array_filter[4].'</option>'."\n" ;
			echo '<option value="12">◇'.$array_filter[12].'</option>'."\n" ;
			echo '<option value="13">◇'.$array_filter[13].'</option>'."\n" ;
			echo '<option value="15">★'.$array_filter[15].'</option>'."\n" ;
			echo '<option value="5">☆'.$array_filter[5].'</option>'."\n" ;
			echo '<option value="6">☆'.$array_filter[6].'</option>'."\n" ;
			echo '<option value="7">☆'.$array_filter[7].'</option>'."\n" ;
			echo '<option value="8">☆'.$array_filter[8].'</option>'."\n" ;
			echo '<option value="9">☆'.$array_filter[9].'</option>'."\n" ;
			echo '<option value="10">☆'.$array_filter[10].'</option>'."\n" ;
			echo '<option value="11">☆'.$array_filter[11].'</option>'."\n" ;
			echo '</select>';
			echo '</form>';
			echo '<span glot-model="main_filter_filter">フィルター2</span> <br><span class="compare_other">'.$array_filter[$filtering_data].'</span>'."\n";
		} else {
			echo '　';
		}
		echo '</div>';
		echo '<div style="float:left;">';
		// ★不具合発生につき非表示中（`at_rank`復旧まで使用不可）
		if($page_type == 99){
			// サブフィルタープルダウンメニュー
			echo '<div class="sub_pulldownmenu">';
			echo '<form id="form8" name="form8" action="#" method="post" enctype="multipart/form-data" accept-charset="utf-8">';
			echo '<select type="text" name="filtering_log_data" style="padding:2px;margin-left:4px;border:0;background-color:#333333;color:#ffffff;" onChange="FormSubmit8();">';
			echo '<option value="0">---</option>'."\n" ;
			echo '<option value="1">■'.$array_logfilter[1].'</option>'."\n" ;
			echo '<option value="2">□'.$array_logfilter[2].'</option>'."\n" ;
			echo '<option value="3">□'.$array_logfilter[3].'</option>'."\n" ;
			echo '<option value="4">□'.$array_logfilter[4].'</option>'."\n" ;
			echo '</select>';
			echo '</form>';
			echo '<span glot-model="main_filter_logfilter">フィルター3</span> <br><span class="compare_other">'.$array_logfilter[$log_data].'</span>';
			echo '</div>';
		}
		echo '</div>';
		echo '<div class="filtering_position">';
		echo '<form id="form2" name="form2" action="#" method="post" enctype="multipart/form-data" accept-charset="utf-8">'."\n";
		echo '<select type="text" name="compare_data" style="padding:2px;margin-left:4px;border:0;background-color:#333333;color:#ffffff;" onChange="FormSubmit();">'."\n";

		// ユーザー以外の比較対象一覧
		echo '<option value="0">---</option>'."\n" ;
		echo '<option value="1">◆'.$array_compare[1].'</option>'."\n" ;
		echo '<option value="3">◆'.$array_compare[3].'</option>'."\n" ;
		echo '<option value="10">◆'.$array_compare[10].'</option>'."\n" ;
		echo '<option value="20">◆'.$array_compare[20].'</option>'."\n" ;
		echo '<option value="_AVE">◆'.$array_compare[101].'</option>'."\n" ;
		echo '<option value="_SD">◆'.$array_compare[102].'</option>'."\n" ;
		echo '<option value="_NEXT">◆'.$array_compare[103].'</option>'."\n" ;
		echo '<option value="_DEF">◆'.$array_compare[104].'</option>'."\n" ;
		if($stage_id == 1 or $stage_cat == 20 or $stage_cat == 26 or $stage_cat == 30 or $page_type == 5) echo '<option value="_TIME">◆'.$array_compare[201].'</option>'."\n" ;
		if($stage_id == 1 or $stage_cat == 20 or $page_type == 5) echo '<option value="_700K">◆'.$array_compare[202].'</option>'."\n" ;
		if($stage_id == 1 or $stage_cat == 20 or $page_type == 5) echo '<option value="_701K">◆'.$array_compare[203].'</option>'."\n" ;
		if($stage_id == 1 or $stage_hook == 31 or $stage_hook == 32 or $stage_hook == 33 or $page_type == 5) echo '<option value="_WR">◆'.$array_compare[204].'</option>'."\n" ;
		if($stage_id == 1 or $stage_hook == 31 or $stage_hook == 32 or $stage_hook == 33 or $stage_hook == 36 or $page_type == 5) echo '<option value="_WRDX">◆'.$array_compare[206].'</option>'."\n" ;
		if($stage_id == 1 or $stage_cat == 30 or $page_type == 5) echo '<option value="_UX">◆'.$array_compare[205].'</option>'."\n" ;

		// ユーザー一覧を取得
		$compare_sql = "SELECT * FROM `user` ORDER BY `total_rps` DESC";
		$compare_result = mysqli_query($mysqlconn, $compare_sql);
			if (!$compare_result) {
				die('<br>Error '.__LINE__.'：クエリの取得に失敗.'.mysql_error());
			}
		while ($compare_row = mysqli_fetch_assoc($compare_result) ){
			$select_user = $compare_row["user_name"];
			echo '<option value="'.$select_user.'">'.$select_user.'</option>'."\n" ;
		}

		echo '</select>'."\n";
		echo '<input type="submit" value="比較" name="compare_check" class="form2_send" style="display:none;" />'."\n";
		echo '</form>'."\n";
		echo '</div>';
		echo '<div style="text-align:right;">';
		// 比較対象との勝敗表示
		if($compare_data === 0) {
			echo '<span glot-model="main_compare_score">スコア比較表示</span> <br><span class="compare_other">'.$array_compare[0].'</span><br class="pc-hidden" /><hr class="mobile-hidden" />'."\n" ;
		} elseif($compare_data == "_TIME") {
			echo '<span glot-model="main_compare_score">スコア比較表示</span> <br><span class="compare_even">'.$array_compare[201].'</span> <br><span style="color:#888888;font-size:0.9em;" glot-model="main_compare_timebonuscaution">(タマゴムシとサンショクシジミのポイントを含む)</span> <br>'."\n";
		} elseif($compare_data == "_NEXT") {
			echo '<span glot-model="main_compare_score">スコア比較表示</span> <br><span class="compare_even">'.$array_compare[103].'</span> <br>'."\n" ;
		} elseif ($compare_data == "_SD") {
			$compare_win = $compare_win + $compare_even;
			$next_compare_rank = $compare_data + 1;
			echo '<span glot-model="main_compare_score">スコア比較表示</span> <br><span class="compare_even">'.$array_compare[102].'</span> <br>'."\n" ;
		} elseif ($compare_data == "_AVE") {
			$compare_win = $compare_win + $compare_even;
			$next_compare_rank = $compare_data + 1;
			echo '<span glot-model="main_compare_score">スコア比較表示</span> <br><span class="compare_even">'.$array_compare[101].'</span><br class="pc-hidden" /><hr class="mobile-hidden" />'."\n" ;
			if ($page_type == 5) echo '<span glot-model="main_compare_ave_over">平均以上</span>：<span class="compare_win">'.$compare_win.'</span> / <span glot-model="main_compare_ave_down">平均以下</span>：<span class="compare_lose">'.$compare_lose."</span> <br>\n";
		} elseif ($compare_data == "_700K") {
			$compare_win = $compare_win + $compare_even;
			$next_compare_rank = $compare_data + 1;
			echo '<span glot-model="main_compare_score">スコア比較表示</span> <br><span class="compare_even">'.$array_compare[202].'</span><br class="pc-hidden" /><hr class="mobile-hidden" />'."\n" ;
			if ($page_type == 5) echo '<span glot-model="main_compare_target_over">目標突破</span>：<span class="compare_win">'.$compare_win.'</span> / <span glot-model="main_compare_target_down">目標未満</span>：<span class="compare_lose">'.$compare_lose."</span> <br>\n";
		} elseif ($compare_data == "_701K") {
			$compare_win = $compare_win + $compare_even;
			// $next_compare_rank = $compare_data + 1;
			echo '<span glot-model="main_compare_score">スコア比較表示</span> <br><span class="compare_even">'.$array_compare[203].'</span><br class="pc-hidden" /><hr class="mobile-hidden" />'."\n" ;
			if ($page_type == 5) echo '<span glot-model="main_compare_target_over">目標突破</span>：<span class="compare_win">'.$compare_win.'</span> / <span glot-model="main_compare_target_down">目標未満</span>：<span class="compare_lose">'.$compare_lose."</span> <br>\n";
		} elseif ($compare_data == "_UX") {
			$compare_win = $compare_win + $compare_even;
			echo '<span glot-model="main_compare_score">スコア比較表示</span> <br><span class="compare_even">'.$array_compare[205].'</span><br class="pc-hidden" /><hr class="mobile-hidden" />'."\n" ;
			if ($page_type == 5) echo '<span glot-model="main_compare_target_over">目標突破</span>：<span class="compare_win">'.$compare_win.'</span> / <span glot-model="main_compare_target_down">目標未満</span>：<span class="compare_lose">'.$compare_lose."</span> <br>\n";
		} elseif ($compare_data == "_DEF") {
			echo '<span glot-model="main_compare_score">スコア比較表示</span> <br><span class="compare_even">'.$array_compare[104].'</span><br class="pc-hidden" /><hr class="mobile-hidden" /><span style="color:#888888;font-size:0.9em;" glot-model="main_compare_change_caution">(未更新ステージや古い投稿は除く)</span> <br>'."\n";
			if ($page_type == 5) echo '<span glot-model="main_compare_change_over">上昇</span>：<span class="compare_win">'.$compare_win.'</span> / <span glot-model="main_compare_change_down">下降</span>：<span class="compare_lose">'.$compare_lose.'</span> / 変動なし：<span class="compare_even">'.$compare_even."</span> <br>\n";
		} elseif ($compare_data == "_WR") {
			echo '<span glot-model="main_compare_score">スコア比較表示</span> <br><span class="compare_even">'.$array_compare[204].'</span><br class="pc-hidden" /><hr class="mobile-hidden" />'."\n" ;
			$compare_win = $compare_win + $compare_even;
			if ($page_type == 5) echo '<span glot-model="main_compare_getwr">ピクミン3WR獲得数</span>：<span class="compare_wr0">'.$compare_win.'</span> / WR-60：<span class="compare_wr1">'.$compare_wr1.'</span> / WR-120：<span class="compare_wr2">'.$compare_wr2.'</span> / WR-180：<span class="compare_wr3">'.$compare_wr3.'</span> / <span glot-model="main_compare_over180">WR差3分以上</span>：<span class="compare_even">'.$compare_lose."</span> <br>\n";
		} elseif ($compare_data == "_WRDX") {
			echo '<span glot-model="main_compare_score">スコア比較表示</span> <br><span class="compare_even">'.$array_compare[206].'</span><br class="pc-hidden" /><hr class="mobile-hidden" />'."\n" ;
			$compare_win = $compare_win + $compare_even;
			if ($page_type == 5) echo '<span glot-model="main_compare_getwrdx">ピクミン3DXWR獲得数</span>：<span class="compare_wr0">'.$compare_win.'</span> / WR-60：<span class="compare_wr1">'.$compare_wr1.'</span> / WR-120：<span class="compare_wr2">'.$compare_wr2.'</span> / WR-180：<span class="compare_wr3">'.$compare_wr3.'</span> / <span glot-model="main_compare_over180">WR差3分以上</span>：<span class="compare_even">'.$compare_lose."</span> <br>\n";
		} elseif ( !is_numeric($compare_data) and $compare_data != "" ){
			$compare_even = $compare_even + $compare_blank;
			echo '<span glot-model="main_compare_score">スコア比較表示</span> <br><A href="./'.$compare_data.'"><span class="compare_even">'.$compare_data .'</span><span glot-model="san_tail">さん</span></A><br class="pc-hidden" /><hr class="mobile-hidden" />'."\n" ;
			if ($page_type == 5) echo '<span class="compare_win">'.$compare_win.'</span><span glot-model="main_battle_win">勝</span> / <span class="compare_lose">'.$compare_lose.'</span><span glot-model="main_battle_lose">敗</span> / <span class="compare_even">'.$compare_even.'</span><span glot-model="main_battle_draw">分</span> <br>'."\n";
		} elseif ( is_numeric($compare_data) and $compare_data > 0) {
			$compare_win = $compare_win + $compare_even;
			$next_compare_rank = $compare_data + 1;
			echo '<span glot-model="main_compare_score">スコア比較表示</span> <br><span class="compare_even">'.$compare_data .'<span glot-model="rank_tail"> 位</span></span><br class="pc-hidden" /><hr class="mobile-hidden" />'."\n" ;
			if ($page_type == 5) echo $compare_data.'<span glot-model="main_compare_rank_over">位以上獲得数</span>：<span class="compare_win">'.$compare_win."</span> / ".$next_compare_rank.'<span glot-model="main_compare_rank_down">位以下</span>：<span class="compare_lose">'.$compare_lose."</span> <br>\n";
		} else {
			echo '<span glot-model="main_compare_score">スコア比較表示</span> <br><span class="compare_other">'.$array_pin[0].'</span><br class="pc-hidden" /><hr class="mobile-hidden" />'."\n" ;
		}
	}
	echo '</div>';
	echo '</div>';
}
echo '</div>';
if($page_type != 1 and $page_type != 6 and $page_type != 13 and $page_type != 16 and $page_type != 20)  echo '</div>';

if($page_type == 20){
	if(strpos($unique_data["pic_file"], 'mp4')){
		echo '<video id="my-video" style="margin:0 auto;" class="video-js" controls preload="auto" width="720" data-setup="{}">
		<source src="../_img/pik4/uploads/'.$unique_data["pic_file"].'" type="video/mp4"></video>';
	}
	echo ' <br>';
}
