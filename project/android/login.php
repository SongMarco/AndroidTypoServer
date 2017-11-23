<?php
session_start();

$host ="localhost:3306";
$user = "root";
$password = "ehrhekrk527";
$database = "dbMember2";

$db = mysqli_connect($host, $user, $password, $database);

$memberId = $_POST['u_email'];
$memberPw = $_POST['u_pw'];


$sql = "SELECT * FROM member WHERE email = '{$memberId}' AND password = '{$memberPw}'";

$res = $db->query($sql);

$row = $res->fetch_array(MYSQLI_ASSOC);


if ($row != null) {
    $_SESSION['ses_email'] = $row['email'];
//    echo $_SESSION['ses_userid'].'님 로그인되셨습니다.';
    echo 'login_success';
}

if($row == null){
    echo 'login_failed';
}
?>
