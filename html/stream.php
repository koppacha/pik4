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
                <title>ピクチャレ大会 ランダムセレクトステージチャレンジ</title>
                <script type="text/javascript" charset="UTF-8" src="https://code.jquery.com/jquery-1.10.0.min.js"></script>
        </head>
        <script>
                // ページ読み込み時に実行
                var stage_id = '<?php echo $stage_id; ?>';

                // window.onload = function(){
                //         time();
                //         getstream(stage_id);
                // }

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
                $(function(){
                    $("#button").on("click",function(){
                        $("#button").attr("disabled", true);
                        let cnt = 0;
                        const shuffleInterval = setInterval(function() {
                                let stage = Math.floor(Math.random() * ((256 + 1) - 201)) + 201;
                                $("#random").text(stage);
                                if(++cnt > 40){
                                    clearInterval(shuffleInterval);
                                    $.ajax({
                                        url: "pik4_random_stage.php",
                                        type: "POST",
                                        data: {
                                            stage: stage
                                        },
                                        timeout: 3000
                                    }).done(function(data){
                                        $("#stage_name").text(data["stage_name"]);
                                        $("#eng_stage_name").text(data["eng_stage_name"]);
                                        $("#type").text(data["type"]);
                                        $("#type-style").css("color", data["type_style"]);
                                        $("#score").text(data["score"]);
                                        $("#post_rank").text(data["post_rank"]);
                                        $("#next_rank").text(data["next_rank"]);
                                        $("#next_score").text(data["next_score"]);
                                        $("#next2_score").text(data["next2_score"]);
                                        $("#next4_score").text(data["next4_score"]);
                                        $("#next9_score").text(data["next9_score"]);
                                        $("#next_user_name").text(data["next_user_name"]);
                                        $("#post_date").text(data["post_date"]);
                                        $("#button").attr("disabled", false);

                                    }).fail( function(XMLHttpRequest, textStatus, errorThrown){
                                        // console.log("error:" + textStatus + " Thrown:" + errorThrown);
                                        // location.reload();
                                        $("#button").attr("disabled", false);
                                    })

                                }
                            }
                            , 40);
                    });
                })
                // 1秒ごとに実行
                // setInterval('time()', 1000);
                // setInterval('getstream(stage_id)', 1000);
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
                        border-collapse: separate;
                        width:400px;
                }
                table td {
                        font-size: 14px;
                        text-align: center;
                        border: 1px solid #777;
                        padding: 8px;
                }
                tr th:nth-child(1),
                tr td:nth-child(1){
                    color: #f20c96;
                }
                tr th:nth-child(2),
                tr td:nth-child(2){
                    color: #b90cf2;
                }
                tr th:nth-child(3),
                tr td:nth-child(3){
                    color: #0ca2f2;
                }
                tr th:nth-child(4),
                tr td:nth-child(4){
                    color: #36f20c;
                }
                tr th:nth-child(5),
                tr td:nth-child(5){
                    color: #f2e70c;
                }
        </style>
<body>
<?php
// トップスコアを表示
//echo '<A href="https://chr.mn/pik4/'.$stage_id.'">'.$array_stage_title[$stage_id]."</A><br><br>\n";
//echo '<span id="time"></span>';
//echo '<table>';
//foreach($stage_array as $val){
//        echo '<tr><td>'.$array_stage_title[$val]."</td>\n";
//        echo '<td id="name'.$val.'"></td>'."\n";
//        echo '<td id="score'.$val.'"></td></tr>'."\n";
//}
//echo '</table>';
// 必要な情報
// ステージ名（日本語、英語）
// 自己ベスト（順位）
// 次の順位（スコア差）
// ランダムステージスイッチ
?>

<div style="width:100%;">
    #<span id="random">???</span><br>
    <span style="font-size:1.5em;" id="stage_name">？？？</span>
    <span style="font-weight:bold;" id="type-style">（<span id="type">？？？</span>）</span> /
    <span style="font-size:1.2em;color:#777;" id="eng_stage_name">???</span>
    <br>
    <table style="width:100%;">
        <tr>
            <th style="width:8%;">Lv.1</th>
            <th style="width:10%;">Lv.2</th>
            <th style="width:15%;">Lv.3</th>
            <th style="width:25%;">Lv.4<br>自己ベ（<span id="post_rank">?</span> 位）</th>
            <th style="width:30%;">Lv.5<br>ライバル（<span id="next_user_name">？？？</span> さん）</th>
            <th style="width:12%;"></th>
        </tr>
        <tr>
            <td><span id="next9_score">??,???</span></td>
            <td><span id="next4_score">??,???</span></td>
            <td><span id="next2_score">??,???</span></td>
            <td><span id="score">??,???</span></td>
            <td><span id="next_score">??,???</span></td>
            <td style="border:none;"><button id="button">シャッフル</button></td>
        </tr>
    </table>
</div>
</body>
</html>
