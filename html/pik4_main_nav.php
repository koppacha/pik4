<?php
if($page_type != 0 and $page_type != 1 and $page_type != 9 and $page_type != 15){
// 総合ナビゲーションテーブルのロック機構
if(isset($_COOKIE["navlock"])){
	$lock_icon_def= ($_COOKIE["navlock"] == 1)? '<i class=" fa fa-lock" ></i><span glot-model="main_navlock_on">ナビゲーションロック中</span></a>' : '<i class=" fa fa-unlock" ></i><span glot-model="main_navlock_off">ナビゲーションロック解除中</span></a>';
} else {
	$lock_icon_def= '<i class=" fa fa-unlock" ></i><span glot-model="main_navlock_off">ナビゲーションロック解除中</span></a>';
}
echo '<div id="navlock_div" style="float:right;font-size:0.8em;width:20%;text-align:right;" class="mobile-hidden"><a class="marklink" href="javascript:void(0)" style="color:#ffffff;line-height:24px;" onclick="navlock();">';
echo $lock_icon_def.'</div>';

// 総合ナビゲーションテーブル
	echo '<div class="scroll-wrap" style="clear:both;"><table class="series_nav" style="margin-top:1em;"><tr>';
		$series_nav_output = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 20, 21, 22, 30, 31, 32, 33, 36, 91, 26, 28, 92, 93, 96, 94, 24, 34);
		$i = 1;
		if($stage_id < 101) $stage_hook = $stage_id;
		foreach($series_nav_output as $val){
			$style = '';
			if($val > 2) $style = ' style="border-bottom:solid 2px '.$array_theme_color[$val].';"';
			if($val==10) $style = ' style="border-bottom:solid 2px '.$array_theme_color[8].';"';
			if($val== 3) $style = ' style="border-bottom:solid 2px '.$array_theme_color[9].';"';
			$color = "";
			if($stage_hook == $val) $style = ' style="color:#111111;border-bottom:solid 1px '.$array_theme_color[$val].';background-color:'.$array_theme_color[$val].'"';
			if($stage_hook == $val) $color = ' style="color:#111111;"';
			// 呼び出し番号とステージIDが噛み合わない例外の対応
			if($page_type == 4 and $val == 91) $style = ' style="background-color:'.$array_theme_color[$val].'"';
			if($page_type == 4 and $val == 91) $color = ' style="color:#111111;"';
			if(($stage_hook == 9 and $val == 3) or  ($stage_hook == 10 and $val == 4)) $style = ' style="background-color:'.$array_theme_color[$stage_hook].'"';
			if(($stage_hook == 9 and $val == 3) or  ($stage_hook == 10 and $val == 4)) $color = ' style="color:#111111;"';
			if($stage_hook == 8 and $val == 10)  $style = ' style="border-bottom:solid 1px '.$array_theme_color[$stage_hook].';background-color:'.$array_theme_color[$stage_hook].'"';
			if($stage_hook == 8 and $val == 10)  $color = ' style="color:#111111;"';
			if($stage_hook ==10 and $val == 10)  $style = ' style="border-bottom:solid 1px '.$array_theme_color[8].';"';
			if($stage_hook ==10 and $val == 10)  $color = '';
			if($val == 20){
			echo '<td class="navmenu" id="nv'.$val.'"'.$style.'><A'.$color.' href="./'.$val.'"><span glot-model="main_nav_pik2">ピクミン2総合</span></A></td>';
		} elseif($val == 30){
			echo '<td class="navmenu" id="nv'.$val.'"'.$style.'><A'.$color.' href="./'.$val.'"><span glot-model="main_nav_pik3">ピクミン3総合</span></A></td>';
		} elseif($i   >  10){
			echo '<td class="navmenu" id="nv'.$val.'"'.$style.'><A'.$color.' href="./'.$val.'">'.$array_stage_title_fixed[$val].'</A></td>';
		} else {
		if($val == 1) echo '<td'.$style.' colspan="10"><b><A'.$color.' href="./9"><span glot-model="main_nav_normal">通常ランキング</span></A></b></td>';
		if($val == 2) echo '<td'.$style.' colspan="10"><b><A'.$color.' href="./8"><span glot-model="main_nav_special">特殊ランキング</span></A></b></td></tr>';
		if($val == 3) echo '<tr><td class="navmenu" id="nv9"'.$style.' rowspan="2"><b><A'.$color.' href="./9">'.$array_stage_title_fixed[9].'</A></b></td>';
		if($val == 4) echo '<td class="navmenu" id="nv10"'.$style.' rowspan="2"><b><A'.$color.' href="./10">'.$array_stage_title_fixed[10].'</A></b></td>';
		if($val == 5) echo '<td colspan="3"><b><A href="./20">'.$array_stage_title_fixed[20].'</A></b></td>';
		if($val == 6) echo '<td colspan="5"><b><A href="./30"><span glot-model="main_nav_pik3anddx">ピクミン3/デラックス</span></A></b></td>';
		if($val == 7) echo '<td colspan="4"><b><span glot-model="main_nav_anomaly">変則ルール</span></b></td>';
		if($val == 8) echo '<td colspan="3"><b><A href="./23"><span glot-model="main_nav_storyandrta">本編/RTA</span></A></b></td>';
		if($val == 9) echo '<td colspan="2"><b><A href="./6"><span glot-model="main_nav_2p">2Pプレイ</span></b></td>';
		if($val ==10) echo '<td class="navmenu" id="nv8"'.$style.' rowspan="2"><b><A'.$color.' href="./8">'.$array_stage_title_fixed[8].'</A></b></td></tr><tr>';
		}
		$i++;
		}
		// ユーザーページの総合順位表示
		if($page_type == 5){
			echo '<tr>';
			foreach($array_select_rank as $val){
				if($val != ""){
					if($users[$user_name][$val] > 0){
						if ( $array_rank[$val] == 1) $rtd_tr = "rtd_1st_m";
						if ( $array_rank[$val] == 2) $rtd_tr = "rtd_2nd_m";
						if ( $array_rank[$val] == 3) $rtd_tr = "rtd_3rd_m";
						if ( $array_rank[$val] >  3 and $array_rank[$val] < 11) $rtd_tr = "rtd_10th_m";
						if ( $array_rank[$val] > 10 and $array_rank[$val] < 21) $rtd_tr = "rtd_11th_m";
						if ( $array_rank[$val] > 20) $rtd_tr = "rtd_21th_m";
						echo '<td class="'.$rtd_tr.'">'.$array_rank[$val].' <span class="score_tale"><span glot-model="rank_tail">位</span>/'.$array_pcount[$val].'</span> <br>'.number_format($users[$user_name][$val]).'</td>';
					} else {
						echo '<td>-</td>';
					}
				} else {
					echo '<td>-</td>';
				}
			}
		echo '</tr>';
		}
		echo "</table></div>";
}
// その他
$display = 'style="display:none;"';
echo '<div class="scroll-wrap"><table class="topscore series_nav top-score8" '.$display.'>';
echo '</div>';

// Stage_hookを収斂する
$pikcup_hook = array(171231, 180429);
$userplan_hook = array(190209, 190321, 210829);
$legacylim_hook = array(151101, 160306, 160319, 160423, 160430, 160806);

