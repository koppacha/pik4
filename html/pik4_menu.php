<div class="pik4_form" id="g-nav">
<div id="g-nav-list">
<nav class="nav nav-masthead justify-content-center" style="overflow:hidden;">
	<a class="nav-link" href="#" id="ja" glot-model="jp" style="width:50%;float:left;padding:4px 0 4px 0;font-size:1.3em;text-align:center;">日本語</a>
	<a class="nav-link" href="#" id="en" glot-model="us" style="width:50%;float:left;padding:4px 0 4px 0;font-size:1.3em;text-align:center;">English</a>
</nav>
<span style="letter-spacing:0.5em;line-height:1.2em;font-size:1.65em;font-weight:bold;">
<A name="menu" href="./" glot-model="menu_title">
<span style="color:#fff;">ピク</span><span style="color:#bbb;">ミンシリーズ</span> <br>
<span style="color:#fff;">チャレ</span><span style="color:#bbb;">ンジモード</span> <br>
<span style="color:#fff;">大会</span></A>
</span> <br>
<hr size="1"/>
<span style="line-height:1.0em;font-size:0.9em;color:#999999;">
<A href="https://github.com/koppacha/pik4" target="_brank"><?php echo "Ver.".$sys_ver." (".$php_update.")"; ?></A><br>
<hr size="1"/>
<?php
if(!$mysql_mode){
	echo '<span style="color:#ff9e56;"><i class="fa fa-flask" aria-hidden="true"></i>Local Mode</span> <br>'.date('Y/m/d H:i:s', $now_time)." <br>";
	echo "Memory:".round(memory_get_usage()/1024/1024,2)."MB/".round(memory_get_peak_usage()/1024/1024,2)."MB <br>";
	echo 'Page Type: '.$page_type.'<br>';
	$time_c = microtime(true) - $time_start;
	$loadtime_echo[] = " <br>".__LINE__. "行目：{$time_c} 秒";
}
if(!$mysql_mode) loadtime_calc(__LINE__);
// お砂場

// お砂場ここまで

// メニューカラムヘッダー
?>
</span>
<?php if($_SESSION['debug_mode']) echo '<span style="color:#ff9e56;"><i class="fa fa-flask" aria-hidden="true"></i>Debug Mode</span> <br>'; ?>
<div id="display_config_on" style="display:none;margin-bottom:0.5em;" class="pickup_menu">
<span class="nav_caption"><span style="color:#cccccc;cursor:pointer;" href="javascript:void(0)" onclick="menu_toggle('display_config_on','display_config_off');"><i class="fa fa-wrench" aria-hidden="true"></i><span glot-model="menu_setting">表示設定</span></A></span></span> <br>

<?php if($nav_table != 2) echo '<span><A style="color:#05ffe3;" href="javascript:void(0);" onclick="SeasonToggle(\'nav_table\');"><i class="fa fa-toggle-on" aria-hidden="true"></i><span glot-model="menu_nav_on">ナビゲーションテーブル表示</span></A> <br></span>'; ?>
<?php if($nav_table == 2) echo '<span><A style="color:#aaaaaa;" href="javascript:void(0);" onclick="SeasonToggle(\'nav_table\');"><i class="fa fa-toggle-off" aria-hidden="true"></i><span glot-model="menu_nav_off">ナビゲーションテーブル非表示</span></A> <br></span>'; ?>
<?php if($starter_info != 2) echo '<span><A style="color:#05ffe3;" href="javascript:void(0);" onclick="SeasonToggle(\'starter_info\');"><i class="fa fa-toggle-on" aria-hidden="true"></i><span glot-model="menu_info_on">ご案内表示</span></A> <br></span>'; ?>
<?php if($starter_info == 2) echo '<span><A style="color:#aaaaaa;" href="javascript:void(0);" onclick="SeasonToggle(\'starter_info\');"><i class="fa fa-toggle-off" aria-hidden="true"></i><span glot-model="menu_info_off">ご案内非表示</span></A> <br></span>'; ?>
<?php if($notice_twitter != 2) echo '<span><A style="color:#05ffe3;" href="javascript:void(0);" onclick="SeasonToggle(\'notice_twitter\');"><i class="fa fa-toggle-on" aria-hidden="true"></i><span glot-model="menu_info2_on">お知らせ表示</span></A> <br></span>'; ?>
<?php if($notice_twitter == 2) echo '<span><A style="color:#aaaaaa;" href="javascript:void(0);" onclick="SeasonToggle(\'notice_twitter\');"><i class="fa fa-toggle-off" aria-hidden="true"></i><span glot-model="menu_info2_off">お知らせ非表示</span></A> <br></span>'; ?>
<?php if($movie_link != 2) echo '<span><A style="color:#05ffe3;" href="javascript:void(0);" onclick="SeasonToggle(\'movie_link\');"><i class="fa fa-toggle-on" aria-hidden="true"></i><span glot-model="menu_mov_on">動画リンク表示</span></A> <br></span>'; ?>
<?php if($movie_link == 2) echo '<span><A style="color:#aaaaaa;" href="javascript:void(0);" onclick="SeasonToggle(\'movie_link\');"><i class="fa fa-toggle-off" aria-hidden="true"></i><span glot-model="menu_mov_off">動画リンク非表示</span></A> <br></span>'; ?>
<?php if($latest_record != 2) echo '<span><A style="color:#05ffe3;" href="javascript:void(0);" onclick="SeasonToggle(\'latest_record\');"><i class="fa fa-toggle-on" aria-hidden="true"></i><span glot-model="menu_newrec_on">最新/今週トップ/人気ステージ表示</span></A> <br></span>'; ?>
<?php if($latest_record == 2) echo '<span><A style="color:#aaaaaa;" href="javascript:void(0);" onclick="SeasonToggle(\'latest_record\');"><i class="fa fa-toggle-off" aria-hidden="true"></i><span glot-model="menu_newrec_off">最新/今週トップ/人気ステージ非表示</span></A> <br></span>'; ?>
<?php if($diary_challenge != 2) echo '<span><A style="color:#05ffe3;" href="javascript:void(0);" onclick="SeasonToggle(\'diary_challenge\');"><i class="fa fa-toggle-on" aria-hidden="true"></i><span glot-model="menu_diary_on">日替わりチャレンジ表示</span></A> <br></span>'; ?>
<?php if($diary_challenge == 2) echo '<span><A style="color:#aaaaaa;" href="javascript:void(0);" onclick="SeasonToggle(\'diary_challenge\');"><i class="fa fa-toggle-off" aria-hidden="true"></i><span glot-model="menu_diary_off">日替わりチャレンジ非表示</span></A> <br></span>'; ?>
<?php if($total_ranking != 2) echo '<span><A style="color:#05ffe3;" href="javascript:void(0);" onclick="SeasonToggle(\'total_ranking\');"><i class="fa fa-toggle-on" aria-hidden="true"></i><span glot-model="menu_total_on">参加者総合ランキング表示</span></A> <br></span>'; ?>
<?php if($total_ranking == 2) echo '<span><A style="color:#aaaaaa;" href="javascript:void(0);" onclick="SeasonToggle(\'total_ranking\');"><i class="fa fa-toggle-off" aria-hidden="true"></i><span glot-model="menu_total_off">参加者総合ランキング非表示</span></A> <br></span>'; ?>

