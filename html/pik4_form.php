<?php
// URLから現在のステージIDを取得
if (($url_stage_id >= 231 and $url_stage_id <= 244) or ($url_stage_id >= 10000 and $url_stage_id <= 20000)){
	$open_toggle = 'width:600px;left:-600px; ';
} else {
	$open_toggle = '';
}
if($page_type == 0 or $page_type == 1 or $page_type == 2 or $page_type == 5 or $page_type == 6 or $page_type == 9 or $page_type == 10 or $page_type == 13 or $page_type == 17 or $page_type == 18 or $page_type == 21 or $page_type > 97){
	$display = "display:none; ";
} else {
	$display = "display:block; ";
}
?>
<div id="org_form" style="<?php echo $open_toggle.$display; ?>" >
<div id="org_form_list">
<div id="loading_screen" style="display:none;position:fixed;z-index:100;width:100%;height:100%;background-color:#000;"> </div>

<A name="form"><strong glot-model="form_title">◆スコア登録<span class="form_eng_cap"> / Entry Form</span> </strong></A> <br>
<hr size="1" />
<form id="leftform" name="form1" action="#" method="post" enctype="multipart/form-data" accept-charset="utf-8" onsubmit="return alertWindow();">
<?php
// フォームロック機構
$lock_icon_def = '';
if(isset($_COOKIE["formlock"])){
	$lock_icon_def= ($_COOKIE["formlock"] == 1)? '<i class=" fa fa-lock" ></i><span glot-model="form_lockon">フォームロック中</span></a>' : '<i class=" fa fa-unlock" ></i><span glot-model="form_lockoff">フォームロック解除中</span></a>';
} else {
	$lock_icon_def= '<i class=" fa fa-unlock" ></i><span glot-model="form_lockoff">フォームロック解除中</span></a>';
}
?>
<div id="formlock_div" style="font-size:0.8em;width:100%;text-align:right;" class="mobile-hidden"><a class="marklink" href="javascript:void(0)" style="color:#ffffff;" onclick="formlock();">
<?php echo $lock_icon_def ?></div>
<i class="fa fa-user"></i><span glot-model="form_player">プレイヤー名<span class="form_eng_cap"> / User Name</span></span><br>
<span class="form_eng_cap tooltip" data-tooltip-content="#tooltip_content3" glot-model="form_player_caution">数字のみや半角記号不可。12文字まで <u>[クリックで詳細]</u></span> <br>
<div class="tooltip_templates" style="display:none;">
<span id="tooltip_content3">
<b>名前の制約詳細</b><br>
・使えるのはShift-JISで表現可能なひらカタ・漢字・アルファベット・数字と一部の記号です<br>
・最初の１文字は数字やアンダーバーは使えません<br>
・13文字以上の名前は使えません（半角は0.5文字として計算）<br>
・「名無し」「匿名」「Anonymous」など匿名を想起させる名称は使えません<br>
・ゲームや漫画や小説などに登場するキャラクターや固有名詞はなるべくそのまま使わないでください<br>
・他の人と重複した名前は使えません<br>
・半角記号の一部は使えません（!"$&'()\/）<br>
・機種依存文字（常用漢字外の漢字や絵文字、丸数字など）は使えません<br>
・現実の自分自身や知り合い、現実やネットの著名人の実名やハンドルネームは使えません<br>
</span>
</div>
<input type="text" required="required" name="user_name" value="<?php echo $cookie_name; ?>" /> <br>
<hr size="1"/>
<i class="fa fa-key"></i><span glot-model="form_pass">パスワード<span class="form_eng_cap"> / Password</span></span><br>
<span class="form_eng_cap" glot-model="form_pass_caution">(初投稿したときに入力したパスワードが登録されます)</span> <br>
<span class="form_eng_cap">(<span glot-model="form_pass_caution2">パスワードを忘れた場合は</span> <A href="https://chr.mn/glyph/%e9%80%a3%e7%b5%a1%e3%83%95%e3%82%a9%e3%83%bc%e3%83%a0" glot-model="here">こちら</A>)</span> <br>
<input type="password" required="required" name="password" value="<?php echo $cookie_pass; ?>" /> <br>
<hr size="1"/>

<?php
if(isset($_SERVER["HTTPS"])){
	if(!isset($_SESSION['access_token'])){
		echo '<i class="fab fa-twitter" aria-hidden="true"></i><a style="color:#ffffff;" href="pik4_login.php" glot-model="form_twitter_login">Twitterでログイン</a>';
		echo '<hr size="1"/>';
	}else{
		if($_COOKIE['post_twitter']) $twitter_checked = ' checked="checked"';
		echo '<input type="checkbox" name="post_twitter" id="post_twitter" value="1"'.$twitter_checked.' /><label for="post_twitter" glot-model="form_twitter_post">Twitterにも投稿する</label> <br>';

		//callback.phpからセッションを受け継ぐ
	//	echo "<p>Twitterでログイン中：(". $_SESSION['id'] . ")</p>";
	//	echo "<p>Twitterでログイン中：(". $_SESSION['name'] . ")</p>";
		echo '<span style="font-size:0.8em;"><span glot-model="form_twitter_login_now">Twitterでログイン中</span>：(@'. $_SESSION['screen_name'] . ")</span> <br>";
	//	echo "<p>最新ツイート：" .$_SESSION['text']. "</p>";
	//	echo "<p><img src=".$_SESSION['profile_image_url_https']."></p>";
	//	echo "<p>access_token：". $_SESSION['access_token']['oauth_token'] . "</p>";
		echo '<span style="font-size:0.8em;"><i class="fab fa-twitter" aria-hidden="true"></i><a href="pik4_logout.php" glot-model="form_twitter_logout">Twitterからログアウト</A></span> <br>';
		echo '<hr size="1"/>';
	}
}
?>
<i class="fa fa-map-signs"></i><span glot-model="form_division">登録区分<span class="form_eng_cap"> / Registration division</span></span><br>
<select type="text" name="ranking_type" onchange="SetSubMenu(value);">
<?php $sel=( $url_stage_id < 1000 and !($url_stage_id > 244 and $url_stage_id < 275))? ' selected="selected"' : ''; ?><option value="normal" <?php echo $sel; ?> glot-model="form_division_normal">通常ランキング</option>
<?php $sel=( ($url_stage_id > 284 and $url_stage_id < 298) or ($url_stage_id > 5000 and $url_stage_id < 5018) )? ' selected="selected"' : ''; ?><option value="new" <?php echo $sel; ?> glot-model="form_division_new">新チャレンジモード</option>
<?php $sel=( $url_stage_id < 3000 and $url_stage_id > 2000)? ' selected="selected"' : ''; ?><option value="multi" <?php echo $sel; ?> glot-model="form_division_2p">2Pモードランキング</option>
<?php $sel=( $url_stage_id > 5016 and $url_stage_id < 5078)? ' selected="selected"' : ''; ?><option value="unlimited" <?php echo $sel; ?> glot-model="form_division_unlimit">アンリミテッド・ランキング</option>
<?php $sel=( ($url_stage_id> 244 and $url_stage_id < 275) or ($url_stage_id >1000 and $url_stage_id < 2000) or ($url_stage_id > 3000  and $url_stage_id < 5000))? ' selected="selected"' : ''; ?><option value="limited" <?php echo $sel; ?> glot-model="form_division_limited">期間限定/日替わりチャレンジ</option>
<?php $sel=( $url_stage_id > 230  and $url_stage_id < 245 )? ' selected="selected"' : ''; ?><option value="storycave"   <?php echo $sel; ?> glot-model="form_division_dungeon">本編地下チャレンジ</option>
<?php $sel=( $url_stage_id > 9999 and $url_stage_id < 100000 )? ' selected="selected"' : ''; ?><option value="story"   <?php echo $sel; ?> glot-model="form_division_story">本編ランキング</option>
<?php $sel=( $url_stage_id == 6 or $url_stage_id == 25 or $url_stage_id == 35 or ($url_stage_id > 274 and $url_stage_id < 285) or ($url_stage_id > 336 and $url_stage_id < 349) )? ' selected="selected"' : ''; ?><option value="battle"   <?php echo $sel; ?> glot-model="form_division_battle">バトルモード</option>

