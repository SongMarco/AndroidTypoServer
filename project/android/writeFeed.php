<?php

include 'dbConnect2Member.php';
session_start();


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-11-26
 * Time: 오전 3:13
 */

//$writer = $_GET['writer'];
//$title = $_GET['title'];
//$content = $_GET['content'];

$writer = $_POST['writer'];
$email = $_POST['email'];


$profile_url = $_SESSION['ses_profile_url'];

$title = $_POST['title'];
$content = $_POST['content'];

$imgUrl = $_POST['imgUrl'];

//$written_time = date("F j, g:i a");
setlocale(LC_ALL, "ko_KR.utf-8");
$timestamp = time();
//$written_time = strftime('%h %e일(%a)', time());
$written_time = strftime('%Y년 %m월 %d일 %H:%M', $timestamp);
//echo $writer.$title.$content;



$sql = "INSERT INTO dbMember2.table_newsfeed 
      (writer, writer_email, title, text_content, img_url, writer_profile_url, feed_written_time) 
VALUES('$writer',  '$email', '$title', '$content', '$imgUrl',  '$profile_url' , '$written_time' )";

$result = $db->query($sql);

//
//$sql = "INSERT INTO dbMember2.table_newsfeed (writer, title, text_content, img_url, img_name)
//            VALUES('작성자', '제목', '텍스트', '$file_path', '$file_name')";
//
//$res = $db->query($sql);


if(!$result)
    die("mysql query error");
else
    echo "insert success".$imgUrl;
?>