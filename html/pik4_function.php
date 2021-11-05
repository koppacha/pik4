<?php
// 関数の定義
// 改行を削除する
function br2nl($string){
	return preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "\n", $string);
}
// 巨大生物をたおせ！のスコア変換（サイドストーリーモードの一部を含む）
function bossscore_enc($stage_id, $score){
	$value=0;
	if($stage_id == 311) $value = 420 - $score;
	if($stage_id == 312) $value = 900 - $score;
	if($stage_id == 313) $value = 780 - $score;
	if($stage_id == 314) $value = 600 - $score;
	if($stage_id == 315) $value = 900 - $score;
	if($stage_id == 316) $value = 720 - $score;
	if($stage_id == 356) $value = 720 - $score;
	if($stage_id == 359) $value = 840 - $score;
	if($stage_id == 361) $value = 780 - $score;
	if($stage_id ==2311) $value = 420 - $score;
	if($stage_id ==2312) $value = 900 - $score;
	if($stage_id ==2313) $value = 780 - $score;
	if($stage_id ==2314) $value = 600 - $score;
	if($stage_id ==2315) $value = 900 - $score;
	if($stage_id ==2316) $value = 720 - $score;
	if($stage_id ==2356) $value = 720 - $score;
	if($stage_id ==2359) $value = 840 - $score;
	if($stage_id ==2361) $value = 780 - $score;

	return $value;
}
// 秒数をM:SS表記に変換する
function time_enc($time){
	$hours = floor($time / 3600);
	$minutes = floor(($time / 60) % 60);
	$seconds = $time % 60;
	if($hours < 1) $show = sprintf("%02d:%02d", $minutes, $seconds);
	else $show = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
	return $show;
}
// 読み込み時間計測
function loadtime_calc($val){
	global $time_c;
	global $time_start;
	global $loadtime_echo;
	$time_c = microtime(true) - $time_start;
	$loadtime_echo[] = " <br>".$val. "行目：{$time_c} 秒";
}
// 数値を序数詞つきの文字列に変換する
function ordinalNumber($num){
	$n = $num % 10;
	$t = floor($num / 10) % 10;
		
	if($t === 1){
		return $num . "th";
	} else {
		switch($n) {
		case 1:
			return $num . "st";
		case 2:
			return $num . "nd";
		case 3:
			return $num . "rd";
		default:
			return $num . "th";
		}
	}
}
// バトルモードレーティング計算式
function battle_rd_calc($win, $p1r, $p2r){ // 勝敗、自分のレート��相手のレート
	$a = 30 - 30*( tan( ($p1r - 1500 )/1000 )* 0.6); // レートから増減基礎ポイント（偏差）を求める
	$b = ($p1r - $p2r)/ $a;				 // レート差から付加ボーナスを求める
	if($win == 1){
		$c = $p1r + $a - $b;
	} elseif($win == 2){
		$c = $p1r - $a + $b;
	} else {
		$c = $p1r;
	}
	return $c;
}
// 正式ステージ名から「#」を削除する関数（エリア踏破戦は英語非対応）
function fixed_stage_title($stage_id){
	global $array_stage_title, $array_stage_title_raw, $array_stage_title_fixed;
	if($stage_id >= 3000 and $stage_id <= 3999){
		$needle = strpos($array_stage_title_raw[$stage_id] , '#');
		if($needle > 0 ) $needle = $needle + 1;
		$fixed_stage_title = mb_substr($array_stage_title_raw[$stage_id] , $needle);
	} elseif(isset($array_stage_title[$stage_id])){
		$needle = strpos ($array_stage_title[$stage_id] , '#');
		if($needle > 0 ) $needle = $needle + 1;
		$fixed_stage_title = '<span glot-model="array_stage_title'.$stage_id.'">'.mb_substr ( $array_stage_title[$stage_id] , $needle ).'</span>';
	} elseif(isset($array_stage_title_fixed[$stage_id])){
		$fixed_stage_title = $array_stage_title_fixed[$stage_id];
	} else {
		$fixed_stage_title = "";
	}
	return $fixed_stage_title;
}
// 新ハイスコア一覧出力テーブル（バトルモード以外専用）
function topscore_board_tab2($stage_list, $hook, $hook2 = 9999){
	global $stage_id, $topscorelist, $array_theme_color, $stage_hook;
	$color = $array_theme_color[$hook];
	$display = 'style="display:none;"';
	if($stage_id == $hook or $stage_hook == $hook or ($stage_id == 6 and ($hook == 25 or $hook == 35))) $display = '';
	if($stage_id == $hook2 or $stage_hook == $hook2 or ($stage_id == 6 and ($hook2 == 25 or $hook2 == 35))) $display = '';
	$count = count($stage_list);
	// trを差し込む場所を定義：10で割った切り上げ数を行数とし、最終行以外の列数は総数÷行数の切り上げ。最終行は余りが入る
	$rows = ceil($count / 10);
	$pin = array(ceil($count / $rows));
	if($pin[0] == 10){
		$substr = 8;
	} else {
		$substr = 15;
	}
	if($rows > 2){
		for($i = 1; $i < $rows; $i++){
			$pin[] = $pin[$i - 1] + ceil($count / $rows);
		}
	}
	echo '<div class="scroll-wrap topscore top-score'.$hook.'" '.$display.'>'."\n";
	echo '<table class="series_nav">';
	echo '<tr>';
	foreach($stage_list as $key => $stage){
		if($stage_id != $stage){
			$peint = '#777';
		} else {
			$peint = $color;
		}
		$title_stage_title = preg_replace('/<.*?>/', '', fixed_stage_title($stage) );
		if(mb_strlen($title_stage_title) > $substr){
			$tale = '…';
		} else {
			$tale = '';
		}
		// チャレンジ複合と第1～2回参加者企画は規定範囲に収まらないので特別に別の翻訳ブロックを使う
		if($hook == 93 or $hook == 94 or $hook == 190209 or $hook == 190321){
			echo '<td><A href="./'.$stage.'" title="'.$title_stage_title.'"><div style="white-space:nowrap;color:#111111;background-color:'.$peint.';"><span glot-model="array_stage_title_fixed'.$stage.'">'.mb_substr($title_stage_title, 0, $substr).$tale.'</span></div>';
		} else {
			echo '<td><A href="./'.$stage.'" title="'.$title_stage_title.'"><div style="white-space:nowrap;color:#111111;background-color:'.$peint.';"><span glot-model="array_stage_title'.$stage.'">'.mb_substr($title_stage_title, 0, $substr).$tale.'</span></div>';
		}
		if(isset($topscorelist[$stage]['user_name'])){
			if(strlen($topscorelist[$stage]['user_name']) > ($substr * 3)){
				echo mb_substr($topscorelist[$stage]['user_name'],0 ,$substr).'…<br>';
			} else {
				echo $topscorelist[$stage]['user_name'].'<br>';
			}
		}
		if(isset($topscorelist[$stage]['score'])){
			if(($stage > 10000 and $stage < 20000) or ($stage > 310 and $stage < 317) or ($stage > 2310 and $stage < 2317) or $stage == 356 or $stage == 359 or $stage == 361 or $stage == 2356 or $stage == 2359 or $stage == 2361){
				if($stage < 10000){
					$decode_score = bossscore_enc($stage, $topscorelist[$stage]['score']);
				} else {
					$decode_score = $topscorelist[$stage]['score'];
				}
				$score_sec = sprintf('%02d', fmod ( $decode_score , 60) );
				$score_min = floor( $decode_score / 60);
				echo '('.$score_min.":".$score_sec.')';
			} else {
				echo '('.number_format($topscorelist[$stage]['score']).' pts.)';
			}
		} else {
				echo '-<br>-';
		}
		echo '</A></td>';
		if(array_search($key + 1, $pin) !== false){
			echo '</tr><tr>';
		}
	}
	echo '</tr>';
	echo '</table>';
	echo '</div>';
}
// ハイスコア一覧出力テーブル
function topscore_board_tab($val, $stage_id, $table_name, $hook, $hook2){ // 比較単位、クエリ、総合ページ名のID、背景色、第二所属ID
	global $array_stage_title, $mysqlconn, $array_theme_color, $stage_hook, $array_stage_title_fixed;
	$color = $array_theme_color[$hook];
	$stage_list = implode(" ,", $stage_id);
	if($val == "score") $user_sql = "SELECT * FROM `ranking` WHERE `stage_id` IN($stage_list) AND `log` = 0 AND `post_rank` = 1 ORDER BY `stage_id` ASC, `post_date` DESC";
	if($val == "rate")  $user_sql = "SELECT * FROM `battle` WHERE `stage_id` IN($stage_list) AND `log` = 0 AND `post_rank` = 1 ORDER BY  `stage_id` ASC, `post_date` DESC";
	$user_result = mysqli_query($mysqlconn, $user_sql);
	$topscore = array();
	$topuser = array();
	$topuser2 = array();
	while($user_row = mysqli_fetch_assoc($user_result) ){
		$top_score_stage = $user_row["stage_id"];
		$topscore[$top_score_stage] = $user_row[$val];
		$topuser[$top_score_stage] = $user_row["user_name"];
		if(isset($user_row["user_name_2p"])){
			$topuser2[$top_score_stage] = $user_row["user_name_2p"];
		} else {
			$topuser2[$top_score_stage] = "";
		}
	}
	$i = 0;
	$row = 2; // デフォルト行数を2行とする
	$cols2= 0;
	$sc   = count($stage_id);
	if($sc > 20){
		$row = 3;
		$cols = floor(count($stage_id) / $row) - 1;
		$cols2= $sc - $cols - 2;
		$substr = 2;
	}
	if($sc < 21 and $sc > 10){
		$row = 2;
		$cols = floor(count($stage_id) / $row);
		$substr = 10;
	}
	if($sc < 11){
		$row = 1;
		$cols = $sc - 1;
		$substr = 10;
	}
	$display = 'style="display:none;"';
	if($table_name == $hook or $stage_hook == $hook or ($table_name == 6 and ($hook == 25 or $hook == 35))) $display = '';
	if($table_name == $hook2 or $stage_hook == $hook2 or ($table_name == 6 and ($hook2 == 25 or $hook2 == 35))) $display = '';
	echo '<div class="scroll-wrap topscore top-score'.$hook.'" '.$display.'>'."\n";
//		echo '<div class="scroll-wrap">'."\n";
	echo '<table class="series_nav">';
	if($hook == 93) echo '<tr><td colspan="5">本編RTA</td><td colspan="2">ピクミン2 クリアタイム短縮</td></tr>';
	echo '<tr>'."\n";
	while($i <= $cols){

		if($stage_id[$i] > 10000){
			$short_stage_title = $array_stage_title_fixed[$stage_id[$i]];
		} else {
			$short_stage_title = mb_substr($array_stage_title[$stage_id[$i]], strpos($array_stage_title[$stage_id[$i]], '#') + 1, 9);
		}
		$title_stage_title[$stage_id[$i]] = preg_replace('/<.*?>/', '', $array_stage_title[$stage_id[$i]] );
		if($table_name < 100 or $table_name == $stage_id[$i]){
			echo '<td style="background-color:'.$color.';"><A style="color:#111111;" href="./'.$stage_id[$i].'" title="'.$title_stage_title[$stage_id[$i]].'">'.$short_stage_title.'</A></td>'."\n";
		} else {
			echo '<td style="background-color:#777;"><A style="color:#111;" href="./'.$stage_id[$i].'" title="'.$title_stage_title[$stage_id[$i]].'">'.$short_stage_title.'</A></td>'."\n";
		}
		$i++;
	}
	echo '</tr><tr>'."\n";
	$i = 0;
	while($i <= $sc - 1){
		if(!isset($topscore[$stage_id[$i]])){
			echo '<td>-</td>';
		} elseif($topscore[$stage_id[$i]] === 0) {
			echo '<td>-</td>';
		} else {
			if(($stage_id[$i] > 10000 and $stage_id[$i] < 20000) or ($stage_id[$i] > 310 and $stage_id[$i] < 317) or ($stage_id[$i] > 2310 and $stage_id[$i] < 2317)){
				if($stage_id[$i] < 10000){
					$decode_score = bossscore_enc($stage_id[$i], $topscore[$stage_id[$i]]);
				} else {
					$decode_score = $topscore[$stage_id[$i]];
				}
				$score_sec = sprintf('%02d', fmod ( $decode_score , 60) );
				$score_min = floor( $decode_score / 60);
				$show_score= $score_min.":".$score_sec ;
				echo '<td>'.$topuser[$stage_id[$i]].' <br>('.$show_score.')</td>';
			} elseif($stage_id[$i] > 2100 and $stage_id[$i] < 2400){
				echo '<td>'.$topuser[$stage_id[$i]].' <br>'.$topuser2[$stage_id[$i]].' <br>('.number_format($topscore[$stage_id[$i]]).' pts.)</td>'."\n";
			} else {
				echo '<td>'.$topuser[$stage_id[$i]].' <br>('.number_format($topscore[$stage_id[$i]]).' pts.)</td>'."\n";
			}
		}
		if(($i == $cols and $row > 1) or ($i == $cols2 and $row > 2)){
			echo '</tr><tr>';
			if($i == $cols) $q = $cols + 1;
			if($i == $cols2)$q = $cols2+ 1;
			while($q <= $i+$cols+1){
			if(isset($stage_id[$q])) $short_stage_title = mb_substr($array_stage_title[$stage_id[$q]], strpos($array_stage_title[$stage_id[$q]], '#') + 1, $substr);
			if($q < $sc){
				$title_stage_title[$stage_id[$q]] = preg_replace('/<.*?>/', '', $array_stage_title[$stage_id[$q]] );
				if($table_name < 100 or $table_name == $stage_id[$q]){
					echo '<td style="background-color:'.$color.';"><A style="color:#111111;" href="./'.$stage_id[$q].'" title="'.$title_stage_title[$stage_id[$q]].'">'.$short_stage_title.'</A></td>'."\n";
				} else {
					echo '<td style="background-color:#777;"><A style="color:#111;" href="./'.$stage_id[$q].'" title="'.$title_stage_title[$stage_id[$q]].'">'.$short_stage_title.'</A></td>'."\n";
				}
			}
			$q++;
			}
			echo '</tr><tr>'."\n";
		}
		$i++;
	}
	echo '</tr></table></div>'."\n";
}
// 合計点算出・登録関数
function total_score_calc($db, $column, $where, $point, $username){ // 使用するデータベース、登録カラム（returnの場合はDB登録せず値を返す）、抽出条件、抽出単位、ユーザー名
	global $mysqlconn;
	global $limited_pik1;
	$total_score = 0;
	if($db == "battle") $sql = "SELECT * FROM $db WHERE `user_name` = '$username' AND `log` = 0 AND `reague` > 0 AND $where ORDER BY `stage_id` DESC";
	if($db != "battle") $sql = "SELECT * FROM $db WHERE `user_name` = '$username' AND `log` = 0 AND $where ORDER BY `stage_id` DESC";
	$result = mysqli_query($mysqlconn, $sql);
	while ($row = mysqli_fetch_assoc($result) ){
		// 対象ステージがRTAの場合、基準点から引いた点数を加算する
		// 対象ステージが期間限定チャレンジまたは通常総合かつピクミン1チャレンジモードの場合、スコアを10倍して計算する
		if(($column == "total_point" and $row["stage_id"] > 100 and $row["stage_id"] < 106) or array_search($row["stage_id"], $limited_pik1)){
			$total_score = $total_score + ($row[$point] * 10);
		} else {
		$total_score = $total_score + $row[$point];
		}
	}
	if($column != 'return'){
		$query_rps = "UPDATE `user` SET $column = '$total_score' WHERE `user_name` = '$username'";
		$result_rps = mysqli_query($mysqlconn, $query_rps );
		if(!$result_rps) echo " <br>Error ".__LINE__."：合計点算出式でエラーが発生しています。リクエスト：$column ユーザー名：$username";
	} else {
		return $total_score;
	}
}
// シーズン別の合計点算出・登録関数
function total_season_calc($point, $column, $where, $username){ // 抽出条件、登録カラム名、集計カラム名、ユーザー名
	global $mysqlconn;
	global $season;
	global $limited_pik1;
	$total_score = 0;
	foreach($where as $val){
		$sql = "SELECT * FROM `ranking` WHERE `user_name` = '$username' AND `log` < 2 AND `season` = $season AND `stage_id` = $val ORDER BY `score` DESC LIMIT 1";
		$result = mysqli_query($mysqlconn, $sql);
		$row = mysqli_fetch_assoc($result);
		if(isset($row[$point])) $total_score += $row[$point];
	}
	$query_rps = "UPDATE `user` SET $column = '$total_score' WHERE `user_name` = '$username'";
	$result_rps = mysqli_query($mysqlconn, $query_rps );
	if(!$result_rps) echo " <br>Error ".__LINE__."：合計点算出式でエラーが発生しています。リクエスト：$column ユーザー名：$username";
}
// 2Pモード専用合計点算出計算式（1P2P問わずそのプレイヤーが参加したランキングのうち同ステージ最高スコアのみ加算する）
function total_score2calc($db, $column, $where, $point, $username, $score_return = false){ // 抽出条件、登録カラム（retuenの場合はDB登録せず値を返す）、集計カラム名、ユーザー名
	global $mysqlconn;
	global $limited_pik1;
	$total_score = 0;
	$stage_dup_check =array();
	$sql = "SELECT * FROM $db WHERE (`user_name` = '$username' OR `user_name_2p` = '$username') AND `log` < 2 AND $where ORDER BY `stage_id` ASC, `score` DESC";
	$result = mysqli_query($mysqlconn, $sql);
	while ($row = mysqli_fetch_assoc($result) ){
		if(array_search($row["stage_id"], $stage_dup_check) === false){ // スコア降順で取得し、もっとも高いスコアのみ加算する
			$total_score = $total_score + $row[$point];
			$stage_dup_check[] = $row["stage_id"];
		}
	}
	if($column != 'return'){
		$query_rps = "UPDATE `user` SET $column = '$total_score' WHERE `user_name` = '$username'";
		$result_rps = mysqli_query($mysqlconn, $query_rps );
		if(!$result_rps) echo " <br>Error ".__LINE__."：合計点算出式でエラーが発生しています。リクエスト：$column ユーザー名：$username";
	} else {
		return $total_score;
	}
}
// ステージリスト生成関数
function nav_stagelist_echo($cap, $select, $color, $substr, $subcap){
	global $st_count_val;
	global $array_stage_title;
	global $limited_final_stage;
	if(!$subcap) echo '<span class="nav_caption">'.$cap.'</span> <br>'."\n";
	if( $subcap) echo '['.$cap.'] <br>'."\n";
	echo '<ul class="nav">'."\n";
	foreach($select as $value){
		if(!$substr) $stage_title = $array_stage_title[$value];
		// 英語版で表示が崩れるので暫定対応★
//		if( $substr) $stage_title = substr($array_stage_title[$value], 6);
		if( $substr) $stage_title = $array_stage_title[$value];
		if(!isset($st_count_val[$value])) $post_count = "";
		if( isset($st_count_val[$value])) $post_count = " [".$st_count_val[$value]."]";
		echo '<li><A href="./'.$value.'"><span style="color:'.$color.';">◆</span>'.$stage_title.$post_count.'</A></li>'."\n";
	}
	echo '</ul>';
}
// Twitter APIで取得した情報をHTML変換 参考：http://qiita.com/yokoh9/items/760e432ebd39040d5a0f
function disp_tweet($value, $text){
    $icon_url = $value->user->profile_image_url;
    $screen_name = $value->user->screen_name;
    $updated = date('Y/m/d H:i', strtotime($value->created_at));
    $tweet_id = $value->id_str;
    $url = 'https://twitter.com/' . $screen_name . '/status/' . $tweet_id;

    echo '<div class="tweetbox">' . PHP_EOL;
    echo '<div class="thumb">' . '<img alt="" src="' . $icon_url . '">' . '</div>' . PHP_EOL;
    echo '<div class="meta"><a target="_blank" href="' . $url . '">' . $updated . '</a>' . '<br>@' . $screen_name .'</div>' . PHP_EOL;
    echo '<div class="tweet">' . $text . '</div>' . PHP_EOL;
    echo '</div>' . PHP_EOL;
}
// Twitterの投稿IDを動画URLに変換
function twitter_videourl($url){
	global $twObj;
	$url = substr($url, strrpos($url, '/') + 1);
	$result = $twObj->get("statuses/show",["id"=>$url]);
	return $result->extended_entities->media[0]->video_info->variants[0]->url;
}
// DNS正引き結果が信頼できるかどうかをチェックする関数 参考：https://qiita.com/sounisi5011/items/ed6bb99f3d1bdb7db6a7
function is_reliable_host($hostname, $ip_address){
	$ip_list = false;
	if(filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
		$records = @dns_get_record($hostname, DNS_AAAA);
		if ($records){
			$ip_list = array_column($records, 'ipv6');
		}
	} elseif(filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)){
		$ip_list = gethostbynamel($hostname);
	}
	return($ip_list && in_array($ip_address, $ip_list, true));
}
// 中央値を算出 参考：http://php5memo.blog73.fc2.com/blog-entry-7.html
function median($list){
	sort($list);
	if (count($list) % 2 == 0){
		return (($list[(count($list)/2)-1]+$list[((count($list)/2))])/2);
	}else{
		return ($list[floor(count($list)/2)]);
	}
}
// ユーザー名を自動色分けする関数と配列 参考：https://php-archive.net/php/string2color/
$user_colors = array('#b4d73b', '#d7863b', '#d73b8a', '#a63bd7', '#3b41d7', '#3bb0d7', '#3bd796', '#d3d73b', '#b11e16', '#b11662', '#5816b1', '#1647b1', '#16b182', '#26b116', '#e3e69a', '#e6bd9a', '#e69ab9', '#d89ae6', '#a29ae6', '#9acce6', '#9ae6c2', '#ace69a');
function str2color($str, $user_colors){
		if($str == ""){
			return "#777777";
		} else {
    	$index = hexdec( substr(md5($str), 0, 15) ) % count($user_colors);
    	return $user_colors[$index];
		}
}
// ステージIDから親番号を算出する関数（期間限定・参加者企画専用）
// （それ以外のステージは $stage[$stage_id]["parent"]で出力可能）
function parent_stage_id($stage_id){
	global $stage, $limited_stage_list, $uplan_stage_list;
	$stage_id_slice = explode("#", $stage[$stage_id]['parent']);
	// 期間限定ランキングかどうかを判定
	$parent = array_search( end($stage_id_slice), $limited_stage_list);
	if($parent === false){
		$parent = array_search( end($stage_id_slice), $uplan_stage_list);
		if($parent === false){
			return end($stage_id_slice);
		}
	}
	return $parent;
}
// 日替わりチャレンジの定義
$today_challenge = array();
$diary_spflag = 0;
$diary_pik2  = array(245, 271, 251, 272, 264, 258, 273, 274, 254, 269, 270, 250, 246, 265, 247, 252, 259, 253, 267, 248, 268, 249, 255, 261, 262, 263, 266, 260, 256, 257);
$day30_month = array(2, 4, 6, 9, 11);
$get_L = date('L', $now_time);	// 閏年判定
$get_y = date('Y', $now_time);	// 4桁年
$get_m = date('n', $now_time);	// ゼロ詰めしない月
$get_date = date('md', $now_time);
$get_day  = date('j', $now_time);
if($get_L == 1 and $get_date == '0229') $diary_spflag = 1; 		// 閏年の2月29日は30日分も追加
if($get_L == 0 and $get_date == '0228') $diary_spflag = 2; 		// 平年の2月28日は29・30日分も追加
if($get_day == 31) $diary_spflag = 3; 					// 1・3・5・7・8・10・12月の月末はランダムに3ステージ選出

