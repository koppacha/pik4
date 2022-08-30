<?php

require_once('_def.php');
require_once('pik4_config.php');

$back_data = array();
$error = 0;

if(isset($_POST['stage'])){

    $stage_id = intval($_POST['stage']); // ステージID
    if($stage_id > 230 and $stage_id < 244){
        // 231〜243はタマゴムシ縛りに変換
        $stage_id += 54;
        $back_data["type"] = "タマゴムシ縛り";
        $back_data["type_style"] = "#ffd91c";
    } elseif($stage_id > 243){
        // 244〜256はスプレー縛りに変換
        $stage_id += 4757;
        $back_data["type"] = "スプレー縛り";
        $back_data["type_style"] = "#ff1cf4";
    } else {
        $back_data["type"] = "通常ルール";
        $back_data["type_style"] = "#fff";
    }
    $user_name = $_COOKIE['user_name'];  // ユーザー名
    if($stage_id > 5014 or $stage_id < 201) $error = 1;
    if($user_name == "") $error = 1;

    // データベースへアクセス
    $mysqlconn = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);
    if ( $mysqlconn == false) {
        $error = 1;
        $back_data[] = " <br>Error ".__LINE__."：データベースに接続できませんでした。エラー番号：".mysqli_connect_errno();
        exit;
    } else {
        $result = mysqli_query($mysqlconn, 'SET NAMES utf8mb4');
        if (!$result) {
            $error = 1;
            $back_data[] = " <br>Error ".__LINE__."：データベースの文字セット指定に失敗しました。";
        }
    }

    require_once('pik4_function.php');
    require_once('pik4_array.php');
    require_once('pik4_name.php');
    require_once('pik4_database.php');

    if(!$error){
        // 基本情報を取得
        $back_data["stage_name"] = $stage[$stage_id]["stage_name"];
        $back_data["eng_stage_name"] = $stage[$stage_id]["eng_stage_name"];

        // 自己ベストを取得
        $sql = "SELECT `score`,`post_rank`,`post_date` FROM `ranking` WHERE `stage_id` = '$stage_id' AND `user_name` = '$user_name' AND `log` = 0";
        $result = mysqli_query($mysqlconn, $sql);
        $data = mysqli_fetch_assoc($result);
        $score = $data["score"];
        if($score){
            $back_data["score"] = $score;
            $post_rank = $data["post_rank"];
            $back_data["post_rank"] = $post_rank;
            $back_data["post_date"] = $data["post_date"];

            if($post_rank > 1) {
                // 次の順位を取得
                $sql = "SELECT `score`,`user_name`,`post_rank` FROM `ranking` WHERE `stage_id` = '$stage_id' AND `post_rank` < '$post_rank' AND `log` = 0 ORDER BY `post_rank` DESC LIMIT 1";
                $result = mysqli_query($mysqlconn, $sql);
                $data = mysqli_fetch_assoc($result);
                $back_data["next_score"] = $data["score"];
                $back_data["next_user_name"] = $data["user_name"];
                $back_data["next_rank"] = $data["post_rank"];

                // ３位下、５位下、10位下を取得
                $sql = "SELECT `score` FROM `ranking` WHERE `stage_id` = '$stage_id' AND `post_rank` > '$post_rank' AND `log` = 0 ORDER BY `post_rank` ASC LIMIT 10";
                $result = mysqli_query($mysqlconn, $sql);
                $datas = array();
                while($data = mysqli_fetch_assoc($result)){
                    $datas[] = $data;
                }
                $back_data["next2_score"] = $datas[2]["score"];
                $back_data["next4_score"] = $datas[4]["score"];
                $back_data["next9_score"] = $datas[9]["score"];

            } else {
                $back_data["next_score"] = "???";
                $back_data["next_user_name"] = "あなたがWR保持者です！";
                $back_data["next_rank"] = 1;
                $back_data["next2_score"] = 0;
                $back_data["next4_score"] = 0;
                $back_data["next9_score"] = 0;
            }
        } else {
            // 自己ベストが存在しない場合
            $back_data["score"] = 0;
            $back_data["post_rank"] = "-";
            $back_data["post_date"] = "-";
            $back_data["next_score"] = 0;
            $back_data["next_user_name"] = "-";
            $back_data["next_rank"] = "-";
            $back_data["next2_score"] = 0;
            $back_data["next4_score"] = 0;
            $back_data["next9_score"] = 0;
        }
    }


} else {
    $error = 1;
}
if($error) $back_data = "エラーが発生しています。";

header('Content-Type: application/json; charset=utf-8');

echo json_encode($back_data);
