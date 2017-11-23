<?php
require "./dbConnect2Member.php";
session_start();

//$host ="localhost:3306";
//$user = "root";
//$password = "ehrhekrk527";
//$database = "dbMember2";
//
//$db = mysqli_connect($host, $user, $password, $database);



$email = $_POST['u_email'];
$memberPw = $_POST['u_pw'];


$sql = "SELECT * FROM member WHERE email = '{$email}' AND password = '{$memberPw}'";

$res = $db->query($sql);

$row = $res->fetch_array(MYSQLI_ASSOC);

$login_msg = '';
if ($row != null) {
    $login_msg = 'login_success';
    $login_cookie = array('email'=>$row['email'], 'name'=>$row['memberName'],
        'birthday'=>$row['birthday']);


}
else{
    $login_msg = 'login_failed';
    $login_cookie = '';
}

$login_result = array('login_msg'=>$login_msg);
$login_result['login_cookie'] = $login_cookie;

$json_result = json_encode($login_result, JSON_UNESCAPED_UNICODE);
Header('Content-Type: application/json');
print $json_result;
?>