<option value="configure" glot-model="form_conf">各種設定</option>
</select>
<hr size="1" />

<div id="conf" style="display:none;">
<select type="text" name="onfigure_select" onchange="SetSubMenu(value);">
<option value="default" glot-model="form_conf_default">▼選んでください</option>
<option value="record_delete" glot-model="form_conf_delete">記録を削除する</option>
<option value="record_update" glot-model="form_conf_update">記録を更新する</option>
<option value="profile_post" glot-model="form_conf_profile">プロフィールを登録／更新</option>
<option value="limited_post" hidden glot-model="form_conf_post">メッセージを送る</option>
<option value="nopost_login" glot-model="form_conf_nopostlogin">投稿せずにログイン</option>
</select>
<hr size="1" />

<div id="conf_login_box" style="display:none;">
<span class="md" glot-model="form_conf_nopostlogin_caution">（記録を何も登録せずにログインだけします。「登録」ボタンを押してください。）</span><br>
</div>

<div id="conf_prof_box" style="display:none;">
<i class="fa fa-home"></i><span glot-model="form_conf_profile_site">運営しているサイト/ブログ</span><span class="md" glot-model="form_conf_profile_site_caution">（サイト名32文字まで・URLパラメータは登録できません）</span> <br>
<span class="md" glot-model="form_conf_profile_site_name">サイト名</span> <br>
<input type="text" name="prof_sitetitle" value="<?=isset($cookie_row["sitetitle"]) ? $cookie_row["sitetitle"] : ''; ?>" /><br>
<span class="md" glot-model="form_conf_profile_site_url">URL</span> <br>
<input type="url" name="prof_mysite" value="<?=isset($cookie_row["website"]) ? $cookie_row["website"] : ''; ?>" /><br>
<i class="fa fa-tv"></i><span glot-model="form_conf_profile_nicovideo">ニコニコ動画</span><span class="md" glot-model="form_conf_profile_nicovideo_caution">（マイリスト[mylist/XXXXX]またはユーザーページ[user/XXXXX]）</span> <br>
<input type="text" name="prof_nicovideo" value="<?=isset($cookie_row["nicovideo"]) ? $cookie_row["nicovideo"] : ''; ?>" /><br>
<i class="fab fa-twitch"></i><span glot-model="form_conf_profile_twitch">Twitch</span><br>
<input type="text" name="prof_twitch" value="<?=isset($cookie_row["twitch"]) ? $cookie_row["twitch"] : ''; ?>" /><br>
<i class="fab fa-youtube"></i><span glot-model="form_conf_profile_youtube">YouTube</span><span class="md" glot-model="form_conf_profile_youtube_caution">（チャンネルURLの[user/XXXXX]または[channel/XXXXX]をuser・channelを含めて入力）</span> <br>
<input type="text" name="prof_youtube" value="<?=isset($cookie_row["youtube"]) ? $cookie_row["youtube"] : ''; ?>" /><br>
<i class="fab fa-twitter"></i><span glot-model="form_conf_profile_twitter">Twitter ID</span><span class="md" glot-model="form_conf_profile_twitter_caution">（@を除いたアカウント名を入力・鍵アカは非推奨）</span> <br>
<input type="text" name="prof_twitter" value="<?=isset($cookie_row["twitter"]) ? $cookie_row["twitter"] : ''; ?>" /><br>
<i class="fa fa-map-marker"></i><span glot-model="form_conf_profile_fav">お気に入りステージ</span><br>

<select type="text" name="fav_stage_id">
<?php
	$stage_output  = array();
	$stage_output1 = range(101, 105);
	$stage_output2 = range(201, 230);
	$stage_output3 = range(301, 336);
	$stage_output4 = array(10101,10201,10202,10203,10204,10301,10302);
	$stage_output5 = range(10205, 10214);
	$stage_output6 = range(231, 274);
	$stage_output7 = range(2201, 2230);
	$stage_output8 = range(2301, 2336);
	$stage_output9 = range(1001, 1050);
	$stage_output10= range(275, 297);
	$stage_output11= range(337, 348);
	$stage_output  = array_merge($stage_output1, $stage_output2, $stage_output3, $stage_output4, $stage_output5, $stage_output6, $stage_output7, $stage_output8, $stage_output9, $stage_output10, $stage_output11);
	echo '<option value="" glot-model="form_conf_profile_fav_noselect">選択なし</option>';
	foreach( $stage_output as $sel){
		$sel_key = '';
		if(isset($cookie_row["fav_stage_id"])){
			if($cookie_row["fav_stage_id"] == $sel) $sel_key = ' selected="selected"';
		}
		echo '<option value="'.$sel.'"'.$sel_key.'>'.$array_stage_title[$sel].'</option>';
	}
?>
</select> <br>
<i class="fa fa-address-card"></i><span glot-model="form_conf_profile_comment">プロフィールコメント</span><span class="md" glot-model="form_conf_profile_comment_caution">（256文字まで・改行はそのまま反映されます）</span><br>
<textarea name="prof_text" style="font-size:0.9em;margin:0;width:96%;" cols="20" rows="15" maxlength="256">
<?php
	if(isset($cookie_row["user_comment"])) echo br2nl($cookie_row["user_comment"]);
?>
</textarea>
<span class="md" glot-model="form_conf_profile_caution">（※登録されている情報を削除したい場合は空欄のまま送信してください）</span><br>
<span class="md" glot-model="form_conf_profile_caution2">（※NGワードが一つでもあるとすべて反映されません。ご注意ください）</span><br>
</div>

