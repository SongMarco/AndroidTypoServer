<?php

/*
 * 본 코드는 FCM 푸시알림 서비스를 확인하는 코드다.
 *
 * db와 연결하
 *
 */
include '../dbConnect2Member.php';
include_once('functionSendFCM.php');


$sql = "Select Token From dbMember2.fcm_test";

$result = $db->query($sql);

while ($row = mysqli_fetch_array($result)) {
    if($row["Token"]) {
        $tokens[] = $row["Token"];
    }
}


$wr_subject = "메시지입니다.";

$rt = send_fcm($wr_subject, $tokens);

if($rt){
    echo "알림 전송 성공, 기기를 확인하세요";
}
else{
    echo "알림 전송 실패, 코드를 확인하세요";
}





?>