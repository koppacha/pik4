<?php
/*
The Leaderboards of Pikmin Series Challenge & Mission Mode
ピクミンシリーズチャレンジモード大会
Since: 2007/04/29
Autor: @koppachappy（木っ端ちゃっぴー）
*/

// 設定を読み込む
require_once('_def.php');
require_once('pik4_config.php');

// セッションスタート
session_start();

// データベースへアクセス
$mysqlconn = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);
if ( $mysqlconn == false) {
	$network_error = 1;
	echo " <br>Error ".__LINE__."：データベースに接続できませんでした。エラー番号：".mysqli_connect_errno();
	exit;
} else {
	$result = mysqli_query($mysqlconn, 'SET NAMES utf8mb4');
	if (!$result) {
		echo " <br>Error ".__LINE__."：データベースの文字セット指定に失敗しました。";
	}
}
// 汎用変数・ファイル・名前を読み込む
require_once('pik4_function.php');
require_once('pik4_array.php');
require_once('pik4_name.php');

if(!$mysql_mode) loadtime_calc(__LINE__);

// ページ種別を取得
$user_name = "";
$stage_id = "";
if(isset($_GET["s"])) $stage_id = $_GET["s"];
if(isset($_GET["u"])) $user_name= $_GET["u"];

// 汎用データベースを連想配列化
require_once('pik4_database.php');

// URLからステージIDを取得
$url_array = explode('/', $_SERVER["REQUEST_URI"]);
$url_stage_id =  urldecode( array_pop( $url_array ) );

// URLのルーティング
$page_type = 0;
$show_scoretable = 1;
    if ( $site_mode == 1			       ) $page_type =99; // メンテナンスモード
