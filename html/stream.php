<?php
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

// 汎用データベースを連想配列化
require_once('pik4_database.php');

// ページ種別を取得
$user_name = "";
$stage_id = "";
if(isset($_GET["s"])) $stage_id = $_GET["s"];
if(isset($_GET["u"])) $user_name= $_GET["u"];

$stage_array = array();

// IDからステージ群に変換
if($stage_id > 100000){
        if($limited_type[$stage_id] !== 'u') $stage_array = ${'limited'.$stage_id};
        if($limited_type[$stage_id] === 'u') $stage_array = ${'uplan'.$stage_id};
}
// ヘッダー
?>
<html>
        <head>
                <title>ピクチャレ大会 トップスコアストリーム（仮）</title>
        </head>
        <script>
                const timer = 950 // ミリ秒で間隔の時間を指定
                window.addEventListener('load',function(){
                        setInterval('location.reload()',timer);
                });
        </script>
        <body>
<?php
// トップスコアを表示
echo '<A href="https://chr.mn/pik4/'.$stage_id.'">'.$array_stage_title[$stage_id]."</A><br><br>\n";
foreach($stage_array as $val){
        echo $topscorelist[$val]['score']."<br>\n";
}
echo date('Y/m/d H:i:s', $now_time);
