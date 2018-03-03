<?php

include '../dbConnect2Member.php';
//include_once('../fcm/functionSendFCM.php');
session_start();
/**

 * 영어단어를 단어장에 추가하는 스크립트.
 *

 *
 */


ini_set("display_errors", 1);


//post로 보낸 내용들을 변수에 담는다.
//각각 단어장 이름, 단어 이름, 단어장 주인의 이메일이다.


$idWordSet = $_POST['idWordSet'];
$idWord =  $_POST['idWord'];

$emailOwner = $_SESSION['ses_email'];


//단어를 table_stored_words 테이블에서 삭제한다.
//이 테이블은 단어가 어떤 단어장에 담겨있는지를 저장한 장부 역할을 한다.
//추후 단어장 화면에서 단어를 세팅할 때 이곳을 조회한다.

$sql = "DELETE from dbMember2.table_stored_words 
       WHERE id_word_set = '$idWordSet' 
       AND id_word_feed = '$idWord' 
       AND email_set_owner = '$emailOwner'";

$result = $db->query($sql);

//단어-단어장 테이블에 저장 완료.

/*
 * 단어장 테이블의 단어 수를 감소시킨다..
 */
$sql = "UPDATE dbMember2.table_wordset SET 
 num_set_words = num_set_words-1 WHERE id_wordset = '$idWordSet' ";

$result = $db->query($sql);


if (!$result)
    die("mysql query error");
else
    echo "insert success";
?>