// 期間限定ランキングの開催一覧ナビゲーション
	if($stage_id == 91 or $stage_hook == 91 or $stage_cat == 91) $display = '';
	echo '<div class="scroll-wrap"><table class="topscore series_nav top-score91" '.$display.'>';
	$background_color = 'background-color:#333;';
	$color = 'color:#fff;';

	// ピク杯
	if(array_search($stage_id, $pikcup_hook) !== false or array_search($stage_hook, $pikcup_hook) !== false){
		$background_color = 'background-color:#b6db5c;';
		$color = '#111;';
	}
	echo '<td style="'.$background_color.';color:'.$color.';font-weight:bold;width:4em;border-bottom:2px solid #b6db5c;" class="navmenulim" id="nvpikcup" glot-model="main_nav_pikcup">ピク杯</td>';

	// 参加者企画
	$background_color = 'background-color:#333;';
	$color = 'color:#fff;';
	if(array_search($stage_id, $userplan_hook) !== false or array_search($stage_hook, $userplan_hook) !== false){
		$background_color = 'background-color:#8a5cdb;';
		$color = '#111;';
	}
	echo '<td style="'.$background_color.';color:'.$color.';font-weight:bold;width:4em;border-bottom:2px solid #8a5cdb;" class="navmenulim" id="nvuserplan" glot-model="main_nav_userplan">参加者企画</td>';

	// 第1～6回期間限定ランキング
	$background_color = 'background-color:#333;';
	$color = 'color:#fff;';
	if(array_search($stage_id, $legacylim_hook) !== false or array_search($stage_hook, $legacylim_hook) !== false){
		$background_color = 'background-color:#8a5cdb;';
		$color = '#111;';
	}
	echo '<td style="'.$background_color.$color.'font-weight:bold;width:12em;border-bottom:2px solid #5c8bdb;" class="navmenulim" id="nvpersonal"><span glot-model="menu_limited_dai">第</span>1～6<span glot-model="menu_limited_kai">回</span><br><span glot-model="main_nav_individual">個人戦</span></td>';
	$i = 1;

	// 第7回期間限定ランキング以降のナビゲーション
	$limited_stage_list_last = array_slice($limited_stage_list, 6, null, true);
	foreach($limited_stage_list_last as $key => $val){
		$style = ' style="background-color:#333;color:#eee;border-bottom:solid 2px '.$array_theme_color[$val].';"';
		$color = ' style="color:#eee;"';
		if($val == $stage_id or $val == $stage_hook) $style = ' style="color:#111;background-color:'.$array_theme_color[$val].';border-bottom:solid 2px '.$array_theme_color[$val].';"';
		if($val == $stage_id or $val == $stage_hook) $color = ' style="color:#111;"';

		if($key <= $end_of_limited){
			echo '<td'.$style.' class="navmenulim" id="nv'.$val.'"><A'.$color.' href="./'.$val.'"><span glot-model="menu_limited_dai">第</span>'.$key.'<span glot-model="menu_limited_kai">回</span> <br>'.$limited_stage_sub_fixed[$key-1].'</A></td>';
		}
	}
	echo '</tr></table></div>';

// 期間限定ランキング・ピク杯詳細表示
$i = 0;
$stage_list = implode(" ,", range(1001, $limited_last));
$user_sql = "SELECT * FROM `ranking` WHERE `stage_id` IN($stage_list) AND `log` = 0 AND `post_rank` = 1 ORDER BY `stage_id` ASC, `post_date` DESC";
$user_result = mysqli_query($mysqlconn, $user_sql);
$topscore = array();
$topuser = array();
$topuser2 = array();
while($user_row = mysqli_fetch_assoc($user_result) ){
	$top_score_stage = $user_row["stage_id"];
	$topscore[$top_score_stage] = $user_row["score"];
	$topuser[$top_score_stage] = $user_row["user_name"];
	$topuser2[$top_score_stage] = $user_row["user_name_2p"];
}
$display = ($stage_id == 171231 or $stage_id == 180429) ? '' : 'display:none;' ;
echo '<div class="scroll-wrap liminfo limpikcup" style="'.$display.'background-color:#222;color:#ccc;"><span style="color:#fff;font-size:1.2em;" glot-model="main_nav_pikcup">ピク杯</span>（<span glot-model="main_head_offlineevent">ピクチャレ大会オフラインイベント</span>）'."\n";
echo '<table class="series_nav"><tr>'."\n";
$color = ($stage_id == 171231) ? '#df73af' : '#aaa' ;
echo '<td style="background-color:'.$color.';"><A style="color:#111111;" href="./171231" title="第1回ピク杯"><span glot-model="menu_limited_dai">第</span>1<span glot-model="menu_limited_kai">回</span></A></td>'."\n";
$color = ($stage_id == 180429) ? '#df73af' : '#aaa' ;
echo '<td style="background-color:'.$color.';"><A style="color:#111111;" href="./180429" title="第2回ピク杯"><span glot-model="menu_limited_dai">第</span>2<span glot-model="menu_limited_kai">回</span></A></td>'."\n";
echo '</tr><tr>'."\n";
echo '<td><span glot-model="japan_tokyo">東京</span>・<span glot-model="japan_tokyo_ueno">上野</span>（2017/12/31）</td>'."\n";
echo '<td><span glot-model="japan_tokyo">東京</span>・<span glot-model="japan_tokyo_ikebukuro">池袋</span>（2018/04/29）</td>'."\n";
echo '</tr>'."\n";
echo '</table>'."\n";
echo '</div>'."\n";

$display = ($stage_id == 190209 or $stage_hook == 190209 or $stage_id == 190321 or $stage_hook == 190321 or $stage_id == 210829 or $stage_hook == 210829) ? '' : 'display:none;' ;
echo '<div class="scroll-wrap liminfo lim190209 lim190321 lim210829 limuserplan" style="'.$display.'background-color:#222;color:#ccc;">'."\n";
echo '<table class="series_nav"><tr>'."\n";

$color = ($stage_id == 190209 or $stage_hook == 190209) ? '#a773df' : '#aaa' ;
echo '<td class="subnavmenulim" id="nv190209" style="font-weight:bold;font-size:1.1em;background-color:'.$color.';"><A style="color:#111111;" href="./190209" title="ピクミン2全ステージ各一本勝負"><span glot-model="main_nav_userplan1">ピクミン2全ステージ各一本勝負</span>（2019/02/09）</A></td>'."\n";
$color = ($stage_id == 190321 or $stage_hook == 190321) ? '#a773df' : '#aaa' ;
echo '<td class="subnavmenulim" id="nv190321" style="font-weight:bold;font-size:1.1em;background-color:'.$color.';"><A style="color:#111111;" href="./190321" title="ピクミン2全ステージ各一本勝負"><span glot-model="main_nav_userplan2">ピクミン2全ステージ各一本勝負</span>（2019/03/21）</A></td>'."\n";
$color = ($stage_id == 210829 or $stage_hook == 210829) ? '#a773df' : '#aaa' ;
echo '<td class="subnavmenulim" id="nv210829" style="font-weight:bold;font-size:1.1em;background-color:'.$color.';"><A style="color:#111111;" href="./210829" title="ピクミン2タマゴムシ取り大会"><span glot-model="main_nav_userplan3">ピクミン2タマゴムシ取り大会</span>（2021/08/29）</A></td>'."\n";
echo '</tr></table>'."\n";
echo '</div>'."\n";