<div id="conf_text_box" style="display:none;">
<i class="fa fa-pencil-alt"></i><span glot-model="form_conf_post_theme">テーマ</span><br>
<select type="text" name="conf_text_title" onchange="SetSubMenu3(value);">
<option value="default" glot-model="form_conf_default">▼選んでください</option>
<option value="limited_post" glot-model="form_conf_post_limited">期間限定ルールを投稿する</option>
<option value="achievement_post" hidden glot-model="form_conf_post_achievement">ピクミン実績を投稿する</option>
<option value="other_post" glot-model="form_conf_post_other">その他(意見・要望・通報・不具合報告・削除申請)</option>
</select> <br>
<?php
/* ★実績投稿 廃止中
<div id="achievement_post" style="display:none;">
<i class="fa fa-font"></i>実績の概略 <br>
<font class="md">(動画のタイトル等)</font><br>
<input type="text" name="post_achi_title" style="width:270px;" value="" /><br>
<i class="fa fa-user"></i>達成者名 <br>
<font class="md">(自薦・他薦問いませんが本人が公開を望んでいない実績の投稿は避けてください)</font>
<input type="text" name="post_achi_player" style="width:270px;" value="" /><br>
<i class="fa fa-calendar"></i>達成日 <br>
<font class="md">(分かる限りの範囲で半角で入力)</font> <br>
<input type="text" name="post_achi_date" style="width:270px;ime-mode:disabled;" value="" /><br>
<i class="fa fa-link"></i>URL <br>
<font class="md">(動画Part1、プレイリスト、Tweet等の証拠URL)</font><br>
<input type="url" name="post_achi_url" style="width:270px;ime-mode:disabled;" value="" /><br>
<i class="fa fa-pencil-alt"></i> 補足・解説 <br>
</div>
*/
?>
<div id="other_post" style="display:none;">
<hr size="1" />
<i class="fa fa-pencil-alt"></i><span glot-model="form_conf_post_other_post">自由記述欄</span><br>
<span class="md">
投稿の前にお読みください <br>
<ul>
<li>ルール集をよく読んでから送信してください。</li>
<li>こちらはユーザー証明が必要な内容の連絡フォームです。匿名で済む情報提供（不具合報告・要望・荒らし通報等）は<A href="https://docs.google.com/forms/d/e/1FAIpQLSd1BUMOtFlRmMnAGpLCMvpiOiLyvJW0FkTjVbQJjB4ko6ISGA/viewform">Googleフォーム</A>が確実です。</li>
<li>要望等で返信が欲しい場合、先頭行にメールアドレスかTwitter ID（@を含む半角英数字）を入力してください。Twitterの場合管理人TwitterからのDMになります。設定やフォロー状況によっては届きません。</li>
<li>やむを得ない事情でユーザー削除を申請したい場合、以下のフォームに「削除」と入力してそのまま送信してください。
ユーザー名を「名無し」に変える措置を執らせていただきます（スコア自体は他参加者のランクポイントにも強くかかわっているため削除できません。予めご了承ください）。</li>
</ul>
</span>
</div>
<div id="limited_post" style="display:none;">
<i class="fa fa-font"></i><span glot-model="form_conf_post_limited_stagename">ステージ名と縛りルール名</span><br>
<span class="md" glot-model="form_conf_post_limited_caution">(『チーム対抗戦』など包括ルールの投稿の場合、ルール名のみ入力)</span><br>
<input type="text" name="post_lim_title" value="" /><br>
<hr size="1" />
<i class="fa fa-pencil-alt"></i><span glot-model="form_conf_post_limited_detail">ルール詳細</span><br>
<span class="md" glot-model="form_conf_post_limited_detail_caution">
縛りルールの条件 <br>
・プラットフォームなどプレイ環境の差によって著しいスコア差が生まれないこと <br>
・参加者の過半数はクリアできる程度の難易度であること <br>
・実証に大きな手間がかかる、または実証不可能な縛りではないこと <br>
</span>
</div>
<div id="conf_text" style="display:none;">
	<textarea name="conf_text" style="font-size:0.8em;margin:0;width:96%;" cols="20" rows="15" value="" maxlength="1024"></textarea>
</div>
</div>
<div id="conf_value_box" style="display:none;">
<i class="fa fa-tag"></i><span glot-model="form_conf_update_id">投稿ID</span><br>
<input type="text" name="conf_value" style="font-size:2em;margin:0;width:250px;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='12' /> <br>
<span class="md" glot-model="form_conf_update_caution">(投稿者による記録の削除はタイプミス等によって不本意に虚偽のスコアを投稿してしまった場合のみ認められます。投稿者の自己都合による削除は認められません。)</span><br>
<hr size="1" />
</div>
<div id="conf_update_box" style="display:none;">
<i class="fa fa-undo"></i><span glot-model="form_conf_update_reset">リセットする</span><br>
<span class="md" glot-model="form_conf_update_reset_caution">(登録済みのコメント・証拠写真・証拠動画を削除する場合チェックしてください。
チェックした場合、以下のフォームで新しく登録する情報以外は削除されます)</span><br>
<label><input type="checkbox" name="post_reset" value="1" /><span glot-model="form_conf_update_reset_check">←チェック</span></label><br>
<hr size="1" />

<i class="fa fa-comment"></i><span glot-model="form_score_comment">一行コメント</span><br>
<input type="text" name="post_comment2" value="" /><br>
<hr size="1" />
<i class="fa fa-camera"></i>証拠写真</span><br>
<span class="md" glot-model="form_conf_update_evidence_photo_caution">(暫定1位または期間限定ランキング参加の場合必須)</span><br>
<input type="file" name="pic_file2[]" multiple="multiple" /><br>
<hr size="1" />
<i class="fa fa-video"></i> 証拠動画URL <br>
<span style="font-size:0.8em;color:#888888;" glot-model="form_score_evidence_movieurl_caution">（ピクミン2チャレンジモード10位以上の場合必須）</span> <br>
<span style="font-size:0.8em;color:#888888;" glot-model="form_score_evidence_movieurl_caution2">（ニコニコ動画・YouTube・Twitch・Twitterのみ登録可能）</span> <br>
<input type="text" name="video_url2" style="ime-mode:disabled;" value="" /><br>

<hr size="1" />
</div>
</div>
<div id="non-conf">
<div id="normal_stage" <?php $sel=( $page_type == 5 or ($url_stage_id > 100 and $url_stage_id < 106) or ($url_stage_id > 200 and $url_stage_id < 231) or ($url_stage_id > 300 and $url_stage_id < 337) or ($url_stage_id > 348 and $url_stage_id < 362) or $url_stage_id == 399)? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> >
<i class="fa fa-map-marker"></i><span glot-model="form_score_stage">ステージ名<span class="form_eng_cap"> / Stage</span></span><br>
<select type="text" name="stage_id" onchange="SetSubMenu(value);echostage('ranking_evidence', value, 'score', 'my_best');">
<?php
// 通常ランキング選択
	$stage_output = array();
	$stage_output1 = range(101, 105);
	$stage_output2 = range(201, 230);
	$stage_output3 = range(301, 336);
	$stage_output4 = range(349, 362);
	$stage_output  = array_merge($stage_output1, $stage_output2, $stage_output3, $stage_output4);
	if($url_stage_id == 399) $stage_output = array(399);
	foreach( $stage_output as $sel){
		$sel_key = '';
		if($url_stage_id == $sel) $sel_key = ' selected="selected"';
		echo '<option value="'.$sel.'"'.$sel_key.'>'.$array_stage_title[$sel].'/'.$stage[$sel]['eng_stage_name'].'</option>';
	}
?>
</select> <br>
</div>

<div id="new_stage" <?php $sel=( ($url_stage_id > 284 and $url_stage_id < 298) or ($url_stage_id > 5000 and $url_stage_id < 5018))? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> >
<i class="fa fa-map-marker"></i><span glot-model="form_score_stage">ステージ名<span class="form_eng_cap"> / Stage</span></span><br>
<select type="text" name="new_challenge" onchange="SetSubMenu(value);echostage('ranking_evidence', value, 'score', 'my_best');">
<?php
// 新チャレンジモード
	$stage_output = array();
	$stage_output1 = range(285, 297);
	$stage_output2 = range(5001, 5013);
	$stage_output  = array_merge($stage_output1, $stage_output2);
	foreach( $stage_output as $sel){
		$sel_key = '';
		if($url_stage_id == $sel) $sel_key = ' selected="selected"';
		echo '<option value="'.$sel.'"'.$sel_key.'>'.$array_stage_title[$sel].'</option>';
	}
