<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-12-28
 * Time: 오후 8:43
 */

include 'dbConnect2Member.php';

//더미 게시물 몇개를 추가하는 코드다.

//$written_time = date("F j, g:i a");
setlocale(LC_ALL, "ko_KR.utf-8");
$timestamp = time();
//$written_time = strftime('%h %e일(%a)', time());
$written_time = strftime('%Y년 %m월 %d일 %H:%M', $timestamp);
//echo $writer.$title.$content;


$dummy_num = 100;

for($i = 1; $i <$dummy_num ; $i++){

    $writer = 'writer '.$i;

    $email = 'email '.$i;

    $title = 'title '.$i;

    $content = 'content '.$i;

    $imgUrl = '';

    $profile_url = '';






    $sql = "INSERT INTO dbMember2.table_newsfeed 
      (id,writer, writer_email, title, text_content, img_url, writer_profile_url, feed_written_time) 
VALUES('$i','$writer',  '$email', '$title', '$content', '$imgUrl',  '$profile_url' , '$written_time' )";

    $result = $db->query($sql);

    if($i == $dummy_num-1){
        echo "더미 데이터가 추가되었습니다.";
    }

}





?>