<?php
/* リトライカウンター廃止中
   if($retry_counter != 2) echo '<span><A style="color:#05ffe3;" href="javascript:void(0);" onclick="SeasonToggle(\'retry_counter\');"><i class="fa fa-toggle-on" aria-hidden="true"></i>リトライカウンター表示</A> <br></span>';
   if($retry_counter == 2) echo '<span><A style="color:#aaaaaa;" href="javascript:void(0);" onclick="SeasonToggle(\'retry_counter\');"><i class="fa fa-toggle-off" aria-hidden="true"></i>リトライカウンター非表示</A> <br></span>';
*/
?>
</div>
<div id="display_config_off" class="pickup_menu" style="background-color:transparent;margin-bottom:0;"><span class="nav_caption"><span style="color:#cccccc;cursor:pointer;" href="javascript:void(0)" onclick="menu_toggle('display_config_on','display_config_off');"><i class="fa fa-wrench" aria-hidden="true"></i><span glot-model="menu_setting">表示設定</span></A></span></span> <br>

</div>
<?php
if( $mysql_host == "127.0.0.1") {
	echo '<div style="display:none;">';
} else {
	echo '<hr size="1"/><div>';
}
?>
counter <Img title="累計アクセス（2015/09/01～)" src="https://chr.mn/_cgi/dayx_pik4_cha/dayx.cgi?gif"> | <Img title="今日のアクセス" src="https://chr.mn/_cgi/dayx_pik4_cha/dayx.cgi?today"> | <Img title="昨日のアクセス" src="https://chr.mn/_cgi/dayx_pik4_cha/dayx.cgi?yes"> <br>
</div>
<?php
if($page_type == 0 or $page_type == 1 or $page_type == 2 or $page_type == 5 or $page_type == 6 or $page_type == 9 or $page_type == 10 or $page_type == 13 or $page_type == 15 or $page_type == 17 or $page_type == 18 or $page_type == 20 or $page_type == 21 or $page_type > 97){

} else {
	echo '<A href="javascript:void(0)" class="form_toggle" style="display:block;">
	<div class="form_button mobile-hidden">
		<div class="holder">
			<div class="first"></div>
			<div class="second"></div>
			<div class="third"></div>
			<div class="txt" style="text-align:center;margin:8px;width:204px;height:86px;background-color:#fff;border-radius:5px;">
				<div style="margin-top:24px;">
					<span style="border-bottom:solid 1px #777;color:#000;"><i class="faa-float animated fa fa-paper-plane" style="color:#000;" aria-hidden="true"></i>
					<span glot-model="menu_submit">このステージに投稿する</span></span> <br>　<span style="color:#555;font-size:0.9em;">　Submit Record</span>
				</div>
			</div>
		</div>
	</div></A>';
}

	// 参加者総合ランキング簡易表示板

	// テーブルを取得
	$sql = "SELECT * FROM `ranking` ORDER BY `post_date`";
	$result = mysqli_query($mysqlconn, $sql);
	if (!$result) {
		echo " <br>Error ".__LINE__."：クエリの取得エラーが発生しています。";
	}
	$rows_count = mysqli_num_rows($result);
	$sql = "SELECT * FROM `battle` ORDER BY `post_date`";
	$result = mysqli_query($mysqlconn, $sql);
	if (!$result) {
		echo " <br>Error ".__LINE__."：クエリの取得エラーが発生しています。";
	}
	$battle_count = mysqli_num_rows($result) / 2;
	$rows_count += $battle_count;

	// ランキングを表示
	echo '<table class="post_count" style="width:100%;table-layout:fixed;"><tr><td><span glot-model="menu_cnt_total">総投稿数</span></td><td><span glot-model="menu_cnt_now">今週の投稿</span></td><td><span glot-model="menu_cnt_prev">先週の投稿</span></td></tr>';
	echo '<tr><td><span style="font-size:1.5em;color:#f2ed0c;font-weight:bold;">'.$rows_count.'</span></td>';

	// 今週の投稿数を取得
	$week = date("w", $now_time)-1;		// 月曜日＝0
	if($week == -1) $week = 6;		// 日曜日＝6
	$last_monday = strtotime("-{$week}day 0:0:0 -1sec", $now_time);
	$last_week_date = date('Y-m-d H:i:s', $last_monday);
	$sql = "SELECT * FROM `ranking` WHERE `post_date` >= '$last_week_date'";
	$result = mysqli_query($mysqlconn, $sql);
	if (!$result) {
		echo " <br>Error ".__LINE__."：クエリの取得エラーが発生しています。";
	}
	$rows_count = mysqli_num_rows($result);

	echo '<td><span style="font-size:1.5em;color:#aff20c;font-weight:bold;">'.$rows_count.'</span></td>';

	// 先週の投稿数を取得
	$lastest_monday = strtotime("-7day", $last_monday);
	$lastest_week_date = date('Y-m-d H:i:s', $lastest_monday);
	$sql = "SELECT * FROM `ranking` WHERE `post_date` BETWEEN '$lastest_week_date' AND '$last_week_date'";
	$result = mysqli_query($mysqlconn, $sql);
	if (!$result) {
		echo " <br>Error ".__LINE__."：クエリの取得エラーが発生しています。";
	}
	$rows_count = mysqli_num_rows($result);

	echo '<td><span style="font-size:1.5em;color:#0cf2c8;font-weight:bold;">'.$rows_count.'</span></td></tr></table>';


// 期間限定ランキングミニメニュー
	$fixed_limdate  = date('ymd' ,$limited_start_time);
	$fixed_limstart = date('Y.m/d',$limited_start_time);
	$fixed_limend	= date('-m/d',$limited_end_time);

	// チーム対抗ランキングのチーム色をリセットする
	if(isset($limited_stage_list[$limited_num])){
		if( $stage_id != $limited_stage_list[$limited_num]){
			if($stage_id < $limited_stage_list[$limited_num]){
				$team_a = $team_a2;
				$team_b = $team_b2;
			}
		}
	}
