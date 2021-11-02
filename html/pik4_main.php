<div class="pik4_table">
<?php
if(!$mysql_mode) loadtime_calc(__LINE__);

// ランキングヘッダー
require_once('pik4_main_header.php');
if(!$mysql_mode) loadtime_calc(__LINE__);

// 総合ナビゲーションテーブル
if($nav_table != 2){
require_once('pik4_main_nav.php');
}
if(!$mysql_mode) loadtime_calc(__LINE__);

// ステージ情報を表示
require_once('pik4_main_info.php');
if(!$mysql_mode) loadtime_calc(__LINE__);

// ピク杯概要表示（通常スコア表示フラグ削除）
if( $show_scoretable == 1 and $page_type == 18){
	include "pikcup_".$stage_id.".php";
	$show_scoretable = 0;
}
if(!$mysql_mode) loadtime_calc(__LINE__);

//エリア踏破戦ステータス表示
if( $show_scoretable == 1 and ($page_type == 19)){
	$search = array_search($stage_id, array_column($area, 'stage_id')) + 1;

	// エリア踏破戦スタンダード・協力戦の場合はボーダーラインを表示
	if($stage_id >= 3001 and $stage_id <= 3065){
		echo '<table class="series_nav"><tr><td style="background-color:#777;" glot-model="main_nav_team_border">ボーダースコア</td><td style="background-color:#777;" glot-model="main_nav_team_exborder">EXボーダー</td><td style="background-color:#777;" glot-model="main_nav_team_numofplayer">必要人数</td><td style="background-color:#777;" glot-model="main_nav_team_borderover">ボーダー突破人数</td></tr>';
		echo '<tr><td>'.$area[$search]['border_score'].'</td><td>'.$area[$search]['ex_border_score'].'</td><td>'.$area[$search]['border_rank'].'</td><td>'.$area[$search]['break_count'].'</td></tr>';
		echo '</table>';

	// エリア踏破戦チーム対抗戦の場合は各チーム点数を表示
	} else {
		echo '<table class="series_nav"><tr><td style="background-color:#777;" glot-model="team'.$team_a.'">'.$team[$team_a].'</td><td style="background-color:#777;" glot-model="team'.$team_b.'">'.$team[$team_b].'</td></tr>';
		echo '<tr><td>'.$area[$search]['team_a'].'</td><td>'.$area[$search]['team_b'].'</td></tr>';
		echo '</table>';
	}
}
// バトルモード最新戦歴テーブル（通常スコア表示フラグ削除）
if( $show_scoretable == 1 and $page_type == 17){
	require_once('pik4_main_battle.php');
}
if(!$mysql_mode) loadtime_calc(__LINE__);

//チーム対抗テーブル（通常スコア表示フラグ削除）
if( $show_scoretable == 1 and ($page_type == 10 or $stage_id == 200723 or $stage_id == 200918)){
	require_once('pik4_main_team.php');
}
if(!$mysql_mode) loadtime_calc(__LINE__);

//　通常スコアテーブル
if( $show_scoretable == 1 and $page_type != 0 and $page_type != 10 and $page_type != 18 and $page_type != 9 and $page_type != 15){
	require_once('pik4_main_score.php');
}
// 個別ページ
if( $page_type == 9 ){
	echo $note["tag"];
	echo '<div class="fp_content">';
	echo $note["content"];
	echo "</div>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
}
if($page_type == 15){
	$sql = "SELECT * FROM `note` WHERE `tag` = '$user_name'";
	$result = mysqli_query($mysqlconn, $sql);
	echo '<h1 class="rtd_stage_caption">'.$user_name.'</h1><hr size="1"/> <br>';
	while($row = mysqli_fetch_assoc($result)){
		echo '<h2 class="fp_sub_caption"><A href="./'.$row["post_title"].'">◆'.$row["post_title"].'</A></h2>';
		echo '<div class="fp_content">';
		echo $row["content"];
		echo "</div>";
		echo '<hr size="1"/>';
	}
	echo "</div>";
	echo "</div>";
	echo "</div>";
}
