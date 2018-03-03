<?php


// 그룹에 회원을 가입시키는 스크립트
// Typo app 클라이언트의 addGroup 을 통해 호출된다.

//서버 db와 연결, 세션 시작
include '../dbConnect2Member.php';
session_start();

//에러 메시지를 출력하도록 함
ini_set("display_errors", 1);

//클라이언트가 post로 보내온 내용을 변수에 담는다. (그룹 id)

$idGroup = $_POST['idGroup'];

//가입할 사람의 이메일을 세션에서 가져온다.
$emailMember =$_SESSION['ses_email'];
$nameMember = $_SESSION['ses_name'];


//그룹 멤버 테이블에 가입한 멤버를 저장시킨다.
$sql = "INSERT INTO dbMember2.table_group_member 
        (id_group, name_member, email_member)
        VALUES ( '$idGroup', '$nameMember', '$emailMember')";

$result = $db->query($sql);

//그룹 테이블의 그룹 인원수를 업데이트한다.
$sql = "UPDATE dbMember2.table_group SET num_group_members = num_group_members+1 WHERE id_group = '$idGroup'";

$result = $db->query($sql);





if(!$result)
    die("mysql query error");
else
    echo "insert success";





?>