// ピクミンシリーズチャレンジモード大会 各種javascriptプラグイン (2015/11/07)

// 変数の定義
var lang = navigator.language;

// ユーザーエージェント判定 (参考：https://w3g.jp/blog/js_browser_sniffing2015 )
var _ua = (function(u){
      return {
        Tablet:(u.indexOf("windows") != -1 && u.indexOf("touch") != -1 && u.indexOf("tablet pc") == -1)
          || u.indexOf("ipad") != -1
          || (u.indexOf("android") != -1 && u.indexOf("mobile") == -1)
          || (u.indexOf("firefox") != -1 && u.indexOf("tablet") != -1)
          || u.indexOf("kindle") != -1
          || u.indexOf("silk") != -1
          || u.indexOf("playbook") != -1,
        Mobile:(u.indexOf("windows") != -1 && u.indexOf("phone") != -1)
          || u.indexOf("iphone") != -1
          || u.indexOf("ipod") != -1
          || (u.indexOf("android") != -1 && u.indexOf("mobile") != -1)
          || (u.indexOf("firefox") != -1 && u.indexOf("mobile") != -1)
          || u.indexOf("blackberry") != -1
	}
})(window.navigator.userAgent.toLowerCase());

// 自由記述専用トグルスイッチ
function SetSubMenu3( idname3 ) {
	if(idname3 == "limited_post") {
		document.getElementById('limited_post').style.display = 'block';
		document.getElementById('other_post').style.display = 'none';
		document.getElementById('conf_text').style.display = 'block';
	}
	else if(idname3 == "other_post") {
		document.getElementById('limited_post').style.display = 'none';
		document.getElementById('other_post').style.display = 'block';
		document.getElementById('conf_text').style.display = 'block';
	}
	else {
		document.getElementById('limited_post').style.display = 'none';
		document.getElementById('other_post').style.display = 'none';
		document.getElementById('conf_text').style.display = 'none';
	}

}
// バトルモード専用トグルスイッチ
function SetSubMenu4( idname4 ) {
	if(idname4 == 0) {
		document.getElementById('battle_setting').style.display = 'block';
		document.getElementById('battle_setting2').style.display = 'none';
	}
	else if(idname4 == 1 || idname4 == 2) {
		document.getElementById('battle_setting').style.display = 'none';
		document.getElementById('battle_setting2').style.display = 'block';
	}
	else {
		document.getElementById('battle_setting').style.display = 'none';
		document.getElementById('battle_setting2').style.display = 'none';
	}

}
// 特殊フォーム切り替えを本編ランキング用に独立させる
function SetSubMenu2( idname2 ) {
	if(idname2 == 10100 || idname2 == 10200 || idname2 == 10300) {
		document.getElementById('story_limited').style.display = 'block';
	} else {
		document.getElementById('story_limited').style.display = 'none';
	}
	// ピクミン2RTA のみ表示する内容をトグル
	if(idname2 >= 10200 && idname2 <= 10299) {
//		document.getElementById('story_timeradio').style.display = 'block';
		document.getElementById('story_2only').style.display = 'block';
		document.getElementById('story_correct').style.display = 'none';
		document.getElementById('story_3only').style.display = 'none';
		document.getElementById('notice1').style.display = 'none';
		document.getElementById('notice2').style.display = 'block';
		document.getElementById('notice3').style.display = 'none';
	}
	// ピクミン3 のみ表示する内容をトグル
	else if(idname2 >= 10300 && idname2 <= 10399) {
//		document.getElementById('story_timeradio').style.display = 'none';
		document.getElementById('story_correct').style.display = 'block';
		document.getElementById('story_correct').style.float = 'left';
		document.getElementById('story_2only').style.display = 'none';
		document.getElementById('story_3only').style.display = 'block';
		document.getElementById('notice1').style.display = 'none';
		document.getElementById('notice2').style.display = 'none';
		document.getElementById('notice3').style.display = 'block';
	}
	// ピクミン のみ表示する内容をトグル
	else {
//		document.getElementById('story_timeradio').style.display = 'none';
		document.getElementById('story_correct').style.display = 'block';
		document.getElementById('story_correct').style.float = 'left';
		document.getElementById('story_2only').style.display = 'none';
		document.getElementById('story_3only').style.display = 'none';
		document.getElementById('notice1').style.display = 'block';
		document.getElementById('notice2').style.display = 'none';
		document.getElementById('notice3').style.display = 'none';
	}

}

