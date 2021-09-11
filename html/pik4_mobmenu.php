<!--/ 携帯用メニューここから /-->
<div id="mobile_fixed_key1" class="pc-hidden mobile_fixed">
	<A href="#top">
		<i class="mfoot fa fa-arrow-up" aria-hidden="true"></i><span glot-model="mobile-menu1">先頭へ</span>
	</A>
</div>
<div id="mobile_fixed_key2" class="pc-hidden mobile_fixed"<?= $post_hidden; ?>>
<?php
if($page_type == 0 or $page_type == 1 or $page_type == 2 or $page_type == 5 or $page_type == 6 or $page_type == 9 or $page_type == 10 or $page_type == 13 or $page_type == 15 or $page_type == 17 or $page_type == 18 or $page_type == 20 or $page_type == 21 or $page_type > 97){
	echo '<A href="./9"><i class="mfoot fa fa-award" aria-hidden="true"></i><span glot-model="mobile-menu6">総合ランキング</span></A>';
} else {
	echo '<A href="javascript:void(0)" class="submenutoggle" style="cursor: pointer;"><i class="mfoot fa fa-paper-plane" aria-hidden="true"></i><span glot-model="mobile-menu2">投稿</span></A>';
}
?>
</div>
<div id="mobile_fixed_key3" class="pc-hidden mobile_fixed">
	<A href="javascript:void(0)" class="submenutoggle" style="cursor: pointer;">
		<i class="mfoot fa fa-list" aria-hidden="true"></i><span glot-model="mobile-menu3">メニュー</span>
	</A>
</div>
<div id="mobile_fixed_key4" class="pc-hidden mobile_fixed">
	<A href="./1">
		<i class="mfoot fas fa-meteor" aria-hidden="true"></i><span glot-model="array_stage_title_fixed1">新着記録</span>
	</A>
</div>
<div id="mobile_fixed_key5" class="pc-hidden mobile_fixed">
<?php
if($cookie_name == ''){
	echo '<A href="./"><i class="mfoot fas fa-home" aria-hidden="true"></i><span glot-model="mobile-menu5">トップページ</span></A>';
} else {
	echo '<A href="./<?php $cookie_name; ?>"><i class="mfoot fas fa-user-alt" aria-hidden="true"></i><span glot-model="mobile-menu4">マイページ</span></A>';
}
?>
</div>
<div id="wrapper_filter" class="blurhidden pc-hidden hidden"></div>

<select type="text" name="pulldown1" id="mobile_header_menu" class="pc-hidden" style="display:none;">

<option value="#" selected>LIST</option>
<option value="./" glot-model="menu_toplink">トップページ</option>

<option value="#" glot-model="menu_mobile_total">総合 ------------------------------ </option>
<option value="./ルール集" glot-model="menu_info_rule">ルール集</option>

<?php
// モバイルメニュー総合
$mobile_menu_list_total_array = array(1, 7, 8, 9, 10, 20, 21, 22, 23, 26, 27, 28, 30, 31, 32, 33, 91, 92, 93, 94);
foreach($mobile_menu_list_total_array as $val){
	echo '<option value="./'.$val.'">'.$array_stage_title[$val].'</option>'."\n";
}
?>
<option value="#"  　 >ステージ別 ----------------------- </option>
<?php
// モバイルメニューステージ別
$temp_array1 = range(101, 105);
$temp_array2 = range(201, 230);
$temp_array3 = range(301, 336);
$mobile_menu_list_stage_array = array_merge($temp_array1, $temp_array2, $temp_array3);
foreach($mobile_menu_list_stage_array as $val){
	$be = '';
	if(($val >= 306 and $val <= 310) or ($val >= 332 and $val <= 336)) $be = "（BE）";
	echo '<option value="./'.$val.'">'.$array_stage_title[$val].$be.'</option>';
}
?>
<option value="#"  　 >プレイヤー別 --------------------- </option>

<?php
	// 参加者総合ランキング簡易表示板（モバイル用）

	// テーブルを取得
	$sql = "SELECT * FROM `user` ORDER BY `total_rps` DESC LIMIT 100";
	$result = mysqli_query($mysqlconn, $sql);
	if (!$result) {
		echo " <br>Error ".__LINE__."：クエリの取得エラーが発生しています。";
	}
	$p = -1;
	$i =  0;
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
?>
</select>
<!--/ 携帯用メニューここまで /-->
