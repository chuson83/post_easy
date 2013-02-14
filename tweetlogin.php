<?php
//SESSION開始
session_start();
//インクルード
require_once 'model/twitteroauth.php';
require_once 'model/appinfo.php';

//OAuthオブジェクト生成
$oOauth = new TwitterOAuth(TW_KEY,TW_SECRET);
 
//callback url を指定して request tokenを取得
$oOauthToken = $oOauth->getRequestToken(TW_CALLBACK);
 
//セッション格納
$_SESSION['requestToken'] = $sToken = $oOauthToken['oauth_token'];
$_SESSION['requestTokenSecret'] = $oOauthToken['oauth_token_secret'];

 
//認証URLの引数 falseの場合はtwitter側で認証確認表示
if(isset($_GET['authorizeBoolean']) && $_GET['authorizeBoolean'] != ''){
    $bAuthorizeBoolean = false;
}else{
    $bAuthorizeBoolean = true;
}

//Authorize url を取得
$sUrl = $oOauth->getAuthorizeURL($sToken, $bAuthorizeBoolean);

header("Location: ".$sUrl);


