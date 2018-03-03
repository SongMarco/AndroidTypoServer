<?php


//새 그룹을 추가하는 php 스크립트이다.
// Typo app 클라이언트의 addGroup 을 통해 호출된다.

//서버 db와 연결, 세션 시작
include '../dbConnect2Member.php';
session_start();

//에러 메시지를 출력하도록 함
ini_set("display_errors", 1);

//클라이언트가 post로 보내온 내용을 변수에 담는다. (그룹 이름, 그룹 설명, 그룹 이미지)
$nameGroup = $_POST['nameGroup'];
$contentGroup = $_POST['contentGroup'];
$imgUrlGroup = $_POST['imgUrlGroup'];



//그룹장의 이메일과 메일을 세션에서 가져온다.
$emailGroupOwner =$_SESSION['ses_email'];
$nameGroupOwner =  $_SESSION['ses_name'];


//그룹 생성 날짜를 생성한다. 한글출력을 위해 로케일을 지정
setlocale(LC_ALL, "ko_KR.utf-8");
$timestamp = time();
$dateGroupMade = strftime('%Y년 %m월 %d일 %H:%M', $timestamp);

//그룹 테이블에 그룹 정보를 저장
$sql = "INSERT INTO dbMember2.table_group
      (name_group, content_group, img_url_group, email_group_owner, name_group_owner, date_group_made  ) 
VALUES('$nameGroup', '$contentGroup', '$imgUrlGroup', '$emailGroupOwner', '$nameGroupOwner',  '$dateGroupMade' )";

$result = $db->query($sql);




//테이블에서 생성한 그룹의 id 값을 가져온다 -> 그룹 멤버 테이블에 그룹 id 값을 저장하기 위함
$sql = "select id_group from dbMember2.table_group order by id_group DESC limit 1";
$result = $db->query($sql);

//숫자형 인덱스 배열로 id 값을 받는다.
$row = mysqli_fetch_array($result, MYSQLI_BOTH);

//배열 0번 요소가 그룹의 id값이 된다.
$idGroup = $row[0];


//그룹 멤버 테이블에 그룹 개설자 저장(멤버 정보가 이 테이블에 저장된다)
$sql = "INSERT INTO dbMember2.table_group_member 
        (id_group, name_member, email_member)
        VALUES ( '$idGroup', '$nameGroupOwner', '$emailGroupOwner')";

$result = $db->query($sql);


if(!$result)
    die("mysql query error");
else
    echo "insert success";





?>