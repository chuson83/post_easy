<?php
//SESSION開始
session_start();
//読み込み
require_once 'model/twitteroauth.php';
require_once 'model/appinfo.php';

//セッションのアクセストークンのチェック
if((isset($_SESSION['oauthToken']) && $_SESSION['oauthToken'] !== NULL) 
        && (isset($_SESSION['oauthTokenSecret']) && $_SESSION['oauthTokenSecret'] !== NULL)){
    //値の格納
    $userId = 			$_SESSION['userId'];
    $accessToken =              $_SESSION['oauthToken'];
    $accessTokenSecret =        $_SESSION['oauthTokenSecret'];
    
    //OAuthオブジェクトを生成する
    $twObj = new TwitterOAuth(TW_KEY,TW_SECRET,$accessToken,$accessTokenSecret);
    
    //つぶやきを投稿
    if(isset($_POST['submit_tweet']) && !empty($_POST['tweet_text'])){
        $tweet_text = htmlspecialchars($_POST['tweet_text']);
        $vRequest = $twObj->OAuthRequest
                ("http://api.twitter.com/1/statuses/update.xml","POST",array("status" => $tweet_text));
        
    }else{
        $mes = '投稿欄が空欄です。';
    }
}
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<title>Twitter投稿完了ページ</title>
<meta charset="UTF-8">
<!--[if lt IE 9]>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<h1>PostEasy</h1>
<?php
if($vRequest){
    echo '投稿ありがとうございました。';
    echo '<br/>';
}else{
    echo '通信エラー';
    echo '<br/>';
}
echo $mes;
echo '<br/>';
?>
<a href="index.html">TOPに戻る</a>
</body>
</html>