// 311-316特殊フォーム切り替え用javascript 参考：http://allabout.co.jp/gm/gc/23955/4/
function AllHide() {
   document.getElementById('normal_score').style.display = 'none';	// 通常スコア
   document.getElementById('boss_score').style.display = 'none';	// 巨大生物をたおせ！
   document.getElementById('normal_stage').style.display = 'none';	// 通常ステージ選択
   document.getElementById('limited_stage').style.display = 'none';	// 期間限定・日替わりステージ選択
   document.getElementById('new_stage').style.display = 'none';		// 新チャレンジモード選択
   document.getElementById('unlimited').style.display = 'none';		// 無差別級・TAS選択
   document.getElementById('story_mode').style.display = 'none';	// 本編ステージ選択
   document.getElementById('story_result').style.display = 'none';	// 本編ステージのスコア
   document.getElementById('specials').style.display = 'none';		// タマゴポイント
   document.getElementById('story_caves').style.display = 'none';	// 本編地下チャレンジのスコア
   document.getElementById('non-specials').style.display = 'none';	// 操作方法・コメント・証拠写真
   document.getElementById('non-conf').style.display = 'none';		// 各種設定以外すべて
   document.getElementById('conf').style.display = 'none';		// 各種設定
   document.getElementById('storycave').style.display = 'none';		// 本編地下チャレンジのステージ選択
   document.getElementById('conf_value_box').style.display = 'none';	// 各種設定のID入力
   document.getElementById('conf_text_box').style.display = 'none';	// 各種設定の自由記入欄
   document.getElementById('conf_update_box').style.display = 'none';	// 各種設定のコメント・証拠写真
   document.getElementById('multi_stage').style.display = 'none';	// 2Pモードステージ選択
   document.getElementById('multi_player').style.display = 'none';	// 2Pモードステージ選択
   document.getElementById('battle_mode').style.display = 'none';	// バトルモードステージ選択
   document.getElementById('conf_prof_box').style.display = 'none';	// バトルモードステージ選択
	var element = document.getElementsByClassName("c0");		// チャレンジ複合
	for (var i=0;i<element.length;i++) {
	element[i].style.display = "none";
	}
}
// オンマウスでナビゲーション表示を切り替え
var navlock_toggle = 0;
// 第一階層
$(function(){
	$('.navmenu').hover(function(){
		navlock_toggle = getCookie("navlock");
		if(navlock_toggle == 0){
			$('.topscore').each(function(){
				$(this).hide();
			});
			$('.liminfo').each(function(){
				$(this).hide();
			});
			var idn = $(this).attr("id");
			idn = idn.replace("nv", "top-score");
			$('.' + idn).show();
		}
	});
});
// 第二階層
$(function(){
	$('.navmenulim').hover(function(){
		navlock_toggle = getCookie("navlock");
		if(navlock_toggle == 0){
			$('.liminfo').each(function(){
				$(this).hide();
			});
			$('.subscore').each(function(){
				$(this).hide();
			});
			var idn = $(this).attr("id");
			idn = idn.replace("nv", "lim");
			$('.' + idn).show();
		}
	});
});
// 第三階層
$(function(){
	$('.subnavmenulim').hover(function(){
		navlock_toggle = getCookie("navlock");
		if(navlock_toggle == 0){
			$('.liminfo').each(function(){
				$(this).hide();
			});
			var idn = $(this).attr("id");
			idn = idn.replace("nv", "lim");
			$('.' + idn).show();
			idn = idn.replace("lim", "top-score");
			$('.' + idn).show();
		}
	});
});
function SetSubMenu( idname ) {
   AllHide();
   // ステージ番号を変更した場合の挙動

               if ( idname != "" && idname >= 101 && idname <= 230) {			// 通常ランキング (1・2)
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('normal_stage').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && idname >= 231 && idname <= 244) {			// 本編地下チャレンジ
		document.getElementById('storycave').style.display = 'block';
		document.getElementById('story_caves').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && idname >= 275 && idname <= 284) {			// 2Pバトルモード
		document.getElementById('non-conf').style.display = 'block';
		document.getElementById('battle_mode').style.display = 'block';
		document.getElementById('multi_player').style.display = 'block';
	} else if ( idname != "" && idname >=285 && idname <=297) {			// 新チャレンジモード
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('new_stage').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && idname >= 245 && idname <= 310) {			// 通常ランキング (3のデフォルト)
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('normal_stage').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && idname >= 311 && idname <= 316) {			// 通常ランキング (ボスバトル)
		document.getElementById('boss_score').style.display = 'block';
		document.getElementById('normal_stage').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && idname >= 317 && idname <= 336) {			// 通常ランキング (3の追加DLC)
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('normal_stage').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && idname >= 337 && idname <= 348) {			// ビンゴバトルモード
		document.getElementById('non-conf').style.display = 'block';
		document.getElementById('battle_mode').style.display = 'block';
		document.getElementById('multi_player').style.display = 'block';
	} else if ( idname != "" && (idname == 356 || idname == 359 || idname == 361)){ // 通常ランキング (ボスバトル)
		document.getElementById('boss_score').style.display = 'block';
		document.getElementById('normal_stage').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && idname >= 349 && idname <= 362) {			// 通常ランキング (サイドストーリー)
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('normal_stage').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && idname >=1000 && idname <=1999) {			// 期間限定ランキング
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('limited_stage').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && idname >=2000 && idname <=2310) {			// 2Pチャレンジ
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('multi_stage').style.display = 'block';
		document.getElementById('multi_player').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && idname >=2311 && idname <=2316) {			// 2Pチャレンジ (ボスバトル)
		document.getElementById('boss_score').style.display = 'block';
		document.getElementById('multi_stage').style.display = 'block';
		document.getElementById('multi_player').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && idname >=2317 && idname <=2336) {			// 2Pチャレンジ (3の追加DLC)
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('multi_stage').style.display = 'block';
		document.getElementById('multi_player').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && (idname == 2356 || idname == 2359 || idname == 2361)){ // 通常ランキング (ボスバトル)
		document.getElementById('boss_score').style.display = 'block';
		document.getElementById('multi_stage').style.display = 'block';
		document.getElementById('multi_player').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && idname >= 2349 && idname <= 2362) {			// 通常ランキング (サイドストーリー)
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('multi_stage').style.display = 'block';
		document.getElementById('multi_player').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && idname >=5017 && idname <=5077) {			// 無差別級＆TAS
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('unlimited').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	} else if ( idname != "" && idname >=10205 && idname <=10206) {			// チャレンジ複合
		document.getElementById('story_mode').style.display = 'block';
		document.getElementById('story_result').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
		var element = document.getElementsByClassName("c0");
		for (var i=0;i<element.length;i++) {
		element[i].style.display = "block";
		}
	} else if ( idname != "" && idname >=10207 && idname <=10212) {			// チャレンジ複合
		var ts = idname - 10206;
		var sid= 'c'+ts;
		document.getElementById('story_mode').style.display = 'block';
		document.getElementById('story_result').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
		var element = document.getElementsByClassName(sid);
		for (var i=0;i<element.length;i++) {
		element[i].style.display = "block";
		}

	} else if ( idname != "" && idname >=10000 && idname <=99999) {			// 本編
		document.getElementById('story_mode').style.display = 'block';
		document.getElementById('story_result').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';


   // 登録区分を変更した場合の挙動
   } else if( idname == "limited") {
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('limited_stage').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';

	} else if(idname == "new") {
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('new_stage').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';

	} else if(idname == "unlimited") {
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('unlimited').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';

	} else if(idname == "story") {
		document.getElementById('story_mode').style.display = 'block';
		document.getElementById('story_result').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';

	} else if(idname == "storycave") {
		document.getElementById('storycave').style.display = 'block';
		document.getElementById('story_caves').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';

	} else if(idname == "configure") {
		document.getElementById('conf').style.display = 'block';

	} else if( idname == "record_delete"){
		document.getElementById('conf_value_box').style.display = 'block';
		document.getElementById('conf').style.display = 'block';

	} else if( idname == "profile_post"){
		document.getElementById('conf_prof_box').style.display = 'block';
		document.getElementById('conf').style.display = 'block';

	} else if( idname == "nopost_login"){
		document.getElementById('conf_login_box').style.display = 'block';
		document.getElementById('conf').style.display = 'block';

	} else if( idname == "record_update"){
		document.getElementById('conf_value_box').style.display = 'block';
		document.getElementById('conf_update_box').style.display = 'block';
		document.getElementById('conf').style.display = 'block';

	} else if( idname == "limited_post"){
		document.getElementById('conf_text_box').style.display = 'block';
		document.getElementById('conf').style.display = 'block';

	} else if(idname == "multi") {
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('multi_stage').style.display = 'block';
		document.getElementById('multi_player').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';

	} else if(idname == "battle") {
		document.getElementById('non-conf').style.display = 'block';
		document.getElementById('battle_mode').style.display = 'block';
		document.getElementById('multi_player').style.display = 'block';

	} else if( idname == "default"){
		document.getElementById('conf_value_box').style.display = 'block';
		document.getElementById('conf').style.display = 'block';

	} else {
		document.getElementById('normal_score').style.display = 'block';
		document.getElementById('normal_stage').style.display = 'block';
		document.getElementById('non-conf').style.display = 'block';
	}
   if( idname != "" && idname == 299) {
		document.getElementById('specials').style.display = 'block';
	} else {
		document.getElementById('non-specials').style.display = 'block';
	}
}
// 各種通知を非表示にするjQuery
function notification_out() {
	document.getElementById('post_notification').style.display = 'none';
}
function notification_out2() {
	document.getElementById('post_notification2').style.display = 'none';
}

// 通知領域を自動的に消す
$(function(){
	setTimeout(function(){
		$('.post_notification').slideUp("slow");
	},99999);
});

// ツールチップを表示するjQuery
$(function() {
	$('.rtd_tooltip').tooltip({
		position:{
			my: 'left top',
			at:'left bottom+5px',
			collision: 'none'
		},
		show:{
			effect: 'drop',
			direction:'up',
			delay: '0',
			duration: '0'
		},
		hide:false
	});
});
// IDを表示
function id_tooltip( unique_id ){
	var id = "id-"+unique_id;
	var popup = document.getElementById(id); // メッセージを表示するボックスを指定
	popup.innerHTML = '<p><i class="fa fa-tag rtd_tooltip"></i>投稿ID：'+unique_id+'</p>';
}
// 本編フォームで増やした数の合計を表示
function totalsum2(){
	var red    = eval(document.form1.storyc_red.value);
	var blue   = eval(document.form1.storyc_blue.value);
	var yellow = eval(document.form1.storyc_yellow.value);
	var purple = eval(document.form1.storyc_purple.value);
	var white  = eval(document.form1.storyc_white.value);
	if(!isFinite(red))    red    =0;
	if(!isFinite(blue))   blue   =0;
	if(!isFinite(yellow)) yellow =0;
	if(!isFinite(purple)) purple =0;
	if(!isFinite(white))  white  =0;
	var total = red+blue+yellow+purple+white;
	var elem = document.getElementById("total_pikminc");
	elem.innerHTML = total;
}

// 本編フォームで増やした数の合計を表示
function totalsum(){
	var red    = eval(document.form1.story_red.value);
	var blue   = eval(document.form1.story_blue.value);
	var yellow = eval(document.form1.story_yellow.value);
	var purple = eval(document.form1.story_purple.value);
	var white  = eval(document.form1.story_white.value);
	var rock   = eval(document.form1.story_rock.value);
	var winged = eval(document.form1.story_winged.value);
	if(!isFinite(red))    red    =0;
	if(!isFinite(blue))   blue   =0;
	if(!isFinite(yellow)) yellow =0;
	if(!isFinite(purple)) purple =0;
	if(!isFinite(white))  white  =0;
	if(!isFinite(rock))   rock   =0;
	if(!isFinite(winged)) winged =0;
	var total = red+blue+yellow+purple+white+rock+winged;
	var elem = document.getElementById("total_pikmin");
	elem.innerHTML = total;
}