// 第1～6回期間限定ランキングのナビゲーション
$display = ($stage_id == 151101 or $stage_id == 160306 or $stage_id == 160319 or $stage_id == 160423 or $stage_id == 160430 or $stage_id == 160806 or $stage_hook == 151101 or $stage_hook == 160306 or $stage_hook == 160319 or $stage_hook == 160423 or $stage_hook == 160430 or $stage_hook == 160806) ? '' : 'display:none;' ;
echo '<div class="scroll-wrap topscore subscore limpersonal" style="'.$display.'background-color:#222;color:#ccc;">'."\n";
echo '<table class="series_nav"><tr>'."\n";
$limited_stage_list_personal = array_slice($limited_stage_list, 0, 6, true);
foreach($limited_stage_list_personal as $key => $val){
	$style = ' style="background-color:#333;font-weight:bold;color:#eee;border-bottom:solid 2px '.$array_theme_color[$val].';"';
	$color = ' style="color:#eee;"';
	if($val == $stage_id or $val == $stage_hook) $style = ' style="color:#111;background-color:'.$array_theme_color[$val].';border-bottom:solid 2px '.$array_theme_color[$val].';"';
	if($val == $stage_id or $val == $stage_hook) $color = ' style="color:#111;"';

	if($key == 1){
		echo '<td'.$style.' class="subnavmenulim" id="nv151101"><span glot-model="menu_limited_dai">第</span>'.$key.'<span glot-model="menu_limited_kai">回</span> <br>'.$limited_stage_sub_fixed[$i].'</td>';
	} else {
		echo '<td'.$style.' class="subnavmenulim" id="nv'.$val.'"><A'.$color.' href="./'.$val.'"><span glot-model="menu_limited_dai">第</span>'.$key.'<span glot-model="menu_limited_kai">回</span> <br>'.$limited_stage_sub_fixed[$key-1].'</A></td>';
	}
}
echo '</tr></table>'."\n";
echo '</div>'."\n";

$display = ($stage_id == 190209 or $stage_hook == 190209) ? '' : 'display:none;' ;
echo '<div class="scroll-wrap liminfo lim190209" style="'.$display.'background-color:#222;color:#ccc;">';
	topscore_board_tab2(range(4001, 4030), 190209);
echo '</div>'."\n";

$display = ($stage_id == 190321 or $stage_hook == 190321) ? '' : 'display:none;' ;
echo '<div class="scroll-wrap liminfo lim190321" style="'.$display.'background-color:#222;color:#ccc;">';
	topscore_board_tab2(range(4031, 4060), 190321);
echo '</div>'."\n";

$display = ($stage_id == 210829 or $stage_hook == 210829) ? '' : 'display:none;' ;
echo '<div class="scroll-wrap liminfo lim210829" style="'.$display.'background-color:#222;color:#ccc;">';
	topscore_board_tab2(range(4061, 4073), 210829);
echo '</div>'."\n";