elseif ( $network_error == 1			       ) $page_type =98; // ネットワークエラー
elseif ( !$stage_id	     and!$user_name 	       ) $page_type = 0; // エラー
elseif ( $stage_id >       0 and $stage_id <         6 ) $page_type = 1; // 特殊ランキング（新着、RPS順）
elseif ( $stage_id >       5 and $stage_id <         7 ) $page_type =17; // 特殊ランキング（バトルモード戦歴）
elseif ( $stage_id >       6 and $stage_id <       101 ) $page_type = 2; // 総合ランキング（9＝RPS総合、10番台＝初代、20番台＝2、30番台＝3、90番台＝特殊）
elseif ( $stage_id >     100 and $stage_id <       106 ) $page_type = 3; // 通常ランキング (ピクミン1)
elseif ( $stage_id >     105 and $stage_id <       201 ) $page_type =98; // 無効
elseif ( $stage_id >     200 and $stage_id <       231 ) $page_type = 3; // 通常ランキング (ピクミン2)
elseif ( $stage_id >     230 and $stage_id <       245 ) $page_type =11; // 特殊ランキング (ピクミン2本編地下)
elseif ( $stage_id >     244 and $stage_id <       275 ) $page_type = 8; // 特殊ランキング (ピクミン2日替わり)
elseif ( $stage_id >     274 and $stage_id <       285 ) $page_type =16; // 特殊ランキング (2Pバトルモード)
elseif ( $stage_id >     284 and $stage_id <       298 ) $page_type = 3; // 特殊ランキング（タマゴムシ縛り）
elseif ( $stage_id >     297 and $stage_id <       301 ) $page_type =98; // 無効
elseif ( $stage_id >     300 and $stage_id <       337 ) $page_type = 3; // 通常ランキング (ピクミン3)
elseif ( $stage_id >     336 and $stage_id <       349 ) $page_type =16; // 特殊ランキング (ビンゴバトルモード)
elseif ( $stage_id >     348 and $stage_id <       363 ) $page_type = 3; // 通常ランキング（サイドストーリーモード）
elseif ( $stage_id ==    399			       ) $page_type = 3; // サンドボックス用
elseif ( $stage_id >     348 and $stage_id <      1001 ) $page_type =98; // 無効
elseif ( $stage_id >    1000 and $stage_id <      2001 ) $page_type = 4; // 特殊ランキング（期間限定チャレンジ）
elseif ( $stage_id >    2000 and $stage_id <      3001 ) $page_type =12; // 特殊ランキング (2Pモード)
elseif ( $stage_id >    3000 and $stage_id <      3143 ) $page_type =19; // 特殊ランキング（エリア踏破戦個別ページ）
elseif ( $stage_id >    3142 and $stage_id <      4001 ) $page_type =98; // 無効
elseif ( $stage_id >    4000 and $stage_id <      4074 ) $page_type = 4; // 特殊ランキング（参加者企画）
elseif ( $stage_id >    4073 and $stage_id <      5001 ) $page_type =98; // 無効
elseif ( $stage_id >    5000 and $stage_id <      5018 ) $page_type = 3; // 特殊ランキング（スプレー縛り等）
elseif ( $stage_id >    5017 and $stage_id <      5049 ) $page_type = 3; // 特殊ランキング（ピクミン2なんでもあり）
elseif ( $stage_id >    5047 and $stage_id <      5079 ) $page_type = 3; // 特殊ランキング（ピクミン2TAS）
elseif ( $stage_id >    4017 and $stage_id <     10001 ) $page_type =98; // 無効
elseif ( $stage_id >   10000 and $stage_id <     10205 ) $page_type = 7; // 特殊ランキング (本編RTA)
elseif ( $stage_id >   10204 and $stage_id <     10215 ) $page_type =14; // 特殊ランキング（チャレンジ複合）
elseif ( $stage_id >   10214 and $stage_id <     10225 ) $page_type =22; // 特殊ランキング（ソロバトル）
elseif ( $stage_id >   10224 and $stage_id <     10300 ) $page_type =98; // 無効
elseif ( $stage_id >   10299 and $stage_id <     10303 ) $page_type = 7; // 特殊ランキング (ピクミン3)
elseif ( $stage_id >   10302 and $stage_id <     10315 ) $page_type =23; // 特殊ランキング（ソロビンゴ）
elseif ( $stage_id >   10399 and $stage_id <    151101 ) $page_type =98; // 無効
elseif ( $stage_id >  151100 and $stage_id <    211232 ) $page_type = 6; // 総合ランキング（期間限定ランキング)
elseif ( $stage_id >  211231 and $stage_id < 100000000 ) $page_type =98; // エラー
elseif ( $stage_id >99999999 and $stage_id <1000000000 ) $page_type =20; // 記録個別ページ
elseif ( $user_name != "index.php" )		         $page_type = 5; // ユーザー別ランキング
elseif ( $stage_id >  201231  or $stage_id <         0 ) $page_type =98; // エラー
else					                 $page_type =98; // トップページを表示

if($page_type == 6 and strpos($limited_type[$stage_id], 't') !== false) $page_type = 10;// 特殊ランキング (チーム対抗戦)
if($page_type == 6 and strpos($limited_type[$stage_id], 'e') !== false) $page_type = 13;// 特殊ランキング (エリア踏破戦総合)
if($page_type == 6 and strpos($limited_type[$stage_id], 'f') !== false) $page_type = 18;// 特殊ランキング (ピク杯)
if($page_type == 6 and strpos($limited_type[$stage_id], 'u') !== false) $page_type = 21;// 特殊ランキング (参加者企画)

