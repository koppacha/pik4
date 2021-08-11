<div class="pik4_table">
<?php
if(!$mysql_mode) loadtime_calc(__LINE__);
//ランキングヘッダー表示部 ここから
if( isset($_GET["s"]) or isset($_GET["u"]) ){

	$stage_sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$stage_id'";
	$result = mysqli_query($mysqlconn, $stage_sql);
	if (!$result) {
		echo " <br>Error ".__LINE__."：クエリの取得エラーが発生しています。";
	}
	if($result) $stage_row = mysqli_fetch_assoc($result);

	// カテゴリ番号の分割処理
	$page_row = '';		// タグ表示の定義
	$stage_cat = 0;
	if ( $stage_row["parent"] != 0){
		if(strstr($stage_row["parent"], '#') !== false){
			$parent_split = explode("#", $stage_row["parent"]);
			$stage_hook = end($parent_split); // ナビゲーション表示用に所属カテゴリを取得しておく
			$stage_cat = $parent_split[0];    // ナビゲーション表示用に所属カテゴリを取得しておく
			foreach($parent_split as $val){
			if($val < 100) $ui_tip = substr($val ,0 ,1);	// 2桁の場合は先頭文字をシリーズと見なす
			if($val >  99) $ui_tip = "l";			// 期間限定の場合はクラス「ui_pl」を適用
//			$page_row .=  '<span class="user_info ui_p'.$ui_tip.'"><A href="./'.$val.'">'.$array_stage_title_fixed[$val].'</A></span>';
			}
		} else {
			$stage_hook = $stage_row["parent"];
			$stage_cat  = $stage_row["parent"];
			if($stage_row["parent"] < 100) $ui_tip = substr($stage_row["parent"] ,0 ,1);	// 2桁の場合は先頭文字をシリーズと見なす
			if($stage_row["parent"] >  99) $ui_tip = "l";					// 期間限定の場合はクラス「ui_pl」を適用
//			$page_row .=  '<span class="user_info ui_p'.$ui_tip.'"><A href="./'.$stage_row["parent"].'">'.$array_stage_title_fixed[$stage_row["parent"]].'</A></span>';
		}
	} else {
		$stage_hook = 0;
	}

	// 過去のチーム対抗にアクセスしている場合はチーム色の定義を変える（本体部の後ろまで有効）
	if(isset($limited_stage_list[$limited_num]) || $limited_num == 0){
		// 未定義エラー回避不能のためエラー制御演算子でカバー
		if( $stage_id != @$limited_stage_list[$limited_num]){
			if($stage_id == 170211){
				$team_a = 3;
				$team_b = 4;
			} elseif($stage_id == 170325){
				$team_a = 5;
				$team_b = 6;
			} elseif($stage_id == 170429){
				$team_a = 7;
				$team_b = 8;
			} elseif($stage_id == 171013){
				$team_a = 9;
				$team_b = 10;
			} elseif($stage_id == 180101){
				$team_a = 11;
				$team_b = 12;
			} elseif($stage_id == 200723){
				$team_a = 13;
				$team_b = 14;
			} elseif($stage_id == 200918){
				$team_a = 15;
				$team_b = 16;
			} elseif($stage_id <= 170101){
				$team_a = 1;
				$team_b = 2;
			}
		}
		if($stage_id >= 3066 and $stage_id <= 3095){
			$team_a = 13;
			$team_b = 14;
		} elseif($stage_id >= 3096 and $stage_id <= 3112) {
			$team_a = 15;
			$team_b = 16;
		}
	}
	//ステージ種別を表示
	$sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$stage_id'";
	$result = mysqli_query($mysqlconn, $sql);
	if (!$result) {
		echo " <br>Error ".__LINE__."：クエリの取得エラーが発生しています。";
	}
	$row = mysqli_fetch_assoc($result);
	$fixed_stage_sub = '<A href="./'.$stage_hook.'"><font class="rtd_eng_stage_name">'.$stage_row["stage_sub"]."</font></A> <br>\n";

	// 個別ページ情報を取得
	if( $page_type == 9 ){
		$sql = "SELECT * FROM `note` WHERE `post_title` = '$user_name'";
		$result = mysqli_query($mysqlconn, $sql);
		$note = mysqli_fetch_assoc($result);
	} elseif($page_type == 15){
		$sql = "SELECT * FROM `note` WHERE `tag` = '$user_name'";
		$tagpage = mysqli_query($mysqlconn, $sql);
	} else {
	}
	//概要・ヘッダー部分表示
	if($page_type != 5 && $page_type != 9 && $page_type != 15){

		$fixed_stage_title = fixed_stage_title($stage_id);
	}
	    if ( $page_type == 1     		    ) $page_header = '<div class="rtd_main"><div class="rtd_head"><span glot-model="main_head_special">◆特殊スコアリスト</span> <br><h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 3    		    ) $page_header = '<div class="rtd_main"><div class="rtd_head">#'.$stage_id.' <br>'.$fixed_stage_sub.'<h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 4    		    ) $page_header = '<div class="rtd_main"><div class="rtd_head">#'.$stage_id.' <br>'.$fixed_stage_sub.'<h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 5    		    ) $page_header = '<div class="rtd_main"><div class="rtd_head"><span glot-model="main_head_user">◆ユーザー別スコアリスト</span> <br><h1 class="rtd_stage_caption">'.htmlspecialchars($user_name, ENT_QUOTES).'</h1>' ;
	elseif ( $page_type == 6		    ) $page_header = '<div class="rtd_main"><div class="rtd_head">'.$fixed_stage_sub.'<h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 7		    ) $page_header = '<div class="rtd_main"><div class="rtd_head"><span glot-model="main_head_story">◆本編ランキング</span> <br><h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 8    		    ) $page_header = '<div class="rtd_main"><div class="rtd_head">#'.$stage_id.' <br>'.$fixed_stage_sub.'<h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 9		    ) $page_header = '<div class="fp_main"><div class="rtd_head"><span glot-model="main_head_note">◆個別ページ</span> > <A href="./'.$note["tag"].'">'.$note["tag"].'</A> <br><h1 class="rtd_stage_caption">'.$note["post_title"].'</h1><hr size="1"/> <br>';
	elseif ( $page_type == 10		    ) $page_header = '<div class="rtd_main"><div class="rtd_head">'.$fixed_stage_sub.'<h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 11   		    ) $page_header = '<div class="rtd_main"><div class="rtd_head">#'.$stage_id.' <br>'.$fixed_stage_sub.'<h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 12   		    ) $page_header = '<div class="rtd_main"><div class="rtd_head">#'.$stage_id.' <br>'.$fixed_stage_sub.'<h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 13		    ) $page_header = '<div class="rtd_main"><div class="rtd_head">'.$fixed_stage_sub.'<h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 14		    ) $page_header = '<div class="rtd_main"><div class="rtd_head"><span glot-model="main_head_mix">◆チャレンジモード複合</span> <br><h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 15		    ) $page_header = '<div class="fp_main"><div>◆ノート <br>' ;
	elseif ( $page_type == 16		    ) $page_header = '<div class="fp_main"><div class="rtd_head"><span glot-model="main_head_battle">◆バトルモードランキング</span> <br><h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 17		    ) $page_header = '<div class="fp_main"><div class="rtd_head"><span glot-model="main_head_battle_total">◆バトルモード戦績</span> <br><h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 18		    ) $page_header = '<div class="rtd_main"><div class="rtd_head"><span glot-model="main_head_offlineevent">◆ピクチャレ大会オフラインイベント</span> <br><h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 19		    ) $page_header = '<div class="rtd_main"><div class="rtd_head"><span glot-model="main_head_limited">◆期間限定ランキング</span> <br><h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $page_type == 20		    ) $page_header = '<div class="rtd_main"><div class="rtd_head"><span glot-model="main_head_single">◆記録個別ページ</span> <br><h1 class="rtd_stage_caption">ID:'.$stage_id.'</h1>' ;
	elseif ( $page_type == 21		    ) $page_header = '<div class="rtd_main"><div class="rtd_head"><span glot-model="main_head_userplan">◆参加者企画</span> <br><h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
	elseif ( $stage_id   > 6 AND $stage_id < 100) $page_header = '<div class="rtd_main"><div class="rtd_head"><span glot-model="main_head_total">◆総合ランキング</span> <br><h1 class="rtd_stage_caption">'.$array_stage_title[$stage_id].'</h1>' ;
	elseif ( $stage_id  == 9     		    ) $page_header = '<div class="rtd_main"><div class="rtd_head"><span glot-model="main_head_total">◆総合ランキング</span> <br><h1 class="rtd_stage_caption">'.$array_stage_title[9].'</h1>' ;
	else     $show_scoretable = 0;
	echo $page_header ;

	//英語名・副題・補足情報を表示
	if ( $page_type == 5 ){
		// ログイン名＝ユーザーページならユーザー証明コードを表示
		$sql = "SELECT `` FROM `user` WHERE ";
		if($user_name === $cookie_name or $cookie_name === "木っ端ちゃっぴー"){
			$user_code = substr( sprintf( "%.0f", hexdec( hash("sha256", $sys_ver.$user_name) ) ), 0, 10);
			echo '<span class="rtd_eng_stage_name">ユーザー証明コード（Proof code）：'.$user_code."</span> <br>\n";
		}
	} elseif(($page_type > 0 and $page_type < 9) or $page_type == 14 or $page_type == 12 or $page_type == 16){
		if($stage_row["eng_stage_name"]) echo '<span class="rtd_eng_stage_name">'.$stage_row["eng_stage_name"]."</span> <br>\n";
		if($history_id) echo '<span class="rtd_eng_stage_name">'.$array_stage_title[$history_id]."</span> <br>\n";
	}
	// フィルタリング設定の条件分岐
	if($page_type == 4) $season_data = "0"; // 期間限定ランキング表示時はシーズンモード機能を無効にする

	$whereand = '';						// 追加フィルタ条件 (form4)
	$whereand2= '';						// さらにフィルタ条件を追加 (form5)
	$whereand3= '';						// 未使用
	$orderby  = '`score` DESC';				// デフォルトの並び替え (通常)
	$log = '`log` = 0 ';					// デフォルトのログ表示
	$limitof  = ' LIMIT 100';
	if( $page_type == 5) $orderby = 'ORDER BY `stage_id` ASC';	// デフォルトの並び替え (ユーザー別)
	if( $stage_id  == 4) $orderby = 'ORDER BY `post_date` DESC';	// デフォルトの並び替え (カスタムリスト)
	if( $sort_data == 1) $orderby  = "ORDER BY `stage_id` ASC";
	if( $sort_data == 2) $orderby  = "ORDER BY `post_rank` ASC";
	if( $sort_data == 3) $orderby  = "ORDER BY `rps` DESC";
	if( $sort_data == 4) $orderby  = "ORDER BY `user_name` ASC";
	if( $sort_data == 5) $orderby  = "ORDER BY `score` DESC";
	if( $sort_data == 6) $orderby  = "ORDER BY `post_date` DESC";

	if( $filtering_data == 1) $whereand = "";
	if( $filtering_data == 2) $whereand = "AND `stage_id` BETWEEN 101 AND 105 ";
	if( $filtering_data == 3) $whereand = "AND `stage_id` BETWEEN 201 AND 230 ";
	if( $filtering_data == 4) $whereand = "AND `stage_id` BETWEEN 301 AND 336 ";
	if( $filtering_data == 5) $whereand = "AND `stage_id` IN(10101,10201,10202,10203,10204,10301,10302) ";
	if( $filtering_data == 6) $whereand = "AND `stage_id` BETWEEN 1001 AND '$limited_final_stage'";
	if( $filtering_data == 7) $whereand = "AND `stage_id` BETWEEN 231 AND 244 ";
	if( $filtering_data == 8) $whereand = "AND `stage_id` BETWEEN 245 AND 274 ";
	if( $filtering_data == 9) $whereand = "AND `stage_id` BETWEEN 2201 AND 2230 ";
	if( $filtering_data ==10) $whereand = "AND `stage_id` BETWEEN 2301 AND 2336 ";
	if( $filtering_data ==11) $whereand = "AND `stage_id` BETWEEN 10205 AND 10212 ";
	if( $filtering_data ==12) $whereand = "AND `stage_id` IN(201, 202, 205, 206, 207, 212, 217, 218, 220, 226, 228, 229, 230) ";
	if( $filtering_data ==13) $whereand = "AND `stage_id` IN(203, 204, 208, 209, 210, 211, 213, 214, 215, 216, 219, 221, 222, 223, 224, 225, 227) ";
	if( $filtering_data ==14) $whereand = "AND `stage_id` BETWEEN 101 AND 336 AND `stage_id` NOT BETWEEN 231 AND 299 ";
	if( $filtering_data ==15) $whereand = "AND `stage_id` NOT BETWEEN 101 AND 230 AND `stage_id` NOT BETWEEN 299 AND 336 ";

	if( $filtering_sub_data == 1) $whereand2 = "";
	if( $filtering_sub_data == 2) $whereand2 = "AND `console` = 1 ";
	if( $filtering_sub_data == 3) $whereand2 = "AND `console` = 2 ";
	if( $filtering_sub_data == 4) $whereand2 = "AND `console` = 3 ";
	if( $filtering_sub_data == 5) $whereand2 = "AND `console` = 4 ";
	if( $filtering_sub_data == 6) $whereand2 = "AND `console` = 5 ";
	if( $filtering_sub_data == 7) $whereand2 = "AND `console` = 6 ";
	if( $filtering_sub_data == 8) $whereand2 = "AND `console` = 7 ";
	if( $filtering_sub_data == 9) $whereand2 = "AND `console` = 8 ";
	if( $filtering_sub_data ==10) $whereand2 = "AND `console` = 9 ";
	if( $filtering_sub_data ==11) $whereand2 = "AND `console` =10 ";
	if( $filtering_sub_data ==12) $whereand2 = "AND `console` =11 ";
	if( $filtering_sub_data ==13) $whereand2 = "AND `console` BETWEEN 2 AND 5 ";
	if( $filtering_sub_data ==14) $whereand2 = "AND `console` BETWEEN 6 AND 11 ";
	if( $filtering_sub_data ==15) $whereand2 = "AND `console` = 6 OR `console` = 8 OR `console` = 10 ";
	if( $filtering_sub_data ==16) $whereand2 = "AND `console` = 7 OR `console` = 9 OR `console` = 11 ";

	if( $log_data == 2) $log = "`log` < 2 and `at_rank` = 1 ";
	if( $log_data == 3) $log = "`log` < 2 and `at_rank` = 10 ";
	if( $log_data == 4) $log = "`log` < 2 ";

	// 通常ランキングクエリを取得（優先度3）
	if ( $page_type == 3  ) $sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND ".$log.$whereand3.$whereand2."ORDER BY `score` DESC,`post_date` ASC";
	if ( $page_type == 4  ) $sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` DESC,`post_date` ASC";
	if ( $page_type == 7  ) $sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` ASC,`post_date` ASC";
	if ( $page_type == 14 ) $sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` ASC,`post_date` ASC";
	if ( $page_type == 8  ) $sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` DESC,`post_date` ASC";
	if ( $page_type == 11 ) $sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` DESC,`post_date` ASC";
	if ( $page_type == 12 ) $sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND ".$log."ORDER BY `score` DESC,`post_date` ASC";
	if ( $page_type == 16 ) $sql = "SELECT * FROM `battle` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `rate` DESC";
	if ( $page_type == 17 ) $sql = "SELECT * FROM `battle` ORDER BY `post_id` DESC";
	if ( $page_type == 19 ) $sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` DESC,`post_date` ASC";
	if ( $page_type == 20 ) $sql = "SELECT * FROM `ranking` WHERE `unique_id` = '$stage_id' ORDER BY `score` DESC,`post_date` ASC";

	// 履歴表示クエリ（優先度2）
	if ( $season_data == 2 ) $sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` < 2 AND `season` = '$season' ORDER BY `score` DESC,`post_date` ASC";
	if ( $page_type == 5  ) $sql = "SELECT * FROM `ranking` WHERE `user_name` = '$user_name' AND `log` = 0 AND `stage_id` != 299 "."$whereand"."$whereand2"."$orderby";
	if ( $page_type == 5 and $season_data == 2 ) $sql = "SELECT * FROM `ranking` WHERE `user_name` = '$user_name' AND `log` < 2 AND `season` = '$season'  "."$whereand"."$whereand2"."$orderby";
	if( $history_id  != '') $sql = "SELECT * FROM `ranking` WHERE `user_name` = '$user_id' AND `log` != 2 AND `stage_id` = '$history_id' ORDER BY `post_date` DESC LIMIT 100";

	// 原生の杜でフィルタリングテスト（優先度1.5）
	if( $page_type == 3 and $filtering_sub_data > 2){
		$sql = "SELECT * FROM `ranking` WHERE `log` < 2 AND `stage_id` = '$stage_id' "."$whereand2"."ORDER BY `score` DESC,`post_date` ASC";
		$separation_mode = 2;
	} else {
		$separation_mode = 0;
	}
	// 総合・特殊系テーブルクエリを取得（優先度1）
	if ( $stage_id  == 1  ) $sql = "SELECT * FROM `ranking` WHERE `log` = 0 AND `stage_id` != 399 ORDER BY `post_date` DESC LIMIT 100";
	if ( $stage_id  == 2  ) $sql = "SELECT * FROM `ranking` WHERE `log` < 2 AND `season` = '$season' AND `stage_id` != 399 ORDER BY `post_date` DESC LIMIT 100";
//	if ( $stage_id  == 2  ) $sql = "SELECT * FROM `ranking` WHERE `log` = 0 AND `stage_id` != 299 ORDER BY `rps` DESC LIMIT 100";
	if ( $stage_id  == 3  ) $sql = "SELECT * FROM `ranking` WHERE `log` = 0 AND `stage_id` != 299 AND `stage_id` BETWEEN 101 AND 999 AND `post_rank` = 1 ORDER BY `stage_id` ASC";
	if ( $stage_id  == 4  ) $sql = "SELECT * FROM `ranking` WHERE `log` = 0 AND `stage_id` != 299 "."$whereand"."$whereand2"."$orderby"." LIMIT 100";
	if ( $stage_id  == 5  ) $sql = "SELECT * FROM `stage_title` WHERE `stage_id` NOT IN(299,10100,10200,10300) ORDER BY `stage_id` ASC";
//	if ( $stage_id  == 8  ) $sql = "SELECT * FROM `user`  WHERE `total_point` != 0 ORDER BY `total_point` DESC";
	if ( $stage_id  == 7  ) $sql = "SELECT * FROM `user`  WHERE `total_all` != 0  ORDER BY `total_all` DESC";
	if ( $stage_id  == 8  ) $sql = "SELECT * FROM `user`  WHERE `total_sp` != 0  ORDER BY `total_sp` DESC";
	if ( $stage_id  == 9  ) $sql = "SELECT * FROM `user`  WHERE `total_rps` != 0  ORDER BY `total_rps` DESC";
	if ( $stage_id  == 10 ) $sql = "SELECT * FROM `user`  WHERE `total_pik1cha` != 0 ORDER BY `total_pik1cha` DESC";
	if ( $stage_id  == 20 ) $sql = "SELECT * FROM `user`  WHERE `total_pik2cha` != 0 ORDER BY `total_pik2cha` DESC";
	if ( $stage_id  == 21 ) $sql = "SELECT * FROM `user`  WHERE `total_pik2egg` != 0 ORDER BY `total_pik2egg` DESC";
	if ( $stage_id  == 22 ) $sql = "SELECT * FROM `user`  WHERE `total_pik2noegg` != 0 ORDER BY `total_pik2noegg` DESC";
	if ( $stage_id  == 23 ) $sql = "SELECT * FROM `user`  WHERE `total_pik2cave` != 0 ORDER BY `total_pik2cave` DESC";
	if ( $stage_id  == 24 ) $sql = "SELECT * FROM `user`  WHERE `total_pik2_2p` != 0 ORDER BY `total_pik2_2p` DESC";
	if ( $stage_id  == 25 ) $sql = "SELECT * FROM `user`  WHERE `total_battle2` != 0 ORDER BY `total_battle2` DESC";
	if ( $stage_id  == 26 ) $sql = "SELECT * FROM `user`  WHERE `total_new` != 0 ORDER BY `total_new` DESC";
	if ( $stage_id  == 27 ) $sql = "SELECT * FROM `user`  WHERE `season_pik2cha` != 0 ORDER BY `season_pik2cha` DESC";
	if ( $stage_id  == 28 ) $sql = "SELECT * FROM `user`  WHERE `total_new2` != 0 ORDER BY `total_new2` DESC";
	if ( $stage_id  == 30 ) $sql = "SELECT * FROM `user`  WHERE `total_pik3cha` != 0 ORDER BY `total_pik3cha` DESC";
	if ( $stage_id  == 31 ) $sql = "SELECT * FROM `user`  WHERE `total_pik3ct` != 0 ORDER BY `total_pik3ct` DESC";
	if ( $stage_id  == 32 ) $sql = "SELECT * FROM `user`  WHERE `total_pik3be` != 0 ORDER BY `total_pik3be` DESC";
	if ( $stage_id  == 33 ) $sql = "SELECT * FROM `user`  WHERE `total_pik3db` != 0 ORDER BY `total_pik3db` DESC";
	if ( $stage_id  == 34 ) $sql = "SELECT * FROM `user`  WHERE `total_pik3_2p` != 0 ORDER BY `total_pik3_2p` DESC";
	if ( $stage_id  == 35 ) $sql = "SELECT * FROM `user`  WHERE `total_battle3` != 0 ORDER BY `total_battle3` DESC";
	if ( $stage_id  == 36 ) $sql = "SELECT * FROM `user`  WHERE `total_pik3ss` != 0 ORDER BY `total_pik3ss` DESC";
	if ( $stage_id  == 81 ) $sql = "SELECT * FROM `user`  WHERE `total_unlimit` != 0 ORDER BY `total_unlimit` DESC";
	if ( $stage_id  == 82 ) $sql = "SELECT * FROM `user`  WHERE `total_tas` != 0 ORDER BY `total_tas` DESC";
	if ( $stage_id  == 91 ) $sql = "SELECT * FROM `user`  WHERE `total_limited000` != 0 ORDER BY `total_limited000` DESC";
	if ( $stage_id  == 92 ) $sql = "SELECT * FROM `user`  WHERE `total_diary` != 0 ORDER BY `total_diary` DESC";
	if ( $stage_id  == 93 ) $sql = "SELECT * FROM `user`  WHERE `total_story` != 0 ORDER BY `total_story` DESC";
	if ( $stage_id  == 94 ) $sql = "SELECT * FROM `user`  WHERE `total_mix` != 0 ORDER BY `total_mix` DESC";
	if ( $stage_id  == 95 ) $sql = "SELECT * FROM `user`  WHERE `battle_rate` != 0 ORDER BY `battle_rate` DESC";
	if ( $stage_id  == 98 ) $sql = "SELECT * FROM `user`  WHERE `post_count` != 0 ORDER BY `post_count` DESC";
	if ( $stage_id  == 99 ) $sql = "SELECT * FROM `minites`  WHERE `minites_count` != 0 ORDER BY `minites_count` DESC";
//	if ( $stage_id == 299  ) $sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` DESC";
	if ( $page_type == 10 ) $sql = "SELECT * FROM `user` WHERE `current_team` BETWEEN '$team_a' AND '$team_b'";
	if ( $page_type == 6 ){
		$target_db_num = sprintf('%03d', array_search($stage_id, $limited_stage_list) );
		$target_db = 'total_limited'.$target_db_num;
		$sql = "SELECT * FROM `user`  WHERE $target_db != 0 ORDER BY $target_db DESC";
	}
	if ( $page_type == 13 ){
		$target_db_num = sprintf('%03d', array_search($stage_id, $limited_stage_list) );
		$target_db = 'total_limited'.$target_db_num;
		$target_al = 'total_arealim'.$target_db_num;
		$sql = "SELECT * FROM `user`  WHERE $target_db != 0 or $target_al != 0 ORDER BY $target_db DESC";
	}
	if ( $page_type == 21 ){
		$target_db_num = sprintf('%03d', array_search($stage_id, $uplan_stage_list) );
		$target_db = 'total_uplan'.$target_db_num."rps";
		$sql = "SELECT * FROM `user`  WHERE $target_db != 0 ORDER BY $target_db DESC";
	}

	$result = mysqli_query($mysqlconn, $sql);
	if (!$result) {
		echo " <br>Error ".__LINE__."：クエリの取得エラーが発生しています。".var_dump($sql);
	}
	// 概要表示
	$rows_count = mysqli_num_rows($result);
	if($rows_count < 1) $rows_count = 0;
	if ( $stage_id  == 6 and $rows_count > 0) $rows_count = $rows_count/2;
	$echo_average = '';
	if($stage_id == 99){
		$count_cap = '<span glot-model="main_minites_kuji">くじを引いた総数</span>';
		$head_count = 0;
			$egg_sql = "SELECT * FROM `minites` ORDER BY `ID` DESC LIMIT 1";
			$egg_result = mysqli_query($mysqlconn, $egg_sql);
			$egg_row = mysqli_fetch_assoc($egg_result);
		$head_count = $egg_row["id"];
		$count_foot = '<span glot-model="main_kai">回</span>';
	} elseif($season_data == 2 or $separation_mode == 2 or $log_data > 1){
		$count_cap = '<span glot-model="main_postcount">投稿数</span>';
		$head_count = $rows_count;
		$count_foot = '<span glot-model="main_kai">回</span>';
	} else {
		$count_cap = '<span glot-model="main_playercount">参加人数</span>';
		$head_count = $rows_count;
		if($page_type == 5) $count_cap = '<span glot-model="main_displaycount">表示中のステージ数</span>';
		$count_foot = '<span glot-model="tail_nin">人</span>';
	}
	if ( $stage_id  != 9 ) $user_total_link = '<span class="user_info ui_p9"><A href="./9">'.$array_stage_title_fixed[9].'</A>';