// 参加者数を表示
if($uplan_num){
	$event_flag = 1;
} else {
	$event_flag = 0;
}
if(($uplan_num != 0 or $limited_num != 0) and $now_time < $limited_start_time){
	$query = "SELECT * FROM `user` WHERE `current_team` >= '$team_a'";
	$result = mysqli_query($mysqlconn, $query );
	$pre_entry_rows = mysqli_num_rows($result);
	echo '<div style="background-color:#777777;" class="pickup_menu">';
	if(!$event_flag){
		echo '<span class="nav_caption mini_caption3" glot-model="menu_limited_notice">開催予定の期間限定ランキング</span> <br>';
		echo '<span style="color:#ffffff;"><span glot-model="menu_limited_dai">第</span>'.$limited_num.'<span glot-model="menu_limited_kai">回</span> ('.$fixed_limstart.$fixed_limend.') <br>';
		echo $limited_stage_title_fixed[$limited_num - 1].'×'.$limited_stage_sub_fixed[$limited_num - 1].' <br>';
	} else {
		echo '<span class="nav_caption mini_caption3" glot-model="menu_uplan_notice">開催予定の参加者企画</span> <br>';
		echo '<span style="color:#ffffff;"><span glot-model="menu_limited_dai">第</span>'.$uplan_num.'<span glot-model="menu_limited_kai">回</span>：'.$uplan_stage_title_fixed[$uplan_num - 1].' <br>';
		echo '<A style="font-size:1.2em;" href="./'.$uplan_stage_list[$uplan_num].'">→大会ページへ</A><br>';
	}
	// カウントダウンタイマー（確定前は表示しない）
	echo '<span id="CDT2" style="line-height:150%;">　</span></A> <br>';
	echo "</div>";
} else {
	echo '<span id="CDT2" style="display:none;"></span>';
}
?>
<?php
// 期間限定ランキングメニュー開催時
	if(($uplan_num != 0 or $limited_num != 0) and $now_time > $limited_start_time){
		if(!$event_flag){
			echo '<div style="background-color:#555555;" class="pickup_menu">';
			echo '<span class="nav_caption mini_caption4 glot-model="menu_limited_open">開催中の期間限定ランキング</span> <br>';
			echo '→<b><A href="./'.$limited_stage_list[$limited_num].'"><span glot-model="menu_limited_dai">第</span>'.$limited_num.'<span glot-model="menu_limited_kai">回</span> ('.$fixed_limstart.$fixed_limend.')</A></b> <br>';
			echo $limited_stage_title_fixed[$limited_num - 1].'×'.$limited_stage_sub_fixed[$limited_num - 1].' <br>';
			echo '<span id="CDT" style="line-height:150%;">　</span> <br>';
		} else {
			echo '<div style="background-color:#555555;" class="pickup_menu">';
			echo '<span class="nav_caption mini_caption4 glot-model="menu_uplan_open">開催中の参加者企画</span> <br>';
			echo '<span style="color:#ffffff;"><span glot-model="menu_limited_dai">第</span>'.$uplan_num.'<span glot-model="menu_limited_kai">回</span>：'.$uplan_stage_title_fixed[$uplan_num - 1].' <br>';
			echo '<A style="font-size:1.2em;" href="./'.$uplan_stage_list[$uplan_num].'">→大会ページへ</A><br>';
			echo '<span id="CDT" style="line-height:150%;">　</span> <br>';
		}
		// チーム対抗版期間限定ランキングのスコアボードを表示
		if(strpos($limited_type[$limited_stage_list[$limited_num]], 't') !== false and $now_time > $limited_start_time){

			// チーム点数を再計算
			${'rps'.$team_a} = 0;
			${'rps'.$team_b} = 0;
			${'team'.$team_a.'_score'} = 0;
			${'team'.$team_b.'_score'} = 0;

			// ハンデ再計算 (3673行付近)
			$minority_bonus = 0;
			$sql = "SELECT * FROM `ranking` WHERE `team` = '$team_a' AND `log` = 0";
			$result = mysqli_query($mysqlconn, $sql);
			$rightside_count = mysqli_num_rows($result);
			$sql = "SELECT * FROM `ranking` WHERE `team` = '$team_b' AND `log` = 0";
			$result = mysqli_query($mysqlconn, $sql);
			$leftside_count = mysqli_num_rows($result);
			$sql = "SELECT * FROM `user` WHERE `current_team` BETWEEN '$team_a' AND '$team_b'";
			$result = mysqli_query($mysqlconn, $sql);
			$player_total = mysqli_num_rows($result);
			$post_diff = abs($rightside_count - $leftside_count);
			$minority_bonus = $post_diff * ceil($player_total / 2);
			echo " <br>";
			list($leftside_count, $rightside_count) = array($rightside_count, $leftside_count); // ハンデ付与判定のために便宜的に変数の値を入れ替える
			if($leftside_count > $rightside_count){
				$is_minority = 2;
				${'rps'.$team_b} += $minority_bonus;
			}
			if($leftside_count < $rightside_count){
				$is_minority = 1;
				${'rps'.$team_a} += $minority_bonus;
			}
			$imp_limstage = implode(",", ${'limited'.$limited_stage_list[$limited_num]});
			$i = $team_a;
			while($i <= $team_b){
				$sql = "SELECT * FROM `ranking` WHERE `stage_id` IN($imp_limstage) AND `log` = 0 AND `team` = '$i' ORDER BY `score` DESC";
				$result = mysqli_query($mysqlconn, $sql);
				if (!$result) {
					die('<br>Error '.__LINE__.'：クエリの取得に失敗.'.mysql_error());
				}
				// 各ステージのチーム別レコードをWhileして合計スコアを加算していく
				while(${'total_row'.$i} = mysqli_fetch_assoc($result)){
					${'rps'.$i} += ${'total_row'.$i}["rps2"];
					if(array_search(${'total_row'.$i}["stage_id"], $limited_pik1)){
						${'team'.$i.'_score'} += ${'total_row'.$i}["score"] * 10;
					} else {
						${'team'.$i.'_score'} += ${'total_row'.$i}["score"];
					}
				}
			$i++;
			}
		echo '<div style="width:100%;text-align:center;"><span style="font-size:3em;line-height:100%;color:#'.$teamc[$team_a].'">'.${'rps'.$team_a}.'</span> <span style="padding:0 1em;font-size:2.5em;">‐</span> <span style="font-size:3em;color:#'.$teamc[$team_b].'">'.${'rps'.$team_b}.'</span></div>';
//			echo '合計スコア：<span class="team'.$team_a.'">'.${'team'.$team_a.'_score'}.'</span> - <span class="team'.$team_b.'">'.${'team'.$team_b.'_score'}.'</span> <br>';
		}

		// 通常版期間限定ランキングのトップランカーを表示
		if($limited_type[$uplan_stage_list[$uplan_num]] == 'u' or $limited_type[$limited_stage_list[$limited_num]] == 'n'){
			foreach($limited_stage as $val){
				echo '<A href="./'.$val.'">・'.mb_substr( preg_replace('/<.*?>/', '', $array_stage_title[$val] ), 5).'</A> <br>';
			}
			echo '<hr size="1"/>';
		}
		if(($uplan_num != 0 or $limited_num != 0) and $now_time > $limited_start_time){
			if(!$event_flag){
				$fixed_limited_num = sprintf('%03d', $limited_num);
				$limited_db = 'total_limited'.$fixed_limited_num;
			} else {
				$fixed_limited_num = sprintf('%03d', $uplan_num);
				$limited_db = 'total_uplan'.$fixed_limited_num;
			}
			$sql_uc = "SELECT * FROM `user` WHERE $limited_db > 0 ORDER BY $limited_db DESC LIMIT 5";
			$result_uc = mysqli_query($mysqlconn, $sql_uc);
			if ($result_uc) {
				$rows_count = mysqli_num_rows($result_uc);
				$p = -1;
				$i =  0;
				$j =  1;
				while($row_uc = mysqli_fetch_assoc($result_uc) ){
				$user_rps = $row_uc[$limited_db];
				$prev_user_rps[$i] = $user_rps;
					if ( $prev_user_rps[$p] !== $user_rps ){
						$i++ ;
						$p++ ;
					} else {
						$i = $j;
					}
				// ランキングを表示
					if($user_rps > 0){
						if(!$blind) echo $i.' <span glot-model="rank_tail">位</span>：<A href="./'.$row_uc["user_name"].'">'.$row_uc["user_name"].'</A> ('.number_format($row_uc[$limited_db]).'pts.) <br>'."\n";
						if( $blind) echo $i.' <span glot-model="rank_tail">位</span>：<A href="./'.$row_uc["user_name"].'">'.$row_uc["user_name"].'</A> (??,??? pts.) <br>'."\n";
					}
				}
				$j++;
			}
		}
	echo '</div>';
	} else {
		echo '<span id="CDT" style="display:none;"></span>';
	}

