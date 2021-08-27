<?php
require_once('_def.php');

ini_set( 'session.gc_maxlifetime', 7776000 );
session_save_path(SESSION_PATH);
session_start();

//Callback URL
define('Callback', 'https://chr.mn/pik4/pik4_callback.php');

//ライブラリを読み込む
require "twitteroauth/autoload.php";
require "ca-bundle-master/src/CaBundle.php";
use Abraham\TwitterOAuth\TwitterOAuth;

//TwitterOAuthのインスタンスを生成し、Twitterからリクエストトークンを取得する
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
$request_token = $connection->oauth("oauth/request_token", array("oauth_callback" => Callback));

//リクエストトークンはcallback.phpでも利用するのでセッションに保存する
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

// Twitterの認証画面へリダイレクト
$url = $connection->url("oauth/authorize", array("oauth_token" => $request_token['oauth_token']));
header('Location: ' . $url);