foreach($limited_stage_list as $key => $val){
	$display = 'display:none;';
	if($stage_id == $val or $stage_hook == $val) $display = '';
	echo '<div class="scroll-wrap liminfo lim'.$val.'" style="'.$display.'background-color:#222;color:#ccc;">';
	echo '<A style="display:block;" href="./'.$val.'"><span style="color:#fff;font-size:1.2em;">'.$array_stage_title[$val].'</span>　(';
	echo $limited_stage_title_fixed[$i]."×".$limited_stage_sub_fixed[$i];
	echo ')　';
	echo date('Y/m/d', strtotime(${'limited_time'.$val}[0])).'～'.date('m/d', strtotime(${'limited_time'.$val}[1]));
	echo '　<span glot-model="main_nav_winner">優勝</span>：';
	if(isset($limited_stage_win_fixed[$i])){
		echo $limited_stage_win_fixed[$i];
	} else {
		echo "？";
	}
	if($limited_stage_mvp[$i] !== ''){
		echo '　MVP：'.$limited_stage_mvp[$i];
	} else {
		echo '　MVP：？';
	}
	if($limited_stage_idea[$i] !== ''){
		echo '<br><div style="text-align:right;"><span glot-model="main_nav_idea">アイデア賞</span>：'.$limited_stage_idea[$i].'</div>';
	}
echo '</A>';
if($limited_type[$val] == 'e'){
// エリア踏破戦のナビゲーション（大会終了後）

// エリア踏破戦のカテゴリ分類
if($key == 13) $area_cat = 'coop';
if($key == 14) $area_cat = 'standard';
if($key == 15) $area_cat = 'team'; // PHP版チーム対抗エリア表示
if($key == 16) $area_cat = 'team';
if($key == 17) $area_cat = 'team2'; // JS版チーム対抗エリア表示

// エリア踏破戦のナビゲーション
echo '<div class="scroll-wrap">';
if($area_cat == 'standard'){
	// 第14回期間限定ランキングの色分け切り替え
	if($watchmode == 2) echo '<span><A style="color:#aaaaaa;" href="javascript:void(0);" onclick="SeasonToggle(\'watchmode\');"><i class="fa fa-toggle-on" aria-hidden="true"></i><span glot-model="main_nav_colorcoded1">自陣と敵陣を色分け</span></A> <br></span>';
	if($watchmode != 2) echo '<span><A style="color:#05ffe3;" href="javascript:void(0);" onclick="SeasonToggle(\'watchmode\');"><i class="fa fa-toggle-off" aria-hidden="true"></i><span glot-model="main_nav_colorcoded2">ユーザー毎に色分け</span></A> <br></span>';
}
if($area_cat == 'team2'){
	// 第17回期間限定ランキングの自動/手動更新切り替え
	if($refleshmode == 2) echo '<span><A style="color:#05ffe3;" href="javascript:void(0);" onclick="SeasonToggle(\'refleshmode\');"><i class="fa fa-toggle-off" aria-hidden="true"></i>自動更新する</A> <br></span>';
	if($refleshmode != 2) echo '<span><A style="color:#aaaaaa;" href="javascript:void(0);" onclick="SeasonToggle(\'refleshmode\');"><i class="fa fa-toggle-on" aria-hidden="true"></i>ボタンで更新する</A> <br></span>';
	if($refleshmode == 0) echo '<a href="javascript:void(0);" onclick="getarea();">エリアを更新</A> | <a href="javascript:void(0);" onclick="getpoint(\'17\', \'17\', \'18\');">チームポイントを更新</A>';
}

if( strpos($area_cat, 'team') !== false and $key == $limited_num){ // 最新のみ表示する
	// エリア踏破戦チーム対抗制のチーム分けボタン
	echo '<div class="areainfo">';
	if($cookie_row['current_team'] >= 17){
		echo $cookie_name.' <span glot-model="main_nav_team_in">さんの所属チームは</span>'.$team[$cookie_row['current_team']].'<span glot-model="desu_tail">です。</span>';
	} elseif($cookie_row['current_team'] > -1){
		echo '<span id="teamoutput">'.$cookie_name.' <span glot-model="main_nav_team_notin">さんはまだチームに所属していません。</span>（'.$cookie_name.'<span glot-model="main_nav_team_rate">さんのレート</span>：'.$cookie_row['rate']."）<br>";
		echo '<A href="#" style="font-size:1.2em;color:#000000;text-decoration:underline;" onClick="teamselect(\''.$cookie_name.'\',\''.$cookie_row['rate'].'\',\''.$team_a.'\',\''.$team_b.'\');">'.$teame['a'][$limited_num].'<span glot-model="main_nav_team_join">参加する</span>'.$teame['b'][$limited_num].'</A><span glot-model="main_nav_team_join_caution">（参加予定のない方は押さないでください！）</span></span>';
	} else {
		echo '<span glot-model="main_nav_team_error">ログインしていません。期間限定ランキングは通常ランキングに１回でも参加してログインしていることが参加条件になります。</span>';
	}
	echo '</div>';
}
if($key == 17){
	// マイニング制の凡例を表示
	echo '<div class="areainfo"><table style="table-layout: fixed;width: 100%;"><tr>';
	echo '<td class="ore01"><span class="gem">1<i class="fas fa-gem"></i>鶏冠石 (15分につき2ポイント)</span></td>';
	echo '<td class="ore02"><span class="gem">2<i class="fas fa-gem"></i>孔雀石 (30分につき8ポイント)</span></td>';
	echo '<td class="ore03"><span class="gem">3<i class="fas fa-gem"></i>天藍石 (1時間につき24ポイント)</span></td>';
	echo '<td class="ore04"><span class="gem">4<i class="fas fa-gem"></i>電気石 (2時間につき64ポイント)</span></td>';
	echo '</tr></table></div>';
}
echo '<table class="area_table">';
$area_score_total = 0;
$area_1_cnt = 0;
$area_2_cnt = 0;
$area_3_cnt = 0;
$area_4_cnt = 0;
$area_5_cnt = 0;
// 自陣が存在するかどうかチェックする
$ae_area_before = $ae_area[$key - 1] + 1;
$ae_area_after  = $ae_area[$key];
$ae_query = "SELECT * FROM `area` WHERE `id` BETWEEN $ae_area_before AND $ae_area_after AND `user_name` = '$cookie_name'";
$ae_result = mysqli_query($mysqlconn, $ae_query);
$myarea_count = mysqli_num_rows($ae_result);

if($area_cat != "team2"){
	for($tr = 1; $tr <= $ae_height[$key]; $tr++){ // 縦の長さを定義
		echo '<tr>';
			for($td = 1; $td <= $ae_width[$key]; $td++){ // 横の長さを定義
				$addr = ($ae_height[$key] * $tr) - ($ae_width[$key] - $td) + $ae_area[$key-1];
				$area_nav_stage_title = str_replace("（",'<p style="text-align:right;">（', fixed_stage_title($area[$addr]["stage_id"]));
				$area_nav_stage_title = str_replace("）",'）</p>', $area_nav_stage_title);
				$break_lest = $area[$addr]["border_rank"] - $area[$addr]["break_count"];
				if($break_lest > 0){
					$break_str = '<i class="fa fa-users" aria-hidden="true"></i> <span glot-model="main_nav_team_last">あと</span>'.$break_lest.'<span glot-model="tail_nin">人</span>';
				} else {
					$break_str = '';
				}
				if(strpos($area_nav_stage_title, "（") === false){
					$area_nav_stage_title = $area_nav_stage_title." <br> <br>";
				}
				if($page_type == 19 and $stage_id == $area[$addr]["stage_id"]){
					$current_area = ' area_c';
				} elseif($page_type == 13){
					$current_area = ' area_c';
				} else {
					$current_area = ' area_n';
				}
				// 協力制のエリア表示
				if($area_cat == 'coop'){
					if($area[$addr]["flag"] == 1){
						// 未解禁のフリーエリア
						echo '<td style="text-align:center;" class="area_1'.$current_area.'">'."{$tr}-{$td}".'</td>';
						$area_1_cnt++;
					} elseif($area[$addr]["flag"] == 2){
						// プレイアブルフリーエリア（まだプレイしていない）
						echo '<td class="area_2'.$current_area.'"><A href="./'.$area[$addr]["stage_id"].'">'."{$tr}-{$td}".'◆'.$area_nav_stage_title.'<span glot-model="main_nav_team_undevelop">（未開地）</span> <br> <br><p>'.$break_str.' <i class="fab fa-font-awesome" aria-hidden="true"></i>'.$area[$addr]["border_score"].' pts.</p></A></td>';
						$area_2_cnt++;
					} elseif($area[$addr]["flag"] == 3){
						// プレイ済み（ボーダーラインを越えていない）
						echo '<td class="area_3'.$current_area.'"><A href="./'.$area[$addr]["stage_id"].'">'."{$tr}-{$td}".'◆'.$area_nav_stage_title.$area[$addr]["user_name"].'<p>'.$area[$addr]["top_score"].' pts.</p><p>'.$break_str.' <i class="fab fa-font-awesome" aria-hidden="true"></i>'.$area[$addr]["border_score"].' pts.</p></A></td>';
						if($area[$addr]["mark"] != "Limited") $area_score_total += $area[$addr]["top_score"];
						$area_3_cnt++;
					} elseif($area[$addr]["flag"] == 4){
						// プレイ済み（第一ボーダーラインを越えた）
						echo '<td class="area_4'.$current_area.'"><A href="./'.$area[$addr]["stage_id"].'">'."{$tr}-{$td}".'◆'.$area_nav_stage_title.'<i class="fab fa-font-awesome" aria-hidden="true"></i>'.$area[$addr]["user_name"].'<p><i class="fa fa-star" aria-hidden="true"></i>'.$area[$addr]["top_score"].' pts.</p><p><span glot-model="main_nav_team_exborder">EXボーダー</span> <i class="fab fa-fort-awesome" aria-hidden="true"></i>'.$area[$addr]["ex_border_score"].' pts</p></A></td>';
						if($area[$addr]["mark"] != "Limited") $area_score_total += $area[$addr]["top_score"];
						$area_4_cnt++;
					} elseif($area[$addr]["flag"] == 5){
						// プレイ済み（第二ボーダーラインを越えた）
						echo '<td class="area_5'.$current_area.'"><A href="./'.$area[$addr]["stage_id"].'">'."{$tr}-{$td}".'◆'.$area_nav_stage_title.'<i class="fab fa-fort-awesome" aria-hidden="true"></i>'.$area[$addr]["user_name"].'<p><span glot-model="main_nav_team_hiscore">ハイスコア</span> <i class="fa fa-spin fa-star" aria-hidden="true"></i>'.$area[$addr]["top_score"].' pts.</p><p> '.$area[$addr]["ex_border_score"].' pts.</p></A></td>';
						if($area[$addr]["mark"] != "Limited") $area_score_total += $area[$addr]["top_score"];
						$area_5_cnt++;
					} else {
						// 侵入不可能
						echo '<td class="area_0"> </td>';
					}
				}
				// スタンダードのエリア表示
				if($area_cat == 'standard'){
					// 侵入不可能
					if($area[$addr]["flag"] == 0){
						echo '<td class="area_0"> </td>';
					}
					// 鑑賞モード時にユーザーカラーで表示
					elseif($watchmode == 2){
						$ae_bgcolor = str2color($area[$addr]["user_name"], $user_colors);
						echo '<td style="background-color:'.$ae_bgcolor.'" class="area_2'.$current_area.'"><A href="./'.$area[$addr]["stage_id"].'">'."{$tr}-{$td}".'◆'.$area_nav_stage_title.$area[$addr]["user_name"].'<p><i class="fa fa-star" aria-hidden="true"></i>'.$area[$addr]["top_score"].' pts.</p><p><i class="fas fa-paper-plane"></i>'.$area[$addr]['count'].'</p></A></td>';
					}
					// 自陣が存在しない
					elseif($myarea_count == 0 or $cookie_name == ""){
						echo '<td class="area_2'.$current_area.'"><A href="./'.$area[$addr]["stage_id"].'">'."{$tr}-{$td}".'◆'.$area_nav_stage_title.$area[$addr]["user_name"].'<p><i class="fa fa-star" aria-hidden="true"></i>'.$area[$addr]["top_score"].' pts.</p><p><i class="fas fa-paper-plane"></i>'.$area[$addr]['count'].'</p></A></td>';
							$area_2_cnt++;
					}
					// 自陣
					elseif($area[$addr]["user_name"] == $cookie_name){
						echo '<td class="area_3'.$current_area.'"><A href="./'.$area[$addr]["stage_id"].'">'."{$tr}-{$td}".'◆'.$area_nav_stage_title.$area[$addr]["user_name"].'<p><i class="fa fa-star" aria-hidden="true"></i>'.$area[$addr]["top_score"].' pts.</p><p><i class="fas fa-paper-plane"></i>'.$area[$addr]['count'].'</p></A></td>';
						if($area[$addr]["mark"] != "Limited") $area_score_total += $area[$addr]["top_score"];
						$area_3_cnt++;
					}
					// 自陣と隣接している
					elseif($area[$addr - 1]["user_name"] == $cookie_name or $area[$addr + 1]["user_name"] == $cookie_name or $area[$addr - $ae_width[$key]]["user_name"] == $cookie_name or $area[$addr + $ae_width[$key]]["user_name"] == $cookie_name){
						echo '<td class="area_2'.$current_area.'"><A href="./'.$area[$addr]["stage_id"].'">'."{$tr}-{$td}".'◆'.$area_nav_stage_title.$area[$addr]["user_name"].'<p><i class="fa fa-star" aria-hidden="true"></i>'.$area[$addr]["top_score"].' pts.</p><p><i class="fas fa-paper-plane"></i>'.$area[$addr]['count'].'</p></A></td>';
						$area_2_cnt++;
					}
					// 敵陣
					elseif($area[$addr]["user_name"] != $cookie_name and $area[$addr]["user_name"] != ""){
						echo '<td class="area_4'.$current_area.'"><A href="./#">'."{$tr}-{$td}".'◆'.$area_nav_stage_title.$area[$addr]["user_name"].'<p><i class="fa fa-star" aria-hidden="true"></i>'.$area[$addr]["top_score"].' pts.</p><p><i class="fas fa-paper-plane"></i>'.$area[$addr]['count'].'</p></A></td>';
						$area_4_cnt++;
					}
					// 自陣と隣接していない
					elseif($area[$addr]["flag"] != 0){
						echo '<td class="area_1'.$current_area.'"><A href="./#">'."{$tr}-{$td}".'◆'.$area_nav_stage_title."（未開地）".'<p><i class="fa fa-star" aria-hidden="true"></i>'.$area[$addr]["top_score"].' pts.</p><p><i class="fas fa-paper-plane"></i>'.$area[$addr]['count'].'</p></A></td>';
						$area_1_cnt++;
					}
					// 侵入不可能
					else {
						echo '<td class="area_0"> </td>';
					}
				}
				// チーム制のエリア表示
				if($area_cat == 'team'){
					// アクセス可能かどうか判定する
					// 大会開催中のみ有効（非開催時は全ステージアクセス可能にする）
					if($limited_num == 16){
						$addr_link_flag = 0;
						if($area[$addr]["flag"] == 3 and $cookie_row['current_team'] == $team_a){
							$addr_link_flag = 1;
						} elseif($area[$addr]["flag"] == 4 and $cookie_row['current_team'] == $team_b){
							$addr_link_flag = 1;
						} else {
							$addr_link_flag = 0;
						}
						// 上下左右が自陣
						if($cookie_row['current_team'] == $team_a){
							if($area[$addr - 1]["flag"] == 3) $addr_link_flag = 1;
							if($area[$addr + 1]["flag"] == 3) $addr_link_flag = 1;
							if($area[$addr - $ae_width[$limited_num]]["flag"] == 3) $addr_link_flag = 1;
							if($area[$addr + $ae_width[$limited_num]]["flag"] == 3) $addr_link_flag = 1;
						} elseif($cookie_row['current_team'] == $team_b){
							if($area[$addr - 1]["flag"] == 4) $addr_link_flag = 1;
							if($area[$addr + 1]["flag"] == 4) $addr_link_flag = 1;
							if($area[$addr - $ae_width[$limited_num]]["flag"] == 4) $addr_link_flag = 1;
							if($area[$addr + $ae_width[$limited_num]]["flag"] == 4) $addr_link_flag = 1;
						} else {
							$addr_link_flag = 0;
						}

						if($area[$addr]["mark"] == 'base'){
							$add_link = '<A href="./200918">';
							$add_tail = '</A>';
						} elseif($addr_link_flag === 1){
							$add_link = '<A href="./'.$area[$addr]["stage_id"].'">';
							$add_tail = '</A>';
						} else {
							$add_link = '<A href="#">';
							$add_tail = '</A>';
	//							$area_nav_stage_title = '？？？<br><br>';
						}
					} else {
						$add_link = '<A href="./'.$area[$addr]["stage_id"].'">';
						$add_tail = '</A>';
					}
					// 侵入不可能
					if($area[$addr]["flag"] == 0){
						echo '<td class="area_0"> </td>';
					}
					// 未開地
					elseif($area[$addr]["flag"] == 1){
						// 未解禁のフリーエリア
						echo '<td style="text-align:center;" class="area_1'.$current_area.'">'."{$tr}-{$td}".'</td>';
						$area_1_cnt++;
					}
					// どちらでもない解禁済みエリア
					elseif($area[$addr]["flag"] == 2){
						echo '<td class="area_2'.$current_area.'">'.$add_link."{$tr}-{$td}".'◆'.$area_nav_stage_title.$area[$addr]["user_name"].'<p><i class="fa fa-star" aria-hidden="true"></i>'.$area[$addr]["top_score"].' pts.  <i class="fas fa-paper-plane"></i>'.$area[$addr]["count"].'</p><p>'.$teame['a'][$key].$area[$addr]['team_a'].' - '.$area[$addr]['team_b'].$teame['b'][$key].'</p>'.$add_tail.'</td>';
						$area_2_cnt++;
					}
					// 左チームのエリア
					elseif($area[$addr]["flag"] == 3){
						// 拠点の場合
						if($area[$addr]["mark"] == 'base'){
							echo '<td style="background-color:#'.$teamc[$teamp['a'][$key]].'" class="area_3'.$current_area.'">'.$add_link."{$tr}-{$td}".'◆'.$team[$teamp['a'][$key]].'<br><div style="text-align:right;" glot-model="main_nav_team_base">（拠点）</div></td>';
						} else {
							echo '<td style="background-color:#'.$teamc[$teamp['a'][$key]].'" class="area_3'.$current_area.'">'.$add_link."{$tr}-{$td}".'◆'.$area_nav_stage_title.$area[$addr]["user_name"].'<p><i class="fa fa-star" aria-hidden="true"></i>'.$area[$addr]["top_score"].' pts.  <i class="fas fa-paper-plane"></i>'.$area[$addr]["count"].'</p><p>'.$teame['a'][$key].$area[$addr]['team_a'].' - '.$area[$addr]['team_b'].$teame['b'][$key].'</p>'.$add_tail.'</td>';
						}
						$area_3_cnt++;
					}
					// 右チームのエリア
					elseif($area[$addr]["flag"] == 4){
						// 拠点の場合
						if($area[$addr]["mark"] == 'base'){
							echo '<td style="background-color:#'.$teamc[$teamp['b'][$key]].'" class="area_3'.$current_area.'">'.$add_link."{$tr}-{$td}".'◆'.$team[$teamp['b'][$key]].'<br><div style="text-align:right;" glot-model="main_nav_team_base">（拠点）</div></td>';
						} else {
							echo '<td style="background-color:#'.$teamc[$teamp['b'][$key]].'" class="area_4'.$current_area.'">'.$add_link."{$tr}-{$td}".'◆'.$area_nav_stage_title.$area[$addr]["user_name"].'<p><i class="fa fa-star" aria-hidden="true"></i>'.$area[$addr]["top_score"].' pts.  <i class="fas fa-paper-plane"></i>'.$area[$addr]["count"].'</p><p>'.$teame['a'][$key].$area[$addr]['team_a'].' - '.$area[$addr]['team_b'].$teame['b'][$key].'</p>'.$add_tail.'</td>';
						}
						$area_4_cnt++;
					}
					// 侵入不可能
					else {
						echo '<td class="area_0"> </td>';
					}
				}
			}
		echo '</tr>';
		}
		echo '</table><br></div>';
	}
	if($area_cat == 'team2'){
		// JS版エリア表示
		for($tr = 1; $tr <= $ae_height[$key]; $tr++){ // 縦の長さを定義
			echo '<tr>';
			for($td = 1; $td <= $ae_width[$key]; $td++){ // 横の長さを定義
				$addr = ($ae_width[$key] * $tr) - ($ae_width[$key] - $td) + $ae_area[$key-1];
				echo '<td id="'."area{$addr}".'" class="'.$area[$addr]["mark"].'"></td>';
			}
			echo '</tr>';
		}
		echo '</table></div>';
		// JS版チームスコア表示
		echo '
		<table class="team_info_tab">
			<tr>
				<td class="team_point_tab_wrapper">
					<span style="color:#'.$teamc[$team_a].';" class="team_point" id="teama_areapoint">0</span>
					<hr style="height:3px;border:none;background-color:#'.$teamc[$team_a].';">
					<span style="color:#'.$teamc[$team_a].';" class="team_point" id="teama_rankpoint">0</span>
					<br>
					<span style="color:#'.$teamc[$team_a].'" class="team_point_mini" id="teama_gamepoint">0</span>
				</td>
				<td class="mobile-hidden team_user_tab_wrapper">
					<b style="color:#'.$teamc[$team_a].'">◆<span glot-model="team'.$team_a.'">'.$team[$team_a].'</span>◆</b> <br>
					<table class="team_user_tab" id="teama_user_tab">
						<tr><td><b></b></td><td>0 RPS</td><td>0 pts.</td></tr>
					</table>
				</td>
				<td class="mobile-hidden team_user_tab_wrapper">
					<b style="color:#'.$teamc[$team_b].'">◆<span glot-model="team'.$team_b.'">'.$team[$team_b].'</span>◆</b> <br>
					<table class="team_user_tab" id="teamb_user_tab">
						<tr><td><b></b></td><td>0 RPS</td><td>0 pts.</td></tr>
					</table>
				</td>
				<td class="team_point_tab_wrapper">
					<span style="color:#'.$teamc[$team_b].';" class="team_point" id="teamb_areapoint">0</span>
					<hr style="height:3px;border:none;background-color:#'.$teamc[$team_b].';">
					<span style="color:#'.$teamc[$team_b].'" class="team_point" id="teamb_rankpoint">0</span>
					<br>
					<span style="color:#'.$teamc[$team_b].'" class="team_point_mini" id="teamb_gamepoint">0</span>
				</td>
			</tr>
		</table>
		';
	}
	if($area_cat == 'coop'){
		$area_count  = $area_1_cnt + $area_2_cnt + $area_3_cnt + $area_4_cnt + $area_5_cnt;
		$lest_count  = $area_1_cnt + $area_2_cnt + $area_3_cnt;
		$break_count = $area_4_cnt + $area_5_cnt;
		$target_total_score = 700000;
		$area_score_per = $area_score_total / $target_total_score * 100;
		$area_score_lest = $target_total_score - $area_score_total;

		echo '<table style="width:100%"><tr><td style="width:50%;">';
		echo '<span style="color:#74e645;" class="team_point"     >'.$break_count.'</span> <br>';
		echo '<span style="color:#74e645;" class="team_point_mini">'.number_format($area_score_total).'</span> <br>';
		echo '</td><td style="text-align:right;">';
		echo '<span style="color:#777;" class="team_point"     >'.$lest_count.'</span> <br>';
		echo '<span style="color:#777;" class="team_point_mini">'.number_format($area_score_lest).'</span> <br>';
		echo '</tr></table>';

		echo '<meter min="0" max="100" value="'.$area_score_per.'">100</meter>';
		echo '<div style="text-align:right;"><b><span glot-model="main_nav_area_unbanned">未解禁</span>：'.$area_1_cnt.' | <span glot-model="main_nav_area_lifted">解禁済み</span>：'.$area_2_cnt.' | <span glot-model="main_nav_area_notclear">未クリア</span>：'.$area_3_cnt.' | <span glot-model="main_nav_area_borderover">ボーダー突破</span><i class="fab fa-font-awesome" aria-hidden="true"></i>：'.$area_4_cnt.' | <span glot-model="main_nav_area_exborderover">EXボーダー突破</span><i class="fab fa-fort-awesome" aria-hidden="true"></i>：'.$area_5_cnt.'</b></div>';
	}
	// if($area_cat == 'team'){
	// 	$area_count  = $area_1_cnt + $area_2_cnt + $area_3_cnt + $area_4_cnt + $area_5_cnt;
	// 	$lest_count  = $area_1_cnt + $area_2_cnt + $area_3_cnt;
	// 	$break_count = $area_4_cnt + $area_5_cnt;
	// 	$target_total_score = 700000;
	// 	$area_score_per = $area_score_total / $target_total_score * 100;
	// 	$area_score_lest = $target_total_score - $area_score_total;

	// 	echo '<table style="width:100%"><tr><td style="width:205px;text-align:center;border-bottom:4px solid #'.$teamc[$team_a].'">';
	// 	echo '<span style="color:#'.$teamc[$team_a].';" class="team_point">'.$area_3_cnt.'</span> <br>';
	// 	echo '</td><td style="width:614px;"> </td><td style="width:205px;text-align:center;border-bottom:4px solid #'.$teamc[$team_b].'">';
	// 	echo '<span style="color:#'.$teamc[$team_b].';" class="team_point">'.$area_4_cnt.'</span> <br>';
	// 	echo '</tr></table>';
	// }
}

// チーム対抗・スタンダード戦のトップランカー一覧
if($limited_type[$val] != 'e'){
	echo '<table class="series_nav"><tr>'."\n";
	$cols = count(${'limited'.$val});
	$q = 0;
	while($q < $cols){
		$array_stage_title[${'limited'.$val}[$q]] = preg_replace('/<.*?>/', '', $array_stage_title[${'limited'.$val}[$q]]);
		$short_stage_lim_title = mb_substr($array_stage_title[${'limited'.$val}[$q]], 5, 200);
		$short_stage_lim_title = str_replace('（',' <br>（', $short_stage_lim_title);
		$color = 'background-color:#aaa;';
		if($stage_id == $val or $stage_id == ${'limited'.$val}[$q]) $color = 'background-color:'.$array_theme_color[91].';';
		echo '<td style="'.$color.'"><A style="color:#111;" href="./'.${'limited'.$val}[$q].'" title="'.$array_stage_title[${'limited'.$val}[$q]].'">'.$short_stage_lim_title.'</A></td>'."\n";
		$q++;
	}
	$q = 0;
	echo '</tr><tr>'."\n";
	while($q < $cols){
		if(!isset($topscore[${'limited'.$val}[$q]])){
			echo '<td>-</td>';
		} else {
			echo '<td>'.$topuser[${'limited'.$val}[$q]].' <br>('.number_format($topscore[${'limited'.$val}[$q]]).' pts.)</td>'."\n";
		}
		$q++;
	}
	echo '</tr></table>'."\n";
}

echo '</div>';
$i++;

}
if(!$mysql_mode) loadtime_calc(__LINE__);
/*
topscore_board_tab("score", range(101, 105), $stage_id, 10, 9999);
topscore_board_tab("score", range(201, 230), $stage_id, 20, 9999);
topscore_board_tab("score", array(201,202,205,206,207,212,217,218,220,226,228,229,230), $stage_id, 21, 9999);
topscore_board_tab("score", array(203,204,208,209,210,211,213,214,215,216,219,221,222,223,224,225,227), $stage_id, 22, 9999);
topscore_board_tab("score", range(231, 244), $stage_id, 23, 9999);
topscore_board_tab("score", range(2201, 2230), $stage_id, 24, 9999);
topscore_board_tab("score", range(285, 297), $stage_id, 26, 9999);
topscore_board_tab("rate",  range(275, 284), $stage_id, 95, 9999);
topscore_board_tab("score", array(301,302,303,304,305,317,318,319,320,321,327,328,329,330,331), $stage_id, 31, 9999);
topscore_board_tab("score", array(306,307,308,309,310,322,323,324,325,326,332,333,334,335,336), $stage_id, 32, 9999);
topscore_board_tab("score", array(311,312,313,314,315,316), $stage_id, 33, 9999);
topscore_board_tab("rate",  range(337, 348), $stage_id, 95, 9999);
topscore_board_tab("score", array(10101, 10201, 10202, 10301, 10302, 10203, 10204), $stage_id, 93, 9999);
topscore_board_tab("score", range(10205, 10214), $stage_id, 94, 9999);
*/
topscore_board_tab2(range(101, 105), 10);
topscore_board_tab2(range(201, 230), 20);
topscore_board_tab2(array(201,202,205,206,207,212,217,218,220,226,228,229,230), 21);
topscore_board_tab2(array(203,204,208,209,210,211,213,214,215,216,219,221,222,223,224,225,227), 22);
topscore_board_tab2(range(231, 244), 23);
topscore_board_tab2(range(2201, 2230), 24);
topscore_board_tab2(range(285, 297), 26);
topscore_board_tab2(range(5001, 5013), 28);
topscore_board_tab("rate",  range(275, 284), $stage_id, 95, 9999);
topscore_board_tab2(array(301,302,303,304,305,306,307,308,309,310,317,318,319,320,321,322,323,324,325,326,327,328,329,330,331,332,333,334,335,336), 30);
topscore_board_tab2(range(311, 316), 30);
topscore_board_tab2(range(349, 362), 30);
topscore_board_tab2(array(2301,2302,2303,2304,2305,2306,2307,2308,2309,2310,2317,2318,2319,2320,2321,2322,2323,2324,2325,2326,2327,2328,2329,2330,2331,2332,2333,2334,2335,2336), 34);
topscore_board_tab2(range(2311, 2316), 34);
topscore_board_tab2(range(2349, 2362), 34);
topscore_board_tab2(range(349, 362), 36);
topscore_board_tab2(array(301,302,303,304,305,317,318,319,320,321,327,328,329,330,331), 31);
topscore_board_tab2(array(306,307,308,309,310,322,323,324,325,326,332,333,334,335,336), 32);
topscore_board_tab2(array(311,312,313,314,315,316), 33);
topscore_board_tab("rate",  range(337, 348), $stage_id, 95, 9999);
topscore_board_tab2(array(10101, 10201, 10202, 10301, 10302, 10203, 10204), 93);
topscore_board_tab2(range(231, 244), 93);
topscore_board_tab2(range(10205, 10214), 94);
topscore_board_tab2(range(10215, 10224), 96);
topscore_board_tab2(range(10303, 10314), 96);

