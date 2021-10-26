<?php
date_default_timezone_set('Asia/Tokyo');

// APIを読み込む
require "twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

// Twitter API関連（アクセストークンは@koppachappy経由）
$pik4_api_key = TWITTER_API_KEY;
$pik4_api_skey= TWITTER_API_SKEY;
$pik4_access_token = TWITTER_TOKEN;
$pik4_access_stoken= TWITTER_STOKEN;
$twObj = new TwitterOAuth($pik4_api_key, $pik4_api_skey, $pik4_access_token, $pik4_access_stoken);

// 現在時刻から取得対象日時を計算
// $since = date('Y-m-d_H:i:s', strtotime("-60 sec"))."_JST";

// ツイートを取得
$query = "#NintendoSwitch -filter:retweets -filter:replies";
$result = $twObj->get("search/tweets",["q"=>$query, "count"=> 100]);

// 出力テスト
echo "<pre>";
var_dump($result);
echo "</pre>";

// ファイルを読み込む
// $fp = fopen('data.csv', 'a');

// // ツイートを出力
// foreach($result->statuses as $var){
//         $text = str_replace(array("\r\n","\r","\n",","), '', $var->text);
//         $time = date('Y/m/d H:i:s', strtotime($var->created_at));
//         $line = $var->user->screen_name.",".$time.",".$text;
//         fwrite($fp, $line."\n");
// }
// fclose($fp);