// 有効ステージ名かどうかを判定
// 廃止中の特殊ステージID（以下に追記して復活）…4（カスタムリスト）/ 5（全ステージ一覧）
if($page_type != 5 and $page_type != 9 and $page_type != 0 and $page_type !=10 and $page_type !=13 and $page_type !=15 and $page_type != 20 and $page_type != 99){
	$stage_array =array(1, 2, 3, 6, 7, 8, 9, 10, 20, 21, 22, 23, 24, 25, 26, 27, 28, 30, 31, 32, 33, 34, 35, 36, 81, 82, 91, 92, 93, 94, 95, 96, 98, 99); // あらかじめ除外するステージID
	$sql = "SELECT * FROM `stage_title`";
	$result = mysqli_query($mysqlconn, $sql);
	if($result){
		while($stage_data = mysqli_fetch_assoc($result)){
			$stage_array[] = $stage_data["stage_id"];
		}
	}
	if(array_search($stage_id, $stage_array) === FALSE) $page_type = 98;  // DBに登録されていないIDはNGとする
	if($stage_id > 1000 and $stage_id < 2000 and $limited_num > 0){
		if($stage_id > max($limited_stage)) $page_type = 98;  // 期間限定チャレンジにおいて、現行最終ステージより後のIDはアクセス禁止とする
	}
	if($stage_id > 3000 and $stage_id < 4000 and $limited_num > 0){
		$sql = "SELECT * FROM `area` WHERE `stage_id` = $stage_id LIMIT 1";
		$result = mysqli_query($mysqlconn, $sql);
		$area_flag = mysqli_fetch_assoc($result);
		if($area_flag["flag"] < 2){
			$page_type = 98;
		}
	}
}
// 開催中の期間限定ランキングでは直飛びを禁止する
//if($stage_id >= 3096 and $stage_id <= 3112){
//	if($_SERVER['HTTP_REFERER'] == ""){
//		$page_type = 98;
//	}
//}
// 記録個別ページの場合、有効ステージかどうか判定
if($page_type == 20){
	$sql = "SELECT * FROM `ranking` WHERE `unique_id` = '$stage_id' ORDER BY `score` DESC,`post_date` ASC";
	$result = mysqli_query($mysqlconn, $sql);
	$unique_data = mysqli_fetch_assoc($result);
	if(!isset($unique_data["post_id"])){
		$page_type = 98;
	}
}
// 有効ユーザー名かどうかを判定
if($page_type == 5){
	if(array_search($user_name, $user) !== FALSE){
		$page_type = 5;
	} else {

	// 有効ユーザー名でない場合に有効ページ名かどうかを判定
		$page = array();
		$sql = "SELECT * FROM `note`";
		$result = mysqli_query($mysqlconn, $sql);
		while($page_data = mysqli_fetch_assoc($result) ){
			$page[] = $page_data["post_title"];
		}
		mysqli_free_result($result);
		if(array_search($user_name, $page) !== FALSE){
			$page_type = 9;
		} else {
			// 有効ページ名でない場合に有効タグ名かどうかを判定
			$tag = array();
			$sql = "SELECT * FROM `note`";
			$result = mysqli_query($mysqlconn, $sql);
			while($row = mysqli_fetch_assoc($result) ){
				$tag[] = $row["tag"];
			}
			mysqli_free_result($result);
			if(array_search($user_name, $tag) !== FALSE){
				$page_type = 15;
			} else {
				$page_type = 98;
			}
		}
	}
}
if($page_type == 98){
	$url = "./notfound.html";
	header("HTTP/1.0 404 Not Found");
	print(file_get_contents($url));
	exit;
}
// メンテナンスモードの自動トグル
if( $now_time > $ment_start_time  AND $now_time < $ment_end_time ) $site_mode = 1 ;

require_once('pik4_cookie.php');

// URLからステージ名を取得
$header_stage_title = $url_stage_id;
$_SESSION['now_stage_id'] = $url_stage_id;
$_SESSION['debug_mode'] = null;
if (!$header_stage_title){
	$header_stage_title = "ピクミンシリーズチャレンジモード大会";
} else {
	if($page_type == 20){
		$header_stage_title = '記録ID:'.$header_stage_title." - ピクチャレ大会";
	} elseif(is_numeric($header_stage_title)){
		// ステージIDからカテゴリ名を取得
		$sql = "SELECT * FROM `stage_title` WHERE `stage_id` = '$header_stage_title'";
		$result = mysqli_query($mysqlconn, $sql);
		if($result){
			$row = mysqli_fetch_assoc($result);
			if(isset($row["stage_sub"])){
				if($row["stage_sub"] && $stage_id < 1000){
					$sub_title = "（".$row["stage_sub"]."）";
				} else {
					$sub_title = "";
				}
			} else {
				$sub_title = "";
			}
		} else {
			$sub_title = "";
		}
		$needle = strpos ($array_stage_title[$header_stage_title] , '#');
		if($needle > 0 ) $needle = $needle + 1;
		$fixed_stage_title = mb_substr ( $array_stage_title[$header_stage_title] , $needle );
		if($stage_id == 7){
			$title_tale = "";
		} else {
			$title_tale = " - ピクチャレ大会";
		}
		$header_stage_title = $fixed_stage_title.$sub_title.$title_tale;
	} else {
		$header_stage_title = urldecode($header_stage_title)." - ピクチャレ大会";
	}
}