if(!$mysql_mode) loadtime_calc(__LINE__);

/*	// ピクミン3ミッションモードモードの勝者一覧

	$i = 301;
	$r = 1;
	$display = ' style="display:none;"';
	if($stage_id == 30) $display = '';
//		echo '<div class="scroll-wrap"><b class="mobile-hidden">◆ピクミン3 ミッションモード ハイスコア一覧 (※タイ記録が存在する場合、古い記録を優先)</b>';
	echo '<div class="scroll-wrap">';
	echo '<table class="topscore series_nav top-score30"'.$display.'><tr>'."\n";
	while($i <= 310){
		$short_stage_title = mb_substr($array_stage_title[$i], 4, 2);
		if($stage_id < 100 or $stage_id == $i){
			$background_color = $array_theme_color[31];
			if($r > 5) $background_color = $array_theme_color[32];
		} else {
			$background_color = "#777";
		}
		echo '<td style="background-color:'.$background_color.';"><A style="color:#111111;" href="./'.$i.'" title="'.$array_stage_title[$i].'">'.$short_stage_title.'</A></td>';
		$i++;
		$r++;
	}
	echo '</tr><tr>';
	$i = 301;
	while($i <= 336){
		$user_sql = "SELECT * FROM `ranking` WHERE `stage_id` = $i AND `log` = 0 AND `post_rank` = 1 ORDER BY `post_date` ASC";
		$user_result = mysqli_query($mysqlconn, $user_sql);
		$user_row = mysqli_fetch_assoc($user_result);
		if($user_row["score"] == 0){
		echo '<td>-</td>';
		} else {
		if( $i < 311 or $i > 316) $show_score = number_format($user_row["score"])." pts.";
			$decode_score = bossscore_enc($i, $user_row["score"]);
		if( $i > 310 and $i < 317){
			$score_sec = sprintf('%02d', fmod ( $decode_score , 60) );
			$score_min = floor( $decode_score / 60);
			$show_score= $score_min.":".$score_sec ;
		}
		echo '<td>'.$user_row["user_name"].' <br>('.$show_score.')</td>';
		}
		if($i == 310){
			echo '</tr><tr>';
			$q = 311;
			while($q <= 316){
			$short_stage_title = mb_substr($array_stage_title[$q], 4, 2);
			if($stage_id < 100 or $stage_id == $q){
				$background_color = $array_theme_color[33];
			} else {
			$background_color = "#777";
			}
			echo '<td style="background-color:'.$background_color.';"><A style="color:#111111;" href="./'.$q.'" title="'.$array_stage_title[$q].'">'.$short_stage_title.'</A></td>';
			$q++;
			}
			echo '</tr><tr>';
		}
		if($i == 316){
			echo '</tr><tr>';
			$r = 1;
			while($q <= 326){
			$short_stage_title = mb_substr($array_stage_title[$q], 4, 4);
			if($stage_id < 100 or $stage_id == $q){
				$background_color = $array_theme_color[31];
				if($r > 5) $background_color = $array_theme_color[32];
			} else {
				$background_color = "#777";
			}
			echo '<td style="background-color:'.$background_color.';"><A style="color:#111111;" href="./'.$q.'" title="'.$array_stage_title[$q].'">'.$short_stage_title.'</A></td>';
			$q++;
			$r++;
			}
			echo '</tr><tr>';
		}
		if($i == 326){
			echo '</tr><tr>';
			$r = 1;
			while($q <= 336){
			$short_stage_title = mb_substr($array_stage_title[$q], 4, 2);
			if($stage_id < 100 or $stage_id == $q){
				$background_color = $array_theme_color[31];
				if($r > 5) $background_color = $array_theme_color[32];
			} else {
				$background_color = "#777";
			}
			echo '<td style="background-color:'.$background_color.';"><A style="color:#111111;" href="./'.$q.'" title="'.$array_stage_title[$q].'">'.$short_stage_title.'</A></td>';
			$q++;
			$r++;
			}
			echo '</tr><tr>';
		}
		$i++;
	}
	echo '</tr></table></div>';

// ピクミン3 2Pミッションモードモードの勝者一覧

	$i = 2301;
	$r = 1;
	$display = ' style="display:none;"';
	if($stage_id == 34 or $stage_hook == 34) $display = '';
	echo '<div class="scroll-wrap">';
	echo '<table class="topscore series_nav top-score34"'.$display.'><tr>'."\n";
	while($i <= 2310){
		$short_stage_title = mb_substr($array_stage_title[$i], 5, 2);
		$background_color = $array_theme_color[36];
		if($r > 5) $background_color = $array_theme_color[37];
		if($stage_id < 100 or $i == $stage_id){
			echo '<td style="background-color:'.$background_color.';"><A style="color:#111111;" href="./'.$i.'" title="'.$array_stage_title[$i].'">'.$short_stage_title.'</A></td>';
		} else {
			echo '<td style="background-color:#777;"><A style="color:#111111;" href="./'.$i.'" title="'.$array_stage_title[$i].'">'.$short_stage_title.'</A></td>';
		}
		$i++;
		$r++;
	}
	echo '</tr><tr>';
	$i = 2301;
	while($i <= 2336){
		$user_sql = "SELECT * FROM `ranking` WHERE `stage_id` = $i AND `log` = 0 AND `post_rank` = 1 ORDER BY `post_date` ASC";
		$user_result = mysqli_query($mysqlconn, $user_sql);
		$user_row = mysqli_fetch_assoc($user_result);
		if($user_row["score"] == 0){
		echo '<td>-</td>';
		} else {
		if( $i < 2311 or $i > 2316) $show_score = number_format($user_row["score"])." pts.";
			$decode_score = bossscore_enc($i, $user_row["score"]);
		if( $i > 2310 and $i < 2317){
			$score_sec = sprintf('%02d', fmod ( $decode_score , 60) );
			$score_min = floor( $decode_score / 60);
			$show_score= $score_min.":".$score_sec ;
		}
		echo '<td>'.$user_row["user_name"].' <br>'.$user_row["user_name_2p"].' <br>('.$show_score.')</td>';
		}
		if($i == 2310){
			echo '</tr><tr>';
			$q = 2311;
			while($q <= 2316){
			$short_stage_title = mb_substr($array_stage_title[$q], 5, 2);
			$background_color = $array_theme_color[38];
			if($stage_id < 100 or $q == $stage_id){
				echo '<td style="background-color:'.$background_color.';"><A style="color:#111111;" href="./'.$q.'" title="'.$array_stage_title[$q].'">'.$short_stage_title.'</A></td>';
			} else {
				echo '<td style="background-color:#777;"><A style="color:#111111;" href="./'.$q.'" title="'.$array_stage_title[$q].'">'.$short_stage_title.'</A></td>';
			}
			$q++;
			}
			echo '</tr><tr>';
		}
		if($i == 2316){
			echo '</tr><tr>';
			$r = 1;
			while($q <= 2326){
			$short_stage_title = mb_substr($array_stage_title[$q], 5, 4);
			$background_color = $array_theme_color[36];
			if($r > 5) $background_color = $array_theme_color[37];
			if($stage_id < 100 or $q == $stage_id){
				echo '<td style="background-color:'.$background_color.';"><A style="color:#111111;" href="./'.$q.'" title="'.$array_stage_title[$q].'">'.$short_stage_title.'</A></td>';
			} else {
				echo '<td style="background-color:#777;"><A style="color:#111111;" href="./'.$q.'" title="'.$array_stage_title[$q].'">'.$short_stage_title.'</A></td>';
			}
			$q++;
			$r++;
			}
			echo '</tr><tr>';
		}
		if($i == 2326){
			echo '</tr><tr>';
			$r = 1;
			while($q <= 2336){
			$short_stage_title = mb_substr($array_stage_title[$q], 5, 2);
			$background_color = $array_theme_color[36];
			if($r > 5) $background_color = $array_theme_color[37];
			if($stage_id < 100 or $q == $stage_id){
				echo '<td style="background-color:'.$background_color.';"><A style="color:#111111;" href="./'.$q.'" title="'.$array_stage_title[$q].'">'.$short_stage_title.'</A></td>';
			} else {
				echo '<td style="background-color:#777;"><A style="color:#111111;" href="./'.$q.'" title="'.$array_stage_title[$q].'">'.$short_stage_title.'</A></td>';
			}
			$q++;
			$r++;
			}
			echo '</tr><tr>';
		}
		$i++;
	}
	echo '</tr></table></div>';
*/
// 日替わりチャレンジの勝者一覧

	$i = 1;
	$display = 'style="display:none;"';
	if($stage_id == 92 or $stage_hook == 92) $display = '';
	echo '<div class="scroll-wrap">';
	echo '<table class="topscore series_nav top-score92" '.$display.'><tr>'."\n";
	while($i <= 10){
		$week = date('w', mktime(0,0,0, $get_m,$i,$get_y) );
		$background_color = 'background-color:#777;color:#111;';
		if($get_day == $i) $background_color = 'background-color:'.$array_theme_color[92].';';
		$str = $i.' ('.$week_array[$week].')';
		if($get_day == $i) $str = '<A style="color:#111;" href="./'.$diary_pik2[$i-1].'">'.$i.' ('.$week_array[$week].')</A>';
		if(checkdate($get_m, $i, $get_y)) echo '<td style="'.$background_color.'font-weight:bold;color:#111111;">'.$str.'</td>';
		$i++;
	}
	echo '</tr><tr>';
	$i = 1;
	while($i <= 31){
		if(!checkdate($get_m, $i, $get_y)){
		} elseif($i == 31){
			echo '<td>？</td>';
		} else {
			$fixed_stage_id = $diary_pik2[$i-1];
			$user_sql = "SELECT * FROM `ranking` WHERE `stage_id` = $fixed_stage_id AND `log` = 0 AND `post_rank` = 1 ORDER BY `post_date` ASC";
			$user_result = mysqli_query($mysqlconn, $user_sql);
			$user_row = mysqli_fetch_assoc($user_result);
			if($user_row["score"] == 0){
			echo '<td>-</td>';
			} else {
				echo '<td>'.$user_row["user_name"].' <br>('.number_format($user_row["score"]).' pts.)</td>';
			}
		}
		if($i == 10){
			echo '</tr><tr>';
			$q = 11;
			while($q <= 20){
			$week = date('w', mktime(0,0,0, $get_m,$q,$get_y) );
			$background_color = 'background-color:#777;color:#111;';
			if($get_day == $q) $background_color = 'background-color:'.$array_theme_color[92].';';
			$str = $q.' ('.$week_array[$week].')';
			if($get_day == $q) $str = '<A style="color:#111;" href="./'.$diary_pik2[$q-1].'">'.$q.' ('.$week_array[$week].')</A>';
			if(checkdate($get_m, $q, $get_y)) echo '<td style="'.$background_color.'font-weight:bold;color:#111111;">'.$str.'</td>';
			$q++;
			}
			echo '</tr><tr>';
		}
		if($i == 20){
			echo '</tr><tr>';
			$q = 21;
			while($q <= 30){
			$week = date('w', mktime(0,0,0, $get_m,$q,$get_y) );
			$background_color = 'background-color:#777;color:#111;';
			if($get_day == $q) $background_color = 'background-color:'.$array_theme_color[92].';';
			$str = $q.' ('.$week_array[$week].')';
			if($get_day == $q) $str = '<A style="color:#111;" href="./'.$diary_pik2[$q-1].'">'.$q.' ('.$week_array[$week].')</A>';
			if(checkdate($get_m, $q, $get_y)) echo '<td style="'.$background_color.'font-weight:bold;color:#111111;">'.$str.'</td>';
			$q++;
			}
			echo '</tr><tr>';
		}
		if($i == 30){
			echo '</tr><tr>';
			$q = 31;
			$week = date('w', mktime(0,0,0, $get_m,$q,$get_y) );
			$background_color = 'background-color:#777;color:#111;';
			if($get_day == $q) $background_color = 'background-color:'.$array_theme_color[92].';';
			$str = $q.' ('.$week_array[$week].')';
			if($get_day == $q) $str = '<A style="color:#111;" href="./'.$diary_pik2[$i-1].'">'.$i.' ('.$week_array[$week].')</A>';
			if(checkdate($get_m, $q, $get_y)) echo '<td style="'.$background_color.'font-weight:bold;color:#111111;">'.$str.'</td>';
			echo '</tr><tr>';
		}
		$i++;
	}
	echo '</tr></table></div>';