?>
</select> <br>
</div>

<div id="unlimited" <?php $sel=($url_stage_id > 5017 and $url_stage_id < 5079)? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> >
<i class="fa fa-map-marker"></i><span glot-model="form_score_stage">ステージ名<span class="form_eng_cap"> / Stage</span></span><br>
<select type="text" name="unlimited" onchange="SetSubMenu(value);echostage('ranking_evidence', value, 'score', 'my_best');">
<?php
// 無差別級・TAS
	$stage_output = array();
	$stage_output1 = range(5018, 5047);
	$stage_output2 = range(5048, 5077);
	$stage_output  = array_merge($stage_output1, $stage_output2);
	foreach( $stage_output as $sel){
		$sel_key = '';
		if($url_stage_id == $sel) $sel_key = ' selected="selected"';
		echo '<option value="'.$sel.'"'.$sel_key.'>'.$array_stage_title[$sel].'</option>';
	}
?>
</select> <br>
</div>

<div id="multi_stage" <?php $sel=( $url_stage_id < 3000 and $url_stage_id > 2000)? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> >
<i class="fa fa-map-marker"></i><span glot-model="form_score_stage">ステージ名<span class="form_eng_cap"> / Stage</span></span><br>
<select type="text" name="multi_stage_id" onchange="SetSubMenu(value);echostage('ranking_evidence', value, 'score', 'my_best');">
<?php
// 2Pランキング選択
	$stage_output = array();
	$stage_output1 = range(2201, 2230);
	$stage_output2 = range(2301, 2336);
	$stage_output3 = range(2349, 2362);
	$stage_output  = array_merge($stage_output1, $stage_output2, $stage_output3);
	foreach( $stage_output as $sel){
		$sel_key = '';
		if($url_stage_id == $sel) $sel_key = ' selected="selected"';
		echo '<option value="'.$sel.'"'.$sel_key.'>'.$array_stage_title[$sel].'</option>';
	}
?>
</select> <br>
</div>

<div id="battle_mode" <?php $sel=( $url_stage_id == 6 or $url_stage_id == 25 or $url_stage_id == 35 or ($url_stage_id > 274 and $url_stage_id < 285) or ($url_stage_id > 336 and $url_stage_id < 349))? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> >
<span glot-model="form_score_reague">参加リーグ</span><br>
<select type="text" name="battle_reague" onchange="SetSubMenu4(value);">
	<option value="1" glot-model="form_score_reague_value1">レギュラーリーグ（レート変動あり）</option>
	<option value="0" hidden glot-model="form_score_reague_value2">フリー対戦（レート変動なし）</option>
</select> <br>
<i class="fa fa-map-marker"></i><span glot-model="form_score_stage">ステージ名<span class="form_eng_cap"> / Stage</span></span><br>
<select type="text" name="battle_stage_id" onchange="SetSubMenu(value);echostage('ranking_evidence', value, 'score', 'my_best');">
<?php
// バトルモードステージ選択
	$stage_output = array();
	$stage_output1 = range(275, 284);
	$stage_output2 = range(337, 348);
	$stage_output  = array_merge($stage_output1, $stage_output2);
	foreach( $stage_output as $sel){
		$sel_key = '';
		$hid_key = '';
		if(($url_stage_id == 25 or ($url_stage_id > 274 and $url_stage_id < 285)) and ($sel > 336 and $sel < 349)) $hid_key = ' hidden';
		if(($url_stage_id == 35 or ($url_stage_id > 336 and $url_stage_id < 349)) and ($sel > 274 and $sel < 285)) $hid_key = ' hidden';
		if($url_stage_id == 35 and $sel == 337) $sel_key = ' selected="selected"';
		if($url_stage_id == $sel) $sel_key = ' selected="selected"';
		echo '<option value="'.$sel.'"'.$sel_key.$hid_key.'>'.$array_stage_title[$sel].'</option>';
	}
?>
</select> <br>
<div id="battle_setting" style="display:none;">
<span glot-model="form_score_rule">対戦ルール</span><br>
<table style="width:200px;">
<tr>
<td><span glot-model="form_score_macaroon">マカロンあり</span> <br><input type="checkbox" name="macaroon" value="1"></td>
<td><span glot-model="form_score_reader">２対２</span> <br><input type="checkbox" name="reader" value="1"></td>
</tr>
</table>

<span glot-model="form_score_pikmin">初期ピクミン</span><br>
<span glot-model="form_score_1p">1P</span><input type="text" name="battle_1p_pikmin" style="font-size:2em;margin:0;width:60px;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='2' />
<span glot-model="form_score_2p">2P</span><input type="text" name="battle_2p_pikmin" style="font-size:2em;margin:0;width:60px;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='2' />
 <br>
</div>
<div id="battle_setting2">
<span glot-model="form_score_regular">対戦ルール（レギュラーリーグ）</span><br>
<span style="font-size:0.8em;color:#aaaaaa;" glot-model="form_score_regular_rule">
[ピクミン2] <br>
　・1P/2P初期ピクミン：25匹 <br>
 <br>
[ピクミン3] <br>
　・マカロン：なし <br>
　・リーダー：1対1 <br>
　・1P/2P初期ピクミン：25匹 <br>
</span>
</div>
<span glot-model="form_score_result">結果</span><br>
<select type="text" name="battle_result">
	<option value="1" glot-model="form_score_result_1win">1Pの勝利</option>
	<option value="2" glot-model="form_score_result_2win">2Pの勝利</option>
	<option value="3" glot-model="form_score_result_draw">引き分け</option>
	<option value="0" hidden glot-model="form_score_result_invalid">無効試合</option>
</select> <br>

<span glot-model="form_score_result_detail">結果詳細</span><br>
<select type="text" name="battle_detail">
	<option value="1" <?php $sel=($url_stage_id == 6 or $url_stage_id == 25 or ($url_stage_id > 274 and $url_stage_id < 285))? '' : 'hidden';echo $sel; ?> glot-model="form_score_result_detail_value1">相手チーム色のビー玉を運んだ</option>
	<option value="2" <?php $sel=($url_stage_id == 6 or $url_stage_id == 25 or ($url_stage_id > 274 and $url_stage_id < 285))? '' : 'hidden';echo $sel; ?> glot-model="form_score_result_detail_value2">黄色ビー玉を４つ運んだ</option>
	<option value="3" <?php $sel=($url_stage_id == 6 or $url_stage_id == 35 or ($url_stage_id > 336 and $url_stage_id < 349))? 'selected' : 'hidden';echo $sel; ?> glot-model="form_score_result_detail_value3">ビンゴシートが１列以上揃った</option>
	<option value="4" <?php $sel=($url_stage_id == 6 or $url_stage_id == 35 or ($url_stage_id > 336 and $url_stage_id < 349))? '' : 'hidden';echo $sel; ?> glot-model="form_score_result_detail_value4">勝利のマカロンを運んだ</option>
	<option value="5" glot-model="form_score_result_detail_value5">相手リーダーがダウンした</option>
	<option value="6" glot-model="form_score_result_detail_value6">相手ピクミンがゼンメツした</option>
	<option value="0" glot-model="form_score_result_detail_value7">無効試合/引き分け</option>
</select>
</div>

