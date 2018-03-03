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

$nameWordSet = $_POST['nameWordSet'];
$nameWord = $_POST['nameWord'];
$idWord =  $_POST['idWord'];

$emailOwner = $_SESSION['ses_email'];




//단어장 주인 메일과 단어장 이름을 기준으로 단어장의 id 값을 가져온다.

$sql = "select id_wordset from dbMember2.table_wordset WHERE name_set = '$nameWordSet' 
                                                        AND email_set_owner = '$emailOwner'";
$result = $db->query($sql);
$row = mysqli_fetch_array($result);
$idWordSet = $row['id_wordset'];

//단어와 단어장을 table_stored_words 테이블에 저장한다.
//이 테이블은 단어가 어떤 단어장에 담겨있는지를 저장한 장부 역할을 한다.
//추후 단어장 화면에서 단어를 세팅할 때 이곳을 조회한다.

$sql = "INSERT INTO dbMember2.table_stored_words 
        (id_word_set, id_word_feed  ,name_word, name_word_set, email_set_owner)
 VALUES ('$idWordSet', '$idWord' ,'$nameWord', '$nameWordSet', '$emailOwner' )";

$result = $db->query($sql);

//단어-단어장 테이블에 저장 완료.

/*
 * 단어장 테이블의 단어 수를 증가시킨다.
 */
$sql = "UPDATE dbMember2.table_wordset SET 
 num_set_words = num_set_words+1 WHERE name_set = '$nameWordSet' 
                                   AND email_set_owner = '$emailOwner'";

$result = $db->query($sql);









//단어 게시물의 단어장 저장 횟수를 증가시켜 저장한다.


// 먼저 해당 피드의 저장 횟수를 가져와야 한다.
$sql = "SELECT num_used_in_set from dbMember2.table_newsfeed WHERE id = '$idWord'";
$result2 = $db->query($sql);

$row = mysqli_fetch_assoc($result2);

$numUsed = $row['num_used_in_set'];
$numUsed++;

//단어 게시물의 단어장 추가 횟수를 증가시킨다.
$sql = "UPDATE dbMember2.table_newsfeed
        SET num_used_in_set = '$numUsed' WHERE  id = '$idWord'";

$result3 = $db->query($sql);





if (!$result || !$result2 || !$result3)
    die("mysql query error");
else
    echo "insert success";
?>
