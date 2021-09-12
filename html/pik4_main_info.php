<?php
// ステージ別基本情報
if($page_type == 3){
	echo '<div class="scroll-wrap">';
	echo '<table class="series_nav"><tr>';
	$st1 = "s".($season - 0)."_top";
	$st2 = "s".($season - 1)."_top";
	$st3 = "s".($season - 2)."_top";
	$str_st1 = '<span glot-model="menu_limited_dai">第</span>'.($season - 0).'<span glot-model="main_ki">期</span>('.($season + 2006).")";
	$str_st2 = '<span glot-model="menu_limited_dai">第</span>'.($season - 1).'<span glot-model="main_ki">期</span>('.($season + 2005).")";
	$str_st3 = '<span glot-model="menu_limited_dai">第</span>'.($season - 2).'<span glot-model="main_ki">期</span>('.($season + 2004).")";
	$stage_info_output = array($stage_info_output_array[0],$stage_info_output_array[1],$stage_info_output_array[2],$stage_info_output_array[3],$str_st1,$str_st2,$str_st3);
	$stage_info_query = array("Time","Total_Pikmin","Max_Treture","score_ave",$st1,$st2,$st3);
	if($stage_id >= 201 and $stage_id <= 230){
		$stage_info_output[] = '<span glot-model="main_info_70k">70万点参考スコア</span>';
		$stage_info_query[] = "border_line";
		$stage_info_output[] = '<span glot-model="main_info_701k">70.1万点参考スコア</span>';
		$stage_info_query[] = "border_line_701k";
	}
	if($stage_id >= 301 and $stage_id <= 336){
		$stage_info_output[] = '<span glot-model="main_info_unexpected">想定外</span>';
		$stage_info_query[] = "unexpected";
		$stage_info_output[] = '<span glot-model="main_info_wr">世界記録 (Wii U)</span>';
		$stage_info_query[] = "wr";
	}
	if(($stage_id >= 301 and $stage_id <= 336) or ($stage_id >= 349 and $stage_id <= 362)){
		$stage_info_output[] = '<span glot-model="main_info_wrdx">世界記録 (Switch)</span>';
		$stage_info_query[] = "wrdx";
	}
	$i = 0;
	while($i < count($stage_info_output)){
		echo '<td style="background-color:#ccc;color:#111;font-weight:bold;">'.$stage_info_output[$i]."</td>";
		$i++;
	}
	echo "</tr><tr>";
	$i = 0;
	$show_score = "";
	while($i < count($stage_info_query)){
		if($stage_row[$stage_info_query[$i]] > 0){
			$stage_result = mysqli_query($mysqlconn, $stage_sql);
			$srow = mysqli_fetch_assoc($stage_result);
			if($i > 0 and (($stage_id > 310 and $stage_id < 317) or ($stage_id == 356 or $stage_id == 359 or $stage_id == 361)) and $stage_info_query[$i] != "Total_Pikmin"){
				if($stage_info_query[$i] == "unexpected" or $stage_info_query[$i] == "wr" or $stage_info_query[$i] == "wrdx"){
					$decode_score = $stage_row[$stage_info_query[$i]];
				} else {
					$decode_score = bossscore_enc($stage_id, $stage_row[$stage_info_query[$i]]);
				}
				$score_sec = sprintf('%02d', fmod ( $decode_score , 60) );
				$score_min = floor( $decode_score / 60);
				$show_score= $score_min.":".$score_sec ;
			} else {
				$show_score= number_format($stage_row[$stage_info_query[$i]]);
			}
			echo "<td>".$show_score."</td>";
		} else {
			echo "<td>-</td>";
		}
		$i++;
	}
	echo "</tr></table></div>";
}
// 日替わりチャレンジの場合、お宝一覧シミュレーターを表示
if($page_type == 8){
	$object_count = 0;
	$p = 0;
	$stage_sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$stage_id'";
	$stage_result = mysqli_query($mysqlconn, $stage_sql);
	$srow = mysqli_fetch_assoc($stage_result);
	echo '<hr size="1"/>';
	echo '<A href="#" onClick="objectlist_toggle()"><b glot-model="main_daily_simtitle">★お宝一覧シミュレーター [クリックで開閉]</b></A> <br>';
	echo '<div id="object_list" style="display:none;">';
	echo '<form name="myform">';
	echo '<table class="object_list">';
	echo '<tr><td><input type="checkbox" id="category_all" /></td><td glot-model="main_daily_floor">階層</td><td><label for="category_all" glot-model="main_daily_name">名前</label></td><td glot-model="main_daily_value">価値</td></tr>'."\n";
	$object_sql = "SELECT * FROM `object_list` WHERE `stage_id` = '$stage_id' ORDER BY `object_id`";
	$object_result2 = mysqli_query($mysqlconn, $object_sql);
	while($prow = mysqli_fetch_assoc($object_result2) ){
		$object_count = $prow["count"] + $object_count;
	}
	$object_count = round($object_count/2);
	$object_result = mysqli_query($mysqlconn, $object_sql);
	while($orow = mysqli_fetch_assoc($object_result) ){
		for($i = 1; $i <= $orow["count"]; $i++){
			if($p == $object_count) echo '</table><table class="object_list"><tr class="mobile-hidden"><td><input type="checkbox" id="dummy" /></td><td glot-model="main_daily_floor">階層</td><td><label for="category_all" glot-model="main_daily_name">名前</label></td><td glot-model="main_daily_value">価値</td></tr>'."\n";
			$object_id = ($orow["object_id"] * 10) + $i;
			if($orow["object_name"] == "あのカギ"){
				$the_key = ' checked="checked"';
			} else {
				$the_key = '';
			}
			echo '<tr><td><input type="checkbox" class="object" name="object" id="'.$object_id.'" value="'.$orow["price"].'"'.$the_key.' /></td><td>'.$orow["floor"].'F</td><td><label for="'.$object_id.'">'.$orow["object_name"]."</label></td><td>".$orow["price"]."</td></tr>"."\n";
		$p++;
		}
	}
	echo '</table><br style="clear:both;"/>';
	echo '<span glot-model="form_score_total">合計</span>：<input type="text" id="total_price" name="total_price" disabled="disabled"/> [<span id="diff_price">'.$srow["Max_Treture"].'</span>]';
	echo '<input type="hidden" id="max_price" name="max_price" value="'.$srow["Max_Treture"].'"/>';
	echo '</form>';
	echo '</div>';
	echo '<hr size="1"/>';
}
// JS未定義エラー回避のためのダミー
if($page_type != 8){
	echo '<form name="myform">';
	echo '<input type="text" id="total_price" hidden="hidden" /><input type="text" id="max_price" hidden="hidden" /></form>';
	echo '<span id="diff_price" hidden></span>';
}
//	if($page_type != 2 and $page_type != 5 and $page_type != 6 and $page_type != 9 and $page_type != 15 and $page_type != 10 and $page_type != 18) echo '<br style="clear:both;"/>';

