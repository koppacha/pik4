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
                <script type="text/javascript" charset="UTF-8" src="https://code.jquery.com/jquery-1.10.0.min.js"></script>
        </head>
        <script>
                // ページ読み込み時に実行
                var stage_id = '<?php echo $stage_id; ?>';

                window.onload = function(){
                        time();
                        getstream(stage_id);
                }

                function getstream(stage){
                        $.ajax({
                                type: "POST",
                                url: "../pik4_stream.php",
                                data: {
                                        "stage_id": stage
                                },
                                success: function(data){
                                        for(const[key, value] of Object.entries(data)){
                                                for(const[keychild, val] of Object.entries(value)){
                                                        $("#"+keychild+key).text(val);
                                                }
                                        }
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                        alert("errorThrown : " + errorThrown.message);
                                }
                        });
                }
                function time(){
                        var now = new Date();
                        document.getElementById("time").innerHTML = now.toLocaleString();
                }

                // 1秒ごとに実行
                setInterval('time()', 1000);
                setInterval('getstream(stage_id)', 1000);
        </script>
        <style>
                body {
                        background-color: #333;
                        color: #ddd;
                }
                a {
                        color: #fff;
                }
                table{
                        table-layout: fixed;
                        border-collapse: collapse;
                        width:400px;
                }
                table td {
                        font-size: 14px;
                        text-align: center;
                        border: 1px solid #777;
                        padding: 4px;
                }
        </style>
        <body>
<?php
// トップスコアを表示
echo '<A href="https://chr.mn/pik4/'.$stage_id.'">'.$array_stage_title[$stage_id]."</A><br><br>\n";
echo '<span id="time"></span>';
echo '<table>';
foreach($stage_array as $val){
        echo '<tr><td>'.$array_stage_title[$val]."</td>\n";
        echo '<td id="name'.$val.'"></td>'."\n";
        echo '<td id="score'.$val.'"></td></tr>'."\n";
}
echo '</table>';
?>
</body>
</html>
