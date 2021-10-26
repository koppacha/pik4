<?php

require_once('_def.php');
require_once('pik4_config.php');

$back_data = array();

if(isset($_POST['stage_id'])){

	$stage_id = intval($_POST['stage_id']);		// ステージIDを取得

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

	require_once('pik4_function.php');
	require_once('pik4_array.php');
	require_once('pik4_name.php');

	// エリア踏破戦データベースを一括取得して配列に入れる
        $area = array(0 => null);
        $sql = "SELECT * FROM `area`";
        $result = mysqli_query($mysqlconn, $sql);
        if($result){
                while($area_data = mysqli_fetch_assoc($result)){
                        $area[$area_data["id"]] = $area_data;
                }
        }

// // アクセス可能かどうか判定する
// // 大会開催中のみ有効（非開催時は全ステージアクセス可能にする）
// if($limited_num == 16){
//         $addr_link_flag = 0;
//         if($area[$addr]["flag"] == 3 and $cookie_row['current_team'] == $team_a){
//                 $addr_link_flag = 1;
//         } elseif($area[$addr]["flag"] == 4 and $cookie_row['current_team'] == $team_b){
//                 $addr_link_flag = 1;
//         } else {
//                 $addr_link_flag = 0;
//         }
//         // 上下左右が自陣
//         if($cookie_row['current_team'] == $team_a){
//                 if($area[$addr - 1]["flag"] == 3) $addr_link_flag = 1;
//                 if($area[$addr + 1]["flag"] == 3) $addr_link_flag = 1;
//                 if($area[$addr - $ae_width[$limited_num]]["flag"] == 3) $addr_link_flag = 1;
//                 if($area[$addr + $ae_width[$limited_num]]["flag"] == 3) $addr_link_flag = 1;
//         } elseif($cookie_row['current_team'] == $team_b){
//                 if($area[$addr - 1]["flag"] == 4) $addr_link_flag = 1;
//                 if($area[$addr + 1]["flag"] == 4) $addr_link_flag = 1;
//                 if($area[$addr - $ae_width[$limited_num]]["flag"] == 4) $addr_link_flag = 1;
//                 if($area[$addr + $ae_width[$limited_num]]["flag"] == 4) $addr_link_flag = 1;
//         } else {
//                 $addr_link_flag = 0;
//         }

//         if($area[$addr]["mark"] == 'base'){
//                 $add_link = '<A href="./200918">';
//                 $add_tail = '</A>';
//         } elseif($addr_link_flag === 1){
//                 $add_link = '<A href="./'.$area[$addr]["stage_id"].'">';
//                 $add_tail = '</A>';
//         } else {
//                 $add_link = '<A href="#">';
//                 $add_tail = '</A>';
// //							$area_nav_stage_title = '？？？<br><br>';
//         }
// } else {
//         $add_link = '<A href="./'.$area[$addr]["stage_id"].'">';
//         $add_tail = '</A>';
// }
// // 侵入不可能
// if($area[$addr]["flag"] == 0){
//         echo '<td class="area_0"> </td>';
// }
// // 未開地
// elseif($area[$addr]["flag"] == 1){
//         // 未解禁のフリーエリア
//         echo '<td style="text-align:center;" class="area_1'.$current_area.'">'."{$tr}-{$td}".'</td>';
//         $area_1_cnt++;
// }
// // どちらでもない解禁済みエリア
// elseif($area[$addr]["flag"] == 2){
//         echo '<td class="area_2'.$current_area.'">'.$add_link."{$tr}-{$td}".'◆'.$area_nav_stage_title.$area[$addr]["user_name"].'<p><i class="fa fa-star" aria-hidden="true"></i>'.$area[$addr]["top_score"].' pts.  <i class="fas fa-paper-plane"></i>'.$area[$addr]["count"].'</p><p>'.$teame['a'][$key].$area[$addr]['team_a'].' - '.$area[$addr]['team_b'].$teame['b'][$key].'</p>'.$add_tail.'</td>';
//         $area_2_cnt++;
// }
// // 左チームのエリア
// elseif($area[$addr]["flag"] == 3){
//         // 拠点の場合
//         if($area[$addr]["mark"] == 'base'){
//                 echo '<td style="background-color:#'.$teamc[$teamp['a'][$key]].'" class="area_3'.$current_area.'">'.$add_link."{$tr}-{$td}".'◆'.$team[$teamp['a'][$key]].'<br><div style="text-align:right;" glot-model="main_nav_team_base">（拠点）</div></td>';
//         } else {
//                 echo '<td style="background-color:#'.$teamc[$teamp['a'][$key]].'" class="area_3'.$current_area.'">'.$add_link."{$tr}-{$td}".'◆'.$area_nav_stage_title.$area[$addr]["user_name"].'<p><i class="fa fa-star" aria-hidden="true"></i>'.$area[$addr]["top_score"].' pts.  <i class="fas fa-paper-plane"></i>'.$area[$addr]["count"].'</p><p>'.$teame['a'][$key].$area[$addr]['team_a'].' - '.$area[$addr]['team_b'].$teame['b'][$key].'</p>'.$add_tail.'</td>';
//         }
//         $area_3_cnt++;
// }
// // 右チームのエリア
// elseif($area[$addr]["flag"] == 4){
//         // 拠点の場合
//         if($area[$addr]["mark"] == 'base'){
//                 echo '<td style="background-color:#'.$teamc[$teamp['b'][$key]].'" class="area_3'.$current_area.'">'.$add_link."{$tr}-{$td}".'◆'.$team[$teamp['b'][$key]].'<br><div style="text-align:right;" glot-model="main_nav_team_base">（拠点）</div></td>';
//         } else {
//                 echo '<td style="background-color:#'.$teamc[$teamp['b'][$key]].'" class="area_4'.$current_area.'">'.$add_link."{$tr}-{$td}".'◆'.$area_nav_stage_title.$area[$addr]["user_name"].'<p><i class="fa fa-star" aria-hidden="true"></i>'.$area[$addr]["top_score"].' pts.  <i class="fas fa-paper-plane"></i>'.$area[$addr]["count"].'</p><p>'.$teame['a'][$key].$area[$addr]['team_a'].' - '.$area[$addr]['team_b'].$teame['b'][$key].'</p>'.$add_tail.'</td>';
//         }
//         $area_4_cnt++;
// }
// // 侵入不可能
// else {
//         echo '<td class="area_0"> </td>';
// }

	mysqli_close($conn);
} else {

$back_data = "エラーが発生しています（ステージIDの取得に失敗しました）";

}

header('Content-Type: application/json; charset=utf-8');

echo json_encode($area);
?>