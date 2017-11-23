<?php
include "../include/dbConnect.php";

$contactName = $_POST['name'];
$contactEmail = $_POST['email'];
$contactMessage = $_POST['message'];

$sql = "select * from contact;";

$res = $dbConnect->query($sql);

//
////PHP에서 유효성 재확인
//
////아이디 중복검사.
//$sql = "SELECT * FROM member WHERE memberId = '{$memberId}'";
//$res = $dbConnect->query($sql);
//if($res->num_rows >= 1){
//    echo '이미 존재하는 아이디가 있습니다.';
//    exit;
//}
//
////비밀번호 일치하는지 확인
//if($memberPw !== $memberPw2){
//    echo '비밀번호가 일치하지 않습니다.';
//    exit;
//}else{
//    //비밀번호를 암호화 처리.
//    $memberPw = md5($memberPw);
//}
//
////닉네임, 생일 그리고 이름이 빈값이 아닌지
//if($memberNickName == '' || $memberBirthDay == '' || $memberName == ''){
//    echo '생일혹은 닉네임의 값이 없습니다.';
//}
//
////이메일 주소가 올바른지
//$checkEmailAddress = filter_var($memberEmailAddress, FILTER_VALIDATE_EMAIL);
//
//if($checkEmailAddress != true){
//    echo "올바른 이메일 주소가 아닙니다.";
//    exit;
//}
//
//이제부터 넣기 시작
$sql = "INSERT INTO contact VALUES('','{$contactName}','{$contactEmail}','{$contactMessage}');";

if($dbConnect->query($sql)){
    echo "<script>alert(\"운영자에게 메시지를 보냈습니다.\");</script>";
}
?>