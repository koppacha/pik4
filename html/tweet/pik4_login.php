<?php
session_start();

define("Consumer_Key", "g8DNcIpCm9LOJMN2x6PKekTPz");
define("Consumer_Secret", "LF2waTjwrFG9dubT8FqJnumzUF11mX1EMb8AkTpa3OkTmqKws8");

//Callback URL
define('Callback', 'http://pik4.chr.mn/tweet/pik4_callback.php');

//ライブラリを読み込む
require "../twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

//TwitterOAuthのインスタンスを生成し、Twitterからリクエストトークンを取得する
$connection = new TwitterOAuth(Consumer_Key, Consumer_Secret);
$request_token = $connection->oauth("oauth/request_token", array("oauth_callback" => Callback));

//リクエストトークンはcallback.phpでも利用するのでセッションに保存する
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

// Twitterの認証画面へリダイレクト
$url = $connection->url("oauth/authorize", array("oauth_token" => $request_token['oauth_token']));
header('Location: ' . $url);