<div id="limited_stage" <?php $sel=( ($url_stage_id> 244 and $url_stage_id < 275) or ($url_stage_id > 1000 and $url_stage_id < 2000) or ($url_stage_id > 3000 and $url_stage_id < 5000) )? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> >
<i class="fa fa-map-marker"></i><span glot-model="form_score_stage">ステージ名<span class="form_eng_cap"> / Stage</span></span><br>
<select type="text" name="limited_stage_id">
<?php
// 期間限定ランキング選択
$selected_limited_type = $limited_type[$limited_stage_list[$limited_num]];
$selected_uplan_type = $limited_type[$uplan_stage_list[$uplan_num]];
if($selected_limited_type == "n" or $selected_limited_type == "t" or $selected_uplan_type == "u"){
	foreach($limited_stage as $val){
		$sel=( $url_stage_id == $val)? ' selected="selected"' : '';
		echo '<option value="'.$val.'"'.$sel.'>'.$array_stage_title[$val].'</option>';
	}
}
if($selected_limited_type == "e"){ // エリア踏破戦の場合はアクセス中のステージのみ表示
	if($url_stage_id < 4000){
		echo '<option value="'.$url_stage_id.'" selected="selected">'.$array_stage_title[$url_stage_id].'</option>';
	}
}
// 日替わりチャレンジ選択
foreach($today_challenge as $val){
	$sel=( $url_stage_id == $val)? ' selected="selected"' : '';
	echo '<option value="'.$val.'"'.$sel.'>'.$array_stage_title[$val].'</option>';
}
?>
</select> <br>
</div>

<div id="story_mode" <?php $sel=( $url_stage_id < 10000 or $url_stage_id > 99999 )? 'style="display:none;"' : ''; ?> <?php echo $sel; ?> >
<i class="fa fa-map-marker"></i><span glot-model="form_score_stage">ステージ名<span class="form_eng_cap"> / Stage</span></span><br>
<select type="text" name="story_stage_id" onchange="SetSubMenu(value);SetSubMenu2(value);echostage('ranking_evidence', value, 'score', 'my_best');">
<?php
// 本編ランキング選択
	$stage_output = array();
	$stage_output1 = array(10101);
	$stage_output2 = range(10201, 10225);
	$stage_output3 = range(10301, 10314);
	$stage_output  = array_merge($stage_output1, $stage_output2, $stage_output3);
	foreach($stage_output as $sel){
		$sel_key = '';
		if($url_stage_id == $sel) $sel_key = ' selected="selected"';
		echo '<option value="'.$sel.'"'.$sel_key.'>'.$array_stage_title[$sel].'</option>';
	}
?>
</select><br>
</div>

<div id="storycave" <?php $sel=( $url_stage_id > 230 and $url_stage_id < 245 )? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> >
<i class="fa fa-map-marker"></i><span glot-model="form_score_stage">ステージ名<span class="form_eng_cap"> / Stage</span></span><br>
<select type="text" name="cave_stage_id" onchange="SetSubMenu2(value);echostage('ranking_evidence', value, 'score', 'my_best');echostage('stage_title', value, 'Total_Pikmin', 'start_pikmin');echostage('stage_title', value, 'Time', 'sim_time');">
<?php
// 本編地下チャレンジ選択
	$stage_output = range(231, 244);
	foreach($stage_output as $sel){
		$sel_key = '';
		if($url_stage_id == $sel) $sel_key = ' selected="selected"';
		echo '<option value="'.$sel.'"'.$sel_key.'>'.$array_stage_title[$sel].'</option>';
	}
?>

</select>
</div>

<hr size="1" />
<div id="specials" <?php $sel=( $url_stage_id != 299)? 'style="display:none;"' : ''; ?> <?php echo $sel; ?> >
<span glot-model="form_score_minites_point">所持TP</span><br>
<?php
$now_tp = $_COOKIE['tp'];
if ($now_tp != ""){
echo $now_tp ;
} else {
echo '0';
}
?>
 <br>
</div>
<div id="non-specials" <?php $sel=( $url_stage_id == 299)? 'style="display:none;"' : ''; ?> <?php echo $sel; ?> >
<i class="fa fa-gamepad"></i><span glot-model="form_score_console_1p">1P操作方法<span class="form_eng_cap"> / Controller</span></span><br>
 <select type="text" name="console">
<?php
// 1P操作方法選択
foreach($array_console_long as $key => $sel){
	$sel_key = '';
	$hid_key = '';
	if($key == 1){
		if($series_cat == 3) $hid_key = ' hidden';
	} elseif($key >= 3){
		if($series_cat != 3) $hid_key = ' hidden';
	}
	if($cookie_console == $key) $sel_key = ' selected="selected"';
	echo '<option value="'.$key.'"'.$sel_key.$hid_key.'>'.$sel.'</option>';
}
?>
</select>

<?php
// 2Pモード選択時の追加フォーム
?>
<div id="multi_player" <?php $sel=($url_stage_id == 6 or $url_stage_id == 25 or $url_stage_id == 35 or ($url_stage_id > 274 and $url_stage_id < 285) or ($url_stage_id > 336 and $url_stage_id < 349) or ($url_stage_id > 2000 and $url_stage_id < 3000))? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> >
<hr size="1"/>
<i class="fa fa-user-plus"></i><span glot-model="form_score_player_2p">2Pプレイヤー名</span><br>
<input type="text" name="user_name_2p" value="<?php echo $cookie_name_2p; ?>" /> <br>
<hr size="1"/>
<i class="fa fa-gamepad"></i><span glot-model="form_score_console_2p">2P操作方法</span><br>
<select type="text" name="console_2p">
<?php
// 1P操作方法選択
foreach($array_console_long as $key => $sel){
	$sel_key = '';
	$hid_key = '';
	if($key == 1){
		if($series_cat == 3) $hid_key = ' hidden';
	} elseif($key >= 3){
		if($series_cat != 3) $hid_key = ' hidden';
	}
	if($cookie_console == $key) $sel_key = ' selected="selected"';
	echo '<option value="'.$key.'"'.$sel_key.$hid_key.'>'.$sel.'</option>';
}
?>
</select>
</div>

<?php
// チャレンジモード通常ステージのスコア入力欄
?>
<div id="normal_score" <?php $sel=( $url_stage_id == 6 or $url_stage_id == 25 or $url_stage_id == 35 or ($url_stage_id > 230 AND $url_stage_id < 245) OR ($url_stage_id > 274 AND $url_stage_id < 285) OR ($url_stage_id > 336 AND $url_stage_id < 349) OR ($url_stage_id > 2310 AND $url_stage_id < 2317) OR ($url_stage_id > 310 AND $url_stage_id < 317) OR ($url_stage_id > 10000 and $url_stage_id < 99999) or $url_stage_id == 356 or $url_stage_id == 359 or $url_stage_id == 361)? 'style="display:none;"' : ''; ?> <?php echo $sel; ?> >
<hr size="1"/>
<i class="fa fa-trophy"></i><span glot-model="form_score_score">スコア<span class="form_eng_cap"> / Score</span></span><br>
<input type="tel" class="sbc_field" <?php $sel=($cookie_name != '' AND $url_stage_id < 311 OR $url_stage_id > 316)? 'autofocus':''; ?> <?php echo $sel; ?>  name="score" style="font-size:2em;margin:0;width:270px;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='6' /><br>
<span style="font-size:0.9em;"><?= (($url_stage_id >= 201 and $url_stage_id <= 230) ? '<span glot-model="form_score_evidence_video">証拠動画必要スコア</span>' : '<span glot-model="form_score_evidence_photo2">証拠画像必要スコア</span>'); ?>＝<span id="my_best"> </span></span> <br>
</div>

