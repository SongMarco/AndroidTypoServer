<?php

include "../include/dbConnect.php";
include "../include/session.php";

if($_POST['auto_login'] == 'on'){

    setcookie("auto_login", "on", time()+60*60*24*30,'/'  );

//$_SESSION['auto_login'] = 'on';
}
else{
    setcookie("auto_login", "off", time()-1,'/'  );
}


$memberEmail = $_POST['InputEmail'];
$memberPw = md5($memberPw = $_POST['memberPw']);

$sql = "SELECT * FROM member WHERE memberEmailAddress = '{$memberEmail}' AND memberPassword = '{$memberPw}'";
$res = $dbConnect->query($sql);


$row = $res->fetch_array(MYSQLI_ASSOC);


if ($row != null) {

    $_SESSION['ses_userEmail'] = $row['memberEmailAddress'];
    $_SESSION['ses_userName'] = $row['memberName'];
    $_SESSION['expireTime']= $expireTime;

    echo $_SESSION['ses_userName'].'님 로그인되셨습니다.';
// print_r($_POST);

    sleep(1);

    echo "<script>history.go(-2);</script>";
}

if($row == null){

    echo "
<script>
alert('로그인 실패 ! 아이디 또는 비밀번호가 일치하지 않습니다.');
history.go(-1);
</script>";

}
?>