// 本編フォームで暫定スコアを計算
function simscore(){
	// ピクミン数
	var stage  = eval(document.form1.cave_stage_id.value);
	var red    = eval(document.form1.storyc_red.value);
	var blue   = eval(document.form1.storyc_blue.value);
	var yellow = eval(document.form1.storyc_yellow.value);
	var purple = eval(document.form1.storyc_purple.value);
	var white  = eval(document.form1.storyc_white.value);
	var koppa  = eval(document.form1.storyc_koppa.value);
	var popoga  = eval(document.form1.storyc_popoga.value);
	var death  = eval(document.form1.storyc_death.value);
	if(!isFinite(red))    red    =0;
	if(!isFinite(blue))   blue   =0;
	if(!isFinite(yellow)) yellow =0;
	if(!isFinite(purple)) purple =0;
	if(!isFinite(white))  white  =0;
	if(!isFinite(koppa))  koppa  =0;
	if(!isFinite(popoga))  popoga=0;
	if(!isFinite(death))  death  =0;
	var total = (red+blue+yellow+purple+white+koppa+(popoga*8))-death;

	// お宝合計価値
	var poko    = eval(document.form1.story_cavepoko.value);

	// 残時間を計算
	var hour    = eval(document.form1.story_cavehour.value);
	var min     = eval(document.form1.story_cavemin.value);
	var sec     = eval(document.form1.story_cavesec.value);
	if(!isFinite(hour))hour=0;
	if(!isFinite(min)) min =0;
	if(!isFinite(sec)) sec =0;
	var nowtime = sec+(min*60)+(hour*60*60);
	var alltime = 0;
        $.ajax({
            type: "POST",
            url: "pik4_cavesdata.php",
            data: {
		"db": 'stage_title',
		"stage_id": stage,
		"type": 'Time'
            },
            success: function(data){
		var lasttime = Math.floor( (data - nowtime) / 2);

		// スコアを計算
		var simscore = (poko*10) + (total*10) + lasttime;

		// 指定要素に表示
		var elem = document.getElementById("sim_score");
		elem.innerHTML = simscore;
	    },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
                elem.innerHTML = "errorThrown : " + errorThrown.message;
	    }
	});
}
// 本編ランキングで各種情報をAjax経由で単純表示する関数
// 2017/01/22 参照DB名を追加
// stageid=ステージID、columntitle=問い合わせするカラム名、divid=返り値を表示する要素名
function echostage(database , stageid, columntitle, divid){
	db = database;
	stage = stageid;
	type = columntitle;
        $.ajax({
            type: "POST",
            url: "pik4_cavesdata.php",
            data: {
		"db": db,
		"stage_id": stage,
		"type": type
            },
            success: function(data){
		if(columntitle == "Time"){
			var htale = '';
			var mtale = '';
			var timestring  = '';
			var hur = data / 3600 | 0;
			var min = data % 3600 / 60 | 0;
			var sec = data % 60;
			if(data > 3600) var htale = zeroPadding(hur,2)+'時間 ';
			if(data > 60) var mtale = zeroPadding(min,2)+'分 ';
			timestring = htale+mtale+zeroPadding(sec,2)+'秒';
			var elem = document.getElementById(divid);
			elem.innerHTML = timestring;
		} else {
			var elem = document.getElementById(divid);
			elem.innerHTML = data;
		}
	    },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
		var elem = document.getElementById(divid);
		elem.innerHTML = errorThrown.message;
	    }
	});
}
// JavaScript内でゼロ埋めする関数 参考 http://shanabrian.com/web/javascript/zero-padding.php
var zeroPadding = function(number, digit) {
    var numberLength = String(number).length;
    if (digit > numberLength) {
        return (new Array((digit - numberLength) + 1).join(0)) + number;
    } else {
        return number;
    }
};
// リトライカウンター
/*
function retry_count_ope(stageid, flag) {
if( stageid > 100 && stageid < 99999){
	var elem = document.getElementById("retry_count"); // メッセージを表示するボックスを指定
	elem.innerHTML = "";

	// 日付フォーマット 参考： http://qiita.com/osakanafish/items/c64fe8a34e7221e811d0
	var formatDate = function (date, format) {
	  if (!format) format = 'YYYY-MM-DD hh:mm:ss.SSS';
	  format = format.replace(/YYYY/g, date.getFullYear());
	  format = format.replace(/MM/g, ('0' + (date.getMonth() + 1)).slice(-2));
	  format = format.replace(/DD/g, ('0' + date.getDate()).slice(-2));
	  format = format.replace(/hh/g, ('0' + date.getHours()).slice(-2));
	  format = format.replace(/mm/g, ('0' + date.getMinutes()).slice(-2));
	  format = format.replace(/ss/g, ('0' + date.getSeconds()).slice(-2));
	  if (format.match(/S/g)) {
	    var milliSeconds = ('00' + date.getMilliseconds()).slice(-3);
	    var length = format.match(/S/g).length;
	    for (var i = 0; i < length; i++) format = format.replace(/S/, milliSeconds.substring(i, i + 1));
	  }
	  return format;
	};

	var count = document.forms.retry_form.retry_count.value;
	if(flag != 1 || !count || count < 0){
		count = 1;
	}
	if(flag == 0){
		count = 0;
	}
	var nowdate = formatDate(new Date());
        $.ajax({
            type: "POST",
	    dataType:'json',
            url: "pik4_counter.php",
            data: {
		"date": nowdate,
		"flag": flag,
		"stage": stageid,
		"count": count
            },
            success: function(data){
		if(data != "データ取得エラー (422)"){
			elem.innerHTML += data;
			document.forms.retry_form.retry_count.value = 1;
		} else {
		elem.innerHTML += data;
		}
	    },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
//            $("#XMLHttpRequest").html("XMLHttpRequest : " + XMLHttpRequest.status);
//            $("#textStatus").html("textStatus : " + textStatus);
//            alert("errorThrown : " + errorThrown.message);
		elem.innerHTML += "データ取得エラー (432)"+errorThrown;
	    }
	});
}
}
*/
// タマゴムシくじJS版
function egg_fortune_ope() {
	var msg = new Array(); // メッセージの初期値
	var EggCount = 8; // タマゴの初期個数
	var minites_total = 0; // 倒したタマゴムシの合計数初期値
	var elem = document.getElementById("egg_fortune"); // メッセージを表示するボックスを指定
	elem.innerHTML = 'タマゴを割っています...';
	setTimeout(function(){
	elem.innerHTML = '';
	elem.innerHTML += '<A href="javascript:void(0)" id="egg_fortune_start" onclick="egg_fortune_ope()">タマゴを割る</A><br/>';
	var ninthegg = Math.floor( Math.random() * ((8 + 1) - 1) + 1); // 15%で8つ目のタマゴが出現
	if( ninthegg == 8){
		EggCount = EggCount + 1;
	}
	for(var i=1; i<= EggCount ; i++){
	msg[i] = "";
		var EggFortune = Math.floor( Math.random() * ((20 + 1) - 1) + 1); // タマゴの中身を決定

		if( EggFortune >  0  && EggFortune < 11) msg[i] = "大地のエキスが出現！<br/>";
		if( EggFortune >  10 && EggFortune < 18) msg[i] = "大地のエキスが2つ出現！<br/>";
		if( EggFortune == 18)			 msg[i] = "ゲキカラエキスが出現！<br/>";
		if( EggFortune == 19)			 msg[i] = "ゲキニガエキスが出現！<br/>";
		if( EggFortune == 20){
			var minites_count = 0;
			var eggs_success = Math.floor( Math.random() * ((1000 + 1) - 1) + 1); // タマゴの中身を決定
			if( eggs_success >= 1   && eggs_success <= 10  ) minites_count =  1;
			if( eggs_success >= 11  && eggs_success <= 34  ) minites_count =  2;
			if( eggs_success >= 35  && eggs_success <= 84  ) minites_count =  3;
			if( eggs_success >= 85  && eggs_success <= 234 ) minites_count =  4;
			if( eggs_success >= 235 && eggs_success <= 784 ) minites_count =  5;
			if( eggs_success >= 785 && eggs_success <= 934 ) minites_count =  6;
			if( eggs_success >= 935 && eggs_success <= 984 ) minites_count =  7;
			if( eggs_success >= 985 && eggs_success <= 994 ) minites_count =  8;
			if( eggs_success >= 995 && eggs_success <= 999 ) minites_count =  9;
			if( eggs_success == 1000 		       ) minites_count = 10;
			msg[i] = "<b>タマゴムシが出現！ ("+minites_count+"匹倒した)</b><br/>";
			minites_total += minites_count;
		}
	}

	// 日付フォーマット 参考： http://qiita.com/osakanafish/items/c64fe8a34e7221e811d0
	var formatDate = function (date, format) {
	  if (!format) format = 'YYYY-MM-DD hh:mm:ss.SSS';
	  format = format.replace(/YYYY/g, date.getFullYear());
	  format = format.replace(/MM/g, ('0' + (date.getMonth() + 1)).slice(-2));
	  format = format.replace(/DD/g, ('0' + date.getDate()).slice(-2));
	  format = format.replace(/hh/g, ('0' + date.getHours()).slice(-2));
	  format = format.replace(/mm/g, ('0' + date.getMinutes()).slice(-2));
	  format = format.replace(/ss/g, ('0' + date.getSeconds()).slice(-2));
	  if (format.match(/S/g)) {
	    var milliSeconds = ('00' + date.getMilliseconds()).slice(-3);
	    var length = format.match(/S/g).length;
	    for (var i = 0; i < length; i++) format = format.replace(/S/, milliSeconds.substring(i, i + 1));
	  }
	  return format;
	};

	var nowdate = formatDate(new Date());
        $.ajax({
            type: "POST",
            url: "pik4_minites.php",
            data: {
                "minites_count": minites_total,
		"date": nowdate,
		"egg": EggCount
            },
            success: function(data){
		if(data != "タマゴムシポイントが足りません！"){

			for (i = 1; i<= EggCount ; i++){
				elem.innerHTML += msg[i];
			}
			elem.innerHTML += "<b>合計："+minites_total+"匹</b><br/>";
			elem.innerHTML += data;
			elem.innerHTML += "（"+nowdate+"）";
		} else {
		elem.innerHTML += data;
		}
	    },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
//            $("#XMLHttpRequest").html("XMLHttpRequest : " + XMLHttpRequest.status);
//            $("#textStatus").html("textStatus : " + textStatus);
//            alert("errorThrown : " + errorThrown.message);
	    }
	});
	},1000);
}