//	if($page_type != 9) echo '<hr size="1"/>';

echo '<div style="display:flex;flex-wrap:wrap;">';
echo '<div style="order:3;width:100%;">';

// 期間限定総合の場合、各大会のサマリーを表示
if($stage_id == 91){
        echo '<table class="mobile-hidden object_list" style="width:100%;table-layout:fixed;">';
        echo '<tr><td>#</td><td>基本ルール</td><td>サブルール</td><td>参加者数</td><td>優勝者</td><td>MVP</td><td>アイデア賞</td></tr>';
        foreach(range(2, $end_of_limited) as $val){
                echo '<tr>';
		echo "<td>".'<A class="wraplink" href="'.$limited_stage_list[$val].'">'."第{$val}回</td>";
                echo "<td>".'<A class="wraplink" href="'.$limited_stage_list[$val].'">'."{$limited_stage_title_fixed[$val - 1]}</td>";
                echo "<td>".'<A class="wraplink" href="'.$limited_stage_list[$val].'">'."{$limited_stage_sub_fixed[$val - 1]}</td>";
                echo "<td>".'<A class="wraplink" href="'.$limited_stage_list[$val].'">'."{$limited_player[$val]}</td>";
                echo "<td>".'<A class="wraplink" href="'.$limited_stage_list[$val].'">'.preg_replace('/(.*?)\s.*/i','$1', $limited_stage_win_fixed[$val - 1])."</td>";
                echo "<td>".'<A class="wraplink" href="'.$limited_stage_list[$val].'">'.preg_replace('/(.*?)\s.*/i','$1', $limited_stage_mvp[$val - 1])."</td>";
                echo "<td>".'<A class="wraplink" href="'.$limited_stage_list[$val].'">'.preg_replace('/(.*?)：(.*)\s.*/i','$2', $limited_stage_idea[$val - 1])."</td>";
                echo "</tr>";
        }
        echo '</table>';
}

