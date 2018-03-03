<?php


//새 그룹을 추가하는 php 스크립트이다.
// Typo app 클라이언트의 addGroup 을 통해 호출된다.

//서버 db와 연결, 세션 시작
include '../dbConnect2Member.php';
session_start();

//에러 메시지를 출력하도록 함
ini_set("display_errors", 1);

//클라이언트가 post로 보내온 내용을 변수에 담는다. (그룹 id)

$idGroup = $_POST['idGroup'];
$memberEmail = $_POST['memberEmail'];


////가입할 사람의 이메일을 세션에서 가져온다.
//$emailMember =$_SESSION['ses_email'];
//$nameMember = $_SESSION['ses_name'];


//그룹 멤버 테이블에서 가입한 멤버 로우를 제거한다
$sql = "DELETE FROM dbMember2.table_group_member WHERE id_group = '$idGroup' AND email_member = '$memberEmail'";

$result = $db->query($sql);


//멤버가 정상적으로 제거되었다면
if($result){
    //그룹 테이블의 그룹 인원수를 업데이트한다. (1명 감소)
    $sql = "UPDATE dbMember2.table_group SET num_group_members = num_group_members-1 WHERE id_group = '$idGroup'";

    $result2 = $db->query($sql);
}





if(!$result2 || !$result)
    die("mysql query error");
else
    echo "회원 삭제 완료";





?>