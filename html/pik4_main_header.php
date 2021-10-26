<?php
$stage_sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$stage_id'";
$result = mysqli_query($mysqlconn, $stage_sql);
if (!$result) {
        echo " <br>Error ".__LINE__."：クエリの取得エラーが発生しています。";
}
if($result) $stage_row = mysqli_fetch_assoc($result);

// カテゴリ番号の分割処理
$page_row = '';	// タグ表示の定義
$stage_cat = 0;
if (isset($stage_row["parent"]) and $stage_row["parent"] != 0){
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
// 親カテゴリからシリーズを算出
$series_cat = 0;
if(floor($stage_cat / 10) == 1){
        $series_cat = 1; // 通常ランキングのピクミン1
} elseif(floor($stage_cat / 10) == 2){
        $series_cat = 2; // 通常ランキングのピクミン2、本編地下、2Pバトル、タマゴムシ縛り、スプレー等縛り、2Pモード、ソロバトル
} elseif(floor($stage_cat / 10) == 3){
        $series_cat = 3; // 通常ランキングのピクミン3、2Pモード、サイドストーリー、ビンゴバトル、ソロビンゴ
} elseif($stage_cat == 81){
        $series_cat = 2; // 実機無差別級
} elseif($stage_cat == 82){
        $series_cat = 2; // TAS
} elseif($stage_cat == 91){
        $series_cat = 2; // 期間限定（★一部ピクミン1が混在するが許容範囲。ただしピクミン3には非対応）
} elseif($stage_cat == 92){
        $series_cat = 2; // 日替わり
} elseif($stage_cat == 93){
        if(floor($stage_id / 100) == 101) $series_cat = 1; // ピクミン1本編RTA
        if(floor($stage_id / 100) == 102) $series_cat = 2; // ピクミン2本編RTA
        if(floor($stage_id / 100) == 103) $series_cat = 3; // ピクミン3本編RTA
} elseif($stage_cat == 94){
        $series_cat = 2; // チャレンジ複合
} elseif($stage_cat == 96){
        if(floor($stage_id / 100) == 102) $series_cat = 2; // ソロバトルRTA
        if(floor($stage_id / 100) == 103) $series_cat = 3; // ソロビンゴRTA
} else {
        $series_cat = 0;
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
                } elseif($stage_id == 211022){
                        $team_a = 17;
                        $team_b = 18;
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
if(isset($stage_row["stage_sub"])) $fixed_stage_sub = '<A href="./'.$stage_hook.'"><font class="rtd_eng_stage_name">'.$stage_row["stage_sub"]."</font></A> <br>\n";

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
elseif ( $page_type == 22		    ) $page_header = '<div class="rtd_main"><div class="rtd_head"><span glot-model="main_head_solobattle">◆ソロバトルRTA</span> <br><h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
elseif ( $page_type == 23		    ) $page_header = '<div class="rtd_main"><div class="rtd_head"><span glot-model="main_head_solobingo">◆ソロビンゴRTA</span> <br><h1 class="rtd_stage_caption">'.$fixed_stage_title.'</h1>' ;
elseif ( $stage_id   > 6 AND $stage_id < 100) $page_header = '<div class="rtd_main"><div class="rtd_head"><span glot-model="main_head_total">◆総合ランキング</span> <br><h1 class="rtd_stage_caption">'.$array_stage_title[$stage_id].'</h1>' ;
elseif ( $stage_id  == 9     		    ) $page_header = '<div class="rtd_main"><div class="rtd_head"><span glot-model="main_head_total">◆総合ランキング</span> <br><h1 class="rtd_stage_caption">'.$array_stage_title[9].'</h1>' ;
else     $show_scoretable = 0;
echo $page_header ;

//英語名・副題・補足情報を表示
if ( $page_type == 5 ){
        // ログイン名＝ユーザーページならユーザー証明コードを表示
        $sql = "SELECT `` FROM `user` WHERE ";
        if($user_name === $cookie_name or $cookie_name === COOKIE_NAME){
                $user_code = substr( sprintf( "%.0f", hexdec( hash("sha256", $sys_ver.$user_name) ) ), 0, 10);
                echo '<span class="rtd_eng_stage_name">ユーザー証明コード（Proof code）：'.$user_code."</span> <br>\n";
        }
} elseif(($page_type > 0 and $page_type < 9) or $page_type == 14 or $page_type == 12 or $page_type == 16){
        if(isset($stage_row["eng_stage_name"])) echo '<span class="rtd_eng_stage_name">'.$stage_row["eng_stage_name"]."</span> <br>\n";
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
if ( $page_type == 22 ) $sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` ASC,`post_date` ASC";
if ( $page_type == 23 ) $sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` ASC,`post_date` ASC";

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
if ( $stage_id  == 96 ) $sql = "SELECT * FROM `user`  WHERE `total_solobb` != 0 ORDER BY `total_solobb` DESC";
if ( $stage_id  == 98 ) $sql = "SELECT * FROM `user`  WHERE `post_count` != 0 ORDER BY `post_count` DESC";
if ( $stage_id  == 99 ) $sql = "SELECT * FROM `minites`  WHERE `minites_count` != 0 ORDER BY `minites_count` DESC";
//	if ( $stage_id == 299  ) $sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` DESC";
if ( $page_type == 10 ) $sql = "SELECT * FROM `user` WHERE `current_team` BETWEEN '$team_a' AND '$team_b'";
if ( $page_type == 6 ){
        $target_db_num = sprintf('%03d', array_search($stage_id, $limited_stage_list) );
        $target_db = 'total_limited'.$target_db_num;
        $sql = "SELECT * FROM `user` WHERE $target_db != 0 ORDER BY $target_db DESC";
}
if ( $page_type == 13 ){
        $target_db_num = sprintf('%03d', array_search($stage_id, $limited_stage_list) );
        $target_db = 'total_limited'.$target_db_num;
        $target_al = 'total_arealim'.$target_db_num;
        $sql = "SELECT * FROM `user` WHERE $target_db != 0 or $target_al != 0 ORDER BY $target_db DESC";
}
if ( $page_type == 21 and $stage_id != 210829 ){ // 参加者企画・RPS基準
        $target_db_num = sprintf('%03d', array_search($stage_id, $uplan_stage_list) );
        $target_db = 'total_uplan'.$target_db_num."rps";
        $sql = "SELECT * FROM `user` WHERE $target_db != 0 ORDER BY $target_db DESC";
}
if ( $page_type == 21 and $stage_id == 210829 ){ // 参加者企画・ゲームポイント基準
        $target_db_num = sprintf('%03d', array_search($stage_id, $uplan_stage_list) );
        $target_db = 'total_uplan'.$target_db_num;
        $sql = "SELECT * FROM `user` WHERE $target_db != 0 ORDER BY $target_db DESC";
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
        if(isset($mushi_row["minites_count"]) and $mushi_row["minites_count"] > 0){
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
if ( $page_type == 22) $page_row .= '<span class="user_info ui_all"><span glot-model="main_playercount">参加人数</span>：'.$rows_count.'<span glot-model="tail_nin">人</span></span>'.$echo_average ;
if ( $page_type == 23) $page_row .= '<span class="user_info ui_all"><span glot-model="main_playercount">参加人数</span>：'.$rows_count.'<span glot-model="tail_nin">人</span></span>'.$echo_average ;

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
        $array_select_rank = array("total_rps", "total_pik1cha", "total_pik2cha", "total_pik2egg", "total_pik2noegg", "total_pik3cha", "total_pik3ct", "total_pik3be", "total_pik3db", "total_pik3ss", "total_limited000", "total_new", "total_new2", "total_diary", "total_story","total_solobb","total_mix", "total_pik2_2p", "total_pik3_2p","total_sp");
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