//フォームロック関数
function formlock(){
	var lock_toggle = getCookie("formlock");
	var icon_toggle = document.getElementById("formlock_div");
	if(lock_toggle == 0){
		lock_toggle = 1;
		icon_toggle.innerHTML = '<a href="#" class="marklink" style="color:#ffffff;" onclick="formlock();"><i class="fa fa-lock"></i>フォームロック中</a>';
	} else {
		lock_toggle = 0;
		icon_toggle.innerHTML = '<a href="#" class="marklink" style="color:#ffffff;" onclick="formlock();"><i class="fa fa-unlock"></i>フォームロック解除中</a>';
	}
	document.cookie = "formlock="+lock_toggle+";max-age=2592000";
}
//ナビゲーションロック関数
function navlock(){
	var lock_toggle = getCookie("navlock");
	var icon_toggle = document.getElementById("navlock_div");
	if(lock_toggle == 0){
		lock_toggle = 1;
		icon_toggle.innerHTML = '<a href="#" class="marklink" style="color:#ffffff;" onclick="navlock();"><i class="fa fa-lock"></i>ナビゲーションロック中</a>';
	} else {
		lock_toggle = 0;
		icon_toggle.innerHTML = '<a href="#" class="marklink" style="color:#ffffff;" onclick="navlock();"><i class="fa fa-unlock"></i>ナビゲーションロック解除中</a>';
	}
	document.cookie = "navlock="+lock_toggle+";max-age=2592000";
}
//観戦モード切り替え関数
function watchmode(){
	var lock_toggle = getCookie("watchmode");
	var icon_toggle = document.getElementById("watchmode_div");
	if(lock_toggle == 0){
		lock_toggle = 1;
		icon_toggle.innerHTML = '<a href="#" class="marklink" style="color:#ffffff;" onclick="watchmode();"><i class="fa fa-lock"></i>観戦モードON</a>';
	} else {
		lock_toggle = 0;
		icon_toggle.innerHTML = '<a href="#" class="marklink" style="color:#ffffff;" onclick="watchmode();"><i class="fa fa-unlock"></i>観戦モードOFF</a>';
	}
	document.cookie = "watchmode="+lock_toggle+";max-age=2592000";
}
//クッキーを取得
    function getCookie(c_name){
        var st="";
        var ed="";
        if (document.cookie.length>0){
            st=document.cookie.indexOf(c_name + "=");
            if (st!=-1){
                st=st+c_name.length+1;
                ed=document.cookie.indexOf(";",st);
                if (ed==-1) ed=document.cookie.length;
                return unescape(document.cookie.substring(st,ed));
            }
        }
        return "";
}

//フォーム全体の表示切り替え用jQuery 参考：http://memocarilog.info/jquery/7551
$(function(){
var menu = $('#org_form'), // スライドインするメニューを指定
    menuBtn = $('.form_toggle'), // メニューボタンを指定
    mainBtn = $('#main_toggle'), // 本編-チャレンジ切り替えリンク
    body = $(document.body),
    menuWidth = menu.outerWidth(),
    lock_toggle = getCookie("formlock");

    if(body.hasClass('pre-open')){
        // 固定フラグが立っている場合、デフォルトでオープンする
        body.animate({'marginLeft' : menuWidth }, 0, "easeInQuint");
        menu.animate({'left' : 0 }, 0, "easeInQuint");
	body.toggleClass('open');
    }
    if(body.hasClass('pre-open') && body.hasClass('pre-open2')){
        // 固定フラグが立っている場合、デフォルトでオープンする
        body.animate({'marginLeft' : menuWidth }, 0, "easeInQuint");
        menu.animate({'left' : 0 }, 0, "easeInQuint");
	body.toggleClass('open2');
    }

    // 本編スコアを投稿する場合、メニュー枠を広げる
	$('select[name="ranking_type"]').change(function() {
	var ranktype = $('select[name="ranking_type"] option:selected').attr("value");
	var wid = $(window).width();
	var spw = 640;
		if( spw <= wid ){
			if(ranktype == "story" || ranktype == "storycave" || ranktype == "configure"){
			// 300px → 600px へスライドイン
				body.animate({'marginLeft' : "600px" }, 300, "easeInQuint");
				menu.animate({'left' : 0, width: "600px" }, 300, "easeInQuint");
				body.addClass('open2');
				body.addClass('pre-open2');
			} else {
			// 600px → 300px へスライドアウト
				menu.animate({width : "300px"  }, 300, "easeOutQuint");
				body.animate({'marginLeft' : "300px" }, 300, "easeOutQuint");
				body.addClass('open');
				body.removeClass('open2');
				body.removeClass('pre-open2');
			}
		}
	});

    // メニューボタンをクリックした時の動き
    menuBtn.on('click', function(){
    // body に open クラスを付与する
        body.toggleClass('open');

        if((body.hasClass('pre-open2') && body.hasClass('open')) || body.hasClass('pre-open3')){
            // 0px → 600px へスライドイン
            body.animate({'marginLeft' : "600px" }, 300, "easeInQuint");
            menu.animate({'left' : 0, width: "600px" }, 300, "easeInQuint");
	    body.toggleClass('open2');

        } else if(body.hasClass('open') && !body.hasClass('open2')){
            // 0px → 300px へスライドイン
            body.animate({'marginLeft' : "300px"}, 300, "easeInQuint");
            menu.animate({'left' : 0, width: "300px" }, 300, "easeInQuint");

	} else if(body.hasClass('open2') || body.hasClass('pre-open2')) {
            // 600px → 0px へスライドイン
            menu.animate({'left' : "-600px", width: "600px" }, 300, "easeOutQuint");
            body.animate({'marginLeft' : "0px" }, 300, "easeOutQuint");
	    body.toggleClass('open2');
	    body.addClass('pre-open2');

        } else {
            // 300px → 0px へスライドイン
            menu.animate({'left' : "-300px", width: "300px" }, 300, "easeOutQuint");
            body.animate({'marginLeft' : 0 }, 300, "easeOutQuint");
        }
    });
});

// フォームが開いているときにWidth640以下になったら強制的にフォームを閉じる
var spformtoggle = function(){
	var wid2 = $(window).width();
	var spw2 = 640;
		if( wid2 <= spw2){
		document.body.style.marginLeft = "0px";
		} else if($(document.body).hasClass('open2')) {
		document.body.style.marginLeft = "600px";
		} else if($(document.body).hasClass('open')) {
		document.body.style.marginLeft = "300px";
		} else {
		document.body.style.marginLeft = "0px";
		}
	};

$(function(){
	spformtoggle();
	$(window).resize(spformtoggle);
});

// プルダウンページ遷移用jQuery 参考：http://php.o0o0.jp/article/jquery-pulldown_location
$(function () {
  // プルダウン変更時に遷移
  $('select[name=pulldown1]').change(function() {
    if ($(this).val() != '') {
      window.location.href = $(this).val();
    }
  });
  // ボタンを押下時に遷移
  $('#location').click(function() {
    if ($(this).val() != '') {
      window.location.href = $('select[name=pulldown2]').val();
    }
  });
});

