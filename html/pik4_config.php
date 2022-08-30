<?php
// 各種設定
ini_set('display_errors', 0);					// エラー表示
ini_set( 'session.gc_maxlifetime', 7776000 );			// セッションの期限 (7,776,000＝90日）★PHP 7.2以降不使用
$time_start = microtime(true);
require "twitteroauth/autoload.php";				// Twitter連携認証ライブラリ (https://github.com/abraham/twitteroauth）
use Abraham\TwitterOAuth\TwitterOAuth;
require "ca-bundle-master/src/CaBundle.php";			// Ca-Bundleライブラリ
require "glicko2/class.Glicko2Player.php";			// グリコ2レーティングライブラリ（https://github.com/Zarel/glicko2-php）
// require "../../vendor/autoload.php";				// Composerライブラリ
date_default_timezone_set('Asia/Tokyo');			// 標準時
$now_time = time()+(0*24*60*60)+(0*60*60);			// 現在時刻
$php_update  = '2022/08/30';					// 最終更新日
$sys_ver     = '2.78';						// バージョン表記 (2015年11月01日より簡易化：MNN形式で3桁にする)
$mysql_mode  = 0 ;						// MySQLのキー情報 (0＝ローカルモード、1＝heteml DataBase Server) (→pik4_cavesdata.php、pik4_minites.php)
$site_mode   = 0 ;						// メンテナンスモード トグルスイッチ (1＝ON)
$blind	     = 0 ;						// ブラインド制のトグルスイッチ
$blind_start = 3036 ;						// ブラインド制対象ステージ開始番号
$blind_end   = 3037 ;						// ブラインド制対象ステージ終了番号
$limited_num = 0 ;						// 現在の期間限定ランキング通しNo. (0＝非開催)
$uplan_num   = 0 ;						// 現在の参加者企画通しNo.（0＝非開催）
$limited_stage = array();					// 現在の期間限定ランキング対象ステージ (非開催時は最後の開催ステージの最終IDのみ残す）
$limited_start_time = strtotime( '2021-11-05 22:00:00');// 期間限定ランキング開始時間
$limited_end_time   = strtotime( '2021-11-07 21:59:59');// 期間限定ランキング終了時間 (→pik4.jsにも反映する)
$ment_start_time    = strtotime( '2018-10-15 08:05:00');// 次回のメンテナンス開始時間 (mysql503.heteml.jp)
$ment_end_time      = strtotime( '2018-10-19 20:04:59');// 次回のメンテナンス終了時間
$team_a = 17;							// 今回の左チーム
$team_b = 18;							// 今回の右チーム
$team_a2= $team_a;						// チーム定義ダミー
$team_b2= $team_b;						// チーム定義ダミー
$loadtime_echo = array();					// ロード時間記録
$network_error = 0;						// データベース接続状態

// ブラウザの言語を取得
$lang = ($http_langs = $_SERVER['HTTP_ACCEPT_LANGUAGE']) ? explode( ',', $http_langs )[0] : 'en';

$mysql_host = "";
$mysql_user = "";
$mysql_pass = "";
$mysql_db = "";
$mysql_mode = 0;

// データベース接続情報
if($_SERVER['SERVER_NAME'] == 'localhost' or $_SERVER['SERVER_NAME'] == LOCAL_HOST or $_SERVER['SERVER_NAME'] == DEV_HOST) {
    // ローカル環境へ接続
    $mysql_host = "pik4_db";
    $mysql_user = "root";
    $mysql_pass = "root";
    $mysql_db = "pik4";
    $mysql_mode = 0;
} else {
    // 本番環境へ接続
    $mysql_host = DATABASE_DOMAIN;
    $mysql_user = DATABASE_USER;
    $mysql_pass = DATABASE_PASS;
    $mysql_db   = DATABASE_USER;
    $mysql_mode = 1;
    session_save_path(SESSION_PATH); // セッションの保存場所を定義
}
// Twitter API関連（アクセストークンは@koppachappy経由）
$pik4_api_key = TWITTER_API_KEY;
$pik4_api_skey= TWITTER_API_SKEY;
$pik4_access_token = TWITTER_TOKEN;
$pik4_access_stoken= TWITTER_STOKEN;
$twObj = new TwitterOAuth($pik4_api_key, $pik4_api_skey, $pik4_access_token, $pik4_access_stoken);