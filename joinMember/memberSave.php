
<?php
include "../include/dbConnect.php";

$memberEmailAddress = $_POST['InputEmail'];
$memberName = $_POST['username'];
$memberPw = $_POST['InputPassword1'];
$memberPw2 = $_POST['InputPassword2'];

//PHP에서 유효성 재확인

//이메일 중복검사.
$sql = "SELECT * FROM member WHERE memberEmailAddress = '{$memberEmailAddress}'";

$res = $dbConnect->query($sql);
if($res->num_rows >= 1){
    echo "
<script>
alert('이미 가입된 이메일입니다.');
history.go(-1);
</script>";
    exit;
}


//닉네임 중복검사.

$sql = "SELECT * FROM member WHERE memberName = '{$memberName}'";

$res = $dbConnect->query($sql);
if($res->num_rows >= 1){
    echo "
<script>
alert('이미 존재하는 닉네임입니다.');
history.go(-1);
</script>";


    exit;

}



//이메일 주소가 올바른지
$checkEmailAddress = filter_var($memberEmailAddress, FILTER_VALIDATE_EMAIL);

if($checkEmailAddress != true){

    echo "
<script>
alert('이메일 형식이 올바르지 않습니다.');
history.go(-1);
</script>";
    exit;
}

$ok_email = true;


//비밀번호 일치하는지 확인
if($memberPw == '' ){
    echo '<script>
alert(\'비밀번호를 입력하지 않으셨습니다.\');
history.go(-1);
</script>";';
    exit;

}

//비밀번호 일치하는지 확인
if($memberPw !== $memberPw2){
    echo "
<script>
alert('비밀번호가 일치하지 않습니다.');
history.go(-1);
</script>";
    exit;

}else{
    //비밀번호를 암호화 처리.
    $memberPw = md5($memberPw);
}

$ok_pw = true;

//이제부터 넣기 시작

if( $ok_email && $ok_pw){
    $sql = "INSERT INTO member (memberEmailAddress, memberName, memberPassword) 
             VALUES('{$memberEmailAddress}','{$memberName}','{$memberPw}');";
    if($dbConnect->query($sql)){

        echo "
<script>
alert('$memberName 님, 이메일 계정 $memberEmailAddress 주소로 회원 가입이 완료되었습니다.');
location.href=\"../\";
</script>";

    }
}


?>