// プルダウンページ遷移 (スコア比較用)
function FormSubmit() {
	var myform = document.forms.form2;
	var compare_utf8 = document.forms.form2.compare_data.value;
	var compare_value = encodeURIComponent(compare_utf8);
	document.cookie = "compare_data="+compare_value+";";
	myform.method = "POST";
	myform.action = "#";
//	myform.submit();
	location.reload();
	return;
}
function FormSubmit2() {
	var myform = document.forms.form3;
	var compare_utf8 = document.forms.form3.sort_data.value;
	var compare_value = encodeURIComponent(compare_utf8);
	document.cookie = "sort_data="+compare_value+";";
	myform.method = "POST";
	myform.action = "#";
//	myform.submit();
	location.reload();
	return;
}
function FormSubmit3() {
	var myform = document.forms.form4;
	var compare_utf8 = document.forms.form4.filtering_data.value;
	var compare_value = encodeURIComponent(compare_utf8);
	document.cookie = "filtering_data="+compare_value+";";
	myform.method = "POST";
	myform.action = "#";
//	myform.submit();
	location.reload();
	return;
}
function FormSubmit4() {
	var myform = document.forms.form5;
	var compare_utf8 = document.forms.form5.filtering_sub_data.value;
	var compare_value = encodeURIComponent(compare_utf8);
	document.cookie = "filtering_sub_data="+compare_value+";";
	myform.method = "POST";
	myform.action = "#";
//	myform.submit();
	location.reload();
	return;
}
function FormSubmit5() {
	var myform = document.forms.form6;
	var compare_utf8 = document.forms.form6.pin_data.value;
	var compare_value = encodeURIComponent(compare_utf8);
	document.cookie = "pin_data="+compare_value+";";
	myform.method = "POST";
	myform.action = "#";
//	myform.submit();
	location.reload();
	return;
}
function FormSubmit6() {
	var myform = document.forms.form7;
	var compare_utf8 = document.forms.form7.season_data.value;
	var compare_value = encodeURIComponent(compare_utf8);
	document.cookie = "season_data="+compare_value+";";
	myform.method = "POST";
	myform.action = "#";
//	myform.submit();
	location.reload();
	return;
}
function FormSubmit8() {
	var myform = document.forms.form8;
	var compare_utf8 = document.forms.form8.filtering_log_data.value;
	var compare_value = encodeURIComponent(compare_utf8);
	document.cookie = "log_data="+compare_value+";";
	myform.method = "POST";
	myform.action = "#";
//	myform.submit();
	location.reload();
	return;
}
// スコア履歴表示
function ScoreHistory(stageid, username){
	var date1,date2;
	date1 = new Date();
	date1.setTime(date1.getTime() + 1*1000);
	date2 = date1.toGMTString();
	document.cookie = "history_id="+stageid+";expires="+date2;
	document.cookie = "user_id="+username+";expires="+date2;
	location.reload();
	return;
}
// トップページのHeight値制御
$(document).ready(function () {
	  hsize = $(window).height();
	  wsize = $(window).width();
	  hsize = (hsize/2)-180;
	  if(wsize > 640){
	  $("#top_page_div").css("margin-top", hsize + "px");
	} else {
	  $("#top_page_div").css("margin-top", "40px");
	  $("#top_page_div").css("margin-bottom", "40px");
	}
});
$(window).resize(function () {
	  hsize = $(window).height();
	  wsize = $(window).width();
	  hsize = (hsize/2)-180;
	  if(wsize > 640){
	  $("#top_page_div").css("margin-top", hsize + "px");
	} else {
	  $("#top_page_div").css("margin-top", "40px");
	  $("#top_page_div").css("margin-bottom", "40px");
	}
});
// 背景動画のHeight値制御
$(document).ready(function () {
	  hsize = $(window).height(); // ウィンドウの縦幅
	  wsize = $(window).width(); // ウィンドウの横幅
	  if( wsize < 640){ // スマホ表示対策
	  hasfix= wsize / 16 * 9; // ウィンドウの横幅から計算した縦幅
	  $("#video").css("width", wsize + "px");
	  $("#video").css("height", hasfix + "px");
	} else {
	  hasfix= wsize / 16 * 9; // ウィンドウの横幅から計算した縦幅
	  wasfix= hsize / 9 * 16; // ウィンドウの横幅から計算した横幅
	  if( hsize < hasfix) hsize = hasfix;
	  if( wsize < wasfix) wsize = wasfix; // 大きい値を採用する
	  $("#video").css("height", hsize + "px");
	  $("#video").css("width", wsize + "px");
	}
});
$(window).resize(function () {
	  hsize = $(window).height(); // ウィンドウの縦幅
	  wsize = $(window).width(); // ウィンドウの横幅
	  if( wsize < 640){ // スマホ表示対策
	  hasfix= wsize / 16 * 9; // ウィンドウの横幅から計算した縦幅
	  $("#video").css("width", wsize + "px");
	  $("#video").css("height", hasfix + "px");
	} else {
	  hasfix= wsize / 16 * 9; // ウィンドウの横幅から計算した縦幅
	  wasfix= hsize / 9 * 16; // ウィンドウの横幅から計算した横幅
	  if( hsize < hasfix) hsize = hasfix;
	  if( wsize < wasfix) wsize = wasfix; // 大きい値を採用する
	  $("#video").css("height", hsize + "px");
	  $("#video").css("width", wsize + "px");
	}
});
// 日替わりチャレンジシミュレーター本体
function sumtotal(){
	var sum_price = 0;
		$('.object:checkbox').each(function(){
			if($(this).prop('checked')){
				var point = $(this).val();
				sum_price = parseInt(point)+sum_price;
			}
		});
	document.myform.total_price.value = sum_price + " poko";
	get_diffprice();
}
// 日替わりチャレンジシミュレーター 参考：http://bunjin.com/java/calc.html
$(document).ready(function() {
	$('.object:checkbox').click(function(){
	var sum_price = 0;
		$('.object:checkbox').each(function(){
			if($(this).prop('checked')){
				var point = $(this).val();
				sum_price = parseInt(point)+sum_price;
			}
		});
	document.myform.total_price.value = sum_price + " poko";
	get_diffprice();
	});
});

// 日替わりチャレンジシミュレーターの合計ポコを取得
function get_diffprice(){
	var elem = document.getElementById("diff_price");
	var a = parseInt(document.forms.myform.total_price.value);
	var b = parseInt(document.forms.myform.max_price.value);
	var c = a-b;
	if(!isNaN(c)){
		if(c == 0){
		elem.innerHTML = "<b>OK!</b>";
		} else {
		elem.innerHTML = c;
		}
	} else {
		elem.innerHTML = b;
	}
}
// チェックボックスの一括チェックトグル
$(function() {
  $('#category_all').on('click', function() {
    $('.object').prop('checked', this.checked);
    sumtotal();
  });

  $('.object').on('click', function() {
    if ($('#categories :checked').length == $('#categories :input').length){
      $('#category_all').prop('checked', 'checked');
    }else{
      $('#category_all').prop('checked', false);
    }
  });
});