?>

<?php if($starter_info !== "2"): ?>
<div id="starter_info" class="pickup_child pickup_menu" style="display:block;">
<span class="nav_caption mini_caption4" glot-model="menu_info">ご案内</span> <br>
<ul class="nav" style="margin-bottom:0;">
<li><A href="./ピクチャレ大会へようこそ"><i class="infof far fa-smile-beam"></i><span glot-model="menu_info_welcome">ピクチャレ大会へようこそ</span></a></li>
<li><A href="./ルール集"><i class="infof fab fa-fort-awesome"></i><span glot-model="menu_info_rule">ルール集</span></a></li>
<li><A href="https://discord.gg/rQEBJQa" tager="_brank"><i class="infof fab fa-discord"></i><span glot-model="menu_info_discord">Discord（ピクミン界隈専用チャット）</span></A></li>
<li><A href="https://discord.gg/CrAgTFP" tager="_brank"><i class="infof fab fa-discord"></i>Discord（Pikmin Speedrunning）</span></A></li>
<li><A href="https://chr.mn/glyph/%e9%80%a3%e7%b5%a1%e3%83%95%e3%82%a9%e3%83%bc%e3%83%a0" rel="nofollow"><i class="infof fas fa-phone-square"></i><span glot-model="menu_info_contact">管理人への連絡はこちら</span></a></li>
<li><A href="./不正疑惑騒動まとめ"><i class="infof fas fa-frown"></i><span glot-model="menu_info_cheating">不正疑惑騒動まとめ</span></a></li>
<li><A href="./期間限定チャレンジ一覧"><i class="infof fas fa-clipboard-list"></i><span glot-model="menu_info_limitedlist">期間限定チャレンジ一覧</span></a></li>
<li><A href="https://docs.google.com/spreadsheets/d/1RPrgH3MnY2BFN-g3whJSgcIY4NXya5Tg/edit?usp=sharing&ouid=106930103873328114782&rtpof=true&sd=true"><i class="infof fas fa-language"></i>English translation sheet</a></li>

</ul>
<div id="display_guide_on" style="display:none;">
<span><span style="color:#cccccc;cursor:pointer;" href="javascript:void(0)" onclick="menu_toggle('display_guide_on','display_guide_off');" glot-model="menu_info_less">▲折り畳む</span></span></A> <br>
<ul class="nav" style="margin-bottom:0;">
<li><A href="https://docs.google.com/forms/d/e/1FAIpQLScqiDmjbzlCb6M85gjsicVRnms9NBVxlOQGsm7oFk12axwOBw/viewform" target="_blank"><i class="infof far fa-paper-plane"></i><span glot-model="menu_info_temporarypost">臨時投稿フォーム(要Googleアカ)</span></a></li>
<li><A href="https://docs.google.com/forms/d/e/1FAIpQLScWDkVFnWgFt_Xta9GpZY2Ykz7_iFHiCQWQ4k901Tesd4Ltgg/viewform"><i class="infof far fa-paper-plane"></i><span glot-model="menu_info_meetingroom">会議室入室申請フォーム</span></A></li>
<li><A href="https://docs.google.com/forms/d/e/1FAIpQLSeV1L1DTmWyim4luqFdI7P6IAXnrIhl5UvRekgPWOmq9uBaSA/viewform"><i class="infof far fa-paper-plane"></i><span glot-model="menu_info_exemption">証拠動画免除フォーム</span></A></li>
<li><A href="./機能一覧"><i class="infof fas fa-dharmachakra"></i><span glot-model="menu_info_functionlist">機能一覧</span></a></li>
<li><A href="./質問集"><i class="infof fas fa-question-circle"></i><span glot-model="menu_info_questionlist">質問集</span></a></li>
<li><A href="./オフ会"><i class="infof fas fa-user-edit"></i><span glot-model="menu_info_realevent">オフ会ガイドライン</span></a></li>
<li><A href="./wiki/"><i class="infof fas fa-book"></i><span glot-model="menu_info_pikminkeywords">新・ピクミンキーワード</span></a></li>
<li><A href="./ピクミン3DXが発売された場合の対応"><i class="infof fas fa-rocket"></i><span glot-model="menu_info_pik3dx">ピクミン3DXが発売された場合の対応</span></a></li>
</ul>
</div>
<div id="display_guide_off">
<span><span style="color:#cccccc;cursor:pointer;" href="javascript:void(0)" onclick="menu_toggle('display_guide_on','display_guide_off');" glot-model="menu_info_more">▼さらに表示</span></span></A> <br>
</div>
</div>
<?php endif ?>

<!-- <div id="pickup_challenge" class="pickup_child pickup_menu" style="display:block;">
<?php
// ピックアップ・チャレンジ
?> 
</div>
/-->


<?php if($notice_twitter !== "2"): ?>
<div id="twitter_timeline" class="pickup_child pickup_menu" style="display:block;">
<?php
// Twitter広報
	echo '<span class="nav_caption"><A class="mini_caption4" href="https://twitter.com/PikminChallenge" target="_blank" glot-model="menu_info2">お知らせ</A></span> <br>'."\n";
	$result = $twObj->get("users/show",["screen_name"=>"PikminChallenge"]);
	echo '<span style="font-weight:normal;"><span style="color:#aaaaaa;">';
	echo '<A target="_blank" href="https://twitter.com/'.$result->screen_name.'"><i class="fab fa-twitter" aria-hidden="true"></i>@'.$result->screen_name.'</A> <br>';
	echo date('Y/m/d H:i:s', strtotime($result->status->created_at));
	echo "</span> <br>";
	echo $result->status->text;
	if(isset($result->status->entities->media[0]->media_url_https)){
		echo ' <A data-lity="data-lity" href="'.$result->status->entities->media[0]->media_url_https.'"><i class="fa fa-camera"></i></A>';
	}
	echo "</span>";
?>
</div>
<?php endif ?>

<?php if($movie_link !== "2"): ?>
<div id="pickup_challenge" class="pickup_child pickup_menu" style="display:block;">
<span class="nav_caption mini_caption4" glot-model="menu_mov">リンク集</span> <br>
<span glot-model="menu_link_mov">◆動画</span><br>
<ul class="nav not-margin">
	<li><A href="https://www.twitch.tv/directory/game/Pikmin" target="_blank">
	<i class="infof fab fa-twitch"></i> <span glot-model="menu_mov_twitch1">Twitch: ピクミン</span></A></li>
	<li><A href="https://www.twitch.tv/directory/game/Pikmin%202" target="_blank">
	<i class="infof fab fa-twitch"></i> <span glot-model="menu_mov_twitch2">Twitch: ピクミン2</span></A></li>
	<li><A href="https://www.twitch.tv/directory/game/Pikmin%203" target="_blank">
	<i class="infof fab fa-twitch"></i> <span glot-model="menu_mov_twitch3">Twitch: ピクミン3</span></A></li>
	<li><A href="https://www.youtube.com/results?search_query=%E3%83%94%E3%82%AF%E3%83%9F%E3%83%B3&sp=CAI%253D" target="_blank">
	<i class="infof fab fa-youtube"></i> <span glot-model="menu_mov_youtubeja">YouTube: 日本語</span></A></li>
	<li><A href="https://www.youtube.com/results?search_query=pikmin&sp=CAI%253D" target="_blank">
	<i class="infof fab fa-youtube"></i> <span glot-model="menu_mov_youtubeen">YouTube: 英語</span></A></li>
	<li><A href="https://www.nicovideo.jp/search/%E3%83%94%E3%82%AF%E3%83%9F%E3%83%B3?sort=f&order=d" target="_blank">
	<i class="infof fas fa-tv"></i> <span glot-model="menu_mov_nicovideo">ニコニコ動画: 新着順</span></A></li>
