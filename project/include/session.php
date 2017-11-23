<?php

$expireTime=3600;

if($_COOKIE['auto_login']=="on"){

    ini_set("session.cookie_lifetime", 60*60*24*30);
    ini_set("session.cache_expire", 60*60*24*30);
    ini_set("session.gc_maxlifetime", 60*60*24*30);
}
else{
    ini_set("session.cookie_lifetime", 0);
    ini_set("session.cache_expire", 0);
    ini_set("session.gc_maxlifetime", 0);


}




session_start();
//
//if($_SESSION['auto_login']=='on'){
//    $expireTime = 3600;
//    $_SESSION['expire']=$expireTime;
//}
// 세션 만료 코드 @@ 굉장히 유용하군.
// expiretime 이상으로 현재 시간과 마지막 활동 시간이 차이나면 세션 만료 !! 심플하다.
// 현재시간 - 마지막 활동이 만료시간보다 커졌고, 로그인이 되어있고, 자동 로그인이 안되있다면 세션만료시킨다.


if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $expireTime) && (isset($_SESSION['ses_userName']))
    && ($_COOKIE['auto_login']!=="on")  ) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage


//    echo "<script>alert(\"장시간 자리를 비우셨습니다. 다시 로그인해주세요@@\");</script>";

}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
?>