// フルスクリーン動画のOn/Off
function VideoToggle() {
	var toggle = getCookie("video_toggle");
	if(toggle != 1){
		toggle = 1;
		document.cookie = "video_toggle="+toggle+";";
	} else {
		toggle = 0;
		document.cookie = "video_toggle="+toggle+";";
	}
	location.reload();
}
// JavaScript内で配列をシャッフルする関数 (参考孫引き：https://h2ham.net/javascript-%E3%81%A7%E9%85%8D%E5%88%97%E3%81%AE%E3%82%B7%E3%83%A3%E3%83%83%E3%83%95%E3%83%AB
function shuffle(array) {
  var n = array.length, t, i;

  while (n) {
    i = Math.floor(Math.random() * n--);
    t = array[n];
    array[n] = array[i];
    array[i] = t;
  }

  return array;
}
// フルスクリーン動画の連続再生 (参考1：https://teratail.com/questions/34499 参考2：http://chicketen.blog.jp/archives/6539298.html)
$(function () {
	var video = document.getElementById("video");
	var info = document.getElementById("video_info");
	if(video != null && info != null){
	var videolist = new Array(
		"https://chr.mn/_mov/pik4/movie101.mp4",
		"https://chr.mn/_mov/pik4/movie103.mp4",
		"https://chr.mn/_mov/pik4/movie201.mp4",
		"https://chr.mn/_mov/pik4/movie202.mp4",
		"https://chr.mn/_mov/pik4/movie203.mp4",
		"https://chr.mn/_mov/pik4/movie204.mp4",
		"https://chr.mn/_mov/pik4/movie206.mp4",
		"https://chr.mn/_mov/pik4/movie207.mp4",
		"https://chr.mn/_mov/pik4/movie208.mp4",
		"https://chr.mn/_mov/pik4/movie209.mp4",
		"https://chr.mn/_mov/pik4/movie210.mp4",
		"https://chr.mn/_mov/pik4/movie211.mp4",
		"https://chr.mn/_mov/pik4/movie212.mp4",
		"https://chr.mn/_mov/pik4/movie213.mp4",
		"https://chr.mn/_mov/pik4/movie214.mp4",
		"https://chr.mn/_mov/pik4/movie215.mp4",
		"https://chr.mn/_mov/pik4/movie216.mp4",
		"https://chr.mn/_mov/pik4/movie217.mp4",
		"https://chr.mn/_mov/pik4/movie218.mp4",
		"https://chr.mn/_mov/pik4/movie219.mp4",
		"https://chr.mn/_mov/pik4/movie220.mp4",
		"https://chr.mn/_mov/pik4/movie221.mp4",
		"https://chr.mn/_mov/pik4/movie222.mp4",
		"https://chr.mn/_mov/pik4/movie223.mp4",
		"https://chr.mn/_mov/pik4/movie224.mp4",
		"https://chr.mn/_mov/pik4/movie225.mp4",
		"https://chr.mn/_mov/pik4/movie226.mp4",
		"https://chr.mn/_mov/pik4/movie227.mp4",
		"https://chr.mn/_mov/pik4/movie228.mp4",
		"https://chr.mn/_mov/pik4/movie229.mp4",
		"https://chr.mn/_mov/pik4/movie230.mp4",
		"https://chr.mn/_mov/pik4/movie301.mp4",
		"https://chr.mn/_mov/pik4/movie302.mp4",
		"https://chr.mn/_mov/pik4/movie303.mp4",
		"https://chr.mn/_mov/pik4/movie304.mp4",
		"https://chr.mn/_mov/pik4/movie305.mp4",
		"https://chr.mn/_mov/pik4/movie306.mp4",
		"https://chr.mn/_mov/pik4/movie307.mp4",
		"https://chr.mn/_mov/pik4/movie308.mp4",
		"https://chr.mn/_mov/pik4/movie309.mp4",
		"https://chr.mn/_mov/pik4/movie310.mp4",
		"https://chr.mn/_mov/pik4/movie311.mp4",
		"https://chr.mn/_mov/pik4/movie312.mp4",
		"https://chr.mn/_mov/pik4/movie313.mp4",
		"https://chr.mn/_mov/pik4/movie314.mp4",
		"https://chr.mn/_mov/pik4/movie315.mp4",
		"https://chr.mn/_mov/pik4/movie316.mp4",
		"https://chr.mn/_mov/pik4/movie317.mp4",
		"https://chr.mn/_mov/pik4/movie318.mp4",
		"https://chr.mn/_mov/pik4/movie319.mp4",
		"https://chr.mn/_mov/pik4/movie320.mp4",
		"https://chr.mn/_mov/pik4/movie321.mp4",
		"https://chr.mn/_mov/pik4/movie322.mp4",
		"https://chr.mn/_mov/pik4/movie323.mp4",
		"https://chr.mn/_mov/pik4/movie324.mp4",
		"https://chr.mn/_mov/pik4/movie325.mp4",
		"https://chr.mn/_mov/pik4/movie326.mp4",
		"https://chr.mn/_mov/pik4/movie327.mp4",
		"https://chr.mn/_mov/pik4/movie328.mp4",
		"https://chr.mn/_mov/pik4/movie329.mp4",
		"https://chr.mn/_mov/pik4/movie330.mp4",
		"https://chr.mn/_mov/pik4/movie331.mp4",
		"https://chr.mn/_mov/pik4/movie332.mp4",
		"https://chr.mn/_mov/pik4/movie333.mp4",
		"https://chr.mn/_mov/pik4/movie334.mp4",
		"https://chr.mn/_mov/pik4/movie335.mp4",
		"https://chr.mn/_mov/pik4/movie336.mp4");

	var videotitle = new Array(
		'ピクミン チャレンジモード</span><br/><span class="video_title">遭難地点</span>',
		'ピクミン チャレンジモード</span><br/><span class="video_title">樹海のヘソ</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">こてしらべの洞窟</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">新参者の試練場</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">神々のおもちゃ箱</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">あのひとの庭</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">地下の温室</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">鉄人の穴</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">赤の洞窟</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">花園を荒らすもの</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">たそがれの庭</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">かくしもちの洞窟</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">コンクリート迷路</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">コレクタールーム</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">ショイグモの巣</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">大足の穴</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">食神のかまど</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">三色試練場</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">炎と水の試練場</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">鼻息の洞穴</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">巨人のトイレ</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">土とんの洞窟</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">地底警備室</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">ひみつの花園</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">さらいの洞窟</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">秘密兵器実験場</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">倍々ゲームの穴</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">天罰の穴</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">どっすん迷路</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">スナイパールーム</span>',
		'ピクミン2 チャレンジモード</span><br/><span class="video_title">デメマダラの巣窟</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">原生の杜</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">白銀の泉</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">渇きの砂</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">落葉の回廊</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">草花の園</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">原生の杜</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">白銀の泉</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">渇きの砂</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">落葉の回廊</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">草花の園</span>',
		'ピクミン3 ミッションモード 巨大生物をたおせ！</span><br/><span class="video_title">ヨロヒイモムカデ</span>',
		'ピクミン3 ミッションモード 巨大生物をたおせ！</span><br/><span class="video_title">オオバケカガミ</span>',
		'ピクミン3 ミッションモード 巨大生物をたおせ！</span><br/><span class="video_title">オオスナフラシ</span>',
		'ピクミン3 ミッションモード 巨大生物をたおせ！</span><br/><span class="video_title">タテゴトハチスズメ</span>',
		'ピクミン3 ミッションモード 巨大生物をたおせ！</span><br/><span class="video_title">ヌマアラシ</span>',
		'ピクミン3 ミッションモード 巨大生物をたおせ！</span><br/><span class="video_title">アメニュウドウ</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">続・原生の杜</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">続・白銀の泉</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">続・渇きの砂</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">続・落葉の回廊</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">続・草花の園</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">続・始まりの森</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">続・再開の花園</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">続・迷いの雪原</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">続・交わりの渓流</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">続・哀しき獣の塔</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">冬の贈りもの</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">工事現場ドリーム</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">ピクアリウム</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">思いでの砂浜</span>',
		'ピクミン3 ミッションモード お宝をあつめろ！</span><br/><span class="video_title">機械仕掛けのブルース</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">冬の贈りもの</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">工事現場ドリーム</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">ピクアリウム</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">思いでの砂浜</span>',
		'ピクミン3 ミッションモード 原生生物をたおせ！</span><br/><span class="video_title">機械仕掛けのブルース</span>');

	var videoposition = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66);
	shuffle(videoposition);
	var videonum = 0;
	var vcount = videolist.length;

	info.innerHTML = '<span class="video_subtitle">1 / ' + vcount + '<br/>' + videotitle[videoposition[videonum]];
	video.src = videolist[videoposition[videonum]];
	video.play();

		$("#video").on("ended", function() {

		if(videonum + 1 == vcount){
			videonum = 0;
		} else {
			videonum ++;
		}
		video.src = videolist[videoposition[videonum]];
		video.play();

		var nowvideo = videonum + 1;
		info.innerHTML = '<span class="video_subtitle">' + nowvideo + " / " + vcount + '<br/>' + videotitle[videoposition[videonum]];
		});
	}
});
// フルスクリーン動画のコントロール
function VideoPause() {
	var video = document.getElementById("video");
	var vcont = document.getElementById("video_control");
	if(video.paused){
		video.play();
		vcont.innerHTML = "一時停止";
	} else {
	video.pause();
		vcont.innerHTML = "再生";
	}
}
// ピックアップ動画をミュートする
function pickupvideo() {
	var pvideo = document.getElementById("pickup_video");
	pvideo.play();
	pvideo.mute();
}
// クッキーを消去
function CookieReset() {
	var mydate = new Date();
	mydate.setTime(0);
	document.cookie = "filtering_data=0;";
	document.cookie = "sort_data=0;";
	document.cookie = "filtering_sub_data=0;";
	document.cookie = "pin_data=0;";
	document.cookie = "season_data=0;";
	location.reload();
}
// 全期間-シーズンモードを切り替え
function SeasonToggle(cookie) {
	var toggle = getCookie(cookie);
	if(toggle != 2){
		toggle = 2;
		document.cookie = cookie+"="+toggle+";";
	} else {
		toggle = 0;
		document.cookie = cookie+"="+toggle+";";
	}
	location.reload();
}