</ul>
<span glot-model="menu_link_rta">◆本編RTA（Speedrun.com）</span><br>
<ul class="nav not-margin">
	<li><A href="https://www.speedrun.com/pikmin1" target="_blank">
	<i class="infof fas fa-trophy"></i> <span glot-model="pik1">ピクミン</span></A></li>
	<li><A href="https://www.speedrun.com/pikmin2" target="_blank">
	<i class="infof fas fa-trophy"></i> <span glot-model="pik2">ピクミン2</span></A></li>
	<li><A href="https://www.speedrun.com/pikmin3" target="_blank">
	<i class="infof fas fa-trophy"></i> <span glot-model="pik3">ピクミン3</span></A></li>
	<li><A href="https://www.speedrun.com/pikmin3dx" target="_blank">
	<i class="infof fas fa-trophy"></i> <span glot-model="pik3dx">ピクミン3DX</span></A></li>
</ul>

<span glot-model="menu_link_other">◆その他</span><br>
<ul class="nav not-margin">
	<li><A href="https://www.pikminwiki.com/" target="_blank">
	<i class="infof fas fa-book-open"></i> <span glot-model="pikipedia">Pikipedia</span></A></li>
</ul>

</div>
<?php endif ?>

<!--/
<div id="twitter_timeline" class="pickup_child pickup_menu" style="display:block;">
<?php
// お楽しみコンテンツ
//	echo '<span class="nav_caption mini_caption4">アンケート</span> <br>'."\n";
//	echo '<ul class="nav not-margin"><li><A href="https://docs.google.com/forms/d/e/1FAIpQLScVj5L2_-XAL1Mjh9VuvZTFVCuKq7ZLKQz7xWozjY5foDuA9A/viewform" target="_blank">◆第14回期間限定ランキング <br>　開催可否決定アンケート</A></li></ul>';
//	echo '<ul class="nav not-margin"><li><A href="https://quiz-maker.site/quiz/play/kecu5020190211142710" target="_blank">◆ピクミンシリーズセンター試験</A></li></ul>';
//	echo '<span style="font-weight:normal;">';
//	echo '2019年初の期間限定ランキングを開催しようと思います！ おまけつきのアンケートにご協力下さい。（８人以上で開催） <br>（2019/02/24～2019/03/02）</span>';
?>
</div>
/-->
<?php if($latest_record !== "2"): ?>
<div id="new_record" class="pickup_child pickup_menu" style="display:block;">
<?php
// 最新記録
	// もっとも最近の記録を抽出
	$sql = "SELECT * FROM `ranking` WHERE `log` = 0 ORDER BY `post_date` DESC LIMIT 1";
	$result = mysqli_query($mysqlconn, $sql);
	if (!$result) {
		echo " <br>Error ".__LINE__."：クエリの取得エラーが発生しています。";
	}
	while ($row = mysqli_fetch_assoc($result) ){

	// 接尾辞 (ステージ番号311～316の場合は表示しない)
	if(isset($get_stage_id)){
		if( ($get_stage_id > 310 AND $get_stage_id < 317) OR ($get_stage_id > 2310 AND $get_stage_id < 2317) or $stage_id == 356 or $stage_id == 359 or $stage_id == 361 or $stage_id == 2356 or $stage_id == 2359 or $stage_id == 2361) {
			$score_tale = "";
		} else {
			$score_tale = " pts.";
		}
	} else {
		$score_tale = "";
	}
	$rpstop_stage = $array_stage_title[ $row["stage_id"] ];
	echo '<span class="nav_caption"><span class="mini_caption4" style="cursor:pointer;" href="javascript:void(0)" onclick="menu_3toggle(\'new_record\',\'this_week_top\',\'trend_stage\');" glot-model="menu_newrec">最新記録</span></span> <span class="mini_caption4">('.date('m/d H:i',strtotime($row["post_date"])).')</span> <br>'."\n";
	echo '<ul class="nav not-margin"><li><A href="./'.$row["stage_id"].'"><span style="color:#8d8ae6;">◆</span>'.$rpstop_stage.'</A></li></ul>'.number_format($row["score"]).$score_tale.' ('.$row["post_rank"].'位) ['.$row["rps"].' pts.] <br><span class="marklink"><A href="./1" glot-model="menu_newrec_link">→新着一覧</A></span><span style="float:right;">Player: <A href="./'.$row["user_name"].'">'.$row["user_name"].'</A>　</span> <br>'."\n" ;
	}
	if (!$rpstop_stage){
		echo '<ul class="nav"><li><A href="#" glot-model="menu_newrec_notrec">◆有効な記録はまだありません。</A></li></ul>';
	}
?>
</div>
<?php endif ?>

<div id="this_week_top" class="pickup_child pickup_menu" style="display:none;">
<?php
// 今週のトップスコア
	$this_week_monday = strtotime("last Monday");
	$this_week_sunday = strtotime("last Monday +6day");
	echo '<span class="nav_caption"><span class="mini_caption4" style="cursor:pointer;" href="javascript:void(0)" onclick="menu_3toggle(\'new_record\',\'this_week_top\',\'trend_stage\');" glot-model="menu_topscore">今週のトップスコア</span></span> <span class="mini_caption4">('.date('m/d',$this_week_monday).'-'.date('m/d',$this_week_sunday).')</span> <br>'."\n";

	// 一週間以内のRPSトップスコアを抽出（日替わりチャレンジは除く）
	$last_week_date = date('Y-m-d', $this_week_monday);
	$sql = "SELECT * FROM `ranking` WHERE `post_date` >= '$last_week_date' AND NOT(`stage_id` BETWEEN 244 AND 274) AND `log` = 0 ORDER BY `rps` DESC LIMIT 1";
	$result = mysqli_query($mysqlconn, $sql);
	if (!$result) {
		die('<br>Error '.__LINE__.'：クエリの取得に失敗.'.mysql_error());
	}
	while ($row = mysqli_fetch_assoc($result) ){

	// 接尾辞 (ステージ番号311～316の場合は表示しない)
	if( ($get_stage_id > 310 AND $get_stage_id < 317) OR ($get_stage_id > 2310 AND $get_stage_id < 2317) OR $stage_id == 356 or $stage_id == 359 or $stage_id == 361 or $stage_id == 2356 or $stage_id == 2359 or $stage_id == 2361) {
		$score_tale = "";
	} else {
		$score_tale = " pts.";
	}

	$rpstop_stage = $array_stage_title[ $row["stage_id"] ];
	echo '<ul class="nav not-margin"><li><A href="./'.$row["stage_id"].'"><span style="color:#8d8ae6;">◆</span>'.$rpstop_stage.'</A></li></ul>'.number_format($row["score"]).$score_tale.' ('.$row["post_rank"].'<span glot-model="rank_tail">位</span>) ['.$row["rps"].' pts.] <br><span style="float:right;">Player: <A href="./'.$row["user_name"].'">'.$row["user_name"].'</A>　</span> <br>'."\n" ;
	}
	if (!$rpstop_stage){
		echo '<ul class="nav"><li><A href="#" glot-model="menu_topscore_notrec">◆今週の記録はまだありません。</A></li></ul>';
	}
