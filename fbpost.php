<?php
session_start();

if(isset($_POST['submit_fb']) && !empty($_POST['fb_text'])){
    //値の格納
    $user_id = $_SESSION['user_id'];
    $token = $_SESSION['access_token'];
    $fb_message = htmlspecialchars($_POST['fb_text']);
    
    //graphAPIを利用して投稿
    $ch = curl_init();
    $params = $token;
    $params .= '&message=' .urlencode($fb_message);
    curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/me/feed');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $resp = curl_exec($ch);
    curl_close($ch);
    
    if ($resp === false) {
    //通信エラー時の処理
    $mes = '通信エラー';
    } else {
      $resp = json_decode($resp);
      if (isset($resp->id)) {
        //投稿に成功した時の処理
        $mes = '投稿ありがとうございました。';
        
      } else if (isset($resp->error)) {
        //投稿に失敗した時の処理
        $mes = '投稿エラー';
      }
    }
}else{
    $mes = '投稿メッセージが空欄です。';
}
?>

<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <title>facebook投稿完了画面</title>
        <meta charset="UTF-8">
        <!--[if lt IE 9]>
        <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <h1>PostEasy</h1>
        <?php echo $mes ?>
        <br/>
        <a href="index.html">TOPページに戻る</a>
    </body>
</html>