// ヒストリーモード解除
function CookieReset2() {
	document.cookie = "history_id=;";
	document.cookie = "user_id=;";
	location.reload();
}

// 日替わりシミュレーターの切り替えボタン
function objectlist_toggle() {
	if(document.getElementById("object_list").style.display == "none"){
		document.getElementById("object_list").style.display = "block";
	}else{
		document.getElementById("object_list").style.display = "none";
	}
}
// 今日のオススメとあなたにオススメの切り替えボタン
function recommend_toggle() {
	if(document.getElementById("recommend_to_you").style.display == "none"){
		document.getElementById("recommend_to_you").style.display = "block";
		document.getElementById("today_recommend").style.display = "none";
	}else{
		document.getElementById("recommend_to_you").style.display = "none";
		document.getElementById("today_recommend").style.display = "block";
	}
}
// メニュー切り替え汎用 (2トグル)
function menu_toggle(defalut_block, other_block) {
	if(document.getElementById(other_block).style.display == "none"){
		document.getElementById(other_block).style.display = "block";
		document.getElementById(defalut_block).style.display = "none";
	}else{
		document.getElementById(other_block).style.display = "none";
		document.getElementById(defalut_block).style.display = "block";
	}
}
// メニュー切り替え汎用 (3トグル)
function menu_3toggle(defalut_block, other_block, third_block) {
	var a = document.getElementById(defalut_block);
	var b = document.getElementById(other_block);
	var c = document.getElementById(third_block);
	if(a.style.display == "block" && b.style.display == "none" && c.style.display == "none"){
		a.style.display = "none";
		b.style.display = "block";
		c.style.display = "none";
	}else if(a.style.display == "none" && b.style.display == "block" && c.style.display == "none"){
		a.style.display = "none";
		b.style.display = "none";
		c.style.display = "block";
	}else if(a.style.display == "none" && b.style.display == "none" && c.style.display == "block"){
		a.style.display = "block";
		b.style.display = "none";
		c.style.display = "none";
	}
}

// 期間限定ランキングのカウントダウン（大会開始→終了まで）
function CountdownTimer(elm,tl,mes){
 this.initialize.apply(this,arguments);
}
CountdownTimer.prototype={
 initialize:function(elm,tl,mes) {
  this.elem = document.getElementById(elm);
  this.tl = tl;
  this.mes = mes;
 },countDown:function(){
  var timer='';
  var today=new Date();
  var day=Math.floor((this.tl-today)/(24*60*60*1000));
  var hour=Math.floor(((this.tl-today)%(24*60*60*1000))/(60*60*1000));
  var min=Math.floor(((this.tl-today)%(24*60*60*1000))/(60*1000))%60;
  var sec=Math.floor(((this.tl-today)%(24*60*60*1000))/1000)%60%60;
  var milli=Math.floor(((this.tl-today)%(24*60*60*1000))/10)%100;
  var me=this;

  if( ( this.tl - today ) > 0 ){
   if (day) timer += '<span class="day">'+day+' Day</span> ';
   if (hour) timer += '<span class="hour">'+hour+':</span>';
   timer += '<span class="min">'+this.addZero(min)+'</span>:<span class="sec">'+this.addZero(sec)+'</span>';
// ミリ秒以下を表示する場合：<span class="milli">'+this.addZero(milli)+'</span>';
   this.elem.innerHTML = timer;
   tid = setTimeout( function(){me.countDown();},10 );
  }else{
   this.elem.innerHTML = this.mes;
   return;
  }
 },addZero:function(num){ return ('0'+num).slice(-2); }
}
function CDT(){
 var tl = new Date('2021/11/07 21:59:59');
 var timer = new CountdownTimer('CDT',tl,'(終了しました)');
 timer.countDown();
}

// 期間限定ランキングのカウントダウン（告知→大会開始まで）
function CDT2(){
 var tl = new Date('2021/11/05 22:00:00');
 var timer = new CountdownTimer('CDT2',tl,'(開幕しました)');
 timer.countDown();
}

// ピクミン3DXの発売カウントダウン
function CDT3(){
	var tl = new Date('2020/10/30 00:00:00');
	var timer = new CountdownTimer('CDT3',tl,'(発売しました)');
	timer.countDown();
}
// ブロック要素のスライド表示 参考：https://zxcvbnmnbvcxz.com/tips-jquery-slidein/
$(function(){
	$('#pickup_stage').slidein({
		intval: 1500,
		speed: 1000,
		vertical: 0,
		horizontal: 500,
		ease: 'easeInCubic',
		pointer: false,
		auto: true,
		reverse: false
	});
});
// エリア争奪戦専用ツールチップ 参考：http://iamceege.github.io/tooltipster/#demos
$(document).ready(function() {
	$('.tooltip').tooltipster(
		{
			theme: 'tooltipster-punk',
			animation: 'fade',
			animationDuration: 0,
			arrow: true,
			trigger: 'click',
			contentCloning: true,
			interactive: true
		}
	);
});
// テーブルをソート可能にする
$(document).ready(function()
{
	$("#sortable_table").tablesorter({
		sortMultiSortKey: 'shiftKey'
	});
});
// ページ内リンクにアニメーションを追加 参考：http://phiary.me/jquery-page-link-smooth-scroll/
$(function() {
  var offsetY = -10;
  var time = 500;
  $('a[href^=#]').click(function() {
    var target = $(this.hash);
    if (!target.length) return ;
    var targetY = target.offset().top+offsetY;
    $('html,body').animate({scrollTop: targetY}, time, 'swing');
    window.history.pushState(null, null, this.hash);
    return false;
  });
});