//	if ( $stage_row["score_ave"] > 0 and !($stage_id >= $blind_start and $stage_id <= $blind_end)) $echo_average = '<span class="user_info ui_all">平均：'.$stage_row["score_ave"].'点</span>';
	if ( $page_type == 1 and $stage_id  != 5 ) $page_row .= '<span class="user_info ui_all"><span glot-model="main_recordcount">記録数</span>：'.$head_count.'</span>';
	if ( $stage_id  == 5 ) $page_row .= '<span class="user_info ui_all"><span glot-model="main_stagecount">ステージ数</span>：'.$rows_count.'</span>';
	if ( $stage_id  == 6 ) $page_row .= '<span class="user_info ui_all"><span glot-model="main_battlecount">総対戦回数</span>：'.$rows_count.'</span>';
	if ( $page_type == 2 ) $page_row .= $user_total_link.'</span><span class="user_info ui_all">'.$count_cap.'：'.$head_count.$count_foot.'</span>';
	if ( $page_type == 3 ) $page_row .= '<span class="user_info ui_all">'.$count_cap.'：'.$head_count.$count_foot.'</span>'.$echo_average;
	if ( $page_type == 4 ) $page_row .= '<span class="user_info ui_all">'.$count_cap.'：'.$head_count.$count_foot.'</span>'.$echo_average ;
	if ( $page_type == 5 ){
		$page_row .= '<span class="user_info ui_all">'.$count_cap.'：'.$head_count."</span>" ;
		$page_row .= '<A href="./98"><span class="user_info ui_all"><span glot-model="menu_cnt_total">総投稿数</span>：'.$user_row["post_count"]."</span></A>" ;
		// 初投稿日を取得
		$date_sql = "SELECT * FROM `ranking` WHERE `user_name` = '$user_name' ORDER BY `post_date` ASC LIMIT 1";
		$date_result = mysqli_query($mysqlconn, $date_sql);
		$date_row = mysqli_fetch_assoc($date_result);
		$first_post_date = date("Y/m/d", strtotime($date_row["post_date"]));
		if(strtotime($date_row["post_date"]) > strtotime("2007-04-28")){
			$page_row .= '<span class="user_info ui_all"><span glot-model="main_signupdate">登録日</span>：'.$first_post_date."</span>" ;
		}
		if(strtotime($user_row["lastupdate"]) > strtotime("2015-09-01")){
			$final_post_date = date("Y/m/d", strtotime($user_row["lastupdate"]));
			$page_row .= '<span class="user_info ui_all"><span glot-model="main_lastupdate">最終投稿日</span>：'.$final_post_date."</span>" ;
		}

		// タマゴムシくじハイスコア
		$mushi_sql = "SELECT * FROM `minites` WHERE `name` = '$user_name' ORDER BY `minites_count` DESC, `date` ASC LIMIT 1";
		$mushi_result = mysqli_query($mysqlconn, $mushi_sql);
		$mushi_row = mysqli_fetch_assoc($mushi_result);
		if($mushi_row["minites_count"] > 0){
			$page_row .= '<A href="./99"><span class="user_info ui_all"><span glot-model="menu_eggfortune">タマゴムシくじ</span>：'.$mushi_row["minites_count"].'<span glot-model="tail_hiki">匹</span></span></A>';
		}

	}
	if ( $page_type == 6 ) $page_row .= '<span class="user_info ui_all">'.$count_cap.'：'.$head_count.'<span glot-model="tail_nin">人</span></span>' ;
	if ( $page_type ==10 ){
		$limited_rank_target = sprintf('%03d', array_search($stage_id, $limited_stage_list));
		$target_db = 'total_limited'.$limited_rank_target;
		$rcount_query = "SELECT * FROM `user` WHERE $target_db != 0 ORDER BY $target_db DESC";
		$rcount_result = mysqli_query($mysqlconn, $rcount_query);
		$rows_count = mysqli_num_rows($rcount_result);
		$page_row .= '<span class="user_info ui_all"><span glot-model="main_playercount">参加人数</span>：'.$rows_count.'<span glot-model="tail_nin">人</span>'.$echo_average ;
	}
	if ( $page_type == 8 ) $page_row .= '<span class="user_info ui_all"><span glot-model="main_playercount">参加人数</span>：'.$rows_count.'<span glot-model="tail_nin">人</span></span>'.$echo_average ;
	if ( $page_type == 11) $page_row .= '<span class="user_info ui_all"><span glot-model="main_playercount">参加人数</span>：'.$rows_count.'<span glot-model="tail_nin">人</span></span>'.$echo_average ;
	if ( $page_type == 18) $page_row .= '<span class="user_info ui_all"><span glot-model="main_playercount">参加人数</span>：6<span glot-model="tail_nin">人</span></span>';
	if ( $page_type == 19) $page_row .= '<span class="user_info ui_all"><span glot-model="main_playercount">参加人数</span>：'.$rows_count.'<span glot-model="tail_nin">人</span></span>'.$echo_average ;
	if ( $page_type == 13) $page_row .= '<span class="user_info ui_all"><span glot-model="main_playercount">参加人数</span>：'.$rows_count.'<span glot-model="tail_nin">人</span></span>'.$echo_average ;
	if ( $page_type == 21) $page_row .= '<span class="user_info ui_all"><span glot-model="main_playercount">参加人数</span>：'.$rows_count.'<span glot-model="tail_nin">人</span></span>'.$echo_average ;

	// ユーザープロフィールを表示
	if($page_type == 5){
		if($users[$user_name]["website"]      != "") $page_row.= '<span class="user_info ui_all"><i class="fa fa-home" aria-hidden="true"></i><A style="color:#000;" href="'.$users[$user_name]["website"].'" nofollow="nofollow">'.$users[$user_name]["sitetitle"].'</A></span>' ;
		if($users[$user_name]["twitter"]      != "") $page_row.= '<span class="user_info ui_all"><i class="fab fa-twitter" aria-hidden="true"></i><A style="color:#000;" href="https://www.twitter.com/'.$users[$user_name]["twitter"].'" nofollow="nofollow">@'.$users[$user_name]["twitter"]."</A></span>" ;
		if($users[$user_name]["youtube"]      != "") $page_row.= '<span class="user_info ui_all"><i class="fab fa-youtube" aria-hidden="true"></i><A style="color:#000;" href="https://www.youtube.com/'.$users[$user_name]["youtube"].'" nofollow="nofollow">YouTube</A></span>' ;
		if($users[$user_name]["twitch"]       != "") $page_row.= '<span class="user_info ui_all"><i class="fab fa-twitch" aria-hidden="true"></i><A style="color:#000;" href="https://www.twitch.tv/'.$users[$user_name]["twitch"].'" nofollow="nofollow">Twitch</A></span>' ;
		if($users[$user_name]["nicovideo"]    != "") $page_row.= '<span class="user_info ui_all"><i class="fa fa-tv" aria-hidden="true"></i><A style="color:#000;" href="http://www.nicovideo.jp/'.$users[$user_name]["nicovideo"].'" nofollow="nofollow">niconico</A></span> <br>' ;
		if($users[$user_name]["fav_stage_id"] > 100) $page_row.= '<span class="user_info ui_all"><A style="color:#000;" href="./'.$users[$user_name]["fav_stage_id"].'"><span glot-model="form_conf_profile_fav">お気に入りステージ</span>：'.$array_stage_title[$users[$user_name]["fav_stage_id"]]."</A></span>" ;
	}

	if ( $history_id  != '') $page_row.= '<span class="user_info history_mode"><A href="javascript:void(0)" onclick="CookieReset2();"><span glot-model="main_historymode">ヒストリーモードで表示中 [クリックで解除]</span></A></span>';

	if ( $rows_count== 0 and $page_type > 0 and $page_type < 9 ) $page_row .= '<span class="user_info history_mode"><A href="javascript:void(0)" onClick="CookieReset()"><span glot-model="main_nodata">記録がありません！ [フィルターを解除]</span></A></span>';
	echo $page_row;

	// ユーザー情報表示
	if ($page_type == 5 ) {

	// 順位を取得する項目を配列に格納
//	$array_select_rank = array("total_rps", "total_pik1cha", "total_pik2cha", "total_pik2egg", "total_pik2noegg", "total_pik3cha", "total_pik3ct", "total_pik3be", "total_pik3db", "post_count", "total_pik2cave", "total_diary", "total_lim");
	$array_select_rank = array("total_rps", "total_pik1cha", "total_pik2cha", "total_pik2egg", "total_pik2noegg", "total_pik3cha", "total_pik3ct", "total_pik3be", "total_pik3db", "total_pik3ss", "total_limited000", "total_new", "total_new2", "total_diary", "total_story", "total_mix", "total_pik2_2p", "total_pik3_2p","battle_rate","total_sp");
	foreach ( $array_select_rank as $val){
		$rank_sql = "SELECT *, (SELECT COUNT(*) + 1 FROM `user` b WHERE b.$val > a.$val) AS `ranking` FROM `user` a WHERE `user_name` = '$user_name';";
		$rank_result = mysqli_query($mysqlconn, $rank_sql);
		if($rank_result){
			$rank_row = mysqli_fetch_assoc($rank_result);
			$array_rank[$val] = $rank_row["ranking"];
		}
	}
	// 参加人数を配列に格納
	foreach( $array_select_rank as $val){
		$rank_sql = "SELECT COUNT(*) AS playercount FROM `user` WHERE $val != 0";
		$rank_result = mysqli_query($mysqlconn, $rank_sql);
		if($rank_result){
			$rank_row = mysqli_fetch_assoc($rank_result);
			$array_pcount[$val] = $rank_row["playercount"];
		}
	}

//	// ユーザーのうち最高位を取っている総合ランキングにCLASSを付与 (投稿数のみ除外)
//	$array_pop  = array_pop( $array_rank );
//	$user_mytop = min( $array_rank );
//
//	foreach ( $array_select_rank as $val){
//		if($array_rank[$val] == $user_mytop){
//			$mytop[$val] = ' ui_top';
//		} else {
//			$mytop[$val] = '';
//		}
//	}
//
	$user_info_rps  = number_format( $user_row["total_rps"] );
//	$user_info_comm = number_format( $user_row["user_comment"] );
	$user_info_point= number_format( $user_row["total_point"] );
	$user_info_pik1 = number_format( $user_row["total_pik1cha"] );
	$user_info_pik2 = number_format( $user_row["total_pik2cha"] );
	$user_info_pik2e= number_format( $user_row["total_pik2egg"] );
	$user_info_pik2n= number_format( $user_row["total_pik2noegg"] );
	$user_info_pik3 = number_format( $user_row["total_pik3cha"] );
	$user_info_pik3c= number_format( $user_row["total_pik3ct"] );
	$user_info_pik3b= number_format( $user_row["total_pik3be"] );
	$user_info_pik3d= number_format( $user_row["total_pik3db"] );
	$user_info_pik3s= number_format( $user_row["total_pik3ss"] );
	$user_info_cnt  = number_format( $user_row["post_count"] );

//	if($user_info_rps  > 0) echo '<span class="user_info ui_all'.$mytop["total_rps"].'" title="'.$user_info_rps.'pts.">総合: '.$array_rank["total_rps"]."位 (".$user_info_rps.' pts.)</span> ';
//	if($user_info_pik1 > 0) echo '<span class="user_info ui_p1'.$mytop["total_pik1cha"].'" title="'.$user_info_pik1.'pts.">ピクミン1: '.$array_rank["total_pik1cha"]."位 (".$user_info_pik1.' pts.)</span> ';
//	if($user_info_pik2 > 0) echo '<span class="user_info ui_p2'.$mytop["total_pik2cha"].'" title="'.$user_info_pik2.'pts.">ピクミン2: '.$array_rank["total_pik2cha"]."位 (".$user_info_pik2.' pts.)</span> ';
//	if($user_info_pik2e > 0) echo '<span class="user_info ui_p2'.$mytop["total_pik2egg"].'" title="'.$user_info_pik2e.'pts.">タマゴあり: '.$array_rank["total_pik2egg"]."位 (".$user_info_pik2e.' pts.)</span> ';
//	if($user_info_pik2n > 0) echo '<span class="user_info ui_p2'.$mytop["total_pik2noegg"].'" title="'.$user_info_pik2n.'pts.">タマゴなし: '.$array_rank["total_pik2noegg"]."位 (".$user_info_pik2n.' pts.)</span> ';
//	if($user_info_pik3 > 0) echo '<span class="user_info ui_p3'.$mytop["total_pik3cha"].'" title="'.$user_info_pik3.'pts.">ピクミン3: '.$array_rank["total_pik3cha"]."位 (".$user_info_pik3.' pts.)</span> ';
//	if($user_info_pik3c > 0) echo '<span class="user_info ui_p3'.$mytop["total_pik3ct"].'" title="'.$user_info_pik3c.'pts.">お宝: '.$array_rank["total_pik3ct"]."位 (".$user_info_pik3c.' pts.)</span> ';
//	if($user_info_pik3b > 0) echo '<span class="user_info ui_p3'.$mytop["total_pik3be"].'" title="'.$user_info_pik3b.'pts.">原生: '.$array_rank["total_pik3be"]."位 (".$user_info_pik3b.' pts.)</span> ';
//	if($user_info_pik3d > 0) echo '<span class="user_info ui_p3'.$mytop["total_pik3db"].'" title="'.$user_info_pik3d.'sec.">ボス: '.$array_rank["total_pik3db"]."位 (".$user_info_pik3d.' sec.)</span> ';
//	if($user_info_cnt  > 0) echo '<span class="user_info ui_all" title="'.$user_info_cnt.'">投稿数: '.$array_rank["post_count"]."位 (".$user_info_cnt.' 回)</span>';
//
//	$user_sql = "SELECT * FROM `minites`  WHERE `name` = '$user_name' ORDER BY `minites_count` DESC LIMIT 1";
//	$user_result = mysqli_query($mysqlconn, $user_sql);
//	$user_row = mysqli_fetch_assoc($user_result);
//
//	if($user_row["minites_count"]  > 0) echo '<span class="user_info ui_all">くじ: '.$user_row["minites_count"]."匹</span>";
	}
	echo '</div>';
	// ユーザープロフィールを表示
	if($page_type == 5){
		echo '<p class="stage_summary"> <br>'.$user_row["user_comment"] .'</p>';
	}

	// ステージ解説文
	if(isset($array_stage_summary[$stage_id])){
		echo '<p class="stage_summary"> <br>'.$array_stage_summary[$stage_id] .'</p>';
//		if($page_type != 10) echo '<br style="clear:both;" />'."\n";
	}
	// Google広告
	// echo '
	// <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	// <!-- 特設5_汎用 -->
	// <ins class="adsbygoogle"
	// style="display:block"
	// data-ad-client="ca-pub-6104103083960859"
	// data-ad-slot="2420735930"
	// data-ad-format="auto"
	// data-full-width-responsive="true"></ins>
	// <script>
	// (adsbygoogle = window.adsbygoogle || []).push({});
	// </script>
	// ';

	// 関連ステージへのリンク集
	$head_link = array();
		// 1Pモード
		if(($stage_id > 2200 and $stage_id < 2231) or ($stage_id > 2300 and $stage_id < 2337) or ($stage_id > 2348 and $stage_id < 2363)){
			$single_link_id = $stage_id - 2000;
			$head_link[] = '<A style="color:#000;" href="./'.$single_link_id.'"><i class="fa fa-user"></i>'.$array_stage_title[$single_link_id].'</A>';
		}
		// 1Pモード
		if($stage_id > 5017 and $stage_id < 5048){
			$single_link_id = $stage_id - 4817;
			$head_link[] = '<A style="color:#000;" href="./'.$single_link_id.'"><i class="fa fa-user"></i>'.$array_stage_title[$single_link_id].'</A>';
		}
		// 1Pモード
		if($stage_id > 5047 and $stage_id < 5079){
			$single_link_id = $stage_id - 4847;
			$head_link[] = '<A style="color:#000;" href="./'.$single_link_id.'"><i class="fa fa-user"></i>'.$array_stage_title[$single_link_id].'</A>';
		}
		// 2Pモード
		if(($stage_id > 200 and $stage_id < 231) or ($stage_id > 300 and $stage_id < 337) or ($stage_id > 348 and $stage_id < 363)){
			$multi_link_id = $stage_id + 2000;
			$head_link[] = '<A style="color:#000;" href="./'.$multi_link_id.'"><i class="fa fa-users"></i>'.$array_stage_title[$multi_link_id].'</A>';
		}
		// 2Pモード
		if($stage_id > 5017 and $stage_id < 5048){
			$multi_link_id = $stage_id - 2817;
			$head_link[] = '<A style="color:#000;" href="./'.$multi_link_id.'"><i class="fa fa-users"></i>'.$array_stage_title[$multi_link_id].'</A>';
		}
		// 2Pモード
		if($stage_id > 5047 and $stage_id < 5079){
			$multi_link_id = $stage_id - 2847;
			$head_link[] = '<A style="color:#000;" href="./'.$multi_link_id.'"><i class="fa fa-users"></i>'.$array_stage_title[$multi_link_id].'</A>';
		}
		// 無差別級
		if($stage_id > 200 and $stage_id < 231){
			$multi_link_id = $stage_id + 4817;
			$head_link[] = '<A style="color:#000;" href="./'.$multi_link_id.'"><i class="fas fa-lemon"></i>'.$array_stage_title[$multi_link_id].'</A>';
		}
		// 無差別級
		if($stage_id > 2200 and $stage_id < 2231){
			$multi_link_id = $stage_id + 2817;
			$head_link[] = '<A style="color:#000;" href="./'.$multi_link_id.'"><i class="fas fa-lemon"></i>'.$array_stage_title[$multi_link_id].'</A>';
		}
		// 無差別級
		if($stage_id > 5047 and $stage_id < 5078){
			$multi_link_id = $stage_id - 30;
			$head_link[] = '<A style="color:#000;" href="./'.$multi_link_id.'"><i class="fas fa-lemon"></i>'.$array_stage_title[$multi_link_id].'</A>';
		}
		// TAS
		if($stage_id > 200 and $stage_id < 231){
			$multi_link_id = $stage_id + 4847;
			$head_link[] = '<A style="color:#000;" href="./'.$multi_link_id.'"><i class="fas fa-star-of-david"></i>'.$array_stage_title[$multi_link_id].'</A>';
		}
		// TAS
		if($stage_id > 2200 and $stage_id < 2231){
			$multi_link_id = $stage_id + 2847;
			$head_link[] = '<A style="color:#000;" href="./'.$multi_link_id.'"><i class="fas fa-star-of-david"></i>'.$array_stage_title[$multi_link_id].'</A>';
		}
		// TAS
		if($stage_id > 5017 and $stage_id < 5048){
			$multi_link_id = $stage_id + 30;
			$head_link[] = '<A style="color:#000;" href="./'.$multi_link_id.'"><i class="fas fa-star-of-david"></i>'.$array_stage_title[$multi_link_id].'</A>';
		}
		if($head_link){
			echo '<br><div style="background-color:#eeeeee;border-radius:2px;margin-bottom:2px;">';
			echo '<table style="table-layout:fixed;width:100%;"><tr>';
			foreach($head_link as $str){
				echo '<td style="text-align:center;">'.$str.'</td>';
			}
			echo '</tr></table>';
			echo '</div>';
		}
	// 前後ステージへのリンク
	// 特殊処理対象：101、105、201、244、301、336
	if($page_type == 3 or $page_type == 16 or $page_type == 12){
		$prev_stage_id = $stage_id - 1;
		$next_stage_id = $stage_id + 1;
		$both_stage_view = 0;
		if($prev_stage_id == 200) $prev_stage_id = 105;
		if($prev_stage_id == 274) $prev_stage_id = 244;
		if($prev_stage_id == 300) $prev_stage_id = 284;
		if($prev_stage_id == 348) $prev_stage_id = 336;
		if($prev_stage_id == 2300)$prev_stage_id = 2230;
		if($prev_stage_id == 2348)$prev_stage_id = 2336;
		if($next_stage_id == 106) $next_stage_id = 201;
		if($next_stage_id == 245) $next_stage_id = 275;
		if($next_stage_id == 285) $next_stage_id = 301;
		if($next_stage_id == 337) $next_stage_id = 349;
		if($next_stage_id == 2231)$next_stage_id = 2301;
		if($next_stage_id == 2337)$next_stage_id = 2349;

		if($stage_id > 100  and $stage_id < 363 and $stage_id != 299) $both_stage_view = 1; // 通常ステージ＋本編地下チャレンジ
		if($stage_id > 2200 and $stage_id < 2363		    ) $both_stage_view = 1; // 2Pモード
		if($stage_id > 5017 and $stage_id < 5069		    ) $both_stage_view = 1; // 実機無差別級＆TAS
		if($prev_stage_id != 100 and $prev_stage_id != 2200) $prev_stage_view = 1;
		if($next_stage_id != 363 and $next_stage_id != 2363) $next_stage_view = 1;

		if($stage_id > 244 and $stage_id < 275) $both_stage_view = 0;

		if( $both_stage_view == 1 and $prev_stage_view == 1){
			$head_link_left = '<div style="float:left;"><A style="display:block;" href="./'.$prev_stage_id.'"><i class="fa fa-arrow-circle-left"></i>'.$array_stage_title[$prev_stage_id].'</A></div>'."\n";
		} else {
			$head_link_left = '';
		}
		if( $both_stage_view == 1 and $next_stage_view == 1){
			$head_link_right = '<div style="float:right;text-align:right;"><A style="display:block;" href="./'.$next_stage_id.'">'.$array_stage_title[$next_stage_id].' <i class="fa fa-arrow-circle-right"></i></A></div>'."\n";
		} else {
			$head_link_right = '';
		}
		echo '<table class="head_link_tab" style="table-layout:fixed;"><tr><td>'.$head_link_left.'</td><td style="text-align:right;">'.$head_link_right.'</td></tr></table>';
	}
	// 新着順一覧の場合、人気ステージを表示
	if($stage_id == 1){
		echo '<table class="mobile-hidden" style="width:100%;table-layout:fixed;">';
		echo '<td style="text-align:center;">';
		$array_newrecord = array();
		echo '<b class="mobile-hidden" glot-model="main_trend">◆最近の流行ステージ</b> <br>';
		$limit_sql = "SELECT * FROM `ranking` WHERE `stage_id` != 399 AND `log` = 0 ORDER BY `post_date` DESC LIMIT 100";
		$limit_result = mysqli_query($mysqlconn, $limit_sql);
		while( $limit_row = mysqli_fetch_assoc($limit_result)){
			$array_newrecord[] = $limit_row["stage_id"];
		}
		$array_newrecord_cnt = array_count_values($array_newrecord);
		arsort($array_newrecord_cnt);
		$i = 0;
		$str = 0;
		echo '<table class="nr_td">';
		while($i < 10){
			$str = key($array_newrecord_cnt);
			echo "<tr><td>".$array_newrecord_cnt[$str].'</td><td><A href="./'.$str.'">'.$array_stage_title[$str]."</A></td></tr>";
			next($array_newrecord_cnt);
			$i++;
		}
		echo '</table>';
		echo '</td>';
/*
		echo '<td style="text-align:center;">';
		$array_newrecord = array();
		echo '<b class="mobile-hidden">◆去年の今頃の流行ステージ</b> <br>';
		$lastest_month = strtotime("-1 year", $now_time);
		$lastest_month_date = date('Y-m-d H:i:s', $lastest_month);
		$limit_sql = "SELECT * FROM `ranking` WHERE `post_date` < '$lastest_month_date' AND `stage_id` != 399 AND `log` = 0 ORDER BY `post_date` DESC LIMIT 100";
		$limit_result = mysqli_query($mysqlconn, $limit_sql);
		while( $limit_row = mysqli_fetch_assoc($limit_result)){
			$array_newrecord[] = $limit_row["stage_id"];
		}
		$array_newrecord_cnt = array_count_values($array_newrecord);
		arsort($array_newrecord_cnt);
		$i = 0;
		$str = 0;
		echo '<table class="nr_td">';
		while($i < 10){
			$str = key($array_newrecord_cnt);
			echo "<tr><td>".$array_newrecord_cnt[$str].'</td><td><A href="./'.$str.'">'.$array_stage_title[$str]."</A></td></tr>";
			next($array_newrecord_cnt);
			$i++;
		}
		echo '</table>';
		echo '</td>';
*/
		echo '<td style="text-align:center;">';
		$array_newrecord = array();
		echo '<b class="mobile-hidden" glot-model="main_activescore">◆アクティブユーザー総合ランキング</b> <br>';
		$limit_sql = "SELECT * FROM `ranking` WHERE `log` = 0 ORDER BY `post_date` DESC LIMIT 100";
		$limit_result = mysqli_query($mysqlconn, $limit_sql);
		while( $limit_row = mysqli_fetch_assoc($limit_result)){
			// 未定義エラーを潰せないのでエラー制御演算子でカバー
			@$array_newrecord[$limit_row["user_name"]] += $limit_row["rps"];
		}
		arsort($array_newrecord);
		$i = 0;
		$str = 0;
		echo '<table class="nr_td">';
		while($i < 10){
			$str = key($array_newrecord);
			echo "<tr><td>".number_format($array_newrecord[$str]).'</td><td><A href="./'.$str.'">'.$str."</A></td></tr>";
			next($array_newrecord);
			$i++;
		}
		echo '</table>';
		echo '</td>';

		echo '<td style="text-align:center;">';
		$array_newrecord = array();
		echo '<b class="mobile-hidden" glot-model="main_activepost">◆アクティブユーザー投稿数ランキング</b> <br>';
		$limit_sql = "SELECT * FROM `ranking` WHERE `log` = 0 ORDER BY `post_date` DESC LIMIT 100";
		$limit_result = mysqli_query($mysqlconn, $limit_sql);
		while( $limit_row = mysqli_fetch_assoc($limit_result)){
			$array_newrecord[] = $limit_row["user_name"];
		}
		$array_newrecord_cnt = array_count_values($array_newrecord);
		arsort($array_newrecord_cnt);
		$i = 0;
		$str = 0;
		echo '<table class="nr_td">';
		while($i < 10){
			$str = key($array_newrecord_cnt);
			echo "<tr><td>".$array_newrecord_cnt[$str].'</td><td><A href="./'.$str.'">'.$str."</A></td></tr>";
			next($array_newrecord_cnt);
			$i++;
		}
		echo '</table>';
		echo '</td>';

		echo '</tr></table>';
	}
	if(!$mysql_mode) loadtime_calc(__LINE__);
	require_once('pik4_nav.php');
}
	// ステージ情報を表示
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