if($diary_spflag == 0) $today_challenge[] = $diary_pik2[$get_day-1];	// 上記以外は日にちでステージを決定する
if($diary_spflag == 1){
	$today_challenge[] = $diary_pik2[29-1];
	$today_challenge[] = $diary_pik2[30-1];
}
if($diary_spflag == 2){
	$today_challenge[] = $diary_pik2[28-1];
	$today_challenge[] = $diary_pik2[29-1];
	$today_challenge[] = $diary_pik2[30-1];
}
if($diary_spflag == 3){
	$rand_cha_seed[] = ((($get_y % 30) + 1 + $get_m) % 28) + 1;
	$rand_cha_seed[] = (($rand_cha_seed[0] + 7) % 28) + 1;
	$rand_cha_seed[] = (($rand_cha_seed[1] + 7) % 28) + 1;
	$today_challenge[] = $diary_pik2[$rand_cha_seed[0]];
	$today_challenge[] = $diary_pik2[$rand_cha_seed[1]];
	$today_challenge[] = $diary_pik2[$rand_cha_seed[2]];
}
// 翻訳準備
function array_translate($array, $name){
	foreach($array as $key => $val){
		$temp[$key] = '<span glot-model="'.$name.$key.'">'.$val.'</span>';
	}
	return $temp;
}
