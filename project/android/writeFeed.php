<?php

include 'dbConnect2Member.php';
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-11-26
 * Time: 오전 3:13
 */

$writer = $_POST['writer'];
$title = $_POST['title'];
$content = $_POST['content'];

echo $writer.$title.$content;
$sql = "INSERT INTO dbMember2.table_newsfeed (writer, title, text_content) VALUES('$writer', '$title', '$content')";

$result = $db->query($sql);

if(!$result)
    die("mysql query error");
else
    echo "insert success"
?>