if(!$mysql_mode) loadtime_calc(__LINE__);
// 一本勝負専用リンク
if( $stage_id > 4000 and $stage_id < 4061){
        if($stage_id > 4000 and $stage_id < 4031){
                $uplan_get_array = $limited190209;
                $uplan_total_calc= "total_uplan001rps";
        }
        if($stage_id > 4030 and $stage_id < 4061){
                $uplan_get_array = $limited190321;
                $uplan_total_calc= "total_uplan002rps";
        }
        echo '<div class="scroll-wrap">';
        echo '<table class="stagelist_tab">';
	echo '<tr><td glot-model="main_uplan_player">参加者名</td>';
	foreach(array_slice($array_stage_title_veryshort, 19) as $val){
		echo '<td>'.$val.'</td>';
	}
	echo '<td glot-model="form_score_total">合計</td></tr>';
	foreach($array_member as $get2_user_name){
	echo '<tr>';
		echo '<td style="width:8em;">'.$get2_user_name.'</td>';
		foreach($limited190209 as $get2_stage_id){
		echo '<td>';
			$board_sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$get2_stage_id' AND `user_name` = '$get2_user_name' AND `log` = 0;";
			$board_result = mysqli_query($mysqlconn, $board_sql);
			$row = mysqli_fetch_assoc($board_result);
			if(isset($row["post_rank"])){
				echo $row["post_rank"];
			} else {
				echo "-";
			}
		echo '</td>';
		}
		echo '<td>';
		$rcount_query = "SELECT * FROM `user` WHERE `user_name` = '$get2_user_name'";
		$rcount_result = mysqli_query($mysqlconn, $rcount_query);
		$row = mysqli_fetch_assoc($rcount_result);
		if(isset($row["total_uplan001rps"])){
			echo $row["total_uplan001rps"];
		} else {
			echo "-";
		}
		echo '</td>';
	echo '</tr>';
	}
echo '</table>';
echo '</div>';

	$next_stage_id = $stage_id + 1;
	echo '<div class="season_botton" style="background-color:#555;"><A style="display:block;width:100%;height:100%;" href="./'.$next_stage_id.'">NEXT STAGE<i class="fa fa-arrow-right" aria-hidden="true"></i>'.fixed_stage_title($next_stage_id).'</A></div>';
}
if( $stage_id == 4030){
	echo '<div class="season_botton" style="background-color:#555;"><A style="display:block;width:100%;height:100%;" href="./190209">THANK YOU FOR PLAYING<i class="fa fa-arrow-right" aria-hidden="true"></i><span glot-model="main_uplan_toplink">ランキング総合ページへ</span></A></div>';
}
if( $stage_id == 190209){
	echo '<div class="season_botton" style="background-color:#555;"><A style="display:block;width:100%;height:100%;" href="./4001">PRESS START<i class="fa fa-arrow-right" aria-hidden="true"></i>'.$array_stage_title[4001].'</A></div>';
}
if( $stage_id == 4060){
	echo '<div class="season_botton" style="background-color:#555;"><A style="display:block;width:100%;height:100%;" href="./190321">THANK YOU FOR PLAYING<i class="fa fa-arrow-right" aria-hidden="true"></i><span glot-model="main_uplan_toplink">ランキング総合ページへ</span></A></div>';
}
if( $stage_id == 190321){
	echo '<div class="season_botton" style="background-color:#555;"><A style="display:block;width:100%;height:100%;" href="./4031">PRESS START<i class="fa fa-arrow-right" aria-hidden="true"></i>'.$array_stage_title[4001].'</A></div>';
}