<div id="trial_version" <?php $sel=( $url_stage_id == 301 or $url_stage_id == 2301)? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> >
<hr size="1"/>
<i class="fas fa-shapes"></i><span glot-model="form_score_trial">体験版<span class="form_eng_cap"> / Trial</span></span><br>
<input type="checkbox" name="trial" style="transform: scale(1.5);" value="Trial" <?php $sel=( $url_stage_id == 301 or $url_stage_id == 2301)? '':''; ?> <?php echo $sel; ?> /><br>
<span style="font-size:0.9em;" glot-model="form_score_trial_caution">（※体験版をプレイした場合はチェックして下さい。）</span>
</div>

<?php
// ミッションモードボスバトルのスコア入力欄
?>
<div id="boss_score" <?php $sel=( ($url_stage_id > 310 AND $url_stage_id < 317) OR ($url_stage_id > 2310 AND $url_stage_id < 2317) or $url_stage_id == 356 or $url_stage_id == 359 or $url_stage_id == 361 or $url_stage_id == 2356 or $url_stage_id == 2359 or $url_stage_id == 2361)? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> >
<hr size="1"/>
<i class="fa fa-trophy"></i><span glot-model="form_score_time">タイム<span class="form_eng_cap"> / Time</span></span><br>
<input type="tel" class="sbc_field" name="score_pik3boss_min" style="font-size:2em;margin:0;width:60px;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='2' /><span glot-model="form_score_min">分</span>
<input type="tel" class="sbc_field" name="score_pik3boss_sec" style="font-size:2em;margin:0;width:60px;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='2' /><span glot-model="form_score_sec">秒</spna> <br>
</div>

<?php
// 本編地下チャレンジのスコア入力欄
?>
<div id="story_caves" <?php $sel=( $url_stage_id > 230 and $url_stage_id < 245 )? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> >
<i class="fa fa-trophy"></i><span glot-model="form_score_score">スコア</span><br>
<span glot-model="form_score_prov">暫定スコア</span>：<span id="sim_score" style="font-size:1.5em;">0</span> <br>
<div style="float:left;margin-bottom:0.25em;">
<span glot-model="form_score_value">お宝累計</span> <input type="tel" class="sbc_field" name="story_cavepoko" style="font-size:2em;margin:0;width:4em;ime-mode:disabled;"  pattern="^[0-9]+$" value="0" maxlength='5' onchange="simscore();" />poko /
</div><div style="float:left;">
<span glot-model="form_score_totaltime">合計時間</span>
<div style="display:none;"><input type="text" name="story_cavehour" style="font-size:2em;margin:0;width:1em;ime-mode:disabled;"  pattern="^[0-9]+$" value="0" maxlength='3' onchange="simscore();" />:</div>
<input type="tel" class="sbc_field" name="story_cavemin"  style="font-size:2em;margin:0;width:1.5em;ime-mode:disabled;"  pattern="^[0-9]+$" value="0" maxlength='2' onchange="simscore();" />:
<input type="tel" class="sbc_field" name="story_cavesec"  style="font-size:2em;margin:0;width:1.5em;ime-mode:disabled;"  pattern="^[0-9]+$" value="0" maxlength='2' onchange="simscore();" />
</div>
<br style="clear:both;" />
<span glot-model="form_score_limittime">制限時間</span>：<span id="sim_time">0</span> <br>
<hr size="1"/>
<b glot-model="form_score_init_composition">初期構成</b> (<span glot-model="form_score_total">合計</span>：<span id="total_pikminc">0</span> / <span glot-model="form_score_possible">連れて行ける数</span>：<span id="start_pikmin">0</span>) <br>
<span glot-model="red">赤</span> <input type="tel" class="sbc_field" name="storyc_red" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="0" maxlength='4' onchange="totalsum2();simscore()" /><span glot-model="tail_hiki">匹</span> /
<span glot-model="blue">青</span> <input type="tel" class="sbc_field" name="storyc_blue" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="0" maxlength='4' onchange="totalsum2();simscore()" /><span glot-model="tail_hiki">匹</span> /
<span glot-model="yellow">黄</span> <input type="tel" class="sbc_field" name="storyc_yellow" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="0" maxlength='4' onchange="totalsum2();simscore()" /><span glot-model="tail_hiki">匹</span> /
<span glot-model="purple">紫</span> <input type="tel" class="sbc_field" name="storyc_purple" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="0" maxlength='4' onchange="totalsum2();simscore()" /><span glot-model="tail_hiki">匹</span> /
<span glot-model="white">白</span> <input type="tel" class="sbc_field" name="storyc_white" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="0" maxlength='4' onchange="totalsum2();simscore()" /><span glot-model="tail_hiki">匹</span>
<br style="clear:both;" /><hr size="1"/>
<b glot-model="form_score_add_composition">追加編成</b><span glot-model="form_score_add_composition_caution">（ポポガシグサは使用回数を入力）</span><br>
<span glot-model="koppa">コッパ</span> <input type="tel" class="sbc_field" name="storyc_koppa" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="0" maxlength='2' onchange="totalsum2();simscore()" /><span glot-model="tail_hiki">匹</span> /
<span glot-model="popoga">ポポガ</span> <input type="tel" class="sbc_field" name="storyc_popoga" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="0" maxlength='1' onchange="totalsum2();simscore()" /><span glot-model="menu_limited_kai">回</span>
<hr size="1"/>

<b glot-model="form_score_deaths">犠牲数</b> <br>
<span glot-model="form_score_total">合計</span> <input type="tel" class="sbc_field" name="storyc_death" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="0" maxlength='4' onchange="simscore();" /><span glot-model="tail_hiki">匹</span> <br>
 <br>
