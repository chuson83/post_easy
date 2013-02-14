<?php
//SESSION開始
session_start();
//読み込み
require_once 'model/twitteroauth.php';
require_once 'model/appinfo.php';
 
//URLパラメータからoauth_verifierを取得
if(isset($_GET['oauth_verifier']) && $_GET['oauth_verifier'] != ''){
	$sVerifier = $_GET['oauth_verifier'];
}else{
	echo 'oauth_verifier error!<br/>';
        echo '<a href="index.html">TOPに戻る</a>';
	exit;
}
 
//リクエストトークンでOAuthオブジェクト生成
$oOauth = new TwitterOAuth(TW_KEY,TW_SECRET,$_SESSION['requestToken'],$_SESSION['requestTokenSecret']);
 
//oauth_verifierを使ってAccess tokenを取得
$oAccessToken = $oOauth->getAccessToken($sVerifier);
 
//取得した値をSESSIONに格納
$_SESSION['oauthToken'] = 	$oAccessToken['oauth_token'];
$_SESSION['oauthTokenSecret'] = $oAccessToken['oauth_token_secret'];
$_SESSION['userId'] = 		$oAccessToken['user_id'];
$_SESSION['screenName'] = 	$oAccessToken['screen_name'];
 
//投稿ページへ飛ぶ
header("Location: tweetcont.html");


