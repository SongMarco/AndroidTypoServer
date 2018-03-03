<?php

//그룹에 단어장을 추가하는 스크립트


//서버 db와 연결, 세션 시작
include '../dbConnect2Member.php';
session_start();

//에러 메시지를 출력하도록 함
ini_set("display_errors", 1);


//클라이언트가 post로 보내온 내용을 변수에 담는다. (그룹 이름, 그룹 설명, 그룹 이미지)
$nameWordSet = $_POST['nameWordSet'];
$idGroup = $_POST['idGroup'];

//단어장 이름과 그룹 id를 그룹-단어장 테이블에 저장한다.
$sql = "INSERT into dbMember2.table_group_wordset 
                          (id_group, name_wordset)
                   VALUES ('$idGroup', '$nameWordSet')";

$result = $db->query($sql);



?>