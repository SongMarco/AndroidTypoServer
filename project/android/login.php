<?php
require "./dbConnect2Member.php";
session_start();

$email = $_POST['u_email'];
$memberPw = $_POST['u_pw'];
$Token = $_POST['Token'];

$sql = "SELECT * FROM member WHERE email = '$email' AND password = '$memberPw'";

$res = $db->query($sql);

$row = $res->fetch_array(MYSQLI_ASSOC);

//if($_SESSION["dtkn"]){
//    echo $_SESSION["dtkn"];
//
//}
//else{
//    echo '세션 토큰 확인 불가';
//}

$login_msg = '';
if ($row != null) {
    $login_msg = 'login_success';

    //디버깅용 로그인 정보다. 디버깅 후 주석처리 할 것(실제 회원정보는 세션에 저장 후 확인을 요청할 때만 보내준다)
    $login_info = array('email'=>$row['email'], 'name'=>$row['memberName'],
        'birthday'=>$row['birthday'],
    'profile_url'=>$row['profile_url']);

    ob_start();
    $_SESSION['ses_email'] = $row['email'];
    $_SESSION['ses_name'] = $row['memberName'];
    $_SESSION['ses_birthday'] = $row['birthday'];
    $_SESSION['ses_profile_url'] = $row['profile_url'];


}
else{
    $login_msg = 'login_failed';
    $login_info = array('email'=>'', 'name'=>'',
        'birthday'=>'');
}

//이메일 정보와 토큰을 모두 가지고 있으므로,
//토큰 DB를 업데이트한다. 이렇게 하면
//같은 기기에서 로그인할 때마다 사용자계정이 바뀌게 된다.
$sql = "INSERT INTO dbMember2.fcm_test (Token, member_email) Values ('$Token', '$email' )
                ON DUPLICATE KEY UPDATE Token = '$Token', member_email = '$email' ";
$result = $db->query($sql);

$_SESSION['dtkn'] = $Token;



$login_result = array('login_msg'=>$login_msg);
$login_result['login_info'] = $login_info;

$json_result = json_encode($login_result, JSON_UNESCAPED_UNICODE);
Header('Content-Type: application/json');
print $json_result;
?>
