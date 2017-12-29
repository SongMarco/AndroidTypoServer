<?php

include 'dbConnect2Member.php';
include_once('./fcm/functionSendFCM.php');
session_start();
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-11-26
 * Time: 오전 3:13
 *
 * 본 코드는 답글(대댓글) 기능을 서버에서 처리하는 코드다.
 *
 * 포스트로 댓글 ID와 내용을 받아와 DB에 담는다.
 */


ini_set("display_errors", 1);


//post로 보낸 내용들을 변수에 담는다.
$commentID = $_POST['commentID'];
$content = $_POST['content'];


//작성자 이름과 이메일, 프로필 주소는 세션을 참고해서 조회한다.
$writer = $_SESSION['ses_name'];
$email = $_SESSION['ses_email'];
$profile_url = $_SESSION['ses_profile_url'];


//날짜 한글출력을 위한 로케일 지정
setlocale(LC_ALL, "ko_KR.utf-8");
$timestamp = time();
$written_time = strftime('%Y년 %m월 %d일 %H:%M', $timestamp);

//변수 확인을 위한 테스트 과정
//echo $writer.$email.$profile_url;
//echo $content;
//echo $written_time;
//echo "commentID = ".$commentID ;


//대댓글을 디비에 저장한다.
//대댓글이므로, 댓글의 ID 값과 depth(2)값을 넣어 댓글과 구별한다.
$sql = "INSERT INTO dbMember2.table_comment
      (subcomment_comment_id, depth,  writer, writer_email,  comment_content, comment_profile_url, comment_written_time) 
VALUES('$commentID', 2 , '$writer',  '$email', '$content', '$profile_url' , '$written_time')";

$result = $db->query($sql);

// 댓글을 DB에 저장했고, 대댓글 갯수를 댓글에 저장시키자

// 먼저 해당 피드의 댓글 갯수를 가져와야 한다.
$sql = "SELECT comment_subcomment_num from dbMember2.table_comment WHERE id = '$commentID'";
$result2 = $db->query($sql);

$row = mysqli_fetch_assoc($result2);

$subCommentNum = $row['comment_subcomment_num'];
$subCommentNum++;

//다음으로 해당 댓글에 대댓글 갯수를 저장한다.
$sql = "UPDATE dbMember2.table_comment
        SET comment_subcomment_num = '$subCommentNum' WHERE  id = '$commentID'";

$result3 = $db->query($sql);



if (!$result || !$result2 || !$result3)
    die("mysql query error");
else
    echo "insert success";
?>
