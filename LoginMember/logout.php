<?php
include "../include/session.php";
//include "../index.php";
//include "../freeboard2/index.php";

echo $_SESSION['ses_userName'].'님 로그아웃 하겠습니다.';

unset($_SESSION['ses_userName']);
unset($_SESSION['ses_userEmail']);
unset($_SESSION['log_status']);


session_unset();     // 현재 연결된 세션에 등록되어 있는 모든 변수의 값을 삭제한다

setcookie("auto_login", "off", time()-1,'/'  );


if(session_destroy()){
    echo "

<script>
alert('로그아웃이 완료되었습니다.');
history.go(-1);
</script>

 ";


//    echo "<script>history.go(-1);</script>";


}
//
?>