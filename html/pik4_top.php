<?php
if( $page_type == 0 ){
	// フルスクリーン動画背景
	$video_cookie = $_COOKIE['video_toggle'];
		echo '<div id="top_wrapper_futter"></div>';
		echo '<div id="top_wrapper"></div>';
		echo '<div id="top_wrapper_back"> </div>';
	if(!$video_cookie){

		// ユーザーエージェントを取得し、モバイルの場合Videoタグを出力しない
		$ua_flag = 1;
		$ua = $_SERVER['HTTP_USER_AGENT'];
		if((strpos($ua,'iPhone')!==false)||(strpos($ua,'iPod')!==false)||(strpos($ua,'Android')!==false)) $ua_flag = 0;
		if($ua_flag){
			echo '<video controls="controls" muted id="video" style="mobile_hidden"></video>'."\n";
		}
	}
?>
<!--/ 携帯表示用スライドショー (→ver.2.30で廃止) /-->
   <div id="headImage" class="pc-hidden">
	      <ul>
<?php
		if($vsa_shuffle){
			$p = 1;
			foreach($video_src_array as $val){
				echo '<li><img src="https://chr.mn/_img/pik4/'.$val.'.jpg" alt="" /></li>'."\n";
				$p++;
			}
		} else {
//			echo ' <br>Error '.__LINE__.'：スライドショーの再生に失敗しました。';
		}
?>
	      </ul>
	   </div><!-- /#headImage -->
<div id="top_page_div" class="mobile-hidden">
<span class="top_sub_title" glot-model="main_sub_title">本家ブログ11周年企画 by @koppachappy</span> <br>
<span class="top_title" glot-model="main_title">ピクミンシリーズチャレンジモード大会</span> <br>
<span class="top_sub_title" glot-model="main_eng_title">The Leaderboards of Pikmin Series Challenge & Mission Mode</span> <br>
<span class="top_content">
<A href="./ピクチャレ大会へようこそ"><span glot-model="main_welcome">ようこそ</span></A> |
<A href="./1"><?= $array_stage_title_fixed[1] ?></A> |
<A href="./7"><?= $array_stage_title_fixed[7] ?></A> |
<A href="./9"><?= $array_stage_title_fixed[9] ?></A> |
<A href="./8"><?= $array_stage_title_fixed[8] ?></A> |
<A href="./91"><?= $array_stage_title_fixed[91] ?></A> |
<A href="./26"><?= $array_stage_title_fixed[26] ?></A> |
<A href="./92"><?= $array_stage_title_fixed[92] ?></A> |
<A href="./93"><?= $array_stage_title_fixed[93] ?></A> |
<A href="./94"><?= $array_stage_title_fixed[94] ?></A>
<table class="top_stage_table">
	<tr>
		<th style="vertical-align:middle;" rowspan="2"><A href="./10"><?= $array_stage_title_fixed[10] ?></A></td>
		<th colspan="3"><A href="./20"><?= $array_stage_title_fixed[20] ?></A></td>
		<th colspan="3"><A href="./30"><?= $array_stage_title_fixed[30] ?></A></td>
	</tr>
	<tr>
		<td style="text-align:center;"><A href="./21"><?= $array_stage_title_fixed[21] ?></A></td>
		<td style="text-align:center;" colspan="2"><A href="./22"><?= $array_stage_title_fixed[22] ?></A></td>
		<td style="text-align:center;"><A href="./31"><?= $array_stage_title_fixed[31] ?></A></td>
		<td style="text-align:center;"><A href="./32"><?= $array_stage_title_fixed[32] ?></A></td>
		<td style="text-align:center;"><A href="./33"><?= $array_stage_title_fixed[33] ?></A></td>
	</tr>
	<tr>
		<td>
		<?php
		// トップページのステージ一覧出力 ◆
		$main_table_stage_array = array(101, 102, 103, 104, 105, 201, 202, 205, 206, 207, 212, 217, 218, 220, 226, 228, 229, 230, 203, 204, 208, 209, 210, 211, 213, 214, 215, 216, 219, 221, 222, 223, 224, 225, 227, 301, 302, 303, 304, 305, 317, 318, 319, 320, 321, 327, 328, 329, 330, 331, 306, 307, 308, 309, 310, 322, 323, 324, 325, 326, 332, 333, 334, 335, 336, 311, 312, 313, 314, 315, 316);
		foreach($main_table_stage_array as $key => $val){
			echo '<A href="./'.$val.'"><span style="color:'.$array_theme_color[parent_stage_id($val)].';">◆</span>'.fixed_stage_title($val).'</A><br>';
			if($val == 105 or $val == 230 or $val == 215 or $val == 227 or $val == 331 or $val == 336) echo '</td><td>';
		}
		?>
		</td>
	</tr>
</table>

<!--/ <span class="mobile-hidden"> | <A href="javascript:void(0)" class="form_toggle">記録を投稿する</A></span> /-->
</span>
</div>
<div style="position:fixed;right:45%;bottom:0px;" class="mobile-hidden">
<A style="color:#ffffff;" href="#" onClick="VideoPause();"><span id="video_control" glot-model="main_video_stop">一時停止</span> | </A><A style="color:#ffffff;" href="#" onClick="VideoToggle();" glot-model="main_video_toggle">動画On/Off</A>
</div>
<div style="position:fixed;right:8px;bottom:0px;color:#aaaaaa;text-align:right;" class="mobile-hidden">
Since: 2007/04/29 (Rebuilding Date: 2015/09/01) <br>
<span glot-model="main_warning">このサイトは非公式であり、任天堂株式会社とは一切関係ありません。 </span><br>
Total: <Img src="https://chr.mn/_cgi/dayx_pik4_cha/dayx.cgi?gif">
Today: <Img src="https://chr.mn/_cgi/dayx_pik4_cha/dayx.cgi?today">
Yesterday: <Img src="https://chr.mn/_cgi/dayx_pik4_cha/dayx.cgi?yes">
</div>
<div id="video_info" class="mobile-hidden"> </div>
<?php
}
