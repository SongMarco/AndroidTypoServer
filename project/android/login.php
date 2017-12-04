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
    $login_info = array('email'=>$row['email'], 'name'=>$row['memberName'],
        'birthday'=>$row['birthday']);

    ob_start();
    $_SESSION['ses_email'] = $row['email'];
    $_SESSION['ses_name'] = $row['memberName'];
    $_SESSION['ses_birthday'] = $row['birthday'];


}
else{
    $login_msg = 'login_failed';
    $login_info = array('email'=>'', 'name'=>'',
        'birthday'=>'');
}

$login_result = array('login_msg'=>$login_msg);
$login_result['login_info'] = $login_info;

$json_result = json_encode($login_result, JSON_UNESCAPED_UNICODE);
Header('Content-Type: application/json');
print $json_result;
?>
