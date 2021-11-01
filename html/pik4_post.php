<?php
// 汎用フォーム処理部 ここから
if (@$_POST['check_send']) {
	echo '<div id="post_notification" class="post_notification">';
	echo '<A href="./'.$url_stage_id.'" onClick="notification_out();">';
	echo '<b glot-model="notice_title">★送信結果</b><span glot-model="notice_out"> (クリックで非表示にします) </span></A><br>';

	// スコア登録処理部分 ここから
	if(@$_POST['formtype'] == 1){

		// 処理する情報一覧
		$admin_flag	= 0;				// 管理用コマンドフラグ（1以上で非エントリー）
		$ranking_type	= $_POST['ranking_type'];	// ランキングタイプ
		$user_name	= $_POST['user_name'];		// 投稿者ID
		$password	= $_POST['password'];		// パスワード
		$stage_id	= $_POST['stage_id'];		// ステージ番号
		$multi_stage_id	= $_POST['multi_stage_id'];	// ステージ番号（2P）
		$lim_stage_id	= $_POST['limited_stage_id'];	// ステージ番号（期間限定）
		$story_stage_id	= $_POST['story_stage_id'];	// ステージ番号（本編）
		$cave_stage_id	= $_POST['cave_stage_id'];	// ステージ番号（本編地下）
		$new_challenge	= $_POST['new_challenge'];	// ステージ番号（新チャレ）
		$unlimited	= $_POST['unlimited'];		// ステージ番号（無制限）
		$score		= $_POST['score'];		// スコア
		$trial		= $_POST['trial'];		// 体験版
		$post_comment	= $_POST['post_comment'];	// コメント
		$console	= $_POST['console'];		// 操作方法
		$console_2p	= $_POST['console_2p'];		// 2Pの操作方法
		$user_name_2p	= $_POST['user_name_2p'];	// 2Pの名前
		$video_url	= $_POST['video_url'];		// 動画URL
		$large_picfile	= $_POST['large_picfile'];	// 先行アップロード画像のURL
		$user_ip	= $_SERVER["REMOTE_ADDR"];	// 投稿者のIPアドレス
		$user_agent	= $_SERVER["HTTP_USER_AGENT"];	// 投稿者のユーザーエージェント
		$post_count	= 1;				// 投稿回数
		$post_rank	= 0;				// 順位
		$post_rps	= 0;				// ランクポイント
		$prev_score	= 0;				// 前回のスコア
		$new_file_name  = array();			// 添付ファイル名
		$video_check	= 0;				// 証拠動画URLの整合性チェック
		$firstpost_date = "1970-01-01 00:00:00";	// 初投稿日

		$old_user_name	= "";				// ユーザー名
		$old_console	= "";				// 操作方法
		$old_user_ip	= "";				// IPアドレス
		$old_unique_id	= "";				// ユニークID
		$old_rank	= 0;

		$data_user_name = "";				// データベース上の名前
		$crypted_pass	= "";				// データベース上のパスワード
		$del_ranking_type = "";				// 登録区分をステージIDから逆算して格納（削除時のみ）
		$ranking_flag   = 0;				// 参加者企画用の特殊処理フラグ

		$story_cavepoko	= $_REQUEST['story_cavepoko'];	// 本編地下お宝総価値
		$story_cavehour	= $_REQUEST['story_cavehour'];	// 本編地下時間(hour)
		$story_cavemin	= $_REQUEST['story_cavemin'];	// 本編地下分
		$story_cavesec	= $_REQUEST['story_cavesec'];	// 本編地下秒
		$storyc_red	= $_REQUEST['storyc_red'];	// 本編地下赤ピクミン
		$storyc_blue	= $_REQUEST['storyc_blue'];	// 本編地下青ピクミン
		$storyc_yellow	= $_REQUEST['storyc_yellow'];	// 本編地下黄ピクミン
		$storyc_purple	= $_REQUEST['storyc_purple'];	// 本編地下紫ピクミン
		$storyc_white	= $_REQUEST['storyc_white'];	// 本編地下白ピクミン
		$storyc_koppa	= $_REQUEST['storyc_koppa'];	// 本編地下コッパチャッピー
		$storyc_popoga	= $_REQUEST['storyc_popoga'];	// 本編地下ポポガシグサ
		$storyc_death	= $_REQUEST['storyc_death'];	// 本編地下犠牲数

		$story_daycount = $_REQUEST['story_daycount'];	// 本編クリア日数
		$story_correct	= $_REQUEST['story_correct'];	// 本編回収数
		$story_rtahour	= $_REQUEST['story_rtahour'];	// 本編クリア(時)
		$story_rtamin	= $_REQUEST['story_rtamin'];	// 本編クリア(分)
		$story_rtasec	= $_REQUEST['story_rtasec'];	// 本編クリア(秒)
//		$story_pikmin	= $_REQUEST['story_pikmin'];	// 本編増やした数合計
		$story_red	= $_REQUEST['story_red'];	// 本編赤を増やした数
		$story_blue	= $_REQUEST['story_blue'];	// 本編青を増やした数
		$story_yellow	= $_REQUEST['story_yellow'];	// 本編黄を増やした数
		$story_purple	= $_REQUEST['story_purple'];	// 本編紫を増やした数
		$story_white	= $_REQUEST['story_white'];	// 本編白を増やした数
		$story_winged	= $_REQUEST['story_winged'];	// 本編羽を増やした数
		$story_rock	= $_REQUEST['story_rock'];	// 本編岩を増やした数
		$story_death	= $_REQUEST['story_death'];	// 本編犠牲数
//		$story_lim_array= $_REQUEST['story_lim_array'];	// 本編縛り内容配列（停止中）
//		$story_lim_pts	= $_REQUEST['story_lim_pts'];	// 本編縛りポイント
//		$story_lim_han	= $_REQUEST['story_lim_han'];	// 本編縛り飜

//		$comp_{$i}[hms] = $_REQUEST[($1)];		// チャレンジ複合通過タイム (変数変換略)

		$conf		= $_REQUEST['onfigure_select'];	// 設定項目
		$conf_value	= $_REQUEST['conf_value'];	// 記録削除用に入力されたユニークID
		$post_reset	= $_REQUEST['post_reset'];	// 登録情報リセットフラグ
		$post_twitter	= $_REQUEST['post_twitter'];	// Twitter連携フラグ
		$conf_text	= $_REQUEST['conf_text'];	// 自由記述
		$conf_text_title= $_REQUEST['conf_text_title'];	// 自由記述のテーマ
		$post_achi_title= $_REQUEST['post_achi_title'];	// 実績タイトル
		$post_achi_player=$_REQUEST['post_achi_player'];// 達成者名
		$post_achi_date	= $_REQUEST['post_achi_date'];	// 達成日
		$post_achi_url	= $_REQUEST['post_achi_url'];	// URL
		$post_lim_title	= $_REQUEST['post_lim_title'];	// 期間限定ルールのタイトル

		$battle_stage_id= $_REQUEST['battle_stage_id'];	// バトルモードのステージID
		$battle_reague	= $_REQUEST['battle_reague'];	// 登録するリーグ
		$macaroon	= $_REQUEST['macaroon'];	// マカロンの有無 [1=あり]
		$reader		= $_REQUEST['reader'];		// ビンゴバトルのリーダー人数 [1=2対2]
		$pikmin_1p	= $_REQUEST['battle_1p_pikmin'];// 1Pの初期ピクミン数
		$pikmin_2p	= $_REQUEST['battle_2p_pikmin'];// 2Pの初期ピクミン数
		$battle_result	= $_REQUEST['battle_result'];	// 対戦結果
		$battle_detail	= $_REQUEST['battle_detail'];	// 対戦結果詳細

		$prof_text	= $_REQUEST['prof_text'];	// プロフィール本文
		$prof_mysite	= $_REQUEST['prof_mysite'];	// プロフィール本文
		$prof_sitetitle	= $_REQUEST['prof_sitetitle'];	// プロフィール本文
		$prof_nicovideo	= $_REQUEST['prof_nicovideo'];	// プロフィール本文
		$prof_twitch	= $_REQUEST['prof_twitch'];	// プロフィール本文
		$prof_youtube	= $_REQUEST['prof_youtube'];	// プロフィール本文
		$prof_twitter	= $_REQUEST['prof_twitter'];	// プロフィール本文
		$fav_stage_id	= $_REQUEST['fav_stage_id'];	// プロフィール本文

		$story_rta	= 0;				// 未定義回避用
		$story_pikmin	= 0;				//
		$story_lim_array= 0;				//
		$story_lim_pts	= 0;				//
		$story_lim_han	= 0;				//
		$secret_flag	= 0;				//
		$secret_flag	= 0;				//
		$cave_time	= 0;				//
		$alltime	= 0;				//
		$max_pikmin	= 0;				//
		$lasttime	= 0;				//
		$allpikmin	= 0;				//
		$addpikmin	= 0;				//
		$lastpikmin	= 0;				//
		$story_lim_imp	= 0;				//
		$text_check	= 0;				//
		$ng_text_through= 0;				//
		$ng_text_check	= 0;				//
		$comment_check	= 0;				//
		$leftside_rps	= 0;				//
		$rightside_rps	= 0;				//
		$diff_team_count= 0;				//
		$right_ave	= 0;				//
		$left_ave	= 0;				//
		$comp_rps_array	= 0;				//
		$your_team	= 0;				//
		$success_picupload= 0;				//
		$shere_tp	= 0;				//
		$season_column	= 0;				//
		$leftside_rps	= 0;				//
		$rightside_rps	= 0;				//
		$minority_bonus	= 0;				//
		$score_sum	= 0;				//
		$score_ave	= 0;				//
		$score_variance	= 0;				//
		$score_sd	= 0;				//

		// デバッグモード切り替え
		if ( $user_name == COOKIE_NAME and $post_comment == DEBUG_MODE){
			if($_SESSION['debug_mode'] != 1){
				$_SESSION['debug_mode'] = 1;
				die('デバッグモードに切り替えました');

			} elseif($_SESSION['debug_mode'] == 1){
				$_SESSION['debug_mode'] = 0;
				die('通常モードに切り替えました');

			}
		}

		// 隠しステージの場合は処理方法を変更
		if ( $stage_id == 299 ){
			$ranking_type = "eastegg";
		}
		// IPアドレスからホスト名を算出
		$user_host = gethostbyaddr($user_ip);

		// 先行アップロードしている場合はファイル名を代入する
		if($large_picfile){
			$new_file_name[0] = $large_picfile;
		}

		// 編集モードの場合はサブフォームの内容を代入する
		if ( $ranking_type == "configure"){
			$video_url	= $_REQUEST['video_url2'];	// 動画URL
			$post_comment	= $_REQUEST['post_comment2'];	// コメント
			$_FILES['pic_file'] = $_FILES['pic_file2'];	// 証拠画像
		}
		// 送信情報の整合性チェック
		$new_entry = 1;		// 整合性チェックフラグ OK：1、NG：0
		$old_score = 0;		// 旧スコア (初期値0)
		$score_check = 9;   	// スコアの更新チェック 初期値9、更新1、更新せず0
		$old_datamatch = 9;	// OFF：9、パスワード一致：1、不一致：0
		$old_entry = 9;		// OFF：9、過去データ検索したがデータがEmpty：0、検索成功：1
		$entry_success = 0;	// 投稿終了したら1

		// ステージIDを変換して処理分岐前のメタ情報をする整理（ステージIDによって登録区分が変わる場合）
		if( $ranking_type == "limited" or $ranking_type == "limited_team") $stage_id = $lim_stage_id;
		if( $ranking_type == "multi") $stage_id = $multi_stage_id;
		if( $ranking_type == "story") $stage_id = $story_stage_id;
		if( $ranking_type == "storycave") $stage_id = $cave_stage_id;
		if( $ranking_type == "battle") $stage_id = $battle_stage_id;
		if( $ranking_type == "new") $stage_id = $new_challenge;
		if( $ranking_type == "unlimited") $stage_id = $unlimited;

		if( $user_name == COOKIE_NAME and $post_comment == ALTERNATIVE_USER) $ranking_type = "admin";
		if( $user_name == COOKIE_NAME and $post_comment == ALTERNATIVE_USER) $admin_flag = 1;
		if( $conf == "limited_post") $ranking_type = "free_post";
		if( $conf == "profile_post") $ranking_type = "profile_post";
		if( $stage_id >= 311 AND $stage_id <= 316) $ranking_type = "boss";
		if( $stage_id >= 231 AND $stage_id <= 244) $ranking_type = "storycave";
		if( $stage_id >= 245 AND $stage_id <= 274) $ranking_type = "diary";
		if( $stage_id >=4001 AND $stage_id <=4060) $ranking_flag = 1;
		if( $stage_id >=1001 AND $ranking_type == "limited" and strpos($limited_type[$limited_stage_list[$limited_num]], 't') !== false) $ranking_type = "limited_team";
		if( $stage_id >=1001 AND $ranking_type == "limited" and strpos($limited_type[$limited_stage_list[$limited_num]], 'e') !== false) $ranking_type = "limited_area";

		//							0	1	2	3	4	5	6	7	8	9	10	11	12	13	14	15	16	17	18	19	20	21	22	23	24
		// 処理分岐の定義					未使用	ID変換	必須	メンテ	再送信	U比較	ID生成	日時	DB変換	本編T	縛り	名前	コメ	動画	理論値	操作	期限	更新?	画像	フラグ	登録	U更新	TP	RPS	合計
		if ($ranking_type == "normal"   	) $switch = array(0,	0,	1,	1,	1,	1,	1,	1,	0,	0,	0,	1,	1,	1,	1,	1,	0,	1,	1,	1,	1,	1,	1,	1,	1);
		if ($ranking_type == "new"   		) $switch = array(0,	0,	1,	1,	1,	1,	1,	1,	0,	0,	0,	1,	1,	1,	1,	1,	0,	1,	1,	1,	1,	1,	1,	1,	1);
		if ($ranking_type == "unlimited"	) $switch = array(0,	0,	1,	1,	1,	1,	1,	1,	0,	0,	0,	1,	1,	1,	1,	1,	0,	1,	1,	1,	1,	1,	1,	1,	1);
		if ($ranking_type == "multi"   		) $switch = array(0,	0,	1,	1,	1,	1,	1,	1,	0,	0,	0,	1,	1,	1,	1,	1,	0,	1,	1,	1,	1,	1,	1,	1,	1);
		if ($ranking_type == "storycave"   	) $switch = array(0,	0,	1,	1,	1,	1,	1,	1,	0,	0,	0,	1,	1,	1,	1,	1,	0,	1,	1,	1,	1,	1,	1,	1,	1);
		if ($ranking_type == "diary"	   	) $switch = array(0,	0,	1,	1,	1,	1,	1,	1,	0,	0,	0,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1);
		if ($ranking_type == "boss"     	) $switch = array(0,	0,	1,	1,	1,	1,	1,	1,	1,	0,	0,	1,	1,	1,	1,	1,	0,	1,	1,	1,	1,	1,	1,	1,	1);
		if ($ranking_type == "limited"  	) $switch = array(0,	1,	1,	1,	1,	1,	1,	1,	0,	0,	0,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1);
		if ($ranking_type == "limited_team"  	) $switch = array(0,	1,	1,	1,	1,	1,	1,	1,	0,	0,	0,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1);
		if ($ranking_type == "limited_area"  	) $switch = array(0,	1,	1,	1,	1,	1,	1,	1,	0,	0,	0,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1);
		if ($ranking_type == "configure"	) $switch = array(0,	0,	0,	1,	1,	0,	0,	0,	0,	0,	0,	1,	1,	1,	0,	0,	0,	0,	0,	1,	1,	0,	1,	0,	1);
		if ($ranking_type == "story"		) $switch = array(0,	1,	1,	1,	1,	1,	1,	1,	0,	1,	1,	1,	1,	1,	1,	1,	0,	1,	1,	1,	1,	1,	1,	1,	1);
		if ($ranking_type == "free_post"	) $switch = array(0,	0,	1,	1,	1,	1,	0,	1,	0,	0,	0,	1,	0,	0,	0,	0,	0,	0,	0,	0,	1,	0,	0,	0,	0);
		if ($ranking_type == "profile_post"	) $switch = array(0,	0,	1,	1,	1,	1,	0,	1,	0,	0,	0,	1,	0,	0,	0,	0,	0,	0,	0,	0,	1,	0,	0,	0,	0);
		if ($ranking_type == "admin"		) $switch = array(0,	0,	0,	0,	0,	1,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	1,	1);
		if ($ranking_type == "battle"  		) $switch = array(0,	0,	1,	1,	1,	1,	1,	1,	0,	0,	0,	1,	1,	1,	0,	1,	0,	1,	1,	1,	1,	1,	1,	1,	1);

		// f01：未使用
		if( $switch[1] ){

		}
		// f05新：削除しようとしているスコアの情報を取得
		if( ($conf == "record_delete" or $conf == "record_update") and $conf_value != ""){
			$sql = "SELECT * FROM `ranking` WHERE `user_name` = '$user_name' AND `unique_id` = '$conf_value' AND `log` = 0 LIMIT 1";
			$result = mysqli_query($mysqlconn, $sql);
			if(!$result){
				echo ' <br>Error ".__LINE__."：ユニークIDが一致しません。';
				$new_entry = 0;
			} else {
				$row = mysqli_fetch_assoc($result);
				$stage_id = $row["stage_id"];
				$score = $row["score"];

				// ステージIDから投稿タイプを逆算
				$qsid = $row["stage_id"];
				$del_limited_num = 0;
				if($qsid >=  100 and $qsid <=  105) $del_ranking_type = "normal";		 // ピクミン1
				if($qsid >=  200 and $qsid <=  230) $del_ranking_type = "normal";		 // ピクミン2
				if($qsid >=  231 and $qsid <=  244) $del_ranking_type = "storycave";		 // ピクミン2地下チャレンジ
				if($qsid >=  245 and $qsid <=  274) $del_ranking_type = "diary";		 // 日替わり
				if($qsid >=  275 and $qsid <=  297) $del_ranking_type = "new";			 // 新チャレンジモード
				if($qsid >=  301 and $qsid <=  310) $del_ranking_type = "normal";		 // ピクミン3初期ステージ
				if($qsid >=  311 and $qsid <=  316) $del_ranking_type = "boss";			 // ピクミン3ボス
				if($qsid >=  317 and $qsid <=  336) $del_ranking_type = "boss";			 // ピクミン3追加DLC
				if($qsid >= 1001 and $qsid <= 1014) $del_ranking_type = "limited";		 // 期間限定1st-6th
				if($qsid >= 1015 and $qsid <= 1022) $del_ranking_type = "limited_team";	 	 // 期間限定7th-8th
				if($qsid >=10000 and $qsid <=10302) $del_ranking_type = "story";	 	 // 本編

				// ステージIDから期間限定開催回数を逆算
				if($qsid >= 1001 and $qsid <= 1002)  $del_limited_num = 1;
				if($qsid >= 1003 and $qsid <= 1004)  $del_limited_num = 2;
				if($qsid >= 1005 and $qsid <= 1006)  $del_limited_num = 3;
				if($qsid >= 1007 and $qsid <= 1008)  $del_limited_num = 4;
				if($qsid >= 1009 and $qsid <= 1012)  $del_limited_num = 5;
				if($qsid >= 1013 and $qsid <= 1014)  $del_limited_num = 6;
				if($qsid >= 1015 and $qsid <= 1018)  $del_limited_num = 7;
			}
		}
		// f05-a：スコア削除認証
		if( $conf == "record_delete" and $conf_value != ""){
			if(!$_SESSION['debug_mode']) "1140＃スイッチ5-a（スコア削除認証）がONになっています。 <br>";
			$query = "SELECT * FROM `user` WHERE `user_name` = '$user_name' ";
			if ($result = mysqli_query($mysqlconn, $query) ){
				while ($row = mysqli_fetch_assoc($result)) {

					// 必要な前回データを取り出して変数に格納
					$data_user_name	 = $row["user_name"];
					$crypted_pass	 = $row["pass"];
				}
				if($crypted_pass){
					// パスワード暗号化・比較
					$randpass	= PASS_CRYPT; //乱数種を設定
					$iv		= openssl_random_pseudo_bytes( 8 );	//ランダムバイトを設定
					$raw_output	= false;				//Base64で出力
					$method		='aes-256-ecb';				//AES256bitで暗号化

					$decode_pass = openssl_decrypt($crypted_pass, $method, $randpass);
					if(! $decode_pass ){
						exit (' <br>Error ".__LINE__."：データの復号化に失敗しています。');
					}
					if($password == $decode_pass){
//						echo ' <br>パスワードの一致を確認しました。';
					} else {
						$new_entry = 0;
					echo " <br>Error ".__LINE__."：パスワードが一致しません。";
					}
				} else {
				$new_entry = 0;
				echo " <br>Error ".__LINE__."：パスワードが設定されていない記録は削除できません。";
				}
			}
		}
		// f99：スコア削除対象の検索
		if( $conf == "record_update" and $conf_value != ""){
			$old = array();
			$query = "SELECT * FROM `ranking` WHERE `user_name` = '$user_name' AND `unique_id` = '$conf_value' AND `log` != 2 LIMIT 1 ";
			if ($result = mysqli_query($mysqlconn, $query) ){
				$row = mysqli_fetch_assoc($result);
				if(!$row){
					$new_entry = 0;
					echo ' <br>Error '.__LINE__.'：入力したIDが一致しないか、すでにスコアが削除されています。 (入力したID：'.$conf_value.')';
				}
				// 更新する場合に備えて必要情報を取り出しておく
				$old["pic_file"] = $row["pic_file"];
				$old["post_comment"] = $row["post_comment"];
				$old["video_url"] = $row["video_url"];
				$post_memo = $row["post_memo"];
			}
		}
		// f05：ユーザー情報比較
		if( $switch[5] ){
			$query = "SELECT * FROM `user` WHERE `user_name` = '$user_name' ";
			if ($result = mysqli_query($mysqlconn, $query) ){
				while ($row = mysqli_fetch_assoc($result)) {

					// 必要な前回データを取り出して変数に格納
					$data_user_name	 = $row["user_name"];
					$data_post_count = $row["post_count"];
					$crypted_pass	 = $row["pass"];
					$now_tp		 = $row["tp"];
					$now_egg	 = $row["egg"];
				}
				if ( $data_user_name == "" ){
//					echo " <br>ユーザーデータが見つかりません。新規登録します。";
				}
			}

				// パスワード暗号化・比較
				$randpass	= PASS_CRYPT; //乱数種を設定
				$iv		= openssl_random_pseudo_bytes( 8 );	//ランダムバイトを設定
				$raw_output	= false;				//Base64で出力
				$method		='aes-256-ecb';				//AES256bitで暗号化

				if ($crypted_pass != "" AND $data_user_name != "" ){

				$decode_pass = openssl_decrypt($crypted_pass, $method, $randpass);
				if(! $decode_pass ){
					exit (' <br>Error '.__LINE__.'：データの複合化に失敗しています。');
				}
				if($password == $decode_pass or $password == ADMIN_PASSWORD){
//					echo " <br>パスワードの一致を確認しました。";
					if($password == ADMIN_PASSWORD) echo " <br>Notice".__LINE__."：管理者権限で投稿します。";
				} else {
					$new_entry = 0;
//					echo " <br>暗号化されたパスワード：".$crypted_pass ;
//					echo " <br>複合化されたパスワード：".$decode_pass ;
//					echo " <br>入力したパスワード：".$password ;
					echo " <br>Error ".__LINE__."：パスワードが一致しません。";
				}
			} else {
				$new_pass = openssl_encrypt($password, $method, $randpass);
			}
		}
		// f08：#311-316ボスバトルの登録値を残り秒数に変換
		if( $switch[8] or ($stage_id > 2310 and $stage_id < 2317) or $stage_id == 356 or $stage_id == 359 or $stage_id == 361 or $stage_id == 2356 or $stage_id == 2359 or $stage_id == 2361 ){
			$bb_min = $_REQUEST['score_pik3boss_min'];
			$bb_sec = $_REQUEST['score_pik3boss_sec'];
			$bb_time= ($bb_min * 60) + $bb_sec;
			$score = bossscore_enc($stage_id, $bb_time);
		}
		// f08-2新：地下本編登録情報をスコアに変換＆不正値チェック
		if ($ranking_type == "storycave" ){
			// 時間を計算
			$cave_time = ($story_cavehour * 3600) + ($story_cavemin * 60) + $story_cavesec;
			if ($cave_time < 1){
				$new_entry = 0;
				echo ' <br>Error '.__LINE__.'：入力されている合計時間が不正な値です。';
			}

			// ステージIDから制限時間と連れて行けるピクミンを取得
			$cave_query = "SELECT * FROM `stage_title` WHERE `stage_id` = '$stage_id' ";
			$cave_result = mysqli_query($mysqlconn, $cave_query);
			$cave_row = mysqli_fetch_assoc($cave_result);
			$alltime = $cave_row["Time"];
			$max_pikmin = $cave_row["Total_Pikmin"];

			// 残り時間を取得
			$lasttime = $alltime - $cave_time;
			if ($lasttime < 0){
				$new_entry = 0;
				echo ' <br>Error '.__LINE__.'：合計時間が制限時間を超過しているスコアは登録できません。';
			}

			// 合計ピクミン数を取得
			$allpikmin = $storyc_red + $storyc_blue + $storyc_yellow + $storyc_white + $storyc_purple;
			$addpikmin = $storyc_koppa + ($storyc_popoga * 8);
			if($allpikmin < 1 or $addpikmin < 0 or $allpikmin > $max_pikmin){
				$new_entry = 0;
				echo ' <br>Error '.__LINE__.'：初期構成または追加構成が不正な値です。 <br>連れて行ける数：'.$max_pikmin.' <br>初期隊列：'.$allpikmin;
			}

			// 最終ピクミン数を計算
			$lastpikmin = ($allpikmin + $addpikmin) - $storyc_death;
			if($lastpikmin < 1){
				$new_entry = 0;
				echo ' <br>Error '.__LINE__.'：犠牲数が不正な値か、連れていった数を上回っています。';
			}

			// お宝価値を判定
			if($story_cavepoko < 0){
				$new_entry = 0;
				echo ' <br>Error '.__LINE__.'：お宝累計価値が不正な値です。';
			}

			// 最終スコアを計算
			$score = ($story_cavepoko * 10)+ ($lastpikmin * 10)+ floor($lasttime /2);
		}
		// f09：本編のRTAタイムを変換
		if( $switch[9] ){
			$story_rta = $story_rtahour.':'.$story_rtamin.':'.$story_rtasec;		// 登録用の文字列hh:mm:ss形式
			$score   = ($story_rtahour * 60 * 60) + ($story_rtamin * 60) + $story_rtasec;	// 比較用の秒換算形式を通常スコアとして処理する

		// f09-2：本編増やした数の合計を算出
			if ($stage_id > 10000 and $stage_id < 10200) $story_pikmin = $story_red + $story_blue + $story_yellow;
			if ($stage_id > 10199 and $stage_id < 10300) $story_pikmin = $story_red + $story_blue + $story_yellow + $story_purple + $story_white;
			if ($stage_id > 10299 and $stage_id < 10400) $story_pikmin = $story_red + $story_blue + $story_yellow + $story_winged + $story_rock;
		}
		// f10：本編縛り内容を結合する
		if( $switch[9] and !($stage_id > 10204 and $stage_id < 10213)){
			$story_lim_imp = implode("_", $story_lim_array);
		}
		// f08-3新：チャレンジ複合の通過タイムを結合
		if ($stage_id > 10204 and $stage_id < 10215){
			$story_lim_imp = '';
			$i = 201;
			$complex_check = 1;
			while($i < 231){
				if($_REQUEST["comp_{$i}h"] != "") if($_REQUEST["comp_{$i}h"] < 0 or $_REQUEST["comp_{$i}h"] > 99 or !is_numeric($_REQUEST["comp_{$i}h"])) $complex_check = 0;
				if($_REQUEST["comp_{$i}m"] != "") if($_REQUEST["comp_{$i}m"] < 0 or $_REQUEST["comp_{$i}m"] > 59 or !is_numeric($_REQUEST["comp_{$i}m"])) $complex_check = 0;
				if($_REQUEST["comp_{$i}s"] != "") if($_REQUEST["comp_{$i}s"] < 0 or $_REQUEST["comp_{$i}S"] > 59 or !is_numeric($_REQUEST["comp_{$i}s"])) $complex_check = 0;
				$story_lim_imp .= $_REQUEST["comp_{$i}h"].":";
				$story_lim_imp .= $_REQUEST["comp_{$i}m"].":";
				$story_lim_imp .= $_REQUEST["comp_{$i}s"];
				$story_lim_imp .= "_"; // 区切り文字
				$i++;
			}
			$i = 201;
			while($i < 231){
				if($_REQUEST["score_{$i}"] != "") if($_REQUEST["score_{$i}"] < 0 or $_REQUEST["score_{$i}"] > 59999 or !is_numeric($_REQUEST["score_{$i}"])) $complex_check = 0;
				$story_lim_imp .= $_REQUEST["score_{$i}"];
				$story_lim_imp .= "_";
				$i++;
			}
			if($complex_check == 0){
				$new_entry = 0;
				echo ' <br>Error '.__LINE__.'：[チャレンジ複合] スプリットタイムまたはスコアの入力値が不正です。';
			}
		}
		// f11：名前チェック
		if( $switch[11] ){
			$name_check = 1;
			$ng_word_check = 0;
			if(preg_match("/^[0-9]+/", $user_name))				$name_check = 0;
			if(preg_match("/^_.*/", $user_name))				$name_check = 0;
//			if(preg_match("/.*(\\|\.|\$|\*|\/| |　)+.*$/", $user_name))	$name_check = 0;
			// NGワードをループ処理
			foreach($ng_needle as $ng_word){
				$ng_word_judge = strpos($user_name,$ng_word);
				if(!$ng_word_judge === false) $ng_word_check = 1;
			}
			if($ng_word_check == 1)						$name_check = 0;
			if(mb_strlen($user_name) > 13)					$name_check = 0;
			if( $name_check == 0){
				$new_entry = 0;
				echo " <br>Error ".__LINE__."：登録名が不正です (他のユーザーやピクミンシリーズ用語[ランキング名称・お宝・原生生物名等]と重複していない、12文字以下の、数字やアンダーバー（_）で始まらない、各種記号やスペースを含まない文字列のみ受け付けています)。入力値：".htmlspecialchars($user_name, ENT_QUOTES);
			}
			$name_check = 1;
			$ng_word_check = 0;
			if(preg_match("/^[0-9]+$/", $user_name_2p))			$name_check = 0;
			if(preg_match("/^_.*/", $user_name_2p))				$name_check = 0;
			foreach($ng_needle as $ng_word){
				$ng_word_judge = strpos($user_name_2p,$ng_word);
				if(!$ng_word_judge === false) $ng_word_check = 1;
			}
			if($ng_word_check == 1)						$name_check = 0;
			if(mb_strlen($user_name_2p) > 13)				$name_check = 0;
			if( $name_check == 0){
				$new_entry = 0;
				echo " <br>Error ".__LINE__."：2Pの登録名が不正です (他のユーザーやピクミンシリーズ用語[ランキング名称・お宝・原生生物名等]と重複していない、12文字以下の、数字のみでない、各種記号やスペースを含まない文字列のみ受け付けています)。入力値：".htmlspecialchars($user_name, ENT_QUOTES);
			}
		}
		// f12新：体験版チェック
		if($trial){
			if($stage_id != 301 and $stage_id != 2301){
				$new_entry = 0;
				$post_memo = '';
				echo " <br>Error ".__LINE__."：体験版の存在しないステージに体験版として登録しようとしています。";
			} elseif($console < 6){
				$new_entry = 0;
				$post_memo = '';
				echo " <br>Error ".__LINE__."：体験版の存在しないプラットフォームで体験版として登録しようとしています。";
			} else {
				$post_memo .= $trial;
			}
		}
		// f12新：プロフィールコメントチェック
		if($ranking_type == "profile_post"){
			if($prof_text != ""){
			$text_check = 1;
			$ng_text_through = 0;
			$ng_text_check = 0;
				foreach($ng_needle as $ng_comment){
					$ng_text_judge = strpos($prof_text, $ng_comment);
					if($ng_text == '　' or $ng_text == ' ' or $ng_text == '\n')	$ng_text_through = 1;
					if(!$ng_text_judge === false and $ng_text_through == 0)		$ng_text_check = 1;
				}
				if($ng_text_check == 1)			$text_check = 0;
				if( $text_check == 0){
					$new_entry = 0;
					echo " <br>Error ".__LINE__."：プロフィール本文に不正な記号が入っています (一部の記号はコメントに使えません)。";
				} else {
				// プロフィールの改行処理
					$prof_text = nl2br($prof_text);
					$prof_text = str_replace("\n","",$prof_text);
					$prof_text = str_replace("\r","",$prof_text);
				}
			}
			if($prof_mysite != ""){
			$text_check = 1;
			$ng_text_through = 0;
			$ng_text_check = 0;
				foreach($ng_needle as $ng_comment){
					$ng_text_judge = strpos($prof_mysite, $ng_comment);
					if($ng_comment == '/' or $ng_comment == '.')	 		$ng_text_through = 1;
					if(!$ng_text_judge === false and $ng_text_through == 0)		$ng_text_check = 1;
				}
				if($ng_text_check == 1)			$text_check = 0;
				if( $text_check == 0){
					$new_entry = 0;
					echo " <br>Error ".__LINE__."：サイトURLに不正な記号が入っています (一部の記号はコメントに使えません)。";
				}
			}
			$i = 0;
			$array_ng_check = array($prof_twitter, $prof_twitch, $prof_youtube, $prof_nicovideo, $prof_sitetitle);
			$array_ng_echo = array('Twitter ID', 'Twitch ID', 'YouTubeチャンネル名', 'ニコニコ動画チャンネルID', 'サイト名');
			foreach($array_ng_check as $ng_check){
				if($ng_check != ""){
				$text_check = 1;
				$ng_text_through = 0;
				$ng_text_check = 0;
					foreach($ng_needle as $ng_comment){
						$ng_text_judge = strpos($ng_check, $ng_comment);
						if($i == 3){
							if(!preg_match("/^(mylist|user)\/[0-9]*$/", $ng_check))		$ng_text_check = 1;
							if($ng_comment == '/')			 			$ng_text_through = 1;
						}
						if($i == 2){
							if(!preg_match("/^(user|channel)\/[0-9A-z_\-]*$/", $ng_check))	$ng_text_check = 1;
							if($ng_comment == '/')						$ng_text_through = 1;
						}
						if(($ng_comment == ' ' or $ng_comment == '　') and $i == 4)	$ng_text_through = 1;
						if(!$ng_text_judge === false and $ng_text_through == 0)		$ng_text_check = 1;
					}
					if($ng_text_check == 1)			$text_check = 0;
				if( $text_check == 0){
					$new_entry = 0;
					echo " <br>Error ".__LINE__."{$array_ng_echo[$i]}に不正な記号が入っています (一部の記号はコメントに使えません)。";
				}
				}
			$i++;
			}
		}
		// f12新：長文コメントチェック
		if($ranking_type == "free_post"){
			if($conf_text != ""){
			$text_check = 1;
			$ng_text_through = 0;
			$ng_text_check = 0;
				foreach($ng_needle as $ng_comment){
					$ng_text_judge = strpos($conf_text, $ng_comment);
					if($ng_text == '　' or $ng_text == ' ') 			$ng_text_through = 1;
					if(!$ng_text_judge === false and $ng_text_through == 0)		$ng_text_check = 1;
				}
				if($ng_text_check == 1)			$text_check = 0;
			}
			if( $text_check == 0){
				$new_entry = 0;
				echo " <br>Error ".__LINE__."：コメントが不正です (一部の記号はコメントに使えません)。";
			}
			if($conf_text_title == "default"){
				$new_entry = 0;
				echo " <br>Error ".__LINE__."：リクエストが不正です（プルダウン項目で「▼選んでください」のまま送信した可能性があります）。";
			}
			if($conf_text_title == "limited_post"){
				$text_check = 1;
				$ng_text_through = 0;
				$ng_text_check = 0;
				foreach($ng_needle as $ng_comment){
					$ng_text_judge = strpos($post_lim_title, $ng_comment);
					if($ng_text == '　' or $ng_text == ' ') 			$ng_text_through = 1;
					if(!$ng_text_judge === false and $ng_text_through == 0)		$ng_text_check = 1;
				}
				if($ng_text_check == 1)	$text_check = 0;
				if( $text_check == 0){
					$new_entry = 0;
					echo " <br>Error ".__LINE__."：縛りタイトルが空白か、不正文字列が含まれています。";
				}
				$conf_text = "期間限定投稿_【".$post_lim_title."】".$conf_text;
			}
			if($conf_text_title == "achievement_post"){
				$text_check = 1;
				$ng_text_through = 0;
				$ng_text_check = 0;
				foreach($ng_needle as $ng_comment){
					$ng_text_judge = strpos($post_achi_title, $ng_comment);
					if($ng_text == '　' or $ng_text == ' ') 			$ng_text_through = 1;
					if(!$ng_text_judge === false and $ng_text_through == 0)		$ng_text_check = 1;
				}
				foreach($ng_needle as $ng_comment){
					$ng_text_judge = strpos($post_achi_player, $ng_comment);
					if($ng_text == '　' or $ng_text == ' ') 			$ng_text_through = 1;
					if(!$ng_text_judge === false and $ng_text_through == 0)		$ng_text_check = 1;
				}
				foreach($ng_needle as $ng_comment){
					$ng_text_judge = strpos($post_achi_date, $ng_comment);
					if($ng_text == '　' or $ng_text == ' ') 			$ng_text_through = 1;
					if(!$ng_text_judge === false and $ng_text_through == 0)		$ng_text_check = 1;
				}
				if($ng_text_check == 1)	$text_check = 0;
				if( $text_check == 0){
					$new_entry = 0;
					echo " <br>Error ".__LINE__."：実績タイトル・実績達成者名・日付のいずれか空白か、不正文字列が含まれています。";
				}
				$conf_text = "実績投稿_【".$post_achi_title."◇".$post_achi_player."◆".$post_achi_date."★".$post_achi_url."】".$conf_text;
			}
		}
		// f12：コメントチェック
		if( $switch[12] ){
			if ($post_comment != ""){
				$comment_check = 1;
				$ng_comment_through = 0;
				$ng_comment_check = 0;
				if(mb_strlen($post_comment) > 101)		$comment_check = 0;
				if(   strstr($post_comment, 'ttp:'))		$comment_check = 0;
				// NGワードをループ処理
				foreach($ng_needle as $ng_comment){
					$ng_comment_judge = strpos($post_comment,$ng_comment);
					if($ng_comment == '　' or $ng_comment == ' ') 			$ng_comment_through = 1;
					if(!$ng_comment_judge === false and $ng_comment_through == 0)	$ng_comment_check = 1;
				}
				if($ng_comment_check == 1)			$comment_check = 0;

				if( $comment_check == 0){
					$new_entry = 0;
					echo " <br>Error ".__LINE__."：コメントが不正です (100文字以下、かつURLを含まない文字列のみ受け付けています)。";
				}
			} else {
				// コメントが空の場合は代替文を挿入
				$post_comment = "コメントなし" ;
			}
		}
		// f13：動画サイトURLの整合性チェック
		if( $switch[13] ){
			if( $video_url != ""){
				if(!preg_match("/^[0-9]+$/", $video_url))	$video_check = 0;
				if( strstr( $video_url, 'nicovideo.jp'))	$video_check = 101; // ニコニコ動画
				if( strstr( $video_url, 'nico.ms'))		$video_check = 102; // ニコニコ動画 (短縮)
				if( strstr( $video_url, 'youtube.com'))		$video_check = 201; // Youtube
				if( strstr( $video_url, 'youtu.be'))		$video_check = 202; // Youtube (短縮)
				if( strstr( $video_url, 'twitch.tv'))		$video_check = 301; // Twitch
				if( strstr( $video_url, 'twitter.com'))		$video_check = 401; // Twitch

				if( $video_check == 0 ){
					$new_entry = 0;
					echo " <br>Error ".__LINE__."：非対応または無効な動画サイトURLです (現在対応のサイトは「YouTube」と「ニコニコ動画」と「Twitch」と「Twitter」となります)。 <br>";
				}
			}
		}
		// f07：送信日時の処理
		if( $switch[7] ){
			$post_unixtime	= time();
			$post_date	= date("Y/m/d H:i:s", $post_unixtime);
			$post_date_sql	= date("Y-m-d H:i:s", $post_unixtime);
			$post_dummy	= date("YmdHis", $post_unixtime);

			// まったく同じ日付の投稿があった場合は投稿を弾く (リロード再送信対策)
			$query = "SELECT * FROM `ranking` WHERE `user_name` = '$user_name' ORDER BY `post_date` DESC LIMIT 1 ";
			if ($result = mysqli_query($mysqlconn, $query) ){
				$row = mysqli_fetch_assoc($result);
				if($row){
					$reg_datetime = date('Y-m-d H:i:s', strtotime($row["post_date"]." +30 sec"));
					if($reg_datetime >= $post_date_sql){
//						$new_entry = 0;
//						echo ' <br>Error ".__LINE__."：多重投稿エラーが発生しています（1分間に投稿できるのは2回までです）';
					}
				}
			}
		}
		// f06：ユニークIDを生成 ver.2.25から重複チェックにする 参考：http://qiita.com/TetsuTaka/items/bb020642e75458217b8a
		if( $switch[6] ){
			static $chars = '0123456789';
			$unique_id = '';
			for ($i = 0; $i < 6; ++$i) {
				$unique_id .= $chars[mt_rand(0, 9)];
			}
			$edited_ver = str_replace ('.','',$sys_ver);
			$unique_id = $edited_ver.$unique_id;
		}
		// バトルモードの場合はユニークIDを2つ発行する
		if( $ranking_type == "battle" ){
			$unique_id2 = '';
			for ($i = 0; $i < 6; ++$i) {
				$unique_id2 .= $chars[mt_rand(0, 9)];
			}
			$unique_id2 = $edited_ver.$unique_id2;
		}
		// f03：メンテナンスチェック
		if( $switch[3] ){
			if ( $site_mode == 1){
				$new_entry = 0;
				echo " <br>Error ".__LINE__."：ただいまメンテナンスモードになっています。申し訳ありませんが、復旧まで投稿はお控えください。";
			}
		}
		// f00-a：投稿欄ブランクチェック
		if ($secret_flag ==""){
			if( $ranking_type == "normal" or $ranking_type == "limited_team" or $ranking_type == "limited_area" or $ranking_type == "limited" or $ranking_type == "boss" or $ranking_type == "new"){
				if ( $stage_id != 299){
					if ( $user_name =="" OR $password =="" OR $stage_id =="" OR $score =="" OR $console ==""){
						$new_entry = 0;
						echo " <br>Error ".__LINE__."：必須項目が入力されていません。";
					}
				}
			}
			if ($ranking_type == "story"){
				if( ($stage_id > 10204 and $stage_id < 10225) or ($stage_id > 10302 and $stage_id < 10315)){
					if ( $user_name =="" OR $password =="" OR $stage_id =="" OR $console =="" OR $story_rtahour == "" OR $story_rtamin == "" OR $story_rtasec == ""){
							$new_entry = 0;
							echo " <br>Error ".__LINE__."：必須項目が入力されていません。";
					}
				} else {
					if ( $story_pikmin < 1 OR $user_name =="" OR $password =="" OR $stage_id =="" OR $console =="" OR $story_daycount == "" OR $story_rtahour == "" OR $story_rtamin == "" OR $story_rtasec == ""){
							$new_entry = 0;
							echo " <br>Error ".__LINE__."：必須項目が入力されていません。";
					}
				}
			}
			if ($ranking_type == "configure"){
					if ( $user_name =="" OR $password ==""){
						$new_entry = 0;
						echo " <br>Error ".__LINE__."：必須項目が入力されていません。";
				}
			}
			if ($ranking_type == "storycave"){
					if ( $user_name =="" OR $password =="" OR $stage_id =="" OR $score =="" OR $console =="" OR $story_cavepoko =="" OR $story_cavesec ==""){
						$new_entry = 0;
						echo " <br>Error ".__LINE__."：必須項目が入力されていません。";
				}
			}
			if ($ranking_type == "multi"){
					if ( $user_name =="" OR $password =="" OR $stage_id =="" OR $score =="" OR $console =="" OR $user_name_2p =="" OR $console_2p ==""){
						$new_entry = 0;
						echo " <br>Error ".__LINE__."：必須項目が入力されていません。";
				}
			}
		}
		// f14新2：証拠動画必須ラインのチェック（通常ランキング）
		if($ranking_type == "normal" or $ranking_type == "boss"){
			$evidence_check = 0;

			// 免除リストに名前がある場合は１位でなければ免除とする
			if(array_search($user_name, EXEMPTION_LIST) !== false){
				$sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 AND `post_rank` = 1 ORDER BY `score` DESC LIMIT 1";
				$result = mysqli_query($mysqlconn, $sql);
				$row = mysqli_fetch_assoc($result);
				if($result){
			 		$evidence_point = $row["score"];
				} else {
			 		$evidence_point = 0;
				}
				if($score >= $evidence_point){
					// 証拠動画があるかチェックする
					$evidence_check = 1;
				} else {
					echo " <br>Notice".__LINE__."：証拠動画免除ユーザーとして登録します。";
				}
			} else {
				// 免除しない場合はボーダーラインを取得する（10位以上であれば必須）
				if($stage_id >= 201 and $stage_id <= 230){
					$sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 AND `post_rank` < 11 ORDER BY `score` ASC LIMIT 1";
				} else {
					$sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 AND `post_rank` = 1 ORDER BY `score` ASC LIMIT 1";
				}
				$result = mysqli_query($mysqlconn, $sql);
				$row = mysqli_fetch_assoc($result);
				if($result){
			 		$evidence_point = $row["score"];
				} else {
			 		$evidence_point = 0;
				}
				if($score >= $evidence_point){
					// 証拠動画があるかチェックする
					$evidence_check = 1;
				}
			}
			// 管理者権限投稿の場合は完全に免除する
			if($password == ADMIN_PASSWORD) $evidence_check = 0;
			if($evidence_check){
				if(!$video_url and $_FILES['pic_file']['type'][0] !== 'video/mp4'){
					$new_entry = 0;
					echo " <br>Error ".__LINE__."：証拠動画ボーダーライン以上（ピクミン2は10位以上、その他は3位以上、免除申請済みの場合は１位）のスコアには証拠動画が必要です。";
				}
			}
		}
		// f14新：証拠写真必要スコアチェック (通常ランキング)
		// if( $ranking_type == "normal" or $ranking_type == "boss"){
		// 	$evidence_clear = 0;
		// 	// メンテナンスモードの場合は添付不要
		// 	if($mysql_mode) $evidence_clear = 1;
		// 	// 投稿しようとしているステージの投稿数 (4人以下の場合免除)
		// 	$sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0";
		// 	$result = mysqli_query($mysqlconn, $sql );
		// 	if(mysqli_num_rows($result) < 5) $evidence_clear = 1;

		// 	// 投稿しようとしているステージの証拠写真必要スコアを算出 (1024rps以上かつ10位以上の最低値)
		// 	$sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 AND `rps` > 1023 AND `post_rank` < 11 ORDER BY `score` ASC LIMIT 1";
		// 	$result = mysqli_query($mysqlconn, $sql );
		// 	$row = mysqli_fetch_assoc($result);
		// 	if($result){
		// 		$evidence_point[0] = $row["score"];
		// 	} else {
		// 		$evidence_point[0] = 0;
		// 	}
		// 	// 投稿しようとしているステージの証拠写真必要スコアを算出 (1位のスコア)
		// 	$sql = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 AND `post_rank` = 1 ORDER BY `score` ASC LIMIT 1";
		// 	$result = mysqli_query($mysqlconn, $sql );
		// 	$row = mysqli_fetch_assoc($result);
		// 	if($result){
		// 		$evidence_point[1] = $row["score"];
		// 	} else {
		// 		$evidence_point[1] = 0;
		// 	}
		// 	$evidence_point_fixed = min($evidence_point);

		// 	// スコアをチェック
		// 	if($mysql_mode === 1 and $evidence_clear == 0 AND $evidence_point_fixed > 0 AND $evidence_point_fixed <= $score AND ($_FILES['pic_file']['size'] === 0 and $video_check < 1)){
		// 		echo " <br>Error ".__LINE__."：このスコアの登録には証拠写真または証拠動画が必要です。";
		// 		$new_entry = 0;
		// 	}
		// }
		// f14新：証拠写真必須ステージのチェック（ローカルモードの場合はスルー）
		if( $ranking_type == "storycave" or $ranking_type == "limited_team" or $ranking_type == "limited_area" or $ranking_type == "limited" or $ranking_type == "diary" or ($ranking_type == "story" and !($stage_id > 10204 and $stage_id < 10213))){
			if($large_picfile != '' and $_FILES['pic_file']['size'][0] === 0 and $video_check < 1 and $mysql_mode  === 1){
				echo " <br>Error ".__LINE__."：このスコアの登録には証拠写真または証拠動画が必要です。";
				$new_entry = 0;
			}
		}
		// f14：理論値チェック
		if( $switch[14] ){
			if ( $ranking_type == "story"){
			$score_check = 1;
				if($story_daycount < 0 ) $score_check = 0;
				if($story_correct  < 0 ) $score_check = 0;
				if($story_rtahour  < 0 ) $score_check = 0;
				if($story_rtamin   < 0 ) $score_check = 0;
				if($story_rtasec   < 0 ) $score_check = 0;
				if($story_pikmin   < 0 ) $score_check = 0;
				if($story_red      < 0 ) $score_check = 0;
				if($story_blue     < 0 ) $score_check = 0;
				if($story_yellow   < 0 ) $score_check = 0;
				if($story_purple   < 0 ) $score_check = 0;
				if($story_white    < 0 ) $score_check = 0;
				if($story_winged   < 0 ) $score_check = 0;
				if($story_rock     < 0 ) $score_check = 0;

				if( $score_check == 0 AND $secret_flag ==""){
					$new_entry = 0;
					echo ' <br>Error '.__LINE__.'：送信されたスコアが不正な値です。';
				}
			}

			if ( $ranking_type != "story"){
			$score_check = 1;
			if(! is_numeric( $score ) ) $score_check = 0;
			if( $score < 0 ) $score_check = 0;
			if( $stage_id == 101 AND $score > 278) $score_check = 0;
			if( $stage_id == 102 AND $score > 569) $score_check = 0;
			if( $stage_id == 103 AND $score > 482) $score_check = 0;
			if( $stage_id == 104 AND $score > 752) $score_check = 0;
			if( $stage_id == 105 AND $score > 299) $score_check = 0;

			if( $stage_id == 201 AND $score > 59999) $score_check = 0;
			if( $stage_id == 202 AND $score > 59999) $score_check = 0;
			if( $stage_id == 203 AND $score > 59999) $score_check = 0;
			if( $stage_id == 204 AND $score > 59999) $score_check = 0;
			if( $stage_id == 205 AND $score > 59999) $score_check = 0;
			if( $stage_id == 206 AND $score > 59999) $score_check = 0;
			if( $stage_id == 207 AND $score > 59999) $score_check = 0;
			if( $stage_id == 208 AND $score > 59999) $score_check = 0;
			if( $stage_id == 209 AND $score > 59999) $score_check = 0;
			if( $stage_id == 210 AND $score > 59999) $score_check = 0;
			if( $stage_id == 211 AND $score > 59999) $score_check = 0;
			if( $stage_id == 212 AND $score > 59999) $score_check = 0;
			if( $stage_id == 213 AND $score > 59999) $score_check = 0;
			if( $stage_id == 214 AND $score > 59999) $score_check = 0;
			if( $stage_id == 215 AND $score > 59999) $score_check = 0;
			if( $stage_id == 216 AND $score > 59999) $score_check = 0;
			if( $stage_id == 217 AND $score > 59999) $score_check = 0;
			if( $stage_id == 218 AND $score > 59999) $score_check = 0;
			if( $stage_id == 219 AND $score > 59999) $score_check = 0;
			if( $stage_id == 220 AND $score > 59999) $score_check = 0;
			if( $stage_id == 221 AND $score > 59999) $score_check = 0;
			if( $stage_id == 222 AND $score > 59999) $score_check = 0;
			if( $stage_id == 223 AND $score > 59999) $score_check = 0;
			if( $stage_id == 224 AND $score > 59999) $score_check = 0;
			if( $stage_id == 225 AND $score > 59999) $score_check = 0;
			if( $stage_id == 226 AND $score > 59999) $score_check = 0;
			if( $stage_id == 227 AND $score > 59999) $score_check = 0;
			if( $stage_id == 228 AND $score > 59999) $score_check = 0;
			if( $stage_id == 229 AND $score > 59999) $score_check = 0;
			if( $stage_id == 230 AND $score > 59999) $score_check = 0;

			if( $stage_id ==1001 AND $score > 59999) $score_check = 0;
			if( $stage_id ==1002 AND $score > 59999) $score_check = 0;
			if( $stage_id ==1003 AND $score > 59999) $score_check = 0;
			if( $stage_id ==1004 AND $score > 59999) $score_check = 0;

			if( $stage_id == 301 AND $score > 25000) $score_check = 0;
			if( $stage_id == 302 AND $score > 25000) $score_check = 0;
			if( $stage_id == 303 AND $score > 25000) $score_check = 0;
			if( $stage_id == 304 AND $score > 25000) $score_check = 0;
			if( $stage_id == 305 AND $score > 25000) $score_check = 0;
			if( $stage_id == 306 AND $score > 25000) $score_check = 0;
			if( $stage_id == 307 AND $score > 25000) $score_check = 0;
			if( $stage_id == 308 AND $score > 25000) $score_check = 0;
			if( $stage_id == 309 AND $score > 25000) $score_check = 0;
			if( $stage_id == 310 AND $score > 25000) $score_check = 0;
			if( $stage_id == 311 AND $score > 1000)  $score_check = 0;
			if( $stage_id == 312 AND $score > 1000)  $score_check = 0;
			if( $stage_id == 313 AND $score > 1000)  $score_check = 0;
			if( $stage_id == 314 AND $score > 1000)  $score_check = 0;
			if( $stage_id == 315 AND $score > 1000)  $score_check = 0;
			if( $stage_id == 316 AND $score > 1000)  $score_check = 0;

			if( $stage_id == 317 AND $score > 25000) $score_check = 0;
			if( $stage_id == 318 AND $score > 25000) $score_check = 0;
			if( $stage_id == 319 AND $score > 25000) $score_check = 0;
			if( $stage_id == 320 AND $score > 25000) $score_check = 0;
			if( $stage_id == 321 AND $score > 25000) $score_check = 0;
			if( $stage_id == 322 AND $score > 25000) $score_check = 0;
			if( $stage_id == 323 AND $score > 25000) $score_check = 0;
			if( $stage_id == 324 AND $score > 25000) $score_check = 0;
			if( $stage_id == 325 AND $score > 25000) $score_check = 0;
			if( $stage_id == 326 AND $score > 25000) $score_check = 0;
			if( $stage_id == 327 AND $score > 25000) $score_check = 0;
			if( $stage_id == 328 AND $score > 25000) $score_check = 0;
			if( $stage_id == 329 AND $score > 25000) $score_check = 0;
			if( $stage_id == 330 AND $score > 25000) $score_check = 0;
			if( $stage_id == 331 AND $score > 25000) $score_check = 0;
			if( $stage_id == 332 AND $score > 25000) $score_check = 0;
			if( $stage_id == 333 AND $score > 25000) $score_check = 0;
			if( $stage_id == 334 AND $score > 25000) $score_check = 0;
			if( $stage_id == 335 AND $score > 25000) $score_check = 0;
			if( $stage_id == 336 AND $score > 25000) $score_check = 0;

			if( $score_check == 0 AND $secret_flag ==""){
				$new_entry = 0;
				echo ' <br>Error '.__LINE__.'：送信されたスコアが不正な値です。登録しようとしているスコア：'.htmlspecialchars($score).'　ステージID：'.htmlspecialchars($stage_id);
				}
			}
		}
		// 操作方法と選択ステージの整合性チェック
		if( $switch[15] ){
			$console_check = 1;
			if ( $ranking_type != "story" and $ranking_type != "multi"){
//				if( $console == 1 AND $stage_id > 300 AND $stage_id < 400) $console_check = 0; // GCコンでピクミン3
				if( $console  > 2 AND $stage_id < 231) $console_check = 0; // WiiUGamePad、Proコンでピクミン1・2
			}
			if ( $ranking_type == "multi"){
				if( $console == 1 AND $stage_id > 2300 AND $stage_id < 2400) $console_check = 0; // GCコンでピクミン3
				if( $console  > 2 AND $stage_id < 2231) $console_check = 0; // WiiUGamePad、Proコンでピクミン1・2
				if( $console_2p == 1 AND $stage_id > 2300 AND $stage_id < 2400) $console_check = 0; // GCコンでピクミン3
				if( $console_2p  > 2 AND $stage_id < 2231) $console_check = 0; // WiiUGamePad、Proコンでピクミン1・2
			}
			if ( $ranking_type == "story"){
				if( $console == 1 AND $stage_id > 10299 AND $stage_id < 10400) $console_check = 0; // GCコンでピクミン3
				if( $console  > 2 AND $stage_id > 10000 AND $stage_id < 10300) $console_check = 0; // WiiUGamePad、Proコンでピクミン1・2
			}
			if ($stage_id == 399) $console_check = 1; // サンドボックスへの投稿は操作方法矛盾を考慮しない
			if( $console_check == 0){
				$new_entry = 0;
				echo ' <br>Error '.__LINE__.'：選択した操作方法とステージ名が矛盾しています。';
			}
		}
		// f17新：2Pモードのユーザー名重複を検査する (登録しようとしている1Pと2Pが入れ替わっただけの登録をNGとする)
		if( $ranking_type == "multi" ){
			$query = "SELECT * FROM `ranking` WHERE `user_name_2p` = '$user_name' AND `user_name` = '$user_name_2p' AND `stage_id` = '$stage_id' AND `log` = 0 ";
			$result = mysqli_query($mysqlconn, $query);
			$row = mysqli_fetch_assoc($result);
			if($row){
				$score_check = 0;
				echo " <br>Error ".__LINE__."：2Pモードランキングでは1Pと2Pを入れ替えただけの同一ユーザーの組み合わせは別記録として登録できません。";
			}
			if($user_name == $user_name_2p){
				$score_check = 0;
				echo " <br>Error ".__LINE__."：1Pと2Pが同一名のスコアは登録できません。";
			}
		}
		// f17新2：2Pモード以外の登録の場合、2P名とコンソールをリセットする
		if( $ranking_type != "multi" and $ranking_type != "battle" ){
			$user_name_2p = '';
			$console_2p = 0;
		}
		// f17：重複データを検索する
		if( $switch[17] ){
			$query = "SELECT * FROM `ranking` WHERE `user_name` = '$user_name' AND `stage_id` = '$stage_id' AND `log` = 0 LIMIT 1";
			if($ranking_type == "battle") $query = "SELECT * FROM `battle` WHERE `user_name` = '$user_name' AND `stage_id` = '$stage_id' AND `log` = 0 LIMIT 1";
			if ($result = mysqli_query($mysqlconn, $query) ){
				while ($row = mysqli_fetch_assoc($result)) {

					// 必要な前回データを取り出して変数に格納
					$old_user_name	 = $row["user_name"];
					if($ranking_type == "battle") $old_score = $row["rate"];
					if($ranking_type != "battle") $old_score = $row["score"];
					if($ranking_type != "battle") $old_rta = $row["score"];
					$old_post_id	 = $row["post_id"];
					$old_post_date	 = $row["post_date"];
					$old_console	 = $row["console"];
					$old_unique_id	 = $row["unique_id"];
					$old_user_ip	 = $row["user_ip"];
					$old_post_count	 = $row["post_count"];
					$old_post_comment= $row["post_comment"];
					$old_post_memo	 = $row["post_memo"];
					$old_password	 = $row["password"];
					$old_rank	 = $row["post_rank"];
					$old_pic_file	 = $row["pic_file"];
					$old_pic_file2	 = $row["pic_file2"];
					$old_video_url	 = $row["video_url"];

					// MySQLiのStrict設定対策
					if($old_post_date == '') $old_post_date = null;

					// 前回データが存在したらスイッチをON
					if (!$row){
						$old_entry = 0;
					} else {
						$old_entry = 1;
					}
					// スコアチェック (2017/01/05より前回と同じスコアは弾くようにした)
					if ($secret_flag == "" and $ranking_type != "battle"){
						      if ($ranking_type == "story" AND $old_score >= $score AND $old_entry == 1){
							$score_check	 = 1;
						} elseif ($ranking_type != "story" AND $old_score <= $score AND $old_entry == 1){
							$score_check	 = 1;
//							echo " <br>スコアの更新を確認しました。";
						} elseif ($old_entry == 1) {
							// スコアが自己ベを上回っていなくてもシーズントップ記録ならlog=1で登録する
							if($ranking_type != "story") $orderby = "DESC";
							if($ranking_type == "story") $orderby = "ASC";
							$st_query = "SELECT * FROM `ranking` WHERE `user_name` = '$user_name' AND `stage_id` = '$stage_id' AND `post_date` BETWEEN '$season_start' AND '$season_end' ORDER BY `score` $orderby LIMIT 1";
							$st_result = mysqli_query($mysqlconn, $st_query);
							$st_row = mysqli_fetch_assoc($st_result);
							if(($ranking_type != "story" AND $st_row["score"] < $score) or ($ranking_type == "story" AND $st_row["score"] > $score)){
								$score_check = 2;
								echo " <br>今シーズンの自己ベを更新！";
							} else {
								$score_check = 0;
								if($stage_id != 299 ) echo " <br>Error ".__LINE__."：シーズン中の自己ベストを上回っていない記録は登録できません。 <br>自己ベスト:".$old_score." <br>今期トップ：".$st_row["score"]." <br>登録しようとしたスコア".$score ;
							}
						}
					}
				}
			}
		}
		// f15新：バトルモードの場合は2Pの記録も探索する
		if($ranking_type == "battle"){
			$score_check = 1;
			$query = "SELECT * FROM `battle` WHERE `user_name` = '$user_name_2p' AND `stage_id` = '$stage_id' AND `log` = 0 ";
			if ($result = mysqli_query($mysqlconn, $query) ){
				$row = mysqli_fetch_assoc($result);
				$old_score_2p	 = $row["rate"];
				$old_post_id_2p	 = $row["post_id"];
			}
		}
		// f16：期間限定ランキングへの登録期限チェック
		if( $switch[16] ){
			$limited_ranking_date_chack = 1;
			if ($ranking_type == "limited" or $ranking_type == "limited_team" or $ranking_type == "limited_area"){
				if( $now_time < $limited_start_time OR $now_time > $limited_end_time ) $limited_ranking_date_chack = 0;
				if( $limited_ranking_date_chack == 0){
					$new_entry = 0;
					echo ' <br>Error '.__LINE__.'：登録しようとしている期間限定ランキングはまだ始まっていないか、すでに受付が終了しています。 <br>投稿しようとした時刻：'.date('h:m:s',$now_time).'　開始時刻：'.date('h:m:s',$limited_start_time);
				}
			}
			// 日替わりチャレンジの対象ステージをチェック
			if ($ranking_type == "diary"){
				$key = array_search($stage_id, $today_challenge);
				if($key === false){
					$new_entry = 0;
					echo ' <br>Error '.__LINE__.'：登録しようとしている日替わりチャレンジステージはすでに投稿締め切りを過ぎています。（日替わりチャレンジの投稿期限は当日の23時59分までです）'.$stage_id."　".$today_challenge[0]."　".$key;
				}
			}
		}
		// f16新2：エリア踏破戦のチーム分けチェック
		// チーム分けプログラムを実行していないと登録できないようにする
		if($stage_id >= 3066 and $stage_id <= 3112){
			$query = "SELECT * FROM `user` WHERE `user_name` = '$user_name' LIMIT 1";
			if ($result = mysqli_query($mysqlconn, $query) ){
				$row = mysqli_fetch_assoc($result);
				if($row["current_team"] == $team_a or $row["current_team"] == $team_b){
					$current_team = $row["current_team"];
				} else {
					$new_entry = 0;
					echo ' <br>Error '.__LINE__.'：このステージは事前にチーム分けが必須です。総合ページからチーム分けボタンを押してどちらかのチームに所属してから投稿してください。';
				}
			} else {
				$new_entry = 0;
				echo ' <br>Error '.__LINE__.'：データベース取得エラーが発生しています。';
			}
		}
		// f16新：チーム対抗登録チェック（チーム分けアルゴリズム）
		if($new_entry != 0 and ($ranking_type == "limited_team")){
			$team_entry_check = 1;
			$query = "SELECT * FROM `user` WHERE `user_name` = '$user_name'";
			if ($result = mysqli_query($mysqlconn, $query) ){
				$row = mysqli_fetch_assoc($result);
				if(!$row){
					$new_entry = 0;
					echo ' <br>Error '.__LINE__.'：ユーザー登録が完了していません。この期間限定ランキングに参加するには、通常ランキングに1回以上参加する必要があります。';
				} else {
					$current_team = $row["current_team"];
						if($current_team < $team_a){
							if($row["rate"] === NULL){
								$myrate = 500;
							} else {
								$myrate = $row["rate"];
							}
							if($myrate > $rating_class[0]) $myclass = "A";
							if($myrate <=$rating_class[0]) $myclass = "B";
							$query = "SELECT * FROM `user` WHERE `current_team` = '$team_a'";
							$result = mysqli_query($mysqlconn, $query);
							$teamcount_a = mysqli_num_rows($result); // 左チームの参加人数
							$query = "SELECT * FROM `user` WHERE `current_team` = '$team_b'";
							$result = mysqli_query($mysqlconn, $query);
							$teamcount_b = mysqli_num_rows($result); // 右チームの参加人数
							// 1. チームの人数に差がある場合は少ない方に所属する
							if($teamcount_a < $teamcount_b){
								$myteam = $team_a;
							} elseif($teamcount_a > $teamcount_b){
								$myteam = $team_b;
							} else {
								$jump_flag = 1;
							}
							if($jump_flag == 1){
								$jump_flag = 0;
								$query = "SELECT * FROM `user` WHERE `current_team` = '$team_a'";
								$result = mysqli_query($mysqlconn, $query);
								while($row = mysqli_fetch_assoc($result)){
									$team_a_sc[] = $row["rate"];
								}
								$median_a = median($team_a_sc); // チームAの中央値
								$query = "SELECT * FROM `user` WHERE `current_team` = '$team_b'";
								$result = mysqli_query($mysqlconn, $query);
								while($row = mysqli_fetch_assoc($result)){
									$team_b_sc[] = $row["rate"];
								}
								$median_b = median($team_b_sc); // チームAの中央値
								// 2. 両チームの中央値を上回っている場合は少ない方に所属する
								if($myrate < $median_a and $myrate < $median_b){
									if($median_a < $median_b) $myteam = $team_a;
									if($median_a > $median_b) $myteam = $team_b;
									if($median_a ==$median_b) $rand_flag = 1;
								}
								// 3. 両チームの中央値を下回っている場合は高い方に所属する
								elseif($myrate > $median_a and $myrate > $median_b){
									if($median_a > $median_b) $myteam = $team_a;
									if($median_a < $median_b) $myteam = $team_b;
									if($median_a ==$median_b) $rand_flag = 1;
								}
								else {
								// 4. 片方のチームだけ上回っている場合は仮所属して差が少なくなる方に所属する
									$team_a_nc = array_merge($team_a_sc, array($myrate)); // 新規プレイヤーを仮所属させたレートの中央値を求める
									$team_b_nc = array_merge($team_b_sc, array($myrate));
									$median_an = median($team_a_nc);
									$median_bn = median($team_b_nc);
									$abs_a_b = abs($median_an - $median_b); // 新A-元Bの絶対値
									$abs_b_a = abs($median_an - $median_b); // 新B-元Aの絶対値
									if($abs_a_b < $abs_b_a) $myteam = $team_a;
									if($abs_a_b > $abs_b_a) $myteam = $team_b;
									if($abs_a_b ==$abs_b_a) $rand_flag = 1;
								}
								// 5. ランダムフラグが有効の場合、ランダムに決定する
								$myteam = rand($team_a, $team_b);
							}
							// 投稿期間内であれば振り分けたチームを登録する
							if($limited_ranking_date_chack == 1){
								$query ="UPDATE `user` SET `current_team` = '$myteam' WHERE `user_name` = '$user_name' ";
								// ★MYSQL登録
								if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
							echo ' <br>抽選の結果あなたは <b>'.$team[$myteam].'</b> になりました。グッドラック！';
							$current_team = $myteam;
							}
						}
				}
			} else {
			$new_entry = 0;
			echo ' <br>Error '.__LINE__.'：データベース取得エラーが発生しています。';
			}
		}
		// f16新：チーム対抗短期集中戦チェック（後半戦登録時、前半登録済みだったら弾く）
		if($ranking_type == "limited_team"){
			if($stage_id > 1025 and $stage_id < 1029){
				$query = "SELECT * FROM `ranking` WHERE `user_name` = '$user_name' AND `stage_id` IN(1023,1024,1025) AND `log` = 0";
				$result = mysqli_query($mysqlconn, $query);
				if( mysqli_num_rows($result) > 0 ){
					$new_entry = 0;
					echo ' <br>Error '.__LINE__.'：前半戦参加者はこのランキングに参加できません。決定戦の開催をお待ちください。';
				}
			}
		}
		// f16新：チーム対抗ピンポイント戦の投稿数チェック
		if($ranking_type == "limited_team"){
			if(($stage_id > 1028 and $stage_id < 1036) or ($stage_id >= 1043 and $stage_id <= 1050)){
				//チーム別投稿数と投稿可能数を抽出
				if($old_entry != 1){
					$query = "SELECT * FROM `ranking` WHERE `team` = '$current_team' AND `log` = 0";
					$result = mysqli_query($mysqlconn, $query);
					$your_teampost = mysqli_num_rows($result);
					$query = "SELECT * FROM `user` WHERE `current_team` IN(11, 12)";
					$result = mysqli_query($mysqlconn, $query);
					$player_total = mysqli_num_rows($result);
					$postable = $player_total * 2;
					echo ' <br>あなたのチーム：'.$team[$current_team];
					echo ' <br>チームの投稿数：'.$your_teampost;
					echo ' <br>　　投稿可能数：'.$postable;
					if($your_teampost == $postable){
						$new_entry = 0;
						echo ' <br>Error '.__LINE__.'：チームの投稿数が上限に達しています。';
					}
				}
			}
		}
		//f16新：投稿条件が指定されている場合はそのチェック
		if(isset($row["terms"]) and $row["terms"] !== NULL){
			$query = "SELECT * FROM `stage_title` WHERE `stage_id` = '$stage_id' LIMIT 1";
			$result = mysqli_query($mysqlconn, $query);
			$row = mysqli_fetch_assoc($result);
			$terms = explode("_", $row["terms"]);
			if($terms[0] == "LU"){ // LU＝レートが指定数以上でなければ投稿できない
				$user_query = "SELECT * FROM `user` WHERE `user_name` = '$user_name' LIMIT 1";
				$user_result = mysqli_query($mysqlconn, $user_query);
				$user_row = mysqli_fetch_assoc($user_result);
				if($terms[1] > $user_row["rate"]){
					$new_entry = 0;
					echo ' <br>Error '.__LINE__.'：このステージは基本レート'.$terms[1].'以上のプレイヤーのみ投稿できます。';
				}
			}
			if($terms[0] == "LD"){ // LD＝レートが指定数以下でなければ投稿できない
				$user_query = "SELECT * FROM `user` WHERE `user_name` = '$user_name' LIMIT 1";
				$user_result = mysqli_query($mysqlconn, $user_query);
				$user_row = mysqli_fetch_assoc($user_result);
				if($terms[1] < $user_row["rate"]){
					$new_entry = 0;
					echo ' <br>Error '.__LINE__.'：このステージは基本レート'.$terms[1].'以下のプレイヤーのみ投稿できます。';
				}
			}
			if($terms[0] == "MD"){ // MD＝各チームの参加者数が指定数以下・かつ他のMDに参加していない人でなければいけない
				$limited_post_check = 1;
				$user_query = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `team` = '$current_team' AND `log` = 0";
				$user_result = mysqli_query($mysqlconn, $user_query);
				if(mysqli_num_rows($user_result) >= $terms[1]) $limited_post_check = 0; // 参加数チェック
				$user_query = "SELECT * FROM `ranking` WHERE `user_name` = '$user_name' AND `stage_id` IN($terms[2]) AND `log` = 0";
				$user_result = mysqli_query($mysqlconn, $user_query);
				if(mysqli_num_rows($user_result) > 0) $limited_post_check = 0; // 他のステージに参加しているかどうかチェック
				$user_query = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `user_name` = '$user_name' AND `log` = 0";
				$user_result = mysqli_query($mysqlconn, $user_query);
				if(mysqli_num_rows($user_result) > 0) $limited_post_check = 1; // 同ステージに投稿済みの場合は通過とする
				if(!$limited_post_check){
					$new_entry = 0;
					echo ' <br>Error '.__LINE__.'：このステージは各チーム'.$terms[1].'人まで投稿できます。すでに投稿数上限にたっしているため投稿できません。';
				}
			}
			if($terms[0] == "MO"){ // MO＝同大会のMD対象ステージに投稿した人以外でなければいけない
				$terms_st = explode(",", $terms[1]);
				$user_query = "SELECT * FROM `ranking` WHERE `user_name` = '$user_name' AND `stage_id` IN($terms[1]) `log` = 0";
				$user_result = mysqli_query($mysqlconn, $user_query);
				if(mysqli_num_rows($user_result) > 0){
					$new_entry = 0;
					echo ' <br>Error '.__LINE__.'：このステージは同時開催中の人数制限付きステージに未投稿のプレイヤーのみ投稿できます。';
				}
			}
		}
		//f16新：バトルモードの登録情報をチェック
		if($ranking_type == "battle"){
			// レート変動制のルールを選択した場合、大会指定のルールを代入する
			if($battle_reague > 0){
				$player1_pikmin = 25;
				$player2_pikmin = 25;
				$macaroon = 0;
				$reader = 0;
			}
			if($battle_result == 9 or $battle_result == 0) $battle_detail = 0; // 無効試合か引き分けの場合、対戦詳細も引き分けにする

			// 対戦カードNoを設定
			$sql = "SELECT * FROM `battle` ORDER BY `battle_id` DESC LIMIT 1";
			$result = mysqli_query($mysqlconn, $sql);
			$row = mysqli_fetch_assoc($result);
			if($row){
				$battle_id = $row["battle_id"] + 1;
			} else {
				$battle_id = 1;
			}
			// 新レート計算クエリ
			$i = 1;
			$pb1 = array(
				't_prev'=> 1500.0,
				'prev'	=> 1500.0,
				'r_prev'=> 1500.0,
				't_rate'=> 1500.0,
				'rate'	=> 1500.0,
				'r_rate'=> 1500.0,
				't_rd'	=> 30.0,
				'rd'	=> 30.0,
				'r_rd'	=> 30.0
			);
			$pb2 = array(
				't_prev'=> 1500.0,
				'prev'	=> 1500.0,
				'r_prev'=> 1500.0,
				't_rate'=> 1500.0,
				'rate'	=> 1500.0,
				'r_rate'=> 1500.0,
				't_rd'	=> 30.0,
				'rd'	=> 30.0,
				'r_rd'	=> 30.0
			);
			// 前回レートを取得
			$i = 1;
			$play_side = array('', $user_name, $user_name_2p);
			while($i < 3){
				$sql = "SELECT * FROM `battle` WHERE `stage_id` = '$stage_id' AND `user_name` = '$play_side[$i]' AND `log` = 0 LIMIT 1";
				$result = mysqli_query($mysqlconn, $sql);
				$row = mysqli_fetch_assoc($result);
				if($row){
					${'pb'.$i}["prev"] = $row["rate"];
					${'player'.$i.'_win'}=$row["win"];
					${'player'.$i.'_lose'}=$row["lose"];
					${'player'.$i.'_draw'}=$row["draw"];
				}
				$sql = "SELECT * FROM `battle` WHERE `reague` = '$reague' AND `user_name` = '$play_side[$i]' ORDER BY `post_date` DESC LIMIT 1";
				$result = mysqli_query($mysqlconn, $sql);
				$row = mysqli_fetch_assoc($result);
				if($row){
					${'pb'.$i}["r_prev"] = $row["r_rate"];
				}
				$sql = "SELECT * FROM `battle` WHERE `user_name` = '$play_side[$i]' ORDER BY `post_date` DESC LIMIT 1";
				$result = mysqli_query($mysqlconn, $sql);
				$row = mysqli_fetch_assoc($result);
				if($row){
					${'pb'.$i}["t_prev"] = $row["t_rate"];
				}
			$i++;
			}
			// 勝敗からレートを再計算する
			if($battle_result == 1){
				$pb1["rate"]   = battle_rd_calc(1, $pb1["prev"], $pb2["prev"]);
				$pb1["r_rate"] = battle_rd_calc(1, $pb1["r_prev"], $pb2["r_prev"]);
				$pb1["t_rate"] = battle_rd_calc(1, $pb1["t_prev"], $pb2["t_prev"]);
				$pb2["rate"]   = battle_rd_calc(2, $pb2["prev"], $pb1["prev"]);
				$pb2["r_rate"] = battle_rd_calc(2, $pb2["r_prev"], $pb1["r_prev"]);
				$pb2["t_rate"] = battle_rd_calc(2, $pb2["t_prev"], $pb1["t_prev"]);
				$player1_win++;
				$player2_lose++;

			}elseif($battle_result == 2){
				$pb1["rate"]   = battle_rd_calc(2, $pb1["prev"], $pb2["prev"]);
				$pb1["r_rate"] = battle_rd_calc(2, $pb1["r_prev"], $pb2["r_prev"]);
				$pb1["t_rate"] = battle_rd_calc(2, $pb1["t_prev"], $pb2["t_prev"]);
				$pb2["rate"]   = battle_rd_calc(1, $pb2["prev"], $pb1["prev"]);
				$pb2["r_rate"] = battle_rd_calc(1, $pb2["r_prev"], $pb1["r_prev"]);
				$pb2["t_rate"] = battle_rd_calc(1, $pb2["t_prev"], $pb1["t_prev"]);
				$player2_win++;
				$player1_lose++;

			} else {
				$pb1["rate"]   = $pb1["prev"];
				$pb1["r_rate"] = $pb1["r_prev"];
				$pb1["t_rate"] = $pb1["t_prev"];
				$pb2["rate"]   = $pb2["prev"];
				$pb2["r_rate"] = $pb2["r_prev"];
				$pb2["t_rate"] = $pb2["t_prev"];
				$player1_draw++;
				$player2_draw++;
			}
		}

		//f16新：エリア踏破戦チェック（フラグチェック、ボーダーチェック）
		if($ranking_type == "limited_area"){
			$flag_check = 0;
			$query = "SELECT * FROM `area` WHERE `stage_id` = '$stage_id'";
			$result = mysqli_query($mysqlconn, $query);
			$row = mysqli_fetch_assoc($result);
			// 進入禁止エリアへの登録を弾く
			if($row["flag"] < 2){
				$new_entry = 0;
				echo ' <br>Error '.__LINE__.'：進入禁止エリアに登録しようとしています。';
			}
			// 上下左右いずれかに自陣があるかチェック
			$user_area_array   = array();
			$user_area_array[] = $row["id"]; // 現在地
			// 今大会の一番左上から１引いた数値を定義しておく
			$min_point = 147;
			if(($row["id"] - $min_point) % $ae_width[$limited_num] !== 0) $user_area_array[] = $row["id"] + 1; // 東
			if(($row["id"] - $min_point) % $ae_width[$limited_num] !== 1) $user_area_array[] = $row["id"] - 1; // 西
			if($row["id"] > ($min_point + $ae_width[$limited_num])) $user_area_array[] = $row["id"] - $ae_width[$limited_num]; // 北
			if($row["id"] <= ($min_point + ($ae_width[$limited_num] * ($ae_height[$limited_num] - 1)))) $user_area_array[] = $row["id"] + $ae_width[$limited_num]; // 南

			$user_check_array   = array();
			foreach($user_area_array as $val){
				$query = "SELECT * FROM `area` WHERE `id` = '$val'";
				$result = mysqli_query($mysqlconn, $query);
				$row = mysqli_fetch_assoc($result);
				$user_check_array[] = $row["user_name"];
				$team_check_array[] = $row["flag"];
			}
			// 個人戦の場合は自分の陣地の数を数えておく（0の場合は判定しない）
			$query = "SELECT * FROM `area` WHERE `lim` = '$limited_num' AND `user_name` = '$user_name'";
			$result = mysqli_query($mysqlconn, $query);
			$ae_user_count = mysqli_num_rows($result);

			if($stage_id >= 3066 and $stage_id <= 3142){
				// チーム対抗制の場合
				if($cookie_row['current_team'] == $team_a) $flag_jadge = 3;
				if($cookie_row['current_team'] == $team_b) $flag_jadge = 4;
				if(array_search($flag_jadge, $team_check_array) === false){
					$new_entry = 0;
					echo ' <br>Error '.__LINE__.'：自陣が隣接していないエリアに登録しようとしています。あなたのチーム：'.$cookie_row['current_team'].' 上下左右のカラー：<br>'.var_dump($team_check_array);
				}
			} else {
				// 個人・協力制の場合
				if($ae_user_count > 0){
					if(array_search($user_name, $user_check_array) === false){
						$new_entry = 0;
						echo ' <br>Error '.__LINE__.'：自陣が隣接していないエリアに登録しようとしています。';
					}
				}
			}
		}
		// レーティングを再計算する（ピクミン2のみ）（期間限定ランキング非開催時のみ計算する）
		$rate_class_a = array(203, 204, 207, 210, 213, 218, 229, 230);
		$rate_class_b = array(202, 206, 208, 209, 214, 215, 216, 217, 219, 220, 221, 222, 223, 224, 225, 226 ,227, 228);
		$rate_class_c = array(201, 205, 211, 212);

		// 全員分を再計算（管理用）
		if ($admin_flag == 1){
			$new_entry = 0;
			echo "管理用コマンド".__LINE__."：全ユーザーのレートを再計算します。";
		}
		if(($limited_num < 1 and $new_entry != 0 and $stage_id > 200 and $stage_id < 231) or $stage_id == 399 or $admin_flag == 1){
			if($admin_flag != 1) $user = array($user_name);
			// ★再計算負荷テスト中
			$user = array($user_name);

			foreach($user as $user_name){
				// ピクミン2通常ランキングレート（通常レート）
				$rating = 1000;
				foreach(range(201, 230) as $stage_tips){
					$sql = "SELECT * FROM `ranking` WHERE `user_name` = '$user_name' AND `log` = 0 AND `stage_id` = '$stage_tips' LIMIT 1";
					$result = mysqli_query($mysqlconn, $sql);
					$row = mysqli_fetch_assoc($result);
					// ステージごとに参加者数を算出
					$sub_sql = "SELECT * FROM `ranking` WHERE `log` = 0 AND `stage_id` = '$stage_tips'";
					$sub_result = mysqli_query($mysqlconn, $sub_sql);
					$player_count = mysqli_num_rows($sub_result);
					if($row["post_rank"] === NULL or $row["post_rank"] < 1){
						$rate_per = 0;
					} else {
						$rate_per = $row["post_rank"] / $player_count;
					}
					if($rate_per == 0.00){
						if(array_search($stage_tips, $rate_class_a) !== false) $rating -= 21;
						if(array_search($stage_tips, $rate_class_b) !== false) $rating -= 16;
						if(array_search($stage_tips, $rate_class_c) !== false) $rating -= 11;
					} elseif($rate_per < 0.10){
						if(array_search($stage_tips, $rate_class_a) !== false) $rating += 21;
						if(array_search($stage_tips, $rate_class_b) !== false) $rating += 16;
						if(array_search($stage_tips, $rate_class_c) !== false) $rating += 11;
					} elseif($rate_per < 0.25){
						if(array_search($stage_tips, $rate_class_a) !== false) $rating += 13;
						if(array_search($stage_tips, $rate_class_b) !== false) $rating += 8;
						if(array_search($stage_tips, $rate_class_c) !== false) $rating += 6;
					} elseif($rate_per < 0.45){
						if(array_search($stage_tips, $rate_class_a) !== false) $rating += 7;
						if(array_search($stage_tips, $rate_class_b) !== false) $rating += 4;
						if(array_search($stage_tips, $rate_class_c) !== false) $rating += 2;
					} elseif($rate_per < 0.55){
						$rating += 0;
					} elseif($rate_per < 0.75){
						if(array_search($stage_tips, $rate_class_a) !== false) $rating -= 7;
						if(array_search($stage_tips, $rate_class_b) !== false) $rating -= 4;
						if(array_search($stage_tips, $rate_class_c) !== false) $rating -= 2;
					} else {
						if(array_search($stage_tips, $rate_class_a) !== false) $rating -= 21;
						if(array_search($stage_tips, $rate_class_b) !== false) $rating -= 16;
						if(array_search($stage_tips, $rate_class_c) !== false) $rating -= 11;
					}
				}
				$query_rps = "UPDATE `user` SET `rate` = '$rating' WHERE `user_name` = '$user_name' ";
				if(!$_SESSION['debug_mode']) $result_rps = mysqli_query($mysqlconn, $query_rps );

				// 期間限定ランキングレート（期間限定レート）

				// 対象ステージを配列で取得
				$top_select_stage = ${'limited'.$limited_stage_list[$end_of_limited - 2]}[0];
				$last_select_stage= end(${'limited'.$limited_stage_list[$end_of_limited]});
				
				// 値をリセット
				$user_rate = array();

				// 各ユーザーごとにレートを計算
				$limited_rate_query = "SELECT `rps` FROM `ranking` WHERE `stage_id` BETWEEN '$top_select_stage' AND '$last_select_stage' AND `log` = 0 AND `user_name` = '$user_name'";
				$limited_rate_result = mysqli_query($mysqlconn, $limited_rate_query);
				while($limited_rate_row = mysqli_fetch_assoc($limited_rate_result)){
					$user_rate[] = $limited_rate_row['rps'];
				}
				$user_rate_count = count($user_rate);
				$user_rate_sum = array_sum($user_rate);
				if($user_rate_sum < 1){
					$user_rate_sum = 0;
					$user_rate_ave = 0;
				} else {
					$user_rate_ave = $user_rate_sum / $user_rate_count;
				}
				$limited_rate = round((($user_rate_sum * $user_rate_ave * 1.5 / 100000) + 1) * $rating);
				$limited_rate_query = "UPDATE `user` SET `limrate` = '$limited_rate' WHERE `user_name` = '$user_name' ";
				if(!$_SESSION['debug_mode']) $result_rps = mysqli_query($mysqlconn, $limited_rate_query);
			}
		}

		// f18：送信する画像処理
		//参考：http://up300.net/blog/php%E3%81%AE%E3%83%95%E3%82%A9%E3%83%BC%E3%83%A0%E3%81%A7%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB%E3%81%AE%E3%82%A2%E3%83%83%E3%83%97%E3%83%AD%E3%83%BC%E3%83%89%E3%82%92%E3%81%99%E3%82%8B2/

		// 2017年12月26日現在、画像アップロード自体は複数対応しているが投稿できるのは２つまで★
		if(!isset($_FILES['pic_file']) and $large_picfile == ''){
		    echo ' <br>Error '.__LINE__.'：ページ遷移が不正、または画像添付エラーです。';
		    $entry_success = 0;
		}else{
		for($i = 0; $i <= 1; $i++){
		    if($_FILES['pic_file']['error'][$i] !== UPLOAD_ERR_OK){

		        //エラーが発生している
		        if($_FILES['pic_file']['error'][$i] == UPLOAD_ERR_FORM_SIZE){
		            echo ' <br>Error '.__LINE__.'：ファイルサイズがHTMLで指定した MAX_FILE_SIZE を超えています。';
			    $entry_success = 0;
			    $new_entry = 0;
		        }elseif($_FILES['pic_file']['error'][$i] == UPLOAD_ERR_NO_FILE){
//		            echo ' <br>Error '.__LINE__.'：添付ファイルが存在しません。'.var_dump($_FILES['pic_file']);
			    $entry_success = 1;
		        }

		    }else{

		        //ここから通常の処理

		        //ユーザーが指定したファイル名
		        $myfile_name = $_FILES['pic_file']['name'][$i];
		        //ファイルのMIME型
		        $myfile_type = $_FILES['pic_file']['type'][$i];
		        //ファイルサイズ
		        $myfile_size = $_FILES['pic_file']['size'][$i];
		        //アップロードしたファイルが保存されている一時保存場所
			$myfile_tmp_path = $_FILES['pic_file']['tmp_name'][$i];

		        //SQLインジェクション対策用
		        $safesql_myfile_name = mysqli_real_escape_string($mysqlconn, $myfile_name);
		        $safesql_myfile_type = mysqli_real_escape_string($mysqlconn, $myfile_type);

		        //HTML表示用
		        $safehtml_myfile_name = htmlspecialchars($myfile_name);
		        $safehtml_myfile_type = htmlspecialchars($myfile_type);


		        //拡張子の取得
		        $tmp_ary = explode('.',$myfile_name);
		        if(count($tmp_ary)>1){
		            $extension = $tmp_ary[count($tmp_ary)-1];

		            //拡張子が半角英数字以外なら拡張子がないものとする。
		            if( !preg_match("/^[0-9a-zA-Z]+$/",$extension) ) $extension='';
		        }else{
		            //拡張子がない場合はそのまま。Macなど。
		            $extension='';
		        }

		        //SQLインジェクション対策用
		        $safesql_extension = mysqli_real_escape_string($mysqlconn, $extension);
		        //HTML表示用
		        $safehtml_extension = htmlspecialchars($extension);


		        //新しいファイル名を作成する
		        $new_file_name[$i] = date("Ymd-His").'-'.mt_rand().'.'.$safehtml_extension;

		        //php側でもファイルサイズのチェックを行う
		        if($myfile_size > 3145728 or $myfile_size == 0){
				echo ' <br>Error '.__LINE__.'：添付画像のファイルサイズが不正です（許容範囲は３MB以下＝3,145,728バイト以下です）。';
//				echo ' <br>Error '.__LINE__.'：添付画像のファイルサイズが不正です（許容範囲は40MB以下＝41,943,040バイト以下です）。';
				$new_entry = 0;
			}

			if($new_entry == 1){
			        //ファイルの保存場所
			        if( $mysql_mode) $myfile_new_path = '/home/users/0/chronon/web/chr.mn/_img/pik4/uploads';
			        if(!$mysql_mode) $myfile_new_path = 'D:/Dropbox/web/htdocs/chr.mn/_img/pik4/uploads';
			        if(!move_uploaded_file($myfile_tmp_path,"$myfile_new_path/$new_file_name[$i]")){
					echo ' <br>Error '.__LINE__.'：画像・動画ファイルを保存できませんでした。';
					$new_entry = 0;
			        } else {
//					echo ' <br>Notice'.__LINE__.'：ファイルの保存に成功しました。';
					$success_picupload = 1;
				}
			}
		    }
		}
		}
		// 投稿内容を表示する
//		echo " <br>投稿者名：".htmlspecialchars($user_name, ENT_QUOTES)." <br>パスワード：**** <br>ステージID：".htmlspecialchars($stage_id, ENT_QUOTES)." <br>スコア：".htmlspecialchars($score, ENT_QUOTES)." <br>コメント：".htmlspecialchars($post_comment, ENT_QUOTES)." <br>操作方法：".htmlspecialchars($console, ENT_QUOTES)." <br>IP：".htmlspecialchars($user_ip, ENT_QUOTES)." <br>投稿日時：".htmlspecialchars($post_date, ENT_QUOTES)." <br>ユニークID：".htmlspecialchars($unique_id, ENT_QUOTES)." <br>" ;
	}
	// 各種チェックに合格なら以下を実行
	if ( $score_check != 0 AND $old_datamatch != 0 AND $new_entry == 1){

			if($score_check == 1){
				// f19：前回スコアに非表示フラグを立てる
				if( $old_entry == 1){
					$prev_score = $old_score;
					$firstpost_date = $old_post_date;
					$post_memo  = $old_post_memo;

						//前回スコアと今回スコアが同じなら投稿回数を増やさない
						if ($old_score == $score and $ranking_type != "battle"){
							$post_count = $old_post_count;
							$post_date = $old_post_date;
							$new_file_name[0] = $old_pic_file;
							$new_file_name[1] = $old_pic_file2;
							$video_url = $old_video_url;
						} else {
							$post_count = $old_post_count + 1;
						}
					if (! $post_comment ){
						$post_comment = $old_post_comment;
					}
				if($ranking_type != "battle") $query ="UPDATE `ranking` SET `log` = 1 WHERE `post_id` = '$old_post_id' ";
				if($ranking_type == "battle") $query ="UPDATE `battle` SET `log` = 1 WHERE `post_id` = '$old_post_id' ";
				if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
					// バトルモードの場合2Pの最新記録もlogをトグルする
					if($ranking_type == "battle"){
						$query ="UPDATE `battle` SET `log` = 1 WHERE `post_id` = '$old_post_id_2p' ";
						if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
					}
				}
			}

			if($score_check == 2){
				$old_post_id = $st_row["post_id"];
				$prev_score = $st_row["score"];
				$firstpost_date = $old_post_date;
				$post_memo  = $old_post_memo;
				$query ="UPDATE `ranking` SET `season` = '' WHERE `post_id` = '$old_post_id' ";
				// ★MYSQL登録
				if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );

			}


			// f20：スコア登録本体
		if( $switch[20] ){
			// シーズンフラグを設定
			if($score_check == 2){
				$into = " ,`log`";
				$valu = " , 1";
			} else {
				$into = "";
				$valu = "";
			}
			// レートを取得
			$sql = "SELECT * FROM `user` WHERE `user_name` = '$user_name' LIMIT 1";
			$result = mysqli_query($mysqlconn, $sql);
			$user_data = mysqli_fetch_assoc($result);
			$myrate = $user_data["rate"];

			// エリア踏破戦×チーム対抗戦は擬似的にチーム対抗戦と同じ登録
			if($stage_id >= 3066 and $stage_id <= 3112){
			$query = "INSERT INTO `ranking`( `user_name`, `stage_id`, `score`, `console`, `user_ip`, `user_host`, `user_agent`, `unique_id`, `post_comment`, `post_date`, `post_count`,`prev_score`,`pic_file`,`pic_file2`,`firstpost_date`,`video_url`,`prev_rank`,`team`,`rate`) VALUES('$user_name','$stage_id','$score','$console','$user_ip','$user_host','$user_agent','$unique_id','$post_comment','$post_date','$post_count','$prev_score','$new_file_name[0]','$new_file_name[1]','$firstpost_date','$video_url','$old_rank','$current_team','$myrate')";
			if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );

			// 本編・チーム対抗以外
			} elseif($ranking_type != "battle" and $ranking_type != "free_post" and $ranking_type != "configure" and $ranking_type != "story" and $ranking_type != "storycave" and $ranking_type != "limited_team" and $ranking_type != "limited_area"){
			if($score_check == 1) $query = "INSERT INTO `ranking`( `user_name`, `stage_id`, `score`, `console`, `user_ip`, `user_host`, `user_agent`, `unique_id`, `post_comment`, `post_date`, `post_count`,`prev_score`,`pic_file`,`pic_file2`,`firstpost_date`,`video_url`,`prev_rank`,`season`,`user_name_2p`,`console_2p`,`rate`,`post_memo`) VALUES('$user_name','$stage_id','$score','$console','$user_ip','$user_host','$user_agent','$unique_id','$post_comment','$post_date','$post_count','$prev_score','$new_file_name[0]','$new_file_name[1]','$firstpost_date','$video_url','$old_rank','$season','$user_name_2p','$console_2p','$myrate','$post_memo')";
			if($score_check == 2) $query = "INSERT INTO `ranking`( `user_name`, `stage_id`, `score`, `console`, `user_ip`, `user_host`, `user_agent`, `unique_id`, `post_comment`, `post_date`, `post_count`,`prev_score`,`pic_file`,`pic_file2`,`firstpost_date`,`video_url`,`prev_rank`,`log`,`season`,`user_name_2p`,`console_2p`,`rate`,`post_memo`) VALUES('$user_name','$stage_id','$score','$console','$user_ip','$user_host','$user_agent','$unique_id','$post_comment','$post_date','$post_count','$prev_score','$new_file_name[0]','$new_file_name[1]','$firstpost_date','$video_url','$old_rank','1','$season','$user_name_2p','$console_2p','$myrate','$post_memo')";
			if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
			var_dump(mysqli_error($mysqlconn));

			// バトルモード
			} elseif($ranking_type == "battle"){
			$query = "INSERT INTO `battle` ( `user_name`, `stage_id`, `unique_id`, `post_date`, `user_ip`, `user_host`, `user_agent`, `result`, `pic_file`,`pic_file2`, `video_url`, `post_comment`, `macaroon`, `leader`, `pikmin`, `battle_id`, `post_rank`,`rate`,`prev`,`t_rate`,`t_prev`,`r_rate`,`r_prev`, `win`, `lose`, `draw`, `reague`, `console`, `post_count`,`detail`,`playside`) VALUES('$user_name','$stage_id','$unique_id','$post_date','$user_ip','$user_host','$user_agent','$player1_result','$new_file_name[0]','$new_file_name[1]','$video_url','$post_comment','$macaroon','$leader','$player1_pikmin','$battle_id','$post_rank','$pb1[rate]','$pb1[prev]','$pb1[t_rate]','$pb1[t_prev]','$pb1[r_rate]','$pb1[r_prev]','$player1_win','$player1_lose','$player1_draw','$battle_reague','$console','$post_count','$battle_detail',1)";
			if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
			$query = "INSERT INTO `battle` ( `user_name`, `stage_id`, `unique_id`, `post_date`, `user_ip`, `user_host`, `user_agent`, `result`, `pic_file`,`pic_file2`, `video_url`, `post_comment`, `macaroon`, `leader`, `pikmin`, `battle_id`, `post_rank`,`rate`,`prev`,`t_rate`,`t_prev`,`r_rate`,`r_prev`, `win`, `lose`, `draw`, `reague`, `console`, `post_count`,`detail`,`playside`) VALUES('$user_name_2p','$stage_id','$unique_id2','$post_date','$user_ip','$user_host','$user_agent','$player2_result','$new_file_name[0]','$new_file_name[1]','$video_url','$post_comment','$macaroon','$leader','$player2_pikmin','$battle_id','$post_rank','$pb2[rate]','$pb2[prev]','$pb2[t_rate]','$pb2[t_prev]','$pb2[r_rate]','$pb2[r_prev]','$player2_win','$player2_lose','$player2_draw','$battle_reague','$console_2p','$post_count','$battle_detail',2)";
			if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );

			// チーム対抗
			} elseif($ranking_type == "limited_team" or $ranking_type == "limited_area"){
			$query = "INSERT INTO `ranking`( `user_name`, `stage_id`, `score`, `console`, `user_ip`, `user_host`, `user_agent`, `unique_id`, `post_comment`, `post_date`, `post_count`,`prev_score`,`pic_file`,`pic_file2`,`firstpost_date`,`video_url`,`prev_rank`,`team`,`rate`) VALUES('$user_name','$stage_id','$score','$console','$user_ip','$user_host','$user_agent','$unique_id','$post_comment','$post_date','$post_count','$prev_score','$new_file_name[0]','$new_file_name[1]','$firstpost_date','$video_url','$old_rank','$current_team','$myrate')";
			if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );

			// 本編
			} elseif($ranking_type == "story") {
			$query = "INSERT INTO `ranking`( `user_name`, `stage_id`, `score`, `console`, `user_ip`, `user_host`, `user_agent`, `unique_id`, `post_comment`, `post_date`, `post_count`,`prev_score`,`pic_file`,`pic_file2`,`firstpost_date`,`video_url`,`prev_rank`,`days`,`correct`,`pikmin`,`red_pikmin`,`yellow_pikmin`,`blue_pikmin`,`white_pikmin`,`purple_pikmin`,`rock_pikmin`,`winged_pikmin`,`death`,`lim`,`story_pts`,`story_han`) VALUES('$user_name','$stage_id','$score','$console','$user_ip','$user_host','$user_agent','$unique_id','$post_comment','$post_date','$post_count','$prev_score','$new_file_name[0]','$new_file_name[1]','$firstpost_date','$video_url','$old_rank','$story_daycount','$story_correct','$story_pikmin','$story_red','$story_yellow','$story_blue','$story_white','$story_purple','$story_rock','$story_winged','$story_death','$story_lim_imp','$story_lim_pts','$story_lim_han')";
			if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );

			// 本編地下
			} elseif($ranking_type == "storycave") {
			$query = "INSERT INTO `ranking`( `user_name`, `stage_id`, `score`, `console`, `user_ip`, `user_host`, `user_agent`, `unique_id`, `post_comment`, `post_date`, `post_count`,`prev_score`,`pic_file`,`pic_file2`,`firstpost_date`,`video_url`,`prev_rank`,`days`,`correct`,`pikmin`,`red_pikmin`,`yellow_pikmin`,`blue_pikmin`,`white_pikmin`,`purple_pikmin`,`bulbmin`,`queen_candypop_bud`,`death`,`rta_time`) VALUES('$user_name','$stage_id','$score','$console','$user_ip','$user_host','$user_agent','$unique_id','$post_comment','$post_date','$post_count','$prev_score','$new_file_name[0]','$new_file_name[1]','$firstpost_date','$video_url','$old_rank','$story_daycount','$story_cavepoko','$lastpikmin','$storyc_red','$storyc_yellow','$storyc_blue','$storyc_white','$storyc_purple','$storyc_koppa','$storyc_popoga','$storyc_death','$lasttime')";
			if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
			}
			// 自由記述投稿
			if($ranking_type == "free_post") {
			$query = "INSERT INTO `memo`( `user_name`, `user_ip`, `user_host`, `user_agent`, `post_date`, `post_text`) VALUES('$user_name','$user_ip','$user_host','$user_agent','$post_date','$conf_text')";
			if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
			echo "Notice：投稿を受け付けました。";
			}
			// プロフィール登録
			if($ranking_type == "profile_post") {
			$query = "UPDATE `user` SET `fav_stage_id` = '$fav_stage_id', `user_comment` = '$prof_text', `sitetitle` = '$prof_sitetitle' , `website` = '$prof_mysite', `nicovideo` = '$prof_nicovideo', `twitch` = '$prof_twitch', `youtube` = '$prof_youtube', `twitter` = '$prof_twitter' WHERE `user_name` = '$user_name'";
			if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
			echo "Notice：プロフィール投稿を受け付けました（すでに登録されている場合は上書きします）。";
			}
			// スコアを削除
			if ( $conf == "record_delete"){
			$query ="UPDATE `ranking` SET `log` = 2 WHERE `unique_id` = '$conf_value'";
			if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
			echo "Notice：スコアを削除しました。";
			$entry_success = 1;
			}
			// スコア情報を更新
			if ($conf == "record_update"){
				$post_unixtime	= time();
				$post_dummy	= date("YmdHis", $post_unixtime);
				$old_str = $post_memo.$post_dummy.':';
				if($old["post_comment"]) $old_str .= ' #comment='.$old["post_comment"];
				if($old["pic_file"]) $old_str .= ' #picfile='.$old["pic_file"];
				if($old["video_url"]) $old_str .= ' #videourl='.$old["video_url"];
				$old_str .= " | ";

				// リセットフラグがOFFの場合、修正フォームが空白のカラムは前回情報を継承する
				if(!$post_reset){
					if(!$post_comment) $post_comment = $old["post_comment"];
					if($new_file_name[0] == "") $new_file_name[0] = $old["pic_file"];
					if(!$video_url) $video_url = $old["video_url"];
				// リセットフラグがONの場合、空白はすべて削除する
				} else {
					if(!$post_comment) $post_comment = "コメントなし";
				}
				$query ="UPDATE `ranking` SET `post_comment` = '$post_comment', `pic_file` = '$new_file_name[0]', `video_url` = '$video_url', `post_memo` = '$old_str' WHERE `unique_id` = '$conf_value'";
				// ★MYSQL登録
				if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
				if(!$result) echo "<br>Error ".__LINE__."：コメント・証拠動画・証拠画像の更新処理に失敗しています。";
				if( $result) echo "登録情報を更新しました。";
				if( $result) $entry_success = 1;
			}
		}
		// 2Pはパスワード有無にかかわらずユーザー登録していなければユーザー登録する
		if($user_name_2p){
			$sql = "SELECT * FROM `user` WHERE `user_name` = '$user_name_2p' LIMIT 1";
			$result = mysqli_query($mysqlconn, $sql);
			$row = mysqli_fetch_assoc($result);
			if(!$row){
				$query = "INSERT INTO `user`(`user_name`) VALUES('$user_name_2p')";
				if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
				echo " <br>Notice：2Pユーザー名を暫定登録しました（次回、1Pとしてスコア登録したときに本登録となります）。";
			}
		}
		if( $switch[21] ){
			// f21-1：ユーザー別最終更新日を書き換える
			$query ="UPDATE `user` SET `lastupdate` = '$post_date' WHERE `user_name` = '$user_name' ";
			// ★MYSQL登録
			if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );

			// f21-2：ユーザー情報を更新
			if( $data_user_name == "" AND $crypted_pass == ""){
				$new_post_count = 1;
				$query = "INSERT INTO `user`( `user_name`,`pass`,`post_count`) VALUES('$user_name','$new_pass','$new_post_count')";
				if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
				echo " <br>Notice：新規ユーザー登録が完了しました。";
				$now_tp = 30;
				$query ="UPDATE `user` SET `tp` = '$now_tp' WHERE `user_name` = '$user_name' ";
				if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );

			} elseif( $data_user_name != "" AND $crypted_pass == ""){
				$new_post_count = $data_post_count + 1;
				$query ="UPDATE `user` SET `pass` = '$new_pass' WHERE `user_name` = '$user_name' ";
				$result = mysqli_query($mysqlconn, $query );
				if(!$_SESSION['debug_mode']) echo " <br>Notice：パスワードを更新しました。";
//				echo " <br>あなたの投稿総数：".$new_post_count ;

			} else {
				$new_post_count = $data_post_count + 1;
				$query ="UPDATE `user` SET `post_count` = '$new_post_count' WHERE `user_name` = '$user_name' ";
				if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
//				echo " <br>あなたの投稿総数：".$new_post_count ;
			}

			// TP(タマゴムシポイント) を更新する
			if ($stage_id != 299){
				$now_tp = $now_tp + 10;
				$query ="UPDATE `user` SET `tp` = '$now_tp' WHERE `user_name` = '$user_name' ";
				if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );

				$query ="SELECT * FROM `meta` WHERE `name` = 'tp' ";
				$result = mysqli_query($mysqlconn, $query );
				$row = mysqli_fetch_assoc($result);
				$shere_tp = $row["value"];
				$shere_tp = $shere_tp + 10;
				$query ="UPDATE `meta` SET `value` = '$shere_tp' WHERE `name` = 'tp' ";
				if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );

				echo " <br>Notice：今回のスコアの登録に成功しました。（succeeded in registering this score.）";
			}
			$entry_success = 1;
		}
	}

		// 登録後の包括的な処理
		if ($entry_success == 1 or $admin_flag == 1){

			// // エリア踏破戦ピンポイント制の場合、６番目以降に古いステージにフラグを立てる
			// if($stage_id >= 3066 and $stage_id <= 3095){
			// 	$query = "SELECT `post_id` FROM `ranking` WHERE `user_name` = '$user_name' AND `stage_id` BETWEEN 3066 AND 3095 AND `log` = 0 ORDER BY `post_date` LIMIT 25 OFFSET 5";
			// 	$result = mysqli_query($mysqlconn, $query);
			// 	// 取得したデータのpost_memo欄にコードを付加
			// 	while($af_row = mysqli_fetch_assoc($result)){
			// 		$af_id = $af_row['post_id'];
			// 		$update_query = "UPDATE `ranking` SET `post_memo` = 'area_delete' WHERE `post_id` = '$af_id'";
			// 		if(!$_SESSION['debug_mode']) $result_af = mysqli_query($mysqlconn, $update_query );
			// 	}
			// }
			if( $switch[23] and ($ranking_type != "limited_team" and $ranking_type != "limited_area")){

				// ステージの数だけループする
				$array_stage_list = array();
				if($ranking_type == "admin"){
					$array_stage_list   = array_column($stage, 'stage_id');
					// 再計算でサーバーが落ちる場合はここで対象ステージを絞り込む
					$array_stage_list   = range(311, 316);
				} else {
					$array_stage_list[] = $stage_id;
				}
				foreach($array_stage_list as $stage_id){

					// 登録したステージのRPSと順位を再計算する
					$battle_flag = 0;
					$story_flag = 0;

					if($ranking_type != "admin"){
						if($ranking_type != "story" and $del_ranking_type != "story")   $query = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` DESC";
						if($ranking_type == "story" or  $del_ranking_type == "story")   $query = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` ASC";
						if($ranking_type == "battle")					$query = "SELECT * FROM `battle` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `rate` DESC";
					} else {
						// 期間限定ランキング総合と過去の参加者企画は再計算しない
						if($stage_id > 100000 or ($stage_id > 4000 and $stage_id < 4061)){
							continue;

						// 以下はサーバーの負荷に合わせてスキップする場合は continue を有効にする
						// チャレンジモード複合
						} elseif($stage_id > 10204 and $stage_id < 10215){
							$query = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` ASC";
							continue;

						// 本編
						} elseif(($stage_id > 10000 and $stage_id < 10205) or ($stage_id > 10299 and $stage_id < 10400)){
							$story_flag = 1;
							$query = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` ASC";
							continue;

						// バトルモード
						} elseif(($stage_id > 274 and $stage_id < 285) or ($stage_id > 336 and $stage_id < 349)){
							$battle_flag = 1;
							$query = "SELECT * FROM `battle` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `rate` DESC";
							continue;

						// 期間限定ランキング・参加者企画
						} elseif(($stage_id > 1000 and $stage_id < 2000) or ($stage_id > 3000 and $stage_id < 5000)){
							$query = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` DESC";
							continue;

						// その他すべて
						} else {
							$query = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 ORDER BY `score` DESC";
							// continue;
						}
					}
					if ($result = mysqli_query($mysqlconn, $query) ){
						$i = 1; // カウント番号
						$p = 0; // 前のカウント番号
						$rps_user = array();
						$rows_count = mysqli_num_rows($result);
						while ($row = mysqli_fetch_assoc($result) ) {
							if($ranking_type == "battle" or $battle_flag == 1) $row["score"] = $row["rate"];
							$rps_score[$i] = $row["score"];
							if($ranking_type == "story" or $story_flag == 1) $rps_score[$i] = $row["score"];
							$rps_id[$i]    = $row["post_id"];
							$rps_user[$p]  = $row["user_name"];
							if($i > 1){
								if($rps_score[$i] == $rps_score[$p]){
									$rps_rank[$i] = $rps_rank[$p];
								} else {
									$rps_rank[$i] = $i;
								}
							} else {
								$rps_rank[$i] = 1;
							}

							// ランクポイント計算（2007/04/29～2019/05/30）
							// 通常　： RPS = (参加人数 - 順位 + 1)^(SP) *(FP) + (rounddown(参加人数/10)
							// チーム： TPS = (期間限定総合の参加人数 - 順位 + 1) [1位のとき＝(参加人数 - 1) * 2
							// SP  ：通常ランキング = 2, 本編ランキング = 3
							// FP  ：1位 = 4, 2～3位 = 3, 4～10位 = 2, 11位以下 = 1
							// 現在の期間限定ランキングの参加者数

							// ランクポイント計算（2019/06/01～）
							// 通常　： RPS = (参加人数 - 順位 + 1)^2 *(FP) + (参加人数 * 9) + (BP)
							// 特殊　： TPS = (期間限定総合の参加人数 - 順位 + 1)
							// 本編　： RPS = (参加人数 - 順位 +21)^2 *(FP) + (参加人数 *19) + (BP)
							// BP　　： 10位以上の場合のみ、(10 - 順位 + 1) * 155
							// FP  　： 1位 = 4, 2～3位 = 3, 4～10位 = 2, 11～20尾 = 1.5, 20位以下 = 1

							// 段階点
							if ( $rps_rank[$i] == 1){
								$rp_level = 4;
							} elseif ($rps_rank[$i] < 4) {
								$rp_level = 3;
							} elseif ($rps_rank[$i] < 11) {
								$rp_level = 2;
							} elseif ($rps_rank[$i] < 21) {
								$rp_level = 1.5;
							} else {
								$rp_level = 1;
							}
							// ボーナスポイント
							if( $rps_rank[$i] == 0){
								$bonus_point = 0;
							} elseif ($rps_rank[$i] < 11){
								$bonus_point = (10 - $rps_rank[$i] + 1) * 155;
							} else {
								$bonus_point = 0;
							}
							// 参加人数による分岐（50人以上の場合基礎点の上昇を抑える）
							if($ranking_type == "story" or  $del_ranking_type == "story" or $story_flag == 1){
								$tail_point = 21;
								$afte_point = 19;
							} else {
								$tail_point = 1;
								$afte_point = 9;
							}
							if($rows_count > 50){
								$switch_point = floor( pow( ($rows_count - $rps_rank[$i] + $tail_point) * 50 / $rows_count, 2) );
							} else {
								$switch_point =        pow(  $rows_count - $rps_rank[$i] + $tail_point, 2);
							}
							if(($stage_id > 1000 and $stage_id < 2000) or ($stage_id > 3000 and $stage_id < 4000)){
								// 期間限定ランキングのランクポイント計算
								$rps[$i] = $limited_player[parent_stage_id($stage_id)] - $rps_rank[$i] + 1;
							} elseif($stage_id > 4000 and $stage_id < 5000){
								// 参加者企画のランクポイント計算
								$rps[$i] = $uplan_player[parent_stage_id($stage_id)] - $rps_rank[$i] + 1;
							} else {
								// ランクポイント計算実部（期間限定ランキング・参加者企画を除くすべて）
								$rps[$i] = floor( $switch_point * $rp_level ) + ($rows_count * $afte_point) + $bonus_point;
							}
							// ランクポイントを更新する
							$query_rps ="UPDATE `ranking` SET `post_rank` = '$rps_rank[$i]' , `rps` = '$rps[$i]' WHERE `post_id` = '$rps_id[$i]' ";
							if($ranking_type == "battle" or $battle_flag == 1) $query_rps ="UPDATE `battle` SET `post_rank` = '$rps_rank[$i]' , `rps` = '$rps[$i]' WHERE `post_id` = '$rps_id[$i]' ";
							if(!$_SESSION['debug_mode']) $result_rps = mysqli_query($mysqlconn, $query_rps );

							$i++;
							$p++;
						}
						// １ステージあたりの処理ここまで
					}
					// ステージの数だけループここまで
				}
			}

			// f24新：シーズン別最高記録を更新
			$sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$stage_id'";
			$result = mysqli_query($mysqlconn, $sql);
			$row = mysqli_fetch_assoc($result);
			$season_column = 's'.$season.'_top';
			$now_seaton_top = $row[$season_column];
			if($now_seaton_top < $score){
				$query_season = "UPDATE `stage_title` SET $season_column = '$score' WHERE `stage_id` = '$stage_id' ";
				if(!$_SESSION['debug_mode']) $result_season = mysqli_query($mysqlconn, $query_season );
				if($result_season){
					if(!$blind) echo " <br>第".$season."期のトップスコアを更新！ (".$now_seaton_top."→".$score.")";
				} else {
					echo " <br>Error ".__LINE__."：総合情報登録エラーが発生しています。";
				}
			}

			// f24：合計スコアを算出
			if( $switch[24] ){
				$user_name_list = array();
				if($ranking_type == "admin"){ // ★暫定
					$user_name_list = $user;
					// 再計算でサーバーが落ちる場合はここで対象ユーザーを絞り込む
					$user_name_list[] = "Johnson";
				} elseif($ranking_flag == 1){
					$user_name_list = $array_member2;
				} else {
					$user_name_list[]= $user_name;
				}
				if($user_name_2p) $user_name_list[]= $user_name_2p;
				$stage_output1 = range(101, 105);
				$stage_output2 = range(201, 230);
				$stage_output3 = range(301, 336);
				$stage_normal_array  = array_merge($stage_output1, $stage_output2, $stage_output3);

				// 登録ユーザーの合計スコアを算出して更新
				foreach($user_name_list as $user_name){
					total_season_calc("score","season_pik2cha", range(201 ,230), $user_name);
					total_season_calc("rps","season_normal",$stage_normal_array , $user_name);
					total_score_calc("`ranking`", "total_point", "(`stage_id` BETWEEN 101 AND 105 OR `stage_id` BETWEEN 201 AND 230 OR `stage_id` BETWEEN 301 AND 336 OR `stage_id` BETWEEN 349 AND 362)", "score", $user_name);
					total_score_calc("`ranking`", "total_pik1cha", "`stage_id` BETWEEN 101 AND 105", "score", $user_name);
					total_score_calc("`ranking`", "total_pik2cha", "`stage_id` BETWEEN 201 AND 230", "score", $user_name);
					total_score_calc("`ranking`", "total_pik2egg", "`stage_id` IN(201,202,205,206,207,212,217,218,220,226,228,229,230)", "score", $user_name);
					total_score_calc("`ranking`", "total_pik2noegg", "`stage_id` IN(203,204,208,209,210,211,213,214,215,216,219,221,222,223,224,225,227)", "score", $user_name);
					total_score_calc("`ranking`", "total_pik2cave", "`stage_id` BETWEEN 231 AND 244", "score", $user_name);
					total_score_calc("`ranking`", "total_new", "`stage_id` BETWEEN 285 AND 297", "score", $user_name);
					total_score_calc("`ranking`", "total_new2", "`stage_id` BETWEEN 5001 AND 5017", "score", $user_name);
					total_score_calc("`ranking`", "total_unlimit", "`stage_id` BETWEEN 5018 AND 5047", "score", $user_name);
					total_score_calc("`ranking`", "total_tas", "`stage_id` BETWEEN 5048 AND 5077", "score", $user_name);
					total_score_calc("`ranking`", "total_diary", "`stage_id` BETWEEN 245 AND 274", "score", $user_name);
					total_score_calc("`ranking`", "total_story", "`stage_id` IN(10101,10201,10202,10203,10204,10301,10302)", "rps", $user_name);
					total_score_calc("`ranking`", "total_solobb", "`stage_id` IN(10215,10216,10217,10218,10219,10220,10221,10222,10223,10224,10303,10304,10305,10306,10307,10308,10309,10310,10311,10312,10313,10314)", "rps", $user_name);
					total_score_calc("`ranking`", "total_mix", "`stage_id` BETWEEN 10205 AND 10214", "rps", $user_name);
					total_score_calc("`ranking`", "total_pik3cha", "(`stage_id` BETWEEN 301 AND 336 OR `stage_id` BETWEEN 349 AND 362)", "score", $user_name);
					total_score_calc("`ranking`", "total_pik3ct", "`stage_id` IN(301,302,303,304,305,317,318,319,320,321,327,328,329,330,331)", "score", $user_name);
					total_score_calc("`ranking`", "total_pik3be", "`stage_id` IN(306,307,308,309,310,322,323,324,325,326,332,333,334,335,336)", "score", $user_name);
					total_score_calc("`ranking`", "total_pik3db", "`stage_id` IN(311,312,313,314,315,316)", "score", $user_name);
					total_score_calc("`ranking`", "total_pik3ss", "`stage_id` BETWEEN 349 AND 362", "score", $user_name);
					total_score2calc("`ranking`", "total_pik2_2p", "`stage_id` BETWEEN 2201 AND 2230", "score", $user_name);
					total_score2calc("`ranking`", "total_pik3_2p", "(`stage_id` BETWEEN 2301 AND 2310 OR `stage_id` BETWEEN 2317 AND 2336)", "score", $user_name);
					total_score_calc("`battle`", "total_battle2", "`stage_id` BETWEEN 275 AND 284", "rate", $user_name);
					total_score_calc("`battle`", "total_battle3", "`stage_id` BETWEEN 337 AND 348", "rate", $user_name);
					total_score_calc("`ranking`", "total_lim", "(`stage_id` BETWEEN 1001 AND $limited_last OR `stage_id` BETWEEN 3001 AND $area_last)", "score", $user_name);
					total_score_calc("`ranking`", "total_limited000", "(`stage_id` BETWEEN 1001 AND $limited_last OR `stage_id` BETWEEN 3001 AND $area_last)", "rps", $user_name);
					total_score_calc("`ranking`", "total_uplan001", "`stage_id` BETWEEN 4001 AND 4030", "score", $user_name);
					total_score_calc("`ranking`", "total_uplan001rps", "`stage_id` BETWEEN 4001 AND 4030", "rps", $user_name);
					total_score_calc("`ranking`", "total_uplan002", "`stage_id` BETWEEN 4031 AND 4060", "score", $user_name);
					total_score_calc("`ranking`", "total_uplan002rps", "`stage_id` BETWEEN 4031 AND 4060", "rps", $user_name);
					total_score_calc("`ranking`", "total_uplan003", "`stage_id` BETWEEN 4061 AND 4073", "score", $user_name);
					if($limited_num > 0){
						$imp_limstage = implode(", ", ${'limited'.$limited_stage_list[$limited_num]});
						$fixed_limited_num = sprintf('%03d', $limited_num);
						$limited_db = 'total_limited'.$fixed_limited_num;
						$whereis = "`stage_id` IN($imp_limstage)";
						total_score_calc("`ranking`", $limited_db, $whereis, "score", $user_name);
					}
					if($limited_type[$limited_stage_list[$limited_num]] == 'e'){
						$imp_limstage = implode(", ", ${'arealim'.$limited_stage_list[$limited_num]});
						$fixed_limited_num = sprintf('%03d', $limited_num);
						$limited_db = 'total_arealim'.$fixed_limited_num;
						$whereis = "`stage_id` IN($imp_limstage)";
						total_score_calc("`ranking`", $limited_db, $whereis, "score", $user_name);
					}
					// ユーザー別バトルモード最終レートを取得
					$sql = "SELECT * FROM `battle` WHERE `user_name` = '$user_name' ORDER BY `post_date` DESC LIMIT 1";
					$result = mysqli_query($mysqlconn, $sql);
					$row = mysqli_fetch_assoc($result);
					$query_rps = "UPDATE `user` SET `battle_rate` = '$row[t_rate]' WHERE `user_name` = '$user_name'";
					$result_rps = mysqli_query($mysqlconn, $query_rps );
					if(!$result_rps) echo " <br>Error ".__LINE__."：合計点算出式でエラーが発生しています。リクエスト：battle_rate ユーザー名：$user_name";

					// 総合ポイントを算出
					// 特殊総合
					$total_special  = 0;
					$total_special += total_score_calc("`ranking`", "return", "`stage_id` BETWEEN 231   AND 275",   "rps", $user_name); // 本編地下・日替わり
					$total_special += total_score_calc("`battle`",  "return", "`stage_id` BETWEEN 275   AND 348",   "rps", $user_name); // バトルモード
					$total_special += total_score_calc("`ranking`", "return", "`stage_id` BETWEEN 285   AND 297",   "rps", $user_name); // タマゴムシ縛り
					$total_special += total_score_calc("`ranking`", "return", "`stage_id` BETWEEN 1001  AND 1999",  "rps", $user_name); // 期間限定（通常戦・チーム対抗戦）
					$total_special += total_score2calc("`ranking`", "return", "`stage_id` BETWEEN 2201  AND 2336",  "rps", $user_name); // 2Pモード
					$total_special += total_score_calc("`ranking`", "return", "`stage_id` BETWEEN 3001  AND 3999",  "rps", $user_name); // 期間限定（エリア踏破戦）
					$total_special += total_score_calc("`ranking`", "return", "`stage_id` BETWEEN 5001  AND 5017",  "rps", $user_name); // 期間限定（エリア踏破戦）
					$total_special += total_score_calc("`ranking`", "return", "`stage_id` BETWEEN 10001 AND 10399", "rps", $user_name); // 本編・チャレンジ複合

					// 通常総合
					$total_normal   = total_score_calc("`ranking`", "return", "(`stage_id` BETWEEN 101 AND 230 OR `stage_id` BETWEEN 301 AND 336)", "rps", $user_name);

					// 全総合
					$total_allstage = $total_normal + $total_special;

					$query_rps = "UPDATE `user` SET `total_rps` = '$total_normal', `total_sp` = '$total_special', `total_all` = '$total_allstage' WHERE `user_name` = '$user_name'";
					$result_rps = mysqli_query($mysqlconn, $query_rps );
					if(!$result_rps) echo " <br>Error ".__LINE__."：総合ポイント算出でエラーが発生しています。";
				}
				// ステージ別平均点と標準偏差を再計算
				$ave_stage_id_list = array();
				$stage_ids = array_column( $stage, 'stage_id');
				if($ranking_type == "admin"){
					$ave_stage_id_list = $stage_ids;
					// 再計算でサーバーが落ちる場合はここで対象ステージを絞り込む
					$ave_stage_id_list[] = 101;
				} else {
					$ave_stage_id_list[]= $stage_id;
				}
				foreach($ave_stage_id_list as $ave_stage_id){
					$score_array = array();
					$query = "SELECT * FROM `ranking` WHERE `stage_id` = '$ave_stage_id' AND `log` = 0 ORDER BY `score` DESC";
					$result = mysqli_query($mysqlconn, $query);
					if (!$result) {
						die(' <br>Error '.__LINE__.'：クエリの取得に失敗.'.mysql_error());
					}
					while ($row = mysqli_fetch_assoc($result) ){
						array_push($score_array, $row["score"]);
					}
					$score_sum = array_sum($score_array);				// スコアの合計値
					$score_ave = array_sum($score_array) / count($score_array);	// スコアの平均値
					$variance = 0.0;
					foreach($score_array as $val) {
						$variance += pow($val - $score_ave, 2);
					}
					$score_variance = ($variance / count($score_array));		// スコアの分散

					$score_sd = $score_variance;					// スコアの標準偏差
					$query_rps = "UPDATE `stage_title` SET `score_ave` = '$score_ave' WHERE `stage_id` = '$ave_stage_id' ";
					if(!$_SESSION['debug_mode']) $result_rps = mysqli_query($mysqlconn, $query_rps );
					$query_rps = "UPDATE `stage_title` SET `score_sd` = '$score_sd' WHERE `stage_id` = '$ave_stage_id' ";
					if(!$_SESSION['debug_mode']) $result_rps = mysqli_query($mysqlconn, $query_rps );
					$query_rps = "UPDATE `stage_title` SET `score_sum` = '$score_sum' WHERE `stage_id` = '$ave_stage_id' ";
					if(!$_SESSION['debug_mode']) $result_rps = mysqli_query($mysqlconn, $query_rps );
				}
			}
		// エリア踏破戦×協力制、スタンダードの場合の処理
		// // エリア踏破戦の場合のエリア更新処理
		// if($ranking_type == "limited_area" and $entry_success == 1 and $new_entry != 0){

		// 	$query = "SELECT * FROM `area` WHERE `stage_id` = '$stage_id'";
		// 	$result = mysqli_query($mysqlconn, $query);
		// 	$row = mysqli_fetch_assoc($result);
		// 		$ae_point	= $row["id"];
		// 		$ae_flag	= $row["flag"];
		// 		$ae_border	= $row["border_score"];
		// 		$ae_exborder	= $row["ex_border_score"];
		// 		$ae_topscore	= $row["top_score"];
		// 		$ae_break	= $row["border_rank"];
		// 		$ae_under	= $row["under_score"];
		// 		$ae_count	= $row["count"] + 1;
		// 		$ae_username	= $row["user_name"];
		// 	if($ae_flag > 1){
		// 		// トップスコアを更新していた場合は名前を上書き
		// 		if($score > $ae_topscore){
		// 			$ae_topscore	= $score;
		// 			$ae_username	= $user_name;
		// 		}
		// 		// 必要人数番目のスコアをチェック
		// 		$ae_offset = offset - 1;
		// 		$query = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 AND ORDER BY `score` DESC LIMIT 1 OFFSET $ae_offset";
		// 		$result = mysqli_query($mysqlconn, $query);
		// 		$row = mysqli_fetch_assoc($result);
		// 		$under_score = $row["score"];

		// 		// 必要人数全員がボーダーを超えていた場合は左右上下のステージを解禁する
		// 		$query = "SELECT * FROM `ranking` WHERE `stage_id` = '$stage_id' AND `log` = 0 AND `score` >= '$ae_border' ORDER BY `score` DESC LIMIT $ae_break";
		// 		$result = mysqli_query($mysqlconn, $query);
		// 		if($result){
		// 			$row = mysqli_fetch_assoc($result);
		// 			$break_count = mysqli_num_rows($result);
		// 			if($break_count >= $ae_break){
		// 				if($row["score"] >= $ae_border  ) $ae_flag = 4;
		// 				if($row["score"] >= $ae_exborder) $ae_flag = 5;
		// 			} else {
		// 				$ae_flag = 3;
		// 			}
		// 		} else {
		// 			$break_count = 0;
		// 			$ae_flag = 3;
		// 		}
		// 		if($ae_flag > 3){
		// 			// 周囲エリアのフラグをチェックする
		// 			$around_check_array   = array();
		// 			if($ae_point % $ae_width[$limited_num]  !== 0)	$around_check_array[] = $ae_point + 1; // 東
		// 			if($ae_point % $ae_height[$limited_num] !== 1)	$around_check_array[] = $ae_point - 1; // 西
		// 			if($ae_point > $ae_width[$limited_num])		$around_check_array[] = $ae_point - $ae_width[$limited_num]; // 北
		// 			if($ae_point <= ($ae_width[$limited_num] * ($ae_height[$limited_num] - 1 )))	$around_check_array[] = $ae_point + $ae_width[$limited_num]; // 南
		// 		}
		// 		foreach($around_check_array as $val){
		// 			$query = "SELECT * FROM `area` WHERE `id` = '$val'";
		// 			$result = mysqli_query($mysqlconn, $query);
		// 			$row = mysqli_fetch_assoc($result);
		// 			$ae_around_flag = $row["flag"];
		// 			if($ae_around_flag == 1){
		// 				$query_rps = "UPDATE `area` SET `flag` = 2 WHERE `id` = '$val'";
		// 				$result_rps = mysqli_query($mysqlconn, $query_rps );
		// 			}
		// 		}
		// 	} else {
		// 		if(!$result_rps) echo " <br>Error ".__LINE__."：侵入不可能エリアのステージに登録しようとしています。";
		// 	}

		// 	$query = "UPDATE `area` SET `flag` = '$ae_flag', `post_date` = '$post_date', `top_score` = '$ae_topscore', `user_name` = '$ae_username', `break_count` = '$break_count', `under_score` = '$under_score', `count` = '$ae_count' WHERE `id` = '$ae_point'";
		// 	if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );

		// }

		// チーム対抗の場合は対象ステージすべてのRPSを更新する(★暫定対応）
		if( $switch[23] and ($ranking_type == "limited_team" or $del_ranking_type == "limited_team") or ($stage_id >= 3066 and $stage_id <= 3112)){
		if(     $ranking_type == "limited_team" or ($stage_id >= 3066 and $stage_id <= 3112)) $rps_update_limited_array = ${'limited'.$limited_stage_list[$limited_num]};
		if( $del_ranking_type == "limited_team") $rps_update_limited_array = ${'limited'.$limited_stage_list[$del_limited_num]};

		// 計算対象の期間限定ランキング参加者を計算
		$limited_rank_target = sprintf('%03d', $limited_num);
		$target_db = 'total_limited'.$limited_rank_target;
		$rcount_query = "SELECT * FROM `user` WHERE $target_db != 0 ORDER BY $target_db DESC";
		$rcount_result = mysqli_query($mysqlconn, $rcount_query);
		$current_limited_player = mysqli_num_rows($rcount_result);

		foreach(${'limited'.$limited_stage_list[$limited_num]} as $get_lim_stage_id){
			$query = "SELECT * FROM `ranking` WHERE `stage_id` = '$get_lim_stage_id' AND `log` = 0 ORDER BY `score` DESC";
			if ($result = mysqli_query($mysqlconn, $query) ){
				$i = 1; // カウント番号
				$p = 0; // 前のカウント番号
				$rows_count = mysqli_num_rows($result);
				while ($row = mysqli_fetch_assoc($result) ) {
					$rps_score[$i] = $row["score"] ;
					$rps_id[$i]    = $row["post_id"] ;
					$rps_user[$p]  = $row["user_name"];
					if($i > 1){
						if($rps_score[$i] == $rps_score[$p]){
							$rps_rank[$i] = $rps_rank[$p];
						} else {
							$rps_rank[$i] = $i;
						}
					} else {
						$rps_rank[$i] = 1;
					}
					// RPS = (期間限定総合の参加人数 - 順位 + 1)
					$rps[$i] = ($current_limited_player - $rps_rank[$i]) + 1;

						// レーティング制の場合の特殊処理
						if($limited_num == 11 or $limited_num == 12){

						// 比較元のレートを取得
						$now_score = $row["score"];
						$now_user_name = $row["user_name"];
						$rate_query = "SELECT * FROM `user` WHERE `user_name` = '$now_user_name' LIMIT 1";
						$rate_result = mysqli_query($mysqlconn, $rate_query);
						$rate_row = mysqli_fetch_assoc($rate_result);
						$now_rate = $rate_row["rate"];

						// 上から順にランキングを取得してそれ以下のスコアとレートを比較する
						$sub_query = "SELECT * FROM `ranking` WHERE `stage_id` = '$get_lim_stage_id' AND `log` = 0 AND `score` < '$now_score' ORDER BY `score` DESC";
						$sub_result = mysqli_query($mysqlconn, $sub_query);
						while( $sub_row = mysqli_fetch_assoc($sub_result) ){
							$opponent_user_name = $sub_row["user_name"];

								// 比較相手のレートを取得
								$rate_query = "SELECT * FROM `user` WHERE `user_name` = '$opponent_user_name' LIMIT 1";
								$rate_result = mysqli_query($mysqlconn, $rate_query);
								$rate_row = mysqli_fetch_assoc($rate_result);
								$opponent_rate = $rate_row["rate"];

							if($opponent_rate > $now_rate){
								$rps_seed = 1;
							} else {
								$rps_seed = 0;
							}

							$rps[$i] += $rps_seed;
						}
						// 選抜戦の場合はRPSを2倍にする
						if($get_lim_stage_id > 1037 and $get_lim_stage_id < 1042 and $rps_rank[$i] == 1) $rps[$i] *= 2;
					}
				// ランクポイントを更新する
				$query_rps ="UPDATE `ranking` SET `at_rank` = '$rps_rank[$i]', `post_rank` = '$rps_rank[$i]' , `rps` = '$rps[$i]' , `rps2` = '$rps[$i]' WHERE `post_id` = '$rps_id[$i]' ";
				if(!$_SESSION['debug_mode']) $result_rps = mysqli_query($mysqlconn, $query_rps );

				$i++;
				$p++;
				}
			}
		}

		// エリア踏破戦×チーム対抗戦の処理
		// エリア踏破戦の場合のエリア更新処理
		if($ranking_type == "limited_area" and $entry_success == 1 and $new_entry != 0){

			// 全ステージのRPSを更新する
			foreach(${'limited'.$limited_stage_list[$limited_num]} as $val){
				$teama_rps = 0;
				$teamb_rps = 0;
				$teama_query = "SELECT `rps` FROM `ranking` WHERE `stage_id` = '$val' AND `log` = 0 AND `team` = '$team_a'";
				$teama_result = mysqli_query($mysqlconn, $teama_query );
				if($teama_result){
					while($teama_row = mysqli_fetch_assoc($teama_result) ){
						$teama_rps += $teama_row["rps"];
					}
				}
				$teamb_query = "SELECT `rps` FROM `ranking` WHERE `stage_id` = '$val' AND `log` = 0 AND `team` = '$team_b'";
				$teamb_result = mysqli_query($mysqlconn, $teamb_query );
				if($teamb_result){
					while($teamb_row = mysqli_fetch_assoc($teamb_result) ){
						$teamb_rps += $teamb_row["rps"];
					}
				}
				$query = "UPDATE `area` SET `team_a` = '$teama_rps', `team_b` = '$teamb_rps' WHERE `stage_id` = '$val'";
				if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
			}

			$query = "SELECT * FROM `area` WHERE `stage_id` = '$stage_id'";
			$result = mysqli_query($mysqlconn, $query);
			$row = mysqli_fetch_assoc($result);
				$ae_point	= $row["id"];
				$ae_flag	= $row["flag"];
				$ae_border	= $row["border_score"];
				$ae_exborder	= $row["ex_border_score"];
				$ae_topscore	= $row["top_score"];
				$ae_break	= $row["border_rank"];
				$ae_under	= $row["under_score"];
				$ae_count	= $row["count"] + 1;
				$ae_username	= $row["user_name"];
				$ae_team_a	= $row["team_a"];
				$ae_team_b	= $row["team_b"];
			if($ae_flag > 1){
				// トップスコアを更新していた場合は名前を上書き
				if($score > $ae_topscore){
					$ae_topscore	= $score;
					$ae_username	= $user_name;
				}

				// どちらの陣地か判定する
				if($ae_team_a > $ae_team_b){
					$ae_flag = 3;
				} elseif($ae_team_a < $ae_team_b){
					$ae_flag = 4;
				} else {
					// 第17回より同点になった場合は陣地色を中立にしないようにした
					// $ae_flag = 2;
				}

				if($ae_flag > 2){
					// 周囲エリアのフラグをチェックする
					$around_check_array   = array();
					// 今大会の一番左上から１引いた数値を定義しておく
					$min_point = 172;
					if(($ae_point - $min_point) % $ae_width[$limited_num] !== 0) $around_check_array[] = $ae_point + 1; // 東
					if(($ae_point - $min_point) % $ae_width[$limited_num] !== 1) $around_check_array[] = $ae_point - 1; // 西
					if($ae_point > ($min_point + $ae_width[$limited_num])) $around_check_array[] = $ae_point - $ae_width[$limited_num]; // 北
					if($ae_point < ($min_point + ($ae_width[$limited_num] * ($ae_height[$limited_num] - 1)))) $around_check_array[] = $ae_point + $ae_width[$limited_num]; // 南
				}
				foreach($around_check_array as $val){
					$query = "SELECT * FROM `area` WHERE `id` = '$val'";
					$result = mysqli_query($mysqlconn, $query);
					$row = mysqli_fetch_assoc($result);
					$ae_around_flag = $row["flag"];
					if($ae_around_flag == 1){
						$query_rps = "UPDATE `area` SET `flag` = 2 WHERE `id` = '$val'";
						$result_rps = mysqli_query($mysqlconn, $query_rps );
					}
				}
				$query = "UPDATE `area` SET `flag` = '$ae_flag', `post_date` = '$post_date', `top_score` = '$ae_topscore', `user_name` = '$ae_username', `break_count` = '$break_count', `under_score` = '$under_score', `count` = '$ae_count' WHERE `id` = '$ae_point'";
				if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );

			} else {
				if(!$result_rps) echo " <br>Error ".__LINE__."：侵入不可能エリアのステージに登録しようとしています。";
			}
		}

		// 現在の各チーム合計点を記録
		if($ranking_type == "limited_team" or $ranking_type == "limited_area"){
			$limstage = ${'limited'.$limited_stage_list[$limited_num]};
			$query = "SELECT * FROM `ranking` WHERE `log` = 0 AND `team` = $team_a";
			$result = mysqli_query($mysqlconn, $query);
			while ($row = mysqli_fetch_assoc($result) ) {
				$leftside_rps += $row["rps2"];
			}
			$query = "SELECT * FROM `ranking` WHERE `log` = 0 AND `team` = $team_b";
			$result = mysqli_query($mysqlconn, $query);
			while ($row = mysqli_fetch_assoc($result) ) {
				$rightside_rps += $row["rps2"];
			}

			// ハンデ再計算 (3673行付近を再利用)
			if(!($stage_id >= 3066 and $stage_id <= 3095)){
				$minority_bonus = 0;
				$sql = "SELECT * FROM `ranking` WHERE `team` = '$team_b' AND `log` = 0";
				$result = mysqli_query($mysqlconn, $sql);
				$rightside_count = mysqli_num_rows($result);
				$sql = "SELECT * FROM `ranking` WHERE `team` = '$team_a' AND `log` = 0";
				$result = mysqli_query($mysqlconn, $sql);
				$leftside_count = mysqli_num_rows($result);
				$sql = "SELECT * FROM `user` WHERE `current_team` BETWEEN '$team_a' AND '$team_b'";
				$result = mysqli_query($mysqlconn, $sql);
				$player_total = mysqli_num_rows($result);
				$post_diff = abs($rightside_count - $leftside_count);
				$minority_bonus = $post_diff * ceil($player_total / 2);
				if($leftside_count > $rightside_count){
					$rightside_rps += $minority_bonus;
				}
				if($leftside_count < $rightside_count){
					$leftside_rps += $minority_bonus;
				}
			}

			// エリア情報を出力
			$area_log_array = array();
			$query = "SELECT * FROM `area` WHERE `lim` = '$limited_num'";
			$result = mysqli_query($mysqlconn, $query);
			while($row = mysqli_fetch_assoc($result)){
				$area_log_array[] = $row["flag"];
			}
			$area_log = implode(" ",$area_log_array);
			$query = "INSERT INTO `limited_log`( `date`,`user_name`,`stage_id`,`score`,`left_side`,`right_side`,`area`) VALUES('$post_date','$user_name','$stage_id','$score','$leftside_rps','$rightside_rps','$area_log')";
			if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
		}
	}
} else {
//		echo '送信待機中...';
}
	// Twitterに投稿内容をPOST（★シーズントップスコアには未対応）
	if($entry_success == 1 and $post_twitter){

		$query = "SELECT * FROM `user` WHERE `user_name` = '$user_name' LIMIT 1";
		$result = mysqli_query($mysqlconn, $query);
		$row = mysqli_fetch_assoc($result);
		if($row["twitter_access_key"] != ""){
			$pik4_access_token = $row["twitter_access_key"];
			$pik4_access_stoken= $row["twitter_access_skey"];
		} else {
			$pik4_access_token = $_SESSION['access_token']['oauth_token'];
			$pik4_access_stoken = $_SESSION['access_token']['oauth_token_secret'];
		}

		if($pik4_access_token and $pik4_access_stoken){
			// 今登録したスコア情報をクエリで取得
			$ne_query = "SELECT * FROM `ranking` WHERE `unique_id` = '$unique_id' LIMIT 1";
			$ne_result = mysqli_query($mysqlconn, $ne_query);
			$ne_row = mysqli_fetch_assoc($ne_result);

			$prev_rank = $row["prev_rank"];
			$post_rank = $row["post_rank"];

			$tweet_post_rank = '';
			if($old_entry == 1) $update_flag = '自己ベスト更新！';
			if($old_entry == 0) $update_flag = 'ニューレコード！';
			if($old_entry == 0) $old_score = 0;
			if($prev_rank > 0 and $post_rank > 0) $tweet_post_rank = ' ['.$prev_rank.'位→'.$post_rank.'位] ';

			// ステージ名・URL・カテゴリを取得
			$tweet_post_url = 'https://chr.mn/pik4/'.$stage_id;
			$tweet_post_stage = $array_stage_title[$stage_id];
			$needle = strpos ($array_stage_title[$stage_id] , '#');
			if($needle > 0 ) $needle = $needle + 1;
			$fixed_stage_title = mb_substr ( $array_stage_title[$stage_id] , $needle );
			$tweet_post_cat = '';
			if($stage_id > 100 and $stage_id < 106 ) $tweet_post_cat = '[ピクミン1]';
			if($stage_id > 200 and $stage_id < 231 ) $tweet_post_cat = '[ピクミン2]';
			if($stage_id >2200 and $stage_id <2231 ) $tweet_post_cat = '[ピクミン2/2P]';
			if($stage_id > 230 and $stage_id < 245 ) $tweet_post_cat = '[本編地下]';
			if($stage_id > 244 and $stage_id < 275 ) $tweet_post_cat = '[日替わり]';
			if($stage_id > 300 and $stage_id < 337 ) $tweet_post_cat = '[ピクミン3]';
			if($stage_id >2300 and $stage_id <2337 ) $tweet_post_cat = '[ピクミン3/2P]';
			if($stage_id >1000 and $stage_id < 2000) $tweet_post_cat = '[期間限定]';
			if($stage_id >10000and $stage_id <99999) $tweet_post_cat = '[本編]';

			$tweet = '#ピクミンチャレンジ'."\n".'#ピクチャレ大会'."\n".$update_flag."\n".$tweet_post_cat.$fixed_stage_title."\n".' ('.number_format($old_score).' → '.number_format($score).'pts) '.$tweet_post_rank."\n".htmlspecialchars($post_comment, ENT_QUOTES)."\n".$tweet_post_url;
//			$tweet = '#ピクチャレ大会 自己ベスト更新！ [ピクミン2]こてしらべの洞窟 (35,150 → 35,333pts) [10位→5位] ★連携てすとちゅう★ https://chr.mn/pik4';
			$twObj = new TwitterOAuth($pik4_api_key, $pik4_api_skey , $pik4_access_token, $pik4_access_stoken);
			$result = $twObj->post("statuses/update", array("status" => $tweet));
			if($result) echo ' <br> Twitterに投稿内容を送信しました。';

			// 一致ユーザー名にセッションを登録する
			$query = "UPDATE `user` SET `twitter_access_key` = '$pik4_access_token', `twitter_access_skey` = '$pik4_access_stoken' WHERE `user_name` = '$user_name' ";
			if(!$_SESSION['debug_mode']) $result = mysqli_query($mysqlconn, $query );
		} else {
		echo ' <br>Error '.__LINE__.'：Twitterへの投稿エラーが発生しています。';
		}
	}
	// デバッグ
	if($_SESSION['debug_mode']){
		$output_array = array(
			$ranking_type, $user_name, $password, $stage_id, $lim_stage_id, $story_stage_id, $cave_stage_id, $score, $post_comment, $console,
			$ranking_type, $video_url, $user_ip, $post_count, $post_rank, $post_rps, $prev_score, $new_file_name, $video_check, $firstpost_date, $old_user_name, $old_console,
			$old_user_ip, $old_unique_id, $data_user_name, $crypted_pass, $del_ranking_type, $story_cavepoko, $story_cavehour, $story_cavemin,
			$story_cavesec, $storyc_red, $storyc_blue, $storyc_yellow, $storyc_purple, $storyc_white, $storyc_koppa, $storyc_popoga, $storyc_death,
			$story_daycount, $story_correct, $story_rtahour, $story_rtamin, $story_rtasec, $story_pikmin, $story_red, $story_blue,
			$story_yellow, $story_purple, $story_white, $story_winged, $story_rock, $story_death, $story_lim_array, $story_lim_pts, $story_lim_han,
			$conf, $conf_value, $post_reset, $post_twitter, $conf_text, $new_entry, $old_score, $score_check, $old_datamatch, $old_entry, $entry_success,
			$entry_success, $data_user_name, $data_post_count, $crypted_pass, $now_tp, $now_egg, $cave_time, $alltime, $max_pikmin, $lasttime, $allpikmin,
			$addpikmin, $lastpikmin, $story_lim_imp, $name_check, $ng_word_check, $text_check, $ng_text_through, $ng_text_check, $comment_check,
			$video_check, $video_url, $post_date, $post_date_sql, $post_dummy, $unique_id, $evidence_clear, $evidence_point_fixed, $leftside_rps,
			$rightside_rps, $diff_team_count, $right_ave, $left_ave, $comp_rps_array, $your_team, $team_a, $team_b, $success_picupload,
			$shere_tp, $season_column, $leftside_rps, $rightside_rps, $minority_bonus, $score_sum, $score_ave, $score_variance, $score_sd
			);
		$output_array_title = array(
			'ranking_type', 'user_name', 'password', 'stage_id', 'lim_stage_id', 'story_stage_id', 'cave_stage_id', 'score', 'post_comment', 'console',
			'ranking_type', 'video_url', 'user_ip', 'post_count', 'post_rank', 'post_rps', 'prev_score', 'new_file_name', 'video_check', 'firstpost_date', 'old_user_name', 'old_console',
			'old_user_ip', 'old_unique_id', 'data_user_name', 'crypted_pass', 'del_ranking_type', 'story_cavepoko', 'story_cavehour', 'story_cavemin',
			'story_cavesec', 'storyc_red', 'storyc_blue', 'storyc_yellow', 'storyc_purple', 'storyc_white', 'storyc_koppa', 'storyc_popoga', 'storyc_death',
			'story_daycount', 'story_correct', 'story_rtahour', 'story_rtamin', 'story_rtasec', 'story_pikmin', 'story_red', 'story_blue',
			'story_yellow', 'story_purple', 'story_white', 'story_winged', 'story_rock', 'story_death', 'story_lim_array', 'story_lim_pts', 'story_lim_han',
			'conf', 'conf_value', 'post_reset', 'post_twitter', 'conf_text', 'new_entry', 'old_score', 'score_check', 'old_datamatch', 'old_entry', 'entry_success',
			'entry_success', 'data_user_name', 'data_post_count', 'crypted_pass', 'now_tp', 'now_egg', 'cave_time', 'alltime', 'max_pikmin', 'lasttime', 'allpikmin',
			'addpikmin', 'lastpikmin', 'story_lim_imp', 'name_check', 'ng_word_check', 'text_check', 'ng_text_through', 'ng_text_check', 'comment_check',
			'video_check', 'video_url', 'post_date', 'post_date_sql', 'post_dummy', 'unique_id', 'evidence_clear', 'evidence_point_fixed', 'leftside_rps',
			'rightside_rps', 'diff_team_count', 'right_ave', 'left_ave', 'comp_rps_array', 'your_team', 'team_a', 'team_b', 'success_picupload',
			'shere_tp', 'season_column', 'leftside_rps', 'rightside_rps', 'minority_bonus', 'score_sum', 'score_ave', 'score_variance', 'score_sd'
			);
		$i = 0;
		foreach($output_array as $val){
			echo $i."\t".$output_array_title[$i]."\t".$val." <br>\n";
		$i++;
		}
		echo "FILES：";
		var_dump($_FILES);
		echo "SESSION：";
		var_dump($_SESSION);
		echo "COOKIE：";
		var_dump($_COOKIE);
	}
	echo "</A></div>" ;
}
// フォーム処理部分★ここまで