</div>
<?php
// 本編のスコア入力欄
?>
<div id="complex_challenge" <?php $sel=( $url_stage_id < 10204 or $url_stage_id > 10215 or $url_stage_id === 10225 )? 'style="display:none;"' : ''; ?> <?php echo $sel; ?> >
<b glot-model="form_score_timeandscore">通過タイム/スコア</b> (任意項目です。タイムかスコアどちらかだけの登録も可能です） <br>
<table style="table-layout:fixed;">
<?php
	$i = 201;
	$e = 230 + 1;
	if($url_stage_id < 99999){
		$comp_stage_id = $url_stage_id - 10204; // AL=1,公式=2,3～8=各区
	} else {
		$comp_stage_id = "";
	}
	if($url_stage_id == 10213) $comp_stage_id = 2;
	if($url_stage_id == 10214) $comp_stage_id = 2;
	$output = '';
	$css_style = '';
	while($i < $e){
		$m = ceil( ($i - 200) / 5); // 区別表示
		if($comp_stage_id > 2){
			if($comp_stage_id - 2 != $m){
				$css_style = 'style="display:none;"';
			} else {
				$css_style = 'style="display:block;"';
			}
		}
		$output.= '<tr class="c0 c'.$m.'"'.$css_style.'><td>'.$array_stage_title[$i]."</td><td>";
		$output.= '<input type="tel" class="sbc_field f_time" name="comp_'.$i.'h" pattern="^[0-9]+$" value="" maxlength="2" /><span glot-model="form_score_hour">時間</span>';
		$output.= '<input type="tel" class="sbc_field f_time" name="comp_'.$i.'m" pattern="^[0-9]+$" value="" maxlength="2" /><span glot-model="form_score_min">分</span>';
		$output.= '<input type="tel" class="sbc_field f_time" name="comp_'.$i.'s" pattern="^[0-9]+$" value="" maxlength="2" /><span glot-model="form_score_sec">秒</span></td>';
		$output.= '<td><input type="tel" class="sbc_field f_time" name="score_'.$i.'" style="width:5em;" pattern="^[0-9]+$" value="" maxlength="5" /><span glot-model="form_score_point">点</span></td></tr>'."\n";
		$i++;
	}
	echo $output;
?>
</table>
<hr size="1" />
</div>
<div id="story_result" <?php $sel=( $url_stage_id < 10000 or $url_stage_id > 99999 )? 'style="display:none;"' : ''; ?> <?php echo $sel; ?> >
<!--/
<span id="story_timeradio" style="display:none;">
<input type="radio" name="story_rta" value="1" checked /> RTA <br>
<input type="radio" name="story_rta" value="2" /> クリアタイム |
</span>
/-->
<hr size="1" />
<i class="fa fa-trophy"></i><b glot-model="form_score_basescore">基本スコア</b> <br>
<div id="notice1" <?php $sel=( $url_stage_id > 10000 and $url_stage_id < 10200 )? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> > </div>
<div id="notice2" <?php $sel=( $url_stage_id > 10199 and $url_stage_id < 10215 )? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> ><span style="color:#777777;" glot-model="form_score_cleartime_caution">(＊クリアタイムのみ投稿の場合、秒数には「0」を入力してください)</span></div>
<div style="float:left;">
<div id="story_day" <?php $sel=( ($url_stage_id > 10204 and $url_stage_id < 10225) or ($url_stage_id > 10302 and $url_stage_id < 10315) )? 'style="display:none;"' : 'style="float:left;"'; ?> <?php echo $sel; ?> >
<span glot-model="form_score_days">クリア日数 <input type="tel" class="sbc_field" name="story_daycount" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='3' /><span glot-model="form_score_day">日</span>
 / </div><div id="story_correct" <?php $sel=( ($url_stage_id > 10199 and $url_stage_id < 10300) or ($url_stage_id > 10302 and $url_stage_id < 10315) )? 'style="display:none;"' : 'style="float:left;"'; ?> <?php echo $sel; ?> >
 <span glot-model="form_score_collect">回収数</span> <input type="tel" class="sbc_field" name="story_correct" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='3' /><span glot-model="form_score_piece">個</span>
 / </div><div style="float:left;">
<span glot-model="form_score_hour">時間</span> <input type="tel" class="sbc_field" name="story_rtahour" style="font-size:2em;margin:0;width:1em;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='3' />:
<input type="tel" class="sbc_field" name="story_rtamin"  style="font-size:2em;margin:0;width:1.5em;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='2' />:
<input type="tel" class="sbc_field" name="story_rtasec"  style="font-size:2em;margin:0;width:1.5em;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='2' />
</div><br style="clear:both;" />
<div id="story_pikmin" <?php $sel=( ($url_stage_id > 10204 and $url_stage_id < 10225) or ($url_stage_id > 10302 and $url_stage_id < 10315) )? 'style="display:none;"' : 'style="float:left;"'; ?> <?php echo $sel; ?> >
<b glot-model="form_score_totalpikmin">増やした数</b> <span glot-model="form_score_total">合計</span>：<span id="total_pikmin">0</span> <br>
<div id="notice3" <?php $sel=( $url_stage_id > 10299 and $url_stage_id < 10400 )? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> ><span style="color:#777777;" glot-model="form_score_total_caution">(＊「増やした数」は「残ったピクミン」と「死んだピクミン」の合算です)</span></div>
<span style="float:left;">
<span glot-model="red">赤</span> <input type="tel" class="sbc_field" name="story_red" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='4' onBlur="totalsum()" /><span glot-model="tail_hiki">匹</span> /
<span glot-model="blue">青</span> <input type="tel" class="sbc_field" name="story_blue" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='4' onBlur="totalsum()" /><span glot-model="tail_hiki">匹</span> /
<span glot-model="yellow">黄</span> <input type="tel" class="sbc_field" name="story_yellow" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='4' onBlur="totalsum()" /><span glot-model="tail_hiki">匹</span>
</span>
<span id="story_2only" <?php $sel=( $url_stage_id > 10199 and $url_stage_id < 10300 )? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> >
 / <span glot-model="purple">紫</span> <input type="tel" class="sbc_field" name="story_purple" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='4' onBlur="totalsum()" /><span glot-model="tail_hiki">匹</span> /
 <span glot-model="white">白</span> <input type="tel" class="sbc_field" name="story_white" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='4' onBlur="totalsum()" /><span glot-model="tail_hiki">匹</span>
</span>
<span id="story_3only" <?php $sel=( $url_stage_id > 10299 and $url_stage_id < 10400 )? '' : 'style="display:none;"'; ?> <?php echo $sel; ?> >
 / <span glot-model="winged">羽</span> <input type="tel" class="sbc_field" name="story_winged" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='4' onBlur="totalsum()" /><span glot-model="tail_hiki">匹</span> /
<span glot-model="rock">岩</span> <input type="tel" class="sbc_field" name="story_rock" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='4' onBlur="totalsum()" /><span glot-model="tail_hiki">匹</span> <br>
</span>


<br style="clear:both;" /><hr size="1"/>
<b glot-model="form_score_deaths">犠牲数</b> <br>
<span glot-model="form_score_total">合計</span> <input type="tel" class="sbc_field" name="story_death" style="font-size:2em;margin:0;width:2em;ime-mode:disabled;"  pattern="^[0-9]+$" value="" maxlength='4' /><span glot-model="tail_hiki">匹</span> <br>
</div>

<div id="story_limited" style="line-height:1.5em;display:none;" >
<table style="width:100%;border:solid 1px #aaaaaa;" class="form_story_lim">
<tr>
<td><input type="checkbox" name="story_lim_array[]" value="nsp"> <span glot-model="form_score_storylim01">ノースプレー</span></td>
<td><input type="checkbox" name="story_lim_array[]" value="ndm"> <span glot-model="form_score_storylim02">ノーダメージ</span></td>
<td><input type="checkbox" name="story_lim_array[]" value="nrs"> <span glot-model="form_score_storylim03">ノーリセット</span></td>
</tr>
<tr>
<td><input type="checkbox" name="story_lim_array[]" value="nkl"> <span glot-model="form_score_storylim04">ノーキル</span></td>
<td><input type="checkbox" name="story_lim_array[]" value="oat"> <span glot-model="form_score_storylim05">午前縛り</span></td>
<td><input type="checkbox" name="story_lim_array[]" value="nrp"> <span glot-model="form_score_storylim06">赤不使用</span></td>
<tr>
<tr>
<td><input type="checkbox" name="story_lim_array[]" value="nbp"> <span glot-model="form_score_storylim07">青不使用</span></td>
<td><input type="checkbox" name="story_lim_array[]" value="nyp"> <span glot-model="form_score_storylim08">黄不使用</span></td>
<td><input type="checkbox" name="story_lim_array[]" value="ndm"> <span glot-model="form_score_storylim09">地下隊列最小</span></td>
<tr>
<tr>
<td><input type="checkbox" name="story_lim_array[]" value="nwp"> <span glot-model="form_score_storylim10">白不使用</span></td>
<td><input type="checkbox" name="story_lim_array[]" value="npp"> <span glot-model="form_score_storylim11">紫不使用</span></td>
<td><input type="checkbox" name="story_lim_array[]" value="nkp"> <span glot-model="form_score_storylim12">コッパ不使用</span></td>
</tr>
<tr>
<td><input type="checkbox" name="story_lim_array[]" value="olp"> <span glot-model="form_score_storylim13">葉のみ</span></td>
<td><input type="checkbox" name="story_lim_array[]" value="ozi"> <span glot-model="form_score_storylim14">常時ズームイン</span></td>
<td><input type="checkbox" name="story_lim_array[]" value="nli"> <span glot-model="form_score_storylim15">リーダー1人</span></td>
</tr>
<tr>
<td><input type="checkbox" name="story_lim_array[]" value="ncm"> <span glot-model="form_score_storylim16">LRZボタン禁止</span></td>
<td><input type="checkbox" name="story_lim_array[]" value="ncs"> <span glot-model="form_score_storylim17">Cスティック禁止</span></td>
<td><input type="checkbox" name="story_lim_array[]" value="nbb"> <span glot-model="form_score_storylim18">Bボタン禁止</span></td>
</tr>
<tr>
<td><input type="checkbox" name="story_lim_array[]" value="ngt"> <span glot-model="form_score_storylim19">バグ技不使用</span></td>
<td><input type="checkbox" name="story_lim_array[]" value="odo"> <span glot-model="form_score_storylim20">地下1回制限</span></td>
<td><input type="checkbox" name="story_lim_array[]" value="odo"> <span glot-model="form_score_storylim21">毎日1匹スタート</span></td>
</tr>
</table>
</div>
</div>
<br style="clear:both;" />
</div>
<?php if($season_data == 2) echo '<font style="font-size:0.9em;color:#888888;">(※シーズンモードでは自己ベスト記録でなくても期間内に出したうち最も高いスコアであれば登録できます)</font>'; ?>
<hr size="1" />
<i class="fa fa-comment"></i><span glot-model="form_score_comment">一行コメント<span class="form_eng_cap"> / Comment</span></span><br>
<input type="text" name="post_comment" value="" /><br>
<hr size="1" />
<i class="fa fa-camera"></i><span glot-model="form_score_evidence_photo">証拠写真<span class="form_eng_cap"> / Evidence photo</span></span><br>
<span class="tooltip" data-tooltip-content="#tooltip_content" style="font-size:0.8em;color:#888888;" glot-model="form_score_evidence_photo_caution">写真：bmp/jpeg/png/gif形式のいずれか <u>[クリックで詳細]</u></span> <br>
<!--/ ★ショート動画は停止中
<span class="tooltip" data-tooltip-content="#tooltip_content2" style="font-size:0.8em;color:#888888;" glot-model="form_score_evidence_attachment_video_caution">動画：mp4形式のみ、<b>最大40MBまで</b><u> [クリックで詳細]</u></span> <br>
/-->
<div class="tooltip_templates" style="display:none;">
<span id="tooltip_content" glot-model="form_score_evidence_photo_detail">
<b>証拠写真の条件詳細</b> <br>
・3MB以上の画像は自動的に圧縮されます。<br>
・通常ランキング10位以上（ピクミン2では20位以上）、特殊ランキングへの投稿では必須。 <br>
・リザルト画面の大半が映っているもの、できれば紙吹雪が舞っている状態のリザルト画面が望ましい。 <br>
・撮り損ねた場合はステージセレクト画面で当該ステージのハイスコアが表示されている画面の写真でも可。 <br>
・直撮り・キャプ画かどうかは問わないが、直撮りの場合は顔などの映り込みやExif情報に注意（写真はサイト上に公開される）
</span>
<span id="tooltip_content2" glot-model="form_score_evidence_attachment_video_detail">
<b>ショート動画の条件詳細</b> <br>
<b>・ショート動画は現在不具合対応中です。アップロードできません。（2020/07/04）</b><br>
・ショート動画は当サイトへ直接動画をアップロードする仕組みです。 <br>
・ピクミン2通常ランキング10位以上または各種RTAでは原則必須（動画サイトでも可） <br>
・適当な音質の音声があり、ゲームプレイの認識に支障がない画質であり、著しいブロックノイズや音ズレがないこと <br>
・Aviutl + x264GUIでのH.264エンコードを推奨。ビットレート指定は音声最大128kbps、上限ファイルサイズ指定最大40MB <br>
・機種にかかわらずピクミン1/2では480p・30fps、ピクミン3では720p～1080p・60fps推奨。 <br>
・プレイ時間が長い場合などで上記設定で画質に難がある場合はYouTubeへの投稿をご検討ください。 <br>
</span>
</div>

<input type="file" name="pic_file[]" multiple="multiple" style="width:270px;" id="pic_files" /><br>
<input type="hidden" name="large_picfile" id="large_picfile" value=""/>
<p class="filesize1"></p>
<p id="filesize_over" class="tooltip" style="display:none;border-radius:5px;background-color:#fff;color:#222;" glot-model="form_score_filesizeover">※写真は3MB以下にしてください！</p>
<hr size="1" />
<i class="fa fa-video"></i><span glot-model="form_score_evidence_movieurl">証拠動画URL<span class="form_eng_cap"> / Evidence videos URL</span></span><br>
<span style="font-size:0.8em;color:#888888;" glot-model="form_score_evidence_movieurl_caution">（ピクミン2チャレンジモード10位以上の場合必須）</span> <br>
<span style="font-size:0.8em;color:#888888;" glot-model="form_score_evidence_movieurl_caution2">（ニコニコ動画・YouTube・Twitch・Twitterのみ登録可能）</span> <br>
<input type="text" name="video_url" style="width:270px;ime-mode:disabled;" value="" /><br>
<input type="hidden" name="formtype" value="1" />
<hr size="1" />
</div>

</div>
<span class="form_eng_cap" glot-model="form_score_warning">投稿完了した時点で<A href="./ルール集">ルール集</A>に同意したものと見なされます。投稿前にもう一度スコアをご確認ください！ <br>
It is considered to have agreed to the terms when posting is completed. Please check your score again!</span><br>
<input type="hidden" name="check_send" value="1"/>
<input style="height:40px;" type="submit" value="登録 / Enter" />
</form>
<form action="#" method="post"><input type="submit" name="del_id" value="Cookie削除 (ログアウト)"></form>
<?php
if(!$mysql_mode){
	$time = microtime(true) - $time_start;
	$loadtime_echo[] = " <br>".__LINE__. "行目：{$time} 秒";
	echo '<div class="speed_test">';
	foreach($loadtime_echo as $val){
		echo $val;
	}
	echo '</div>';
	echo '<div class="test_float_left">';
	echo '$stage_id：'.$stage_id.'<br>';
	echo '$url_stage_id：'.$url_stage_id.'<br>';
	echo '$_COOKIE：';
	var_dump($_COOKIE);
	echo '<br>$_SESSION：';
	var_dump($_SESSION);
	echo '<br>$_FILES：';
	var_dump($_FILES);
	echo '<br>';
	echo '</div>';
}
// BODY終了タグ直前に読み込むプラグインはここから記述
?>
<div style="padding-top:4em;"></div>
</div>
</div>