// URLからサブスクリプションを生成
// $subscription = 'ピクチャレ大会は、任天堂より発売中のゲームソフト『ピクミン』シリーズのチャレンジ・ミッションモード全71ステージの記録を対象とした、誰でも参加できる非公式ランキングサイトです。';
if($page_type == 5){
	$subscription = urldecode($url_stage_id).'さんのスコアリストです。ピクチャレ大会は、任天堂より発売中のゲームソフト『ピクミン』シリーズのチャレンジ・ミッションモード全71ステージの記録を対象とした、誰でも参加できる非公式ランキングサイトです。';
} elseif($page_type == 9 || $page_type == 15){
	$subscription = urldecode($url_stage_id).'のページです。ピクチャレ大会は、任天堂より発売中のゲームソフト『ピクミン』シリーズのチャレンジ・ミッションモード全71ステージの記録を対象とした、誰でも参加できる非公式ランキングサイトです。';
} elseif($page_type == 0 || $page_type == 20){
	$subscription = 'ピクチャレ大会は、任天堂より発売中のゲームソフト『ピクミン』シリーズのチャレンジ・ミッションモード全71ステージの記録を対象とした、誰でも参加できる非公式ランキングサイトです。';
} else {
	$subscription = $array_stage_title[$url_stage_id].' のランキングページです。ピクチャレ大会は、任天堂より発売中のゲームソフト『ピクミン』シリーズのチャレンジ・ミッションモード全71ステージの記録を対象とした、誰でも参加できる非公式ランキングサイトです。';
}

// headerに埋め込む文字列から翻訳タグを取り除く
$subscription = preg_replace('/<.*?>/', '', $subscription);
$header_stage_title = preg_replace('/<.*?>/', '', $header_stage_title);
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
	<title><?php echo $header_stage_title; ?></title>

	<!--/ メタ情報 /-->
	<Meta Name="description" Content="<?php echo $subscription; ?>" />
	<Meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<Meta http-equiv="Content-script-Type" content="text/javascript" />
	<Meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />

	<!--/ CDN/プラグイン等読み込み /-->
	<link href="https://vjs.zencdn.net/7.1.0/video-js.css" rel="stylesheet">
	<link rel="alternate" hreflang="ja" href="https://chr.mn<?php echo $_SERVER["REQUEST_URI"] ?>">
	<!--/ <script src="https://use.fontawesome.com/1e4a6b85ab.js"></script> /-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<link type="text/css" rel="stylesheet" href="https://chr.mn/_css/lity.css"/>
	<link type="text/css" rel="stylesheet" href="https://chr.mn/_css/font-awesome-animation.min.css"/>
	<link type="text/css" rel="stylesheet" href="https://chr.mn/_css/grad.css"/>
	<link type="text/css" rel="stylesheet" href="https://chr.mn/_js/tooltipster/dist/css/tooltipster.bundle.min.css" />
	<link type="text/css" rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" async />
	<script type="text/javascript" charset="UTF-8" src="https://code.jquery.com/jquery-1.10.0.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="https://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="https://cdn.jsdelivr.net/gh/fengyuanchen/compressorjs/dist/compressor.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="https://chr.mn/_js/lity.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="https://chr.mn/_js/jquery.easing.1.3.js" async></script>
	<script type="text/javascript" charset="UTF-8" src="https://chr.mn/_js/jquery.slidein.js"></script>
	<script type="text/javascript" charset="UTF-8" src="https://chr.mn/_js/tooltipster/dist/js/tooltipster.bundle.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="https://chr.mn/_js/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="https://chr.mn/_js/jquery.metadata.js" async></script>
	<script type="text/javascript" charset="UTF-8" src="https://chr.mn/_js/chame.js" async></script>
	<!--/ <script type="text/javascript" charset="UTF-8" src="https://chr.mn/_js/glottologist.min.js"></script> /-->
	<link href="https://fonts.googleapis.com/css?family=Asul|Audiowide|Josefin+Sans:400,700|Julius+Sans+One|Merriweather+Sans|Quicksand:400,700|Rajdhani:400,700|Reem+Kufi|Iceland|Geo|Play|Changa|Press+Start+2P|Alef|Hammersmith+One|Josefin+Slab" rel="stylesheet" async>
	<link href="https://fonts.googleapis.com/earlyaccess/sawarabigothic.css" rel="stylesheet" async />

	<?php if($mysql_mode === 1): ?>
	<link rel='stylesheet' id='default-css'  href='https://chr.mn/pik4/pik4.css' type='text/css' media='all' />
	<script type="text/javascript" src="https://chr.mn/pik4/pik4.js" charset="UTF-8"></script>
	<?php endif ?>

	<?php if($mysql_mode === 0): ?>
	<link rel='stylesheet' id='default-css'  href='./pik4.css' type='text/css' media='all'/>
	<script type="text/javascript" src="./pik4.js" charset="UTF-8"></script>
	<?php endif ?>
