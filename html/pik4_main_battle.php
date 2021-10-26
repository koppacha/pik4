<?php
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