?>
</div>
<div id="trend_stage" class="pickup_child pickup_menu" style="display:none;">
<?php
	// 直近の人気ステージ (10日以内の最多投稿)
	$ten_day_ago = strtotime("-10day", $now_time);
	echo '<span class="nav_caption"><span class="mini_caption4" style="cursor:pointer;" href="javascript:void(0)" onclick="menu_3toggle(\'new_record\',\'this_week_top\',\'trend_stage\');" glot-model="menu_poplar">最近の人気ステージ</span></span> <span class="mini_caption4">('.date('m/d',$ten_day_ago).'-'.date('m/d',$now_time).')</span> <br>'."\n";
	$sql = "SELECT `stage_id`,count(*) AS `stage_count` FROM `ranking` WHERE `post_date` > '$lastest_week_date' GROUP BY `stage_id` ORDER BY `stage_count` DESC LIMIT 1";
	$result = mysqli_query($mysqlconn, $sql);
	if($result){
		$row = mysqli_fetch_assoc($result);
			echo '<ul class="nav not-margin"><li><A href="./'.$row["stage_id"].'"><span style="color:#8d8ae6;">◆</span>'.$array_stage_title[$row["stage_id"]].' ('.$row["stage_count"].')</A></li></ul>';
	} else {
			echo '<ul class="nav"><li><A href="#" glot-model="menu_poplar_not">◆該当ステージが存在しません。</A></li></ul>';
	}
?>
</div>

<?php

// Twitterヘッドライン休止中
//<a href="javascript:void(0)" class="menu_toggle" onclick="menu_toggle('twitter_pik4_headline','no-twitter');">ヘッドライン表示ON/OFF</a> <br>
//<div id="no-twitter"> </div>
//<div id="twitter_pik4_headline" style="display:none;">
//<a class="twitter-timeline"  href="https://twitter.com/hashtag/%E3%83%94%E3%82%AF%E3%83%81%E3%83%A3%E3%83%AC%E5%A4%A7%E4%BC%9A" data-widget-id="837956994032021508">#ピクチャレ大会 のツイート</a>
//<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
//</div>
?>
<?php if($diary_challenge !== "2"): ?>
<div id="diary_challenge" class="pickup_menu">
<span class="nav_caption"><span class="mini_caption4" style="cursor:pointer;" href="javascript:void(0)" onclick="menu_toggle('diary_challenge','today_recommend');" glot-model="menu_daily">今日の日替わりチャレンジ</span></span> <span class="mini_caption4"><?php echo date('(m/d)', $now_time); ?></span> <br>
<ul class="nav not-margin">
<?php
	echo '<ul class="nav not-margin">';
	foreach($today_challenge as $val){
		echo '<li><A href="./'.$val.'"><span style="color:#8ae6e1;">◆</span>'.$array_stage_title[$val].'</A></li>'."\n";
	}
	echo '</ul>'."\n";
?>
</div>

<div id="today_recommend" style="display:none;" class="pickup_menu">
<span class="nav_caption"><span class="mini_caption4" style="cursor:pointer;" href="javascript:void(0)" onclick="menu_toggle('diary_challenge','today_recommend');" glot-model="menu_recommend">今日のオススメ！</span></span> <span class="mini_caption4"><?php echo date('(m/d)', $now_time); ?></A> <br>
<ul class="nav not-margin">
<?php
	// 今日のオススメを計算
	$get_recomend_seed = date('z');				// 1月1日を0とする一年の経過日
	$get_recomend_yaer = fmod( date('Y') , 5) * 24;
	$rcm = fmod( ($get_recomend_seed + $get_recomend_yaer) , 36);

	// オススメ選出ステージを配列関数に格納しておく
	$rcm_pik12 = array(201, 203, 214, 220, 204, 101, 210, 229, 227, 103, 202, 208, 207, 216, 104, 206, 213, 205, 219, 105, 218, 209, 228, 211, 102, 217, 223, 226, 224, 225, 212, 222, 215, 221, 230, 104);
	$rcm_pik3  = array(301, 308, 327, 307, 321, 311, 323, 304, 325, 313, 329, 335, 319, 322, 312, 331, 306, 302, 309, 314, 303, 324, 330, 310, 315, 328, 332, 317, 334, 305, 336, 318, 333, 320, 316, 326);

	$today_rcm1= $array_stage_title[ $rcm_pik12[ $rcm] ];
	$today_rcm2= $array_stage_title[ $rcm_pik3 [ $rcm] ];
	echo '<ul class="nav not-margin">';
	echo '<li><A href="./'.$rcm_pik12[$rcm].'"><span style="color:#e6be8a;">◆</span>'.$today_rcm1.'</A></li>'."\n";
	echo '<li><A href="./'.$rcm_pik3 [$rcm].'"><span style="color:#e6be8a;">◆</span>'.$today_rcm2.'</A></li>'."\n";
	echo '</ul>'."\n";

?>
</div>
<?php endif ?>

<?php
// ★リトライカウンター跡地（retry_counter.txt）
?>
<?php
// タマゴムシくじ本体
if($url_stage_id == 205 and isset($_COOKIE["user_name"])){
	echo '<div id="egg_fortune_frame" style="" class="pickup_menu">';
	echo '<span style="color:#51e0ff;" class="nav_caption" glot-model="menu_eggfortune">タマゴムシくじ</span> <br>';
	echo '<div id="egg_fortune"><span style="cursor:pointer;" href="javascript:void(0)" id="egg_fortune_start" onclick="egg_fortune_ope()" glot-model="menu_eggfortune_run">タマゴを割る</span></span></div>';
	echo '</div>';
}
?>

