<?php

include '../dbConnect2Member.php';
session_start();
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-11-26
 * Time: 오전 3:13
 */


ini_set("display_errors", 1);



//post로 보낸 내용들을 변수에 담는다.
$nameWordSet = $_POST['nameWordSet'];


$emailSetOwner =$_SESSION['ses_email'];
$nameSetOwner =  $_SESSION['ses_name'];


    //날짜 한글출력을 위한 로케일 지정
setlocale(LC_ALL, "ko_KR.utf-8");
$timestamp = time();
$timeSetMade = strftime('%Y년 %m월 %d일 %H:%M', $timestamp);

//db에 단어세트 정보를 저장
$sql = "INSERT INTO dbMember2.table_wordset
      ( email_set_owner,   name_set_owner, name_set, date_set_made  ) 
VALUES('$emailSetOwner', '$nameSetOwner', '$nameWordSet', '$timeSetMade' )";

$result = $db->query($sql);



if(!$result)
    die("mysql query error");
else
    echo "insert success";
?>
