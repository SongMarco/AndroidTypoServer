<?php

session_start();
include '../dbConnect2Member.php';
include_once('./functionSendFCMforSubComment.php');


//대댓글 처리가 끝났다. fcm 알림을 댓글 작성자에게 보낸다.
//내 댓글에 대댓글을 단 경우는 코드를 돌리지 않는다.

//토큰 DB에서 댓글 작성자의 이메일 계정을 기준으로 토큰 레코드를 가져온다.

/*
    * 댓글 주인의 토큰 필요 -> 댓글 주인의 이메일 필요
    * commentID를 기준으로 댓글 row 를 DB 에서 가져와 댓글 주인의 이메일을 얻어내자.
    */

$emailCommentWriter = $_POST['emailCommentWriter'];

$feedID = $_POST['feedID'];

$sql = "Select writer_email from dbMember2.table_newsfeed WHERE id = '$feedID' ";

$result = $db->query($sql);

$row = mysqli_fetch_array($result);



$emailFeedWriter = $row['writer_email'];

$commentID = $_POST['commentID'];

echo $commentID;

//댓글 작성자가 로그인한 작성자와 다를때만 fcm 알림 전송
// 테스트를 위해 예외처리 안해둔다.
if (

true
//    $emailCommentWriter != $_SESSION['ses_email']

) {

// 댓글 작성자의 이메일이 등록된 토큰 row 를 토큰 DB 에서 가져온다.
    $sql = "Select Token From dbMember2.fcm_test WHERE member_email = '$emailCommentWriter'";
    $result = $db->query($sql);

//가져온 토큰 값들을 토큰 배열에 세팅
    while ($row = mysqli_fetch_array($result)) {
        if ($row["Token"]) {
            $tokens[] = $row["Token"];
        }
    }

//토큰에 fcm 메시지를 보낸다. - 서버 키가 해당 앱의 키인지 확인!
//서버키가 맞지 않으면 엉뚱한 앱으로 알림이 간다
    $replier_name = $_SESSION['ses_name'];

    $wr_subject = "$replier_name 님이 회원님의 댓글에 답글을 달았습니다.";


    $activity = "SubCommentActivity";


    $profileImageUrl = $_SESSION['ses_profile_url'];
    $rt = send_fcm_subComment($wr_subject, $tokens, $activity, $feedID,
        $commentID, $profileImageUrl, $emailCommentWriter);


    //날짜 출력을 위한 코드
//날짜 한글 출력을 위한 로케일을 지정한다.
    setlocale(LC_ALL, "ko_KR.utf-8");
    $timestamp = time();
    $noticeTime = strftime('%Y년 %m월 %d일 %H:%M', $timestamp);


//메시지 전송 완료. 성공 / 실패 여부를 확인
    if ($rt) {
        echo "알림 전송 성공, 기기를 확인하세요";

        $sql = "INSERT INTO dbMember2.fcm_notice_list 
          (notice_content, notice_sender_profile_url, to_where_activity, notice_owner_email, notice_commenter_email ,notice_date, feed_id, comment_id) 
          
   VALUES ('$wr_subject', '$profileImageUrl', '$activity', '$emailFeedWriter', '$emailCommentWriter', '$noticeTime' ,'$feedID', '$commentID' ) ";

        $db->query($sql);


    } else {
        echo "알림 전송 실패, 코드를 확인하세요";
    }

}

?>