// Google Chromneでスコア入力欄に２バイト文字を入力させない 参考：https://qiita.com/ttake/items/072508219af6e32a263a
jQuery(document).ready(function() {
	
	// ime-modeが使えるか
	var supportIMEMode = ('ime-mode' in document.body.style);
	    
	// 非ASCII
	var noSbcRegex = /[^\x00-\x7E]+/g;
    
	// 1バイト文字専用フィールド
	    jQuery('.sbc_field')
	    .on('keydown blur paste', function(e) { 
		    
	    // ime-modeが使えるならスキップ
	    if (e.type == 'keydown' || e.type == 'blur')
		if (supportIMEMode) return;

	    // 2バイト文字が入力されたら削除
	    var target = jQuery(this);
	    if(!target.val().match(noSbcRegex)) return;
	    window.setTimeout( function() {
	      target.val( target.val().replace(noSbcRegex, '') );
	    }, 1);
	});	    
    }
);
// 送信ボタンの二重送信を防止する 参考：https://www.php-factory.net/trivia/18.php
$(function(){
	$('[type="submit"]').click(function(){
		$(this).prop('disabled',true);//ボタンを無効化する
		$(this).closest('form').submit();//フォームを送信する
	});
});
// 送信時警告ポップアップを表示する
function alertWindow(){
	var mes = '';
	if(lang == 'ja'){
		mes = '投稿すると最新の利用規約に同意したものと見なします。特に、ランキングへの不正記録の投稿（エミュレーター、改造ROM等を使ったスコアの偽装）は発覚次第厳重に処分します。不正をしていないとお約束していただける場合のみ「OK」を押して下さい。';
	} else {
		mes = 'By posting, you agree to the latest terms and conditions. In particular, posting fraudulent records to the ranking (impersonation of scores using emulators, modified ROMs, etc.) will be strictly disposed of as soon as they are discovered. Press "OK" only if you can promise that you are not cheating.';
	}
	if(window.confirm(mes)){ // 確認ダイアログを表示
		return true; // 「OK」時は送信を実行
	}else{ // 「キャンセル」時の処理
		return false; // 送信を中止
	}
}
// 添付ファイルのファイルサイズを取得 参考：https://memo.ark-under.net/memo/1558
// 3MB以上の場合はcompressor.jsで画像を圧縮する 参考：https://fengyuanchen.github.io/compressorjs/
$(function() {
        // inputタグから取得
        $('#pic_files').bind('change', function() {
            var imgSize1 = this.files[0].size; //ここでファイルサイズを取得
            var Mbyte = Math.round(imgSize1 / 1024 / 1024 * 1000) / 1000;
            var PrintMes = "現在のファイルサイズ：" + Mbyte + " MB";
            $('.filesize1').text(PrintMes);
            // 3MBを超えていたら送信ボタンを無効化
            if(imgSize1 > 3145728){
		PrintMes = "圧縮中...";
		$('.filesize1').text(PrintMes);
		// compressorを起動（２ファイル目は非対応）
		const img = new Compressor(this.files[0], {
			quality: 0.6,
			maxWidth: 1000,
			maxHeight: 1000,
			mimeType: 'image/jpeg',
			success(result) {
				var reader = new FileReader();
				reader.readAsDataURL(result);
				// ファイルサイズを再計算
				var fixedMbyte = Math.round(result.size / 1024 / 1024 * 1000) / 1000;
				PrintMes = Mbyte + " MBを" + fixedMbyte + "MBに圧縮しました。<br>アップロードします...";
				$('.filesize1').html(PrintMes);
				// 先行アップロード
				var formData = new FormData();
				formData.append("upFile", result, "test.jpg");
				$.ajax({
					url: "./pik4_picsupload.php",
					type: "POST",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "html"
				})
				.done(function(data, textStatus, xhr){
					if(data == "UPLOAD NG"){
						PrintMes = "エラー1505：ファイルのアップロードに失敗しました。ページを更新してください...";
						$('.filesize1').text(PrintMes);
						$('[type="submit"]').prop('disabled',true);
						$('#filesize_over').show();
					} else {
						// hiddenにファイルパスを渡す
						PrintMes = Mbyte + " MBを" + fixedMbyte + "MBに圧縮しました。<br>ファイルアップロードが完了しました。";
						$('.filesize1').html(PrintMes);
						$('#large_picfile').val(data);
						$('[type="file"]').prop('disabled',true);
						$('[type="submit"]').prop('disabled',false);
						$('#filesize_over').hide();
					}
				})
				.fail(function(data, textStatus, errorThrown){
					PrintMes = "エラー1519：ファイルのアップロードに失敗しました。ページを更新してください...";
					$('.filesize1').text(PrintMes);
				});
			},
			error(err) {
				PrintMes = "圧縮に失敗しました（" + Mbyte +"MB）";
				$('.filesize1').text(PrintMes);
				$('[type="submit"]').prop('disabled',true);
				$('#filesize_over').show();
			},
		});
                $('[type="submit"]').prop('disabled',true);
                $('#filesize_over').show();
            } else {
                $('[type="submit"]').prop('disabled',false);
                $('#filesize_over').hide();
            }
        });
});
// チーム対抗戦のチーム分けをAjaxで処理する
function teamselect(name, rate, min, max){
        $.ajax({
            type: "POST",
            url: "pik4_team.php",
            data: {
                "user_name": name,
                "rate": rate,
		"min": min,
		"max": max
            },
            success: function(data){
		// 指定要素に表示
		var elem = document.getElementById("teamoutput");
		elem.innerHTML = data;
        },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
//            alert("errorThrown : " + errorThrown.message);
	    }
	});
}
// ランダムステージチャレンジ
function teamselect(name){
        $.ajax({
            type: "POST",
            url: "pik4_random.php",
            data: {
                "user_name": name
            },
            success: function(data){
		// 指定要素に表示
		var elem = document.getElementById("randomoutput");
		elem.innerHTML = data;
        },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
//            alert("errorThrown : " + errorThrown.message);
	    }
	});
}
// 携帯表示時、サブメニューをクリックで表示トグル
$(function(){
	$("#mobile_fixed_key3").on("click", ".submenutoggle", function () {
		$("#g-nav").toggleClass('panelactive');
		$("#wrapper_filter").removeClass('hidden');
		var checkpost = $("#org_form").attr("class");
		if(checkpost == "panelactive"){
			$("#org_form").removeClass('panelactive');
		} else {
			$(".pik4_table").toggleClass('mainblur');
		}
	});
	$("#mobile_fixed_key2").on("click", ".submenutoggle", function () {
		$("#org_form").toggleClass('panelactive');
		$("#wrapper_filter").removeClass('hidden');
		var checknav = $("#g-nav").attr("class");
		if(checknav == "pik4_form panelactive"){
			$("#g-nav").removeClass('panelactive');
		} else {
			$(".pik4_table").toggleClass('mainblur');
		}
	});
	$(".blurhidden").click(function () {
		$("#org_form").removeClass('panelactive');
		$("#g-nav").removeClass('panelactive');
		$(".pik4_table").removeClass('mainblur');
		$(".blurhidden").addClass('hidden');
	});
	$("#g-nav a").click(function () {
		$("#g-nav").removeClass('panelactive');
		$(".pik4_table").removeClass('mainblur');
	});
	$("#org_form a").click(function () {
		$("#org_form").removeClass('panelactive');
		$(".pik4_table").removeClass('mainblur');
	});
});
// 先頭へボタンの挙動
$(function(){
	$('#toplink').click(function(){
		$('body, html').animate({ scrollTop: 0 }, 500);
		return false;
	})
});
// 期間限定ランキングナビゲーション：エリア取得リアルタイム版
function getarea(){
	$.ajax({
		type: "POST",
		url: "pik4_getarea.php?id="+Math.random(),
		cache: false,
		data: {
			"stage_id": 1
		},
		success: function(data){
			const mapkey = range(173, 221);
			var areax = 7;
			var areay = 7;
			var teamae = "😂";
			var teambe = "😊";
			var now = new Date();
			mapkey.forEach(function(key){
					var current_area = 0; // ステージIDと一致していたら色を変える
					var tr = Math.floor((key - mapkey[0]) / areay) + 1; // 列数
					var td = (key - mapkey[0] + 1) - (areay * (tr - 1)); // 行数
					var stagetitle = data[key].title.replace("（", "<br>（");
					var mark = data[key].mark;
					if(mark == "ore01"){
						var excav_time = 30;
						var multi = 2;
					} else {
						var excav_time = 30;
						var multi = 2;
					}
					var updatetime = now.getTime() - Date.parse(data[key].update_time);
					var checktime = now.getTime() - Date.parse(data[key].check_time);
					var counttime = orgcountdown(checktime, excav_time);
					var getore = Math.floor(Math.floor((checktime % (24*60*60*1000) ) / (60*1000) ) / excav_time) * multi;
					var bonus = Math.floor(Math.floor((updatetime % (24*60*60*1000) ) / (60*1000) ) / excav_time) * multi / 2;

					if(counttime == 0){
						// カウントダウンが０になったらエリアへの書き込み処理を実行する
						writearea(data[key].id);
					}
					$("#area"+key).removeClass().addClass('area_'+data[key].flag);
					if(data[key].flag == 3 || data[key].flag == 4){
						$("#area"+key).html('<A href="./'+data[key].stage_id+'">'+tr+'-'+td+'◆'+stagetitle+'<br>'+data[key].user_name+'<p><i class="fa fa-star" aria-hidden="true"></i>'+data[key].top_score+' pts.  <i class="fas fa-paper-plane"></i>'+data[key].count+'</p><p>'+teamae+data[key].team_a+' - '+data[key].team_b+teambe+'<br>⛏'+counttime+' | <i class="fas fa-gem"></i>'+getore+' | <i class="fas fa-coins"></i>'+bonus+'</p></A>');
					} else if(data[key].flag == 2){
						$("#area"+key).html('<A href="./'+data[key].stage_id+'">'+tr+'-'+td+'◆'+stagetitle+'</A>');
					}
				}
			);
		},
			// for(const[key, value] of Object.entries(data)){
			// 	for(const[keychild, val] of Object.entries(value)){
			// 		$("#"+keychild+key).text(val);
			// 	}
			// }
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert("errorThrown : " + errorThrown.message);
		}
	});
}
function writearea(id){
	$.ajax({
		type: "POST",
		url: "pik4_writearea.php?id="+Math.random(),
		cache: false,
		data: {
			"stage_id": id
		},
		success: function(flag){
			// パーティクルを表示したい
			console.log(flag); // ★あとで消す
		}
	});
}
// 定期実行する関数一覧
setInterval('getarea()', 1000);

// javascriptでrange()関数 参考：https://qiita.com/RyutaKojima/items/168632d4980e65a285f3
const range = (start, stop) => Array.from({ length: (stop - start) + 1}, (_, i) => start + i);

// 時間のカウントダウン（エリア踏破戦発掘大作戦専用）
function orgcountdown(time, excav){
	var min = excav - (Math.floor((time % (24*60*60*1000) ) / (60*1000) ) % 60) % excav - 1;
	var sec = 60 - Math.floor((time % (24*60*60*1000) ) / 1000) % 60 % 60;
	if(sec == 60){
		sec = 0;
		if(min < excav - 1){
			min++;
		} else {
			min = 0;
		}
	}
	return min+':'+zeroPadding(sec, 2);
}