<?php if($total_ranking !== "2"): ?>
<div style="background-color:#555555;" class="pickup_menu">
<A href="./9"  ><span class="nav_caption mini_caption4" glot-model="array_stage_title9"><?= $array_stage_title[9] ?></span></A> <br>
<div style="text-align:right;"><span class="marklink"><A href="./7"><?= $array_stage_title_fixed[7] ?></A></span> <span class="marklink"><A href="./8"><?= $array_stage_title_fixed[8] ?></A></span> <span class="marklink"><A href="./27"><?= $array_stage_title_fixed[27] ?></A></span></div>
<ul class="nav not-margin">
<?php
	// 参加者総合ランキング簡易表示板

	// テーブルを取得
	$sql = "SELECT * FROM `user` ORDER BY `total_rps` DESC LIMIT 5";
	$result = mysqli_query($mysqlconn, $sql);
	if (!$result) {
		die('<br>Error '.__LINE__.'：クエリの取得に失敗.'.mysql_error());
	}
	$rows_count = mysqli_num_rows($result);
	$p = -1;
	$i =  0;
	while ($row = mysqli_fetch_assoc($result) ){
	$user_rps = $row["total_rps"];
	$prev_user_rps[$i] = $user_rps;
		if($p < 0){
			$prev_user_rps_check = 9999999;
		} else {
			$prev_user_rps_check = $prev_user_rps[$p];
		}
		if ( $prev_user_rps_check !== $user_rps ){
			$i++ ;
			$p++ ;
		}

	// ランキングを表示
	echo '<li><A href="./'.$row["user_name"].'"><span style="color:#ffffff;">◆</span>'.$i.' <span glot-model="rank_tail">位</span>：'.$row["user_name"].' ('.number_format($row["total_rps"]).'pts.)</A></li>'."\n";
	}

	// 6位以下をプルダウンで表示
	$sql = "SELECT * FROM `user` WHERE `total_rps` > 0 ORDER BY `total_rps` DESC LIMIT 99999 OFFSET 5";
	$result = mysqli_query($mysqlconn, $sql);
	if (!$result) {
		die('<br>Error '.__LINE__.'：クエリの取得に失敗.'.mysql_error());
	}
	$rows_count = mysqli_num_rows($result);
	$i = 1;
	echo '</ul>'."\n";
	echo '<select type="text" name="select_user" style="font-size:1em;border:0;margin-top:0.5em;width:210px;padding:5px;" onChange="location.href=value;">'."\n";
	echo '<option value="#" glot-model="menu_total_6th">▼6位以下</option>'."\n";
	$p =  4;
	$i =  5;
	while ($row = mysqli_fetch_assoc($result) ){
	$user_rps = $row["total_rps"];
	$prev_user_rps[$i] = $user_rps;
		if ( $prev_user_rps[$p] !== $user_rps ){
			$i++ ;
			$p++ ;
		}

	// ランキングを表示
	echo '<option value="./'.$row["user_name"].'">'.$i.' <span glot-model="rank_tail">位</span>：'.$row["user_name"].' ('.number_format($row["total_rps"]).'pts.)</option>'."\n";
	}
	echo '</select> <br>'."\n";
?>
</div>
<?php endif ?>
<hr size="1"/>
<ul class="nav">
	<li><A href="./7" ><span style="color:<?=$array_theme_color[7]?>;">☆</span><?= $array_stage_title_fixed[7] ?></a></li>
	<li><A href="./1" ><span style="color:#ffffff;">★</span><?= $array_stage_title[1] ?></a></li>
	<li><A href="./9 "><span style="color:<?=$array_theme_color[9]?>;">★</span><?= $array_stage_title_fixed[9] ?></a></li>
	<li><A href="./10"><span style="color:<?=$array_theme_color[10]?>;">◆</span><?= $array_stage_title_fixed[10] ?></a></li>
	<li><A href="./20"><span style="color:<?=$array_theme_color[20]?>;">◆</span><?= $array_stage_title_fixed[20] ?></a></li>
	<div class="fnavp">
	<li class="fnavl"><A href="./21">　<span style="color:<?=$array_theme_color[21]?>;">◆</span><?= $array_stage_title_fixed[21] ?></a></li>
	<li class="fnavr"><A href="./22"><span style="color:<?=$array_theme_color[22]?>;">◆</span><?= $array_stage_title_fixed[22] ?></a></li>
	</div>
	<div class="fnavp">
	<li class="fnavl"><A href="./23">　<span style="color:<?=$array_theme_color[23]?>;">◆</span><?= $array_stage_title_fixed[23] ?></a></li>
	<li class="fnavr"><A href="./26"><span style="color:<?=$array_theme_color[26]?>;">◆</span><?= $array_stage_title_fixed[26] ?></a></li>
	</div>
	<div class="fnavp">
	<li class="fnavl"><A href="./24">　<span style="color:<?=$array_theme_color[24]?>;">◆</span><?= $array_stage_title_fixed[24] ?></a></li>
	<li class="fnavr"><A href="./25"><span style="color:<?=$array_theme_color[25]?>;">◆</span><?= $array_stage_title_fixed[25] ?></a></li>
	</div>
	<div class="fnavp">
	<li class="fnavl"><A href="./81">　<span style="color:<?=$array_theme_color[81]?>;">◆</span><?= $array_stage_title_fixed[81] ?></a></li>
	<li class="fnavr"><A href="./82"><span style="color:<?=$array_theme_color[82]?>;">◆</span><?= $array_stage_title_fixed[82] ?></a></li>
	</div>
	<li><A href="./28">　<span style="color:<?=$array_theme_color[28]?>;">◆</span><?= $array_stage_title_fixed[28] ?></a></li>
	<li><A href="./30"><span style="color:<?=$array_theme_color[30]?>;">◆</span><?= $array_stage_title_fixed[30] ?></a></li>
	<div class="fnavp">
	<li class="fnavl"><A href="./31"><span style="color:<?=$array_theme_color[31]?>;">◆</span><?= $array_stage_title_fixed[31] ?></a></li>
	<li class="fnavr"><A href="./32"><span style="color:<?=$array_theme_color[32]?>;">◆</span><?= $array_stage_title_fixed[32] ?></a></li>
	</div>
	<div class="fnavp">
	<li class="fnavl"><A href="./33"><span style="color:<?=$array_theme_color[33]?>;">◆</span><?= $array_stage_title_fixed[33] ?></a></li>
	<li class="fnavr"><A href="./34"><span style="color:<?=$array_theme_color[34]?>;">◆</span><?= $array_stage_title_fixed[34] ?></a></li>
	</div>
	<div class="fnavp">
	<li class="fnavl"><A href="./35"><span style="color:<?=$array_theme_color[35]?>;">◆</span><?= $array_stage_title_fixed[35] ?></a></li>
	<li class="fnavr"><A href="./36"><span style="color:<?=$array_theme_color[36]?>;">◆</span><?= $array_stage_title_fixed[36] ?></a></li>
	</div>
	<li><A href="./8" ><span style="color:<?=$array_theme_color[8]?>;">★</span><?= $array_stage_title_fixed[8] ?></a></li>
	<div class="fnavp">
	<li class="fnavl"><A href="./91" >　<span style="color:<?=$array_theme_color[91]?>;">◆</span><?= $array_stage_title_fixed[91] ?></a></li>
	<li class="fnavr"><A href="./92" ><span style="color:<?=$array_theme_color[92]?>;">◆</span><?= $array_stage_title_fixed[92] ?></a></li>
	</div>
	<div class="fnavp">
	<li class="fnavl"><A href="./93" >　<span style="color:<?=$array_theme_color[93]?>;">◆</span><?= $array_stage_title_fixed[93] ?></a></li>
	<li class="fnavr"><A href="./94" ><span style="color:<?=$array_theme_color[94]?>;">◆</span><?= $array_stage_title_fixed[94] ?></a></li>
	</div>
	<li><A href="./95">　<span style="color:<?=$array_theme_color[95]?>;">◆</span><?= $array_stage_title_fixed[95] ?></a></li>
</ul>