</head>
<?php
	// フォームロックされている場合、ページ読み込み時にフォームを開く（総合系ページは無効）
	$val = "";
	$val2= "";
	if($stage_id < 100 or $page_type == 10 or $page_type == 13 or $page_type == 18 or $page_type == 21){
	} else {
		if($formlock == 1) $val = 'pre-open ';
		if(($url_stage_id > 230 and $url_stage_id < 245) or ($url_stage_id > 10000 and $url_stage_id < 20000)) $val2 = 'pre-open2 ';
	}
	if(is_numeric($url_stage_id) ){
		$post_url_stage= $url_stage_id;
	} else {
		$post_url_stage= 0;
	}
//	echo '<body class="'.$val.$val2.'" onload="retry_count_ope('.$post_url_stage.',9);sumtotal();CDT();CDT2();echostage(\'ranking_evidence\', '.$post_url_stage.', \'score\', \'my_best\');echostage(\'stage_title\', '.$post_url_stage.', \'Total_Pikmin\', \'start_pikmin\');echostage(\'stage_title\', '.$post_url_stage.', \'Time\', \'sim_time\');">'."\n";
	echo '<body class="'.$val.$val2.'" onload="sumtotal();CDT();CDT2();echostage(\'ranking_evidence\', '.$post_url_stage.', \'score\', \'my_best\');echostage(\'stage_title\', '.$post_url_stage.', \'Total_Pikmin\', \'start_pikmin\');echostage(\'stage_title\', '.$post_url_stage.', \'Time\', \'sim_time\');">'."\n";
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-61219961-2', 'auto');
  ga('send', 'pageview');

