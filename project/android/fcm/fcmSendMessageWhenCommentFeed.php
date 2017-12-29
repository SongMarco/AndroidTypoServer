<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-12-27
 * Time: 오후 5:20
 * 
 * 뉴스피드 게시물에 댓글이 달릴 경우 메시지를 보내는 과정이다.
 *
 * 클라이언트에서 보낸 이메일 정보로부터 토큰을 가져오고,
 * 토큰을 가진 기기에 알림을 전송한다.
 *
 * 알림 내용
 * 제목 - Typo 댓글 알림
 * 내용 - @@@이 회원님의 게시물에 댓글을 달았습니다.
 *
 *
 * 프사 - 내용
 */
session_start();
include '../dbConnect2Member.php';
include_once('./functionSendFCM.php');

$word_name = $_POST['wordName'];

$feedID = $_POST['feedID'];

$email_feed_writer= $_POST['emailFeedWriter'];

//echo $word_name.$email_feed_writer;

//세션에서 이메일 정보를 꺼내고, 꺼내지 못하면 에러 출력 후 종료
//세션에서 건진 이메일 정보는 댓글 단놈 꺼니까 필요 없음!
// 이름은 필요함
//$email =  $_SESSION['ses_email'];
$commenter_name = $_SESSION['ses_name'];

//echo $commenter_name;


//내 게시물에 내가 단 댓글에는 알림이 필요없으므로 그대로 종료한다.

//if($email_feed_writer == $_SESSION['ses_email']){
//    die('댓글 작성자와 게시물 작성자가 동일하므로 알림 전송이 필요 없습니다.');
//}
//
//if(!$commenter_name){
//    die('에러 ::: 세션에서 로그인 정보를 가져오지 못했습니다.');
//}


//토큰 DB에서 단어 작성자의 이메일 계정을 기준으로 토큰 레코드를 가져온다.
$sql = "Select Token From dbMember2.fcm_test WHERE member_email = '$email_feed_writer'";
$result = $db->query($sql);

//가져온 토큰 값들을 토큰 배열에 세팅
while ($row = mysqli_fetch_array($result)) {
    if($row["Token"]) {
        $tokens[] = $row["Token"];
    }
}


//토큰들에 fcm 메시지를 보낸다. - 서버 키가 해당 앱의 키인지 확인한다.
$wr_subject = "$commenter_name 님이 회원님의 단어 '$word_name'에 댓글을 달았습니다.";

$wr_subject_for_query = "$commenter_name 님이 회원님의 단어 \'$word_name\'에 댓글을 달았습니다.";


$activity = "CommentActivity";

$profileImageUrl =  $_SESSION['ses_profile_url'];



$rt = send_fcm($wr_subject, $tokens, $activity , $feedID, $profileImageUrl);


//날짜 출력을 위한 코드
//날짜 한글 출력을 위한 로케일을 지정한다.
setlocale(LC_ALL, "ko_KR.utf-8");
$timestamp = time();
$noticeTime = strftime('%Y년 %m월 %d일 %H:%M', $timestamp);


//메시지 전송 완료. 성공 / 실패 여부를 확인
if($rt){
    echo "알림 전송 성공, 기기를 확인하세요";

    $sql = "INSERT INTO dbMember2.fcm_notice_list 
          (notice_content, notice_sender_profile_url, to_where_activity, notice_owner_email, notice_date) 
          
   VALUES ('$wr_subject_for_query', '$profileImageUrl', '$activity', '$email_feed_writer', '$noticeTime') ";

    $db->query($sql);



}
else{
    echo "알림 전송 실패, 코드를 확인하세요";
}





?>