<?php
// ステージ選択メニュー
	$sql = "SELECT `stage_id` FROM `ranking` WHERE `log` = 0";
	$result = mysqli_query($mysqlconn, $sql);
	$st_count = array();
	while($row = mysqli_fetch_assoc($result) ){
		$st_count[] = $row["stage_id"];
	}
	$sql = "SELECT `stage_id` FROM `battle` WHERE `log` = 0";
	$result = mysqli_query($mysqlconn, $sql);
	while($row = mysqli_fetch_assoc($result) ){
		$st_count[] = $row["stage_id"];
	}
	$loadtime_echo[] = " <br>".__LINE__. "行目：{$time_c} 秒";
	$st_count_val = array_count_values($st_count);
	echo '<div id="stage_list_noff" style="display:none;background-color:transparent;" class="pickup_menu">
	<div style="width:100%;background-color:#dddddd;"><span style="display:block;color:#111111;cursor:pointer;" href="javascript:void(0)" onclick="menu_toggle(\'stage_list_noff\',\'stage_list_normal\');" glot-model="menu_toggle_open">▼再表示</span></span></div> <br>';
	echo '</div>';

	echo '<div id="stage_list_normal" style="background-color:transparent;" class="pickup_menu">
	<div style="width:100%;background-color:#dddddd;"><span style="display:block;color:#111111;cursor:pointer;" href="javascript:void(0)" onclick="menu_toggle(\'stage_list_noff\',\'stage_list_normal\');" glot-model="menu_toggle_normal">◆通常ステージ</span></div> <br>';

	nav_stagelist_echo($array_stage_title_fixed[10], range(101, 105), "#e6e58a", 0, 0);
	echo '<span class="nav_caption">'.$array_stage_title_fixed[20].'</span> <br>'."\n";
	nav_stagelist_echo($array_stage_title_fixed[21], array(201, 202, 205, 206, 207, 212, 217, 218, 220, 226, 228, 229, 230), "#e68a8b", 0, 1);
	nav_stagelist_echo($array_stage_title_fixed[22], array(203, 204, 208, 209, 210, 211, 213, 214, 215, 216, 219, 221, 222, 223, 224, 225, 227), "#e68ab8", 0, 1);
	echo '<span class="nav_caption">'.$array_stage_title_fixed[30].'</span> <br>'."\n";
	nav_stagelist_echo($array_stage_title_fixed[31], array(301, 302, 303, 304, 305, 317, 318, 319, 320, 321, 327, 328, 329, 330, 331), "#90e68a", 0, 1);
	nav_stagelist_echo($array_stage_title_fixed[32], array(306, 307, 308, 309, 310, 322, 323, 324, 325, 326, 332, 333, 334, 335, 336), "#8ae6cb", 0, 1);
	nav_stagelist_echo($array_stage_title_fixed[33], range(311, 316), "#c9e68a", 0, 1);
	nav_stagelist_echo($array_stage_title_fixed[36], range(349, 362), "#c9e68a", 0, 1);

	echo '</div>';

	echo '<div id="stage_list_off" style="background-color:transparent;" class="pickup_menu">
	<div style="width:100%;background-color:#dddddd;"><span style="display:block;color:#111111;cursor:pointer;" href="javascript:void(0)" onclick="menu_toggle(\'stage_list_off\',\'stage_list_special\');" glot-model="menu_info_more">▼さらに表示</span></div> <br>';
	echo '</div>';

	echo '<div id="stage_list_special" style="display:none;background-color:transparent;" class="pickup_menu">
	<div style="width:100%;background-color:#dddddd;"><span style="display:block;color:#111111;cursor:pointer;" href="javascript:void(0)" onclick="menu_toggle(\'stage_list_off\',\'stage_list_special\');" glot-model="menu_toggle_special">◆特殊ステージ</span></div> <br>';
	nav_stagelist_echo($array_stage_title_fixed[93], array(10101, 10201, 10202, 10203, 10204, 10301, 10302), "#c58ae6", 1, 0);
	nav_stagelist_echo($array_stage_title_fixed[94], range(10205, 10214), "#e68ae5", 1, 0);
	nav_stagelist_echo($array_stage_title_fixed[23], range(231, 244), "#e68ad3", 0, 0);
	nav_stagelist_echo($array_stage_title_fixed[26], range(285, 297), "#da5cab", 0, 0);
	nav_stagelist_echo($array_stage_title_fixed[28], range(5001, 5013), "#da5c7b", 0, 0);
//	nav_stagelist_echo("日替わりチャレンジ", range(245, 274), "#f498d3", 0, 0);
	echo '<span class="nav_caption">'.$array_stage_title_fixed[20].'/2P</span> <br>'."\n";
	nav_stagelist_echo("2P/".$array_stage_title_fixed[21], array(2201, 2202, 2205, 2206, 2207, 2212, 2217, 2218, 2220, 2226, 2228, 2229, 2230), "#e68a8b", 0, 1);
	nav_stagelist_echo("2P/".$array_stage_title_fixed[22], array(2203, 2204, 2208, 2209, 2210, 2211, 2213, 2214, 2215, 2216, 2219, 2221, 2222, 2223, 2224, 2225, 2227), "#e68a8b", 0, 1);
	echo '<span class="nav_caption">'.$array_stage_title_fixed[30].'/2P</span> <br>'."\n";
	nav_stagelist_echo("2P/".$array_stage_title_fixed[31], array(2301, 2302, 2303, 2304, 2305, 2317, 2318, 2319, 2320, 2321, 2327, 2328, 2329, 2330, 2331), "#90e68a", 0, 1);
	nav_stagelist_echo("2P/".$array_stage_title_fixed[32], array(2306, 2307, 2308, 2309, 2310, 2322, 2323, 2324, 2325, 2326, 2332, 2333, 2334, 2335, 2336), "#8ae6cb", 0, 1);
	nav_stagelist_echo("2P/".$array_stage_title_fixed[33], range(2311, 2316), "#c9e68a", 0, 1);
	nav_stagelist_echo($array_stage_title_fixed[91], $limited_stage_list, "#8aa3e6", 0, 0);
//	nav_stagelist_echo("ステージ別", range(1003, $limited_final_stage), "#8aa3e6", 0, 1);
	echo '<span class="nav_caption">'.$array_stage_title_fixed[95].'</span> <br>'."\n";
	nav_stagelist_echo($array_stage_title_fixed[25], range(275, 284), "#90e68a", 0, 1);
	nav_stagelist_echo($array_stage_title_fixed[35], range(337, 348), "#90e68a", 0, 1);
	echo '</div>';

	$mysqlconn = mysqli_close($mysqlconn);

?>

<span class="nav_caption" glot-model="menu_siteinfo">サイト情報</span> <br>
<span style="line-height:90%;">
Since: 2007/04/29 <br>
（<span glot-model="menu_siteinfo_moving">移転日</span>：2015/09/01) <br>
<span glot-model="menu_siteinfo_admin">管理人:木っ端ちゃっぴー</span><br>
Twitter: <A href="https://twitter.com/koppachappy" rel="nofollow">@koppachappy</A> <br>
<span glot-model="menu_siteinfo_blog">ブログ</span>: <A href="https://chr.mn/glyph" rel="nofollow">Chrononglyph</A> <br>
<span style="color:#777777;" glot-model="menu_siteinfo_caution">◆このサイトは非公式であり、任天堂及びその他権利者とは一切関係ありません。
お問い合わせ、要望など管理人への連絡は本家ブログの連絡フォームまでお願いします。
<A href="https://chr.mn/glyph/%e9%80%a3%e7%b5%a1%e3%83%95%e3%82%a9%e3%83%bc%e3%83%a0" rel="nofollow" glot-model="menu_siteinfo_contact">→連絡フォーム</A></span>
<hr>
Background-Image License <br>
<a href="http://bg-patterns.com/?p=1319">Bg-Patterns</a>
</div>
</div>