if(!$mysql_mode) loadtime_calc(__LINE__);
// 一本勝負専用リンク
if( $stage_id > 4000 and $stage_id < 4030){
echo '<div class="scroll-wrap">';
echo '<table class="stagelist_tab">';
	echo '<tr><td glot-model="main_uplan_player">参加者名</td>';
	foreach($array_stage_title_veryshort as $val){
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
			if(isset($row["rps"])){
				echo $row["rps"];
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

// 一本勝負専用リンク
if( $stage_id > 4030 and $stage_id < 4061){
echo '<div class="scroll-wrap">';
echo '<table class="stagelist_tab">';
	echo '<tr><td glot-model="main_uplan_player">参加者名</td>';
	foreach($array_stage_title_veryshort as $val){
		echo '<td>'.$val.'</td>';
	}
	echo '<td glot-model="form_score_total">合計</td></tr>';
	foreach($array_member2 as $get2_user_name){
	echo '<tr>';
		echo '<td style="width:8em;">'.$get2_user_name.'</td>';
		foreach($limited190321 as $get2_stage_id){
		echo '<td>';
			$board_sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$get2_stage_id' AND `user_name` = '$get2_user_name' AND `log` = 0;";
			$board_result = mysqli_query($mysqlconn, $board_sql);
			$row = mysqli_fetch_assoc($board_result);
			if(isset($row["rps"])){
				echo $row["rps"];
			} else {
				echo "-";
			}
		echo '</td>';
		}
		echo '<td>';
		$rcount_query = "SELECT * FROM `user` WHERE `user_name` = '$get2_user_name'";
		$rcount_result = mysqli_query($mysqlconn, $rcount_query);
		$row = mysqli_fetch_assoc($rcount_result);
		if(isset($row["total_uplan002rps"])){
			echo $row["total_uplan002rps"];
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

if(!$mysql_mode) loadtime_calc(__LINE__);
// ピク杯概要表示（ステージIDに一致するパーツPHPをロードする）
if( $show_scoretable == 1 and $page_type == 18){
	$show_scoretable = 0;

	include "pikcup_".$stage_id.".php";
}

if(!$mysql_mode) loadtime_calc(__LINE__);

//エリア踏破戦テーブル本体表示部 ここから
if( $show_scoretable == 1 and ($page_type == 19)){

$search = array_search($stage_id, array_column($area, 'stage_id')) + 1;
echo '<table class="series_nav"><tr><td style="background-color:#777;" glot-model="main_nav_team_border">ボーダースコア</td><td style="background-color:#777;" glot-model="main_nav_team_exborder">EXボーダー</td><td style="background-color:#777;" glot-model="main_nav_team_numofplayer">必要人数</td><td style="background-color:#777;" glot-model="main_nav_team_borderover">ボーダー突破人数</td></tr>';
echo '<tr><td>'.$area[$search]['border_score'].'</td><td>'.$area[$search]['ex_border_score'].'</td><td>'.$area[$search]['border_rank'].'</td><td>'.$area[$search]['break_count'].'</td></tr>';
echo '</table>';
}
// 期間限定ランキングトップページ（エリア踏破戦）
if($page_type == 13){
}

// バトルモード最新戦歴テーブル本体 ここから
if( $show_scoretable == 1 and $page_type == 17){
	$row_count = 1;
	echo '<table class="pik4_teamtab">';
	$sql = "SELECT * FROM `battle` ORDER BY `post_id` DESC LIMIT 200";
	$result = mysqli_query($mysqlconn, $sql);
	while( $row = mysqli_fetch_assoc($result)){
		if($row["playside"] == 1){
			$get_stage_id = $row["stage_id"];
			$get_reague = $row["reague"];
			$post_date = $row["post_date"];
			$get_post_date = substr( $post_date , 0 , 10);
			$get_post_time = substr( $post_date , 11, 8 );
			$needle = strpos ($array_stage_title[$get_stage_id] , '#');
			if($needle > 0 ) $needle = $needle + 1;
			$fixed_stage_title = mb_substr ( $array_stage_title[$get_stage_id] , $needle );

			// 証拠写真有無の判別
			if(!isset($row["pic_file"])){
				$pic_file_url = "";
			} elseif(!$row["pic_file"]){
				$pic_file_url = "";
			} else {
				$pic_file_url = '<A href="../_img/pik4/uploads/'.$row["pic_file"].'" data-lity="data-lity"><i class="fa fa-camera"></i></A>';
			}

			// 証拠動画有無の判別
			$video_link = "";
			if(!isset($row["video_url"])){
				$video_link = "";
			} elseif( !$row["video_url"]){
				$video_link = "";
			} elseif( strpos($row["video_url"], "youtu")) {
				$video_link = '<A href="'.$row["video_url"].'" data-lity="data-lity"><i class="fab fa-youtube"></i></A>';
			} else {
				$video_link = '<A href="'.$row["video_url"].'" target="_brank"><i class="fab fa-youtube"></i></A>';
			}

			$player1_res  = $row["result"];
			$player1_name = $row["user_name"];
			$player1_win  = $row["win"];
			$player1_rate = $row["rate"];
			$player1_lose = $row["lose"];
			$player1_draw = $row["draw"];
			$player1_rank = $row["post_rank"];
			$player1_comm = $row["post_comment"];
			$score_float = round($row["rate"], 3);
			$score_int   = floor($row["rate"]);
			$score_deci  = sprintf('%03d', round(($score_float - $score_int) * 1000, 0));
			$player1_rate= $score_int.'<span class="score_tale">.'.$score_deci.'</span>';
		}
		if($row["playside"] == 2){
			$player2_res  = $row["result"];
			$player2_name = $row["user_name"];
			$player2_win  = $row["win"];
			$player2_rate = $row["rate"];
			$player2_lose = $row["lose"];
			$player2_draw = $row["draw"];
			$player2_rank = $row["post_rank"];
			$player2_comm = $row["post_comment"];
			$score_float = round($row["rate"], 3);
			$score_int   = floor($row["rate"]);
			$score_deci  = sprintf('%03d', round(($score_float - $score_int) * 1000, 0));
			$player2_rate= $score_int.'<span class="score_tale">.'.$score_deci.'</span>';
		}
		if($player1_res < $player2_res){
			$team_center_style = 'width:20%;background-color:#555555;text-align:center;border-left:solid 10px #f7f078;border-right:solid 10px #444444;';
		} elseif($player2_res < $player1_res){
			$team_center_style = 'width:20%;background-color:#555555;text-align:center;border-left:solid 10px #444444;border-right:solid 10px #f7f078;';
		} else {
			$team_center_style = 'width:20%;background-color:#555555;text-align:center;border-left:solid 10px #999999;border-right:solid 10px #999999;';
		}
		if($row_count % 2 == 0){
			echo '<tr>
				<td style="width:40%;text-align:right;border-bottom-left-radius:4px;"><span class="rtd2_player">'.$player1_name.'</span> <br>
				<span class="rtd2_score">'.$player1_rate.'</span> <br>'.$player1_win.'<span glot-model="main_battle_win">勝</span>'.$player1_lose.'<span glot-model="main_battle_lose">敗</span>'.$player1_draw.'<span glot-model="main_battle_draw">分</span>（'.$player1_rank.'<span glot-model="rank_tail">位</span>） <br>
				'.$player1_comm.'</td>
				<td style="'.$team_center_style.'"><span style="font-size:1.0em;font-weight:bold;"><span style="font-size:0.7em;color:#bbbbbb;">'.$array_reague_icon[$get_reague].'</span> <br>
				#'.$get_stage_id.' <br>'.$fixed_stage_title.' <br></span><font class="rtd_date">'.$get_post_date.'</font> <font class="rtd_time'.$new_record_flag.'">'.$get_post_time.'</font> <br>'.$pic_file_url.$video_link.'</td>
				<td style="width:40%;border-bottom-right-radius:4px;"><span class="rtd2_player">'.$player2_name.'</span> <br>
				<span class="rtd2_score">'.$player2_rate.'</span> <br>'.$player2_win.'<span glot-model="main_battle_win">勝</span>'.$player2_lose.'<span glot-model="main_battle_lose">敗</span>'.$player2_draw.'<span glot-model="main_battle_draw">分</span>（'.$player2_rank.'<span glot-model="rank_tail">位</span>） <br>
				<span glot-model="no_comment">コメントなし</span></td>
			</tr>';
		}
		$row_count++;
	}
	echo "</table></div></div>";
	$show_scoretable = 0;
}
if(!$mysql_mode) loadtime_calc(__LINE__);

//チーム対抗テーブル本体表示部 ここから
if( $show_scoretable == 1 and ($page_type == 10 or $stage_id == 200723 or $stage_id == 200918)){

	$team1_win = 0;		// 左チームの勝利数
	$team2_win = 0;		// 右チームの勝利数
	$compare_score = 0;	// スコア差
	${'team'.$team_a.'_score'} = 0;	// 左チームの合計スコア
	${'team'.$team_b.'_score'} = 0;	// 右チームの合計スコア

	// スコアテーブル本体
	$table_row_num = 1;
	${'rps'.$team_a} = 0;
	${'rps'.$team_b} = 0;
	$array_count = count(${'limited'.$stage_id});
	if($page_type == 10 or $stage_id == 200723 or $stage_id == 200918){
		foreach(${'limited'.$stage_id} as $get_limstage){
			$get_stage_title = $array_stage_title[$get_limstage];
			$get_stage_title2= str_replace('#',' <br>', $get_stage_title);
			$get_stage_title3= str_replace('（',' <br>（', $get_stage_title2);
			$stage_title     = str_replace('[',' <br>[', $get_stage_title3);
			$i = $team_a;
			while($i <= $team_b){
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

				// スコア表示を加工
				if(${'row'.$i}["score"] > 0){
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
				} else {
					$date_hook = ${'row'.$i}["post_date"];
				}
				${'get_post_date'.$i} = substr( $date_hook , 0 , 10);
				${'get_post_time'.$i} = substr( $date_hook , 11, 8 );

				// 使用コントローラーの判別
				if (${'row'.$i}["console"]){
					$get_console = ${'row'.$i}["console"];
					${'console_type'.$i} = '['.$array_console[$get_console].'] ';
				} else {
					${'console_type'.$i} = '';
				}
				// 証拠写真有無の判別
				if(! ${'row'.$i}["pic_file"] or(${'row'.$i}["stage_id"] >= $blind_start and ${'row'.$i}["stage_id"] <= $blind_end) ){
					${'pic_file_url'.$i} = "";
				} else {
					${'pic_file_url'.$i} = '<A href="../_img/pik4/uploads/'.${'row'.$i}["pic_file"].'" data-lity="data-lity"><i class="fa fa-camera"></i></A>';
					if(${'row'.$i}["pic_file2"] ) ${'pic_file_url'.$i} .= '<A href="../_img/pik4/uploads/'.${'row'.$i}["pic_file2"].'" data-lity="data-lity"><i class="fa fa-camera"></i></A>';
				}

				// 証拠動画有無の判別
				if(!isset($row["video_url"])){
					$video_link = "";
				} elseif( strpos($row["video_url"], "youtu")) {
					$video_link = '<A href="'.$row["video_url"].'" data-lity="data-lity"><i class="fab fa-youtube"></i></A>';
				} else {
					$video_link = '<A href="'.$row["video_url"].'" target="_brank"><i class="fab fa-youtube"></i></A>';
				}

				// 投稿IDの付与
				if(${'row'.$i}["unique_id"]){
					${'tag_link'.$i} = '<i class="fa fa-tag tooltip" title="POST ID: '.${'row'.$i}["unique_id"].'"></i>';
				} else {
					${'tag_link'.$i} = '';
				}
				// 通常ランキングテーブルを流用ここまで
			$i++;
			}
			// 勝者判定結果を集計＆中央セルのスタイル指定に反映＆スコア差を計算（トップスコア比較）
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
			if(${'row'.$team_a}["score"] < 1 or ${'row'.$team_b}["score"] < 1) $compare_score = 0;
			if($compare_score > 0){
				if($stage_id > 170429) $compare = '<span style="color:#'.$teamc[$team_a].'">'.$stage_rps[$team_a].'</span> - <span style="color:#'.$teamc[$team_b].'">'.$stage_rps[$team_b]."</span>";
				if($stage_id < 170429) $compare = '<span style="color:#'.$teamc[$compare_style].'">[+'.$compare_score.']</span>';
			} else {
				if($stage_id > 170429) $compare = '<span style="color:#'.$teamc[$team_a].'">'.$stage_rps[$team_a].'</span> - <span style="color:#'.$teamc[$team_b].'">'.$stage_rps[$team_b]."</span>";
				if($stage_id < 170429) $compare = '';
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

			$row_output[$table_row_num] = '<tr><td style="width:40%;text-align:right;border-bottom-left-radius:4px;"><span class="rtd2_player">'.${'row'.$team_a}["user_name"].'</span> <br>';
			$row_output[$table_row_num].= '<span class="rtd2_score">'.${'score_lim'.$team_a}.'</span> <br><span id="id-'.${'row'.$team_a}["unique_id"].'" class="rtd_other">'.${'get_post_date'.$team_a}.' <span class="mobile-hidden" style="color:#cccccc;">'.${'get_post_time'.$team_a}.'</span> '.${'console_type'.$team_a}.${'pic_file_url'.$team_a}.${'video_link'.$team_a}.${'tag_link'.$team_a}.'</span> <br>';
			$row_output[$table_row_num].= '<span class="rtd_other">'.${'row'.$team_a}["post_comment"].'</span></td>';
			$row_output[$table_row_num].= '<td style="'.$team_center_style.'"><span style="font-size:1.0em;font-weight:bold;">'.$imp_str.'<A style="display:block;" href="./'.$get_limstage.'">#'.$stage_title.' <br>'.$compare.'</A></span></td>';
			$row_output[$table_row_num].= '<td style="width:40%;border-bottom-right-radius:4px;"><span class="rtd2_player">'.${'row'.$team_b}["user_name"].'</span> <br>';
			$row_output[$table_row_num].= '<span class="rtd2_score">'.${'score_lim'.$team_b}.'</span> <br><span id="id-'.${'row'.$team_b}["unique_id"].'" class="rtd_other">'.${'tag_link'.$team_b}.${'video_link'.$team_b}.${'pic_file_url'.$team_b}.${'console_type'.$team_b}.${'get_post_date'.$team_b}.' <span class="mobile-hidden" style="color:#cccccc;">'.${'get_post_time'.$team_b}.'</span></span> <br>';
			$row_output[$table_row_num].= '<span class="rtd_other">'.${'row'.$team_b}["post_comment"].'</span></td>';

			$table_row_num++;
		}
	}
	// 少数チームへのハンディキャップを処理
	if($stage_id == 200723 or $stage_id == 200918){
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
	if($stage_id == 200723 or $stage_id == 200918){
		// 第15回は処理しない
		
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
		}
	}
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
	echo '<table class="team_info_tab"><tr>';
	echo '<td style="width:20%;text-align:center;vertical-align:top;'.$background_color.'">';
	echo '<span style="color:#'.$teamc[$team_a].'" class="team_point">'.${'rps'.$team_a}.'</span>';
	echo ' <br>';
	if(!$blind) echo '<span style="color:#'.$teamc[$team_a].'" class="team_point_mini">.'.${'team'.$team_a.'_score'}.'</span></td>';
	if( $blind) echo '<span style="color:#'.$teamc[$team_a].'" class="team_point_mini">.?????</span></td>';

	echo '<td style="'.$top_float.'width:30%;text-align:center;vertical-align:top;'.$background_color.'" class="mobile-hidden">';
	echo '<b style="color:#'.$teamc[$team_a].'">◆'.$team[$team_a].'◆</b> <br>';
	$last_postcount = ($player_total * 2) - $leftside_count;
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
		if($is_minority == 1 and $stage_id == 170429) echo '<tr title="総投稿数が少ないチームに{参加者数÷2}の切り捨てを付与" style="color:#'.$teamc[$team_a].'"><td glot-model="main_limited_bonus">(ボーナス)</td><td>'.$minority_bonus.' RPS</td><td>['.$post_diff.']</td><td>- pts.</td></tr>';
		if($is_minority == 1 and $stage_id != 170429 and $stage_id != 171013) echo '<tr style="color:#'.$teamc[$team_a].'"><td glot-model="main_limited_bonus">(ボーナス)</td><td>'.$minority_bonus.' RPS</td><td>- pts.</td></tr>';
		if($is_minority == 1 and $stage_id == 171013) echo '<tr style="color:#'.$teamc[$team_a].'"><td glot-model="main_limited_bonus">(ボーナス)</td><td>'.$minority_bonus.' <br><span class="att">RPS</span></td><td>- <br><span class="att">pts.</span></td></tr>';
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
	$right_postcount = ($player_total * 2) - $rightside_count;
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
		if($is_minority == 2 and $stage_id == 170429) echo '<tr title="総投稿数が少ないチームに{参加者数÷2}の切り捨てを付与" style="color:#'.$teamc[$team_b].'"><td glot-model="main_limited_bonus">(ボーナス)</td><td>'.$minority_bonus.' RPS</td><td>['.$post_diff.']</td><td>- pts.</td></tr>';
		if($is_minority == 2 and $stage_id != 170429 and $stage_id != 171013) echo '<tr style="color:#'.$teamc[$team_b].'"><td glot-model="main_limited_bonus">(ボーナス)</td><td>'.$minority_bonus.' RPS</td><td>- pts.</td></tr>';
		if($is_minority == 2 and $stage_id == 171013) echo '<tr style="color:#'.$teamc[$team_b].'"><td glot-model="main_limited_bonus">(ボーナス)</td><td>'.$minority_bonus.' <br><span class="att">RPS</span></td><td>- <br><span class="att">pts.</span></td></tr>';
	} else {
		echo '<tr><td colspan="4" glot-model="main_limited_noplayer">(まだ参加者がいません)</td></tr>';
	}
	echo '</table>';

	echo '<td style="width:20%;text-align:center;vertical-align:top;'.$background_color.'">';
	echo '<span style="color:#'.$teamc[$team_b].'" class="team_point">'.${'rps'.$team_b}.'</span>';
	echo '<br>';
	if(!$blind) echo '<span style="color:#'.$teamc[$team_b].'" class="team_point_mini">.'.${'team'.$team_b.'_score'}.'</span></td>';
	if( $blind) echo '<span style="color:#'.$teamc[$team_b].'" class="team_point_mini">.?????</span></td>';

	echo '</td></tr></table>';
	// チーム対抗戦ここまで

	// 総合ヘッダーここまで

	// スコアテーブル本体部 ★暫定 全ステージオープンしたら解禁する
	if($stage_id == 999999){ // 開催中の期間限定ランキング
		echo '<table id="team_tab" class="pik4_teamtab" style="margin-top:0.5em;">'."\n";
		echo '</table></div></div>';
	} else {
		echo '<table id="team_tab" class="pik4_teamtab" style="margin-top:0.5em;">'."\n";
		foreach($row_output as $output)	echo $output."\n";
		echo '</table></div></div>';
	}

	if($stage_id == 200723 or $stage_id == 200918) echo '</div>';

	$show_scoretable = 0;
}
if(!$mysql_mode) loadtime_calc(__LINE__);
//　通常スコアテーブル本体表示ここから
if( $show_scoretable == 1 and $page_type != 0 and $page_type != 10 and $page_type != 18 and $page_type != 9 and $page_type != 15){

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
	if($page_type == 0 or $page_type == 1 or $page_type == 2 or $page_type == 5 or $page_type == 6 or $page_type == 9 or $page_type == 10 or $page_type == 13 or $page_type == 15 or $page_type == 17 or $page_type == 18 or $page_type == 20 or $page_type == 21 or $page_type > 97){
	} else {
		echo '<A href="#form" style="display:block;">
		<div class="form_button pc-hidden">
			<div class="holder">
				<div class="first"></div>
				<div class="second"></div>
				<div class="third"></div>
				<div class="txt" style="text-align:center;margin:8px;width:96%;height:86px;background-color:#fff;border-radius:5px;">
					<div style="margin-top:24px;">
						<span style="border-bottom:solid 1px #777;color:#000;"><i class="faa-float animated fa fa-paper-plane" style="color:#000;" aria-hidden="true"></i>
						<span glot-model="menu_submit">このステージに投稿する</span></span> <br>　<span style="color:#555;font-size:0.9em;"><span glot-model="menu_submit_sub">　Submit Record</span></span>
					</div>
				</div>
			</div>
		</div></A>';
	}
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
	$sum_lest_score = array();// 比較値の合計
	$fixed_lest_score = array();// 修正比較値（合計点差産出用）
	$prev_score_hook = array();
	$overlap_name = array();
	$overrap_score = array();
	$hidden_flag = 0;
	$get_user_name = '';

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
					$comm_rank = $users[$comm_user_name]["{$val}_rank"];
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

			$show_score = number_format( $row['$target_db'] );
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

		// ランキングを表示（参加者企画）
		} elseif ( $page_type == 21) {
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
		if($stage_id > 9){
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
		if($row["post_rank"] > 0 and $season_data != 2) $sum_rank[] = $row["post_rank"];
		if($row["post_rank"] > 0 and ($season_data == 2 or $separation_mode == 2)) $sum_rank[] = $i;
		if($row["rps"]>0) $sum_rps[] = $row["rps"];
		if($row["score"]>0){
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

	echo '</table></div>';

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

	// Google広告汎用
	// echo '
	// <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	// <!-- 特設5_汎用 -->
	// <ins class="adsbygoogle"
	// style="display:block"
	// data-ad-client="ca-pub-6104103083960859"
	// data-ad-slot="2420735930"
	// data-ad-format="auto"
	// data-full-width-responsive="true"></ins>
	// <script>
	// (adsbygoogle = window.adsbygoogle || []).push({});
	// </script>
	// ';
	
	if($page_type == 20){
		if(strpos($unique_data["pic_file"], 'mp4')){
			echo '<video id="my-video" style="margin:0 auto;" class="video-js" controls preload="auto" width="720" data-setup="{}">
			<source src="../_img/pik4/uploads/'.$unique_data["pic_file"].'" type="video/mp4"></video>';
		}
		echo ' <br>';
	}
}
// 個別ページ ここから
if( $page_type == 9 ){
	echo $note["tag"];
	echo '<div class="fp_content">';
	echo $note["content"];
	echo "</div>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
} elseif($page_type == 15){
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
} else {
// 大会トップページ表示部 ここから
}
?>

</div>