</script>
<?php
if(!$mysql_mode) loadtime_calc(__LINE__);
// フォーム処理部分★ここから
// メンテナンスモードの場合は処理を中止する
if ($site_mode == 1){
	exit('<div style="position:relative;top:0px;text-align:center;margin:0 auto;padding:2em;background-color:#111111;color:#ffffff;font-size:1em;"><b>ピクミンシリーズチャレンジモード大会</b> <br> <br>
	現在設定中の定期メンテナンス期間：'.date('Y/m/d H:i:s',$ment_start_time).'～'.date('Y/m/d H:i:s',$ment_end_time).' <br>
	＊緊急トラブルのため期間外にこの画面が表示されている場合もあります。 <br>
	Total: <Img src="https://chr.mn/_cgi/dayx_pik4_cha/dayx.cgi?gif">
	Today: <Img src="https://chr.mn/_cgi/dayx_pik4_cha/dayx.cgi?today">
	Yesterday: <Img src="https://chr.mn/_cgi/dayx_pik4_cha/dayx.cgi?yes"></div></body></html>');
}
// ★期間限定ランキング事前登録フォーム跡地（pre_entry.txt）

// ホスト名一括取得（必要なときはコメントアウトを外してページを更新しすぐ戻す
// for($i = 914; $i <= 8505; $i++){
// 	$sql = "SELECT `user_ip` FROM `ranking` WHERE `post_id` = '$i'";
// 	$result = mysqli_query($mysqlconn, $sql);
// 	if($result){
// 		$iphost_row = mysqli_fetch_row($result);
// 		$getip_host = gethostbyaddr($iphost_row[0]);
// 		$sql = "UPDATE `ranking` SET `user_host` = '$getip_host' WHERE `post_id` = '$i'";
// 		$result = mysqli_query($mysqlconn, $sql);
// 	}
// }

require_once('pik4_post.php');

// ランキング表示部分★ここから（旧$page_type分岐置き場）

// エラー出力
//	if ($page_type == 0 ) echo '★URLが不正です。<hr size="1"/>' ;

// トップページ表示
require_once('pik4_top.php');

// テーブルヘッダー出力判定 (メンテ中＝非表示、トップページ＝PCのみ非表示、他＝表示)
      if( $page_type == 99 ){
	echo '<div class="wrapper" style="display:none;">';
} elseif($page_type == 0) {
	echo '<div class="wrapper pc-hidden">';
} else {
	echo '<div class="wrapper">';
}
require_once('pik4_mobmenu.php');
require_once('pik4_main.php');
//
// デバッグ表示
if($_SESSION['debug_mode']){
	$output_board_array = array($sql,$stage_id, $page_type ,$show_scoretable ,$user_name ,$compare_data , $compare_score ,$filtering_data ,$filtering_sub_data ,$season_data ,$sort_data ,$pin_data ,$history_id ,$user_id ,$fixed_stage_sub ,$whereand ,$whereand2 ,$orderby ,$limitof);
	$output_board_title = array("sql","stage_id", "page_type", "show_scoretable", "user_name", "compare_data", "compare_score", "filtering_data", "filtering_sub_data", "season_data", "sort_data", "pin_data", "history_id", "user_id", "fixed_stage_sub", "whereand", "whereand2", "orderby", "limitof");
	$i = 0;
	echo '<table>';
	foreach($output_board_array as $val){
		if(isset($val)){
			echo "<tr><td>".$i."</td><td>".$output_board_title[$i]."</td><td>".$val."</td></tr>\n";
		} else {
			echo "<tr><td>".$i."</td><td>".$output_board_title[$i]."</td><td>-</td></tr>\n";
		}
	$i++;
	}
	echo '</table>';
}
	// ページタイプによるdiv調整まずはここを試す
	if($page_type != 21 and $page_type != 22 and $page_type != 23) echo '</div>';
	if($page_type == 1 or $page_type ==  3 or $page_type ==  4 or $page_type == 5 or $page_type == 7 or $page_type == 8 or $page_type == 10 or $page_type == 11 or $page_type ==  12 or $page_type ==  14 or $page_type ==  16 or $page_type ==  18 or $page_type == 19) echo '</div>';

require_once('pik4_menu.php'); // メニュー画面読み込み
require_once('pik4_form.php'); // フォーム画面読み込み
?>
<!--/ フッターで読み込むjavascript /-->
	<script src="https://vjs.zencdn.net/7.1.0/video.js"></script>
	<script src="https://unpkg.com/glottologist"></script>
	<script>
		const glot = new Glottologist();

		//JSONファイルの読み込み
		glot.import("lang.json").then(() => {
		glot.render();
		})
		/**
		 **言語切り替え用のイベント処理
		**/
		const ja = document.getElementById('ja');
		const en = document.getElementById('en');

		ja.addEventListener('click', e => {
		e.preventDefault();
		glot.render('ja');
		});

		en.addEventListener('click', e => {
		e.preventDefault()
		glot.render('en');
		});

		// 定期実行する関数
		// setInterval('getarea()', 1000); // エリア踏破戦エリア取得
		// setInterval('getpoint(\'<?= $limited_num ?>\',\'<?= $team_a ?>\',\'<?= $team_b ?>\')', 1000);// エリア踏破戦ポイント取得
	</script